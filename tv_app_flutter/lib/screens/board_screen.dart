import 'dart:async';
import 'dart:ui';
import 'package:flutter/foundation.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:webview_flutter_android/webview_flutter_android.dart';
import '../models/board_model.dart';
import '../services/api_service.dart';
import '../services/update_service.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';
import '../widgets/board_header.dart';
import '../widgets/price_card.dart';
import '../widgets/product_slider.dart';
import 'pairing_screen.dart';

class BoardScreen extends StatefulWidget {
  final String username;

  const BoardScreen({
    super.key,
    required this.username,
  });

  @override
  State<BoardScreen> createState() => _BoardScreenState();
}

class _BoardScreenState extends State<BoardScreen> {
  BoardModel? _model;
  bool _isLoading = true;
  bool _isOffline = false;
  bool _isWebViewMode = false;
  bool _isWebLoading = true;
  WebViewController? _webViewController;
  final ValueNotifier<DateTime> _timeNotifier = ValueNotifier<DateTime>(DateTime.now());

  Timer? _clockTimer;
  Timer? _refreshTimer;
  Timer? _updateCheckTimer;

  static const String _prefKeyWebMode = 'tv_webview_mode';
  static const String _prefKeyZoom = 'talalive_zoom_level';
  static const String _prefKeyDarkMode = 'tv_dark_mode_override';
  double _zoomLevel = 1.0;
  bool? _isDarkModeOverride;

  String _installedVersion = '1.0.0';
  UpdateInfo? _availableUpdate;

  static const MethodChannel _nativeChannel = MethodChannel('ir.talalive.tv/updater');
  final FocusNode _focusNode = FocusNode();
  bool _isSettingsOpen = false;
  String? _zoomFeedbackText;
  Timer? _zoomFeedbackTimer;

  @override
  void initState() {
    super.initState();
    if (!kIsWeb) {
      _initWebViewController();
    }
    _setupNativeKeyHandler();
    _loadInstalledVersion();
    _loadSavedMode();
    _loadSavedZoom();
    _loadSavedThemeMode();
    _fetchData();

    // Zero-overhead clock timer: updates ValueNotifier only, ZERO root rebuilds!
    _startClockTimer();

    // Check update in background after 12 seconds
    _updateCheckTimer = Timer(const Duration(seconds: 12), () {
      _checkForUpdate(manual: false);
    });

    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (mounted) _focusNode.requestFocus();
    });
  }

  void _startClockTimer() {
    _clockTimer?.cancel();
    _clockTimer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (mounted) {
        _timeNotifier.value = DateTime.now();
      }
    });
  }

  void _setupNativeKeyHandler() {
    _nativeChannel.setMethodCallHandler((call) async {
      switch (call.method) {
        case 'onMenuPressed':
          if (!_isSettingsOpen && mounted) {
            _showSettingsMenu();
          }
          break;
        case 'onDpadUp':
          if (!_isSettingsOpen && mounted) {
            _zoomIn();
          }
          break;
        case 'onDpadDown':
          if (!_isSettingsOpen && mounted) {
            _zoomOut();
          }
          break;
      }
    });
  }



  void _initWebViewController() {
    final webUrl = 'https://talalive.ir/${widget.username}?tv=1&app=1';

    late final PlatformWebViewControllerCreationParams params;
    if (WebViewPlatform.instance is AndroidWebViewPlatform) {
      params = AndroidWebViewControllerCreationParams();
    } else {
      params = const PlatformWebViewControllerCreationParams();
    }

    final controller = WebViewController.fromPlatformCreationParams(params);

    controller
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setBackgroundColor(const Color(0xFF020617))
      ..setUserAgent(
        'Mozilla/5.0 (Linux; Android 10; SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 TalaLiveTV/2.0',
      )
      ..setNavigationDelegate(
        NavigationDelegate(
          onProgress: (progress) {
            if (progress >= 70 && mounted && _isWebLoading) {
              setState(() => _isWebLoading = false);
            }
          },
          onPageStarted: (url) {
            if (mounted) setState(() => _isWebLoading = true);
            Timer(const Duration(seconds: 4), () {
              if (mounted && _isWebLoading) {
                setState(() => _isWebLoading = false);
              }
            });
          },
          onPageFinished: (url) {
            if (mounted) setState(() => _isWebLoading = false);
            _webViewController?.runJavaScript('''
              (function() {
                if (document.getElementById('talalive-app-tuning')) return;
                const s = document.createElement('style');
                s.id = 'talalive-app-tuning';
                s.textContent = `
                  /* .ambient-orb-container { display: none !important; } */
                  #tv-stage-canvas { transform-style: flat !important; }
                `;
                document.head.appendChild(s);
              })();
            ''');
          },
          onWebResourceError: (error) {
            debugPrint('[TalaLiveTV] Web resource error: ${error.description}');
            if (mounted) setState(() => _isWebLoading = false);
          },
        ),
      );

    if (controller.platform is AndroidWebViewController) {
      final androidController = controller.platform as AndroidWebViewController;
      androidController.setMediaPlaybackRequiresUserGesture(false);
    }

    controller.loadRequest(Uri.parse(webUrl));
    _webViewController = controller;
  }

  Widget _buildWebViewWidget() {
    if (kIsWeb) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.language, size: 64, color: Color(0xFFF59E0B)),
            const SizedBox(height: 16),
            const Text(
              'شما در حال حاضر روی مرورگر وب قرار دارید.',
              style: TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn'),
            ),
            const SizedBox(height: 8),
            Text(
              'https://talalive.ir/${widget.username}?tv=1&app=1',
              style: const TextStyle(color: Color(0xFF94A3B8), fontSize: 14),
            ),
          ],
        ),
      );
    }
    if (_webViewController == null) {
      return const SizedBox.shrink();
    }
    final gestureRecognizers = <Factory<OneSequenceGestureRecognizer>>{
      Factory<LongPressGestureRecognizer>(
        () => LongPressGestureRecognizer()..onLongPress = _showSettingsMenu,
      ),
    };
    if (WebViewPlatform.instance is AndroidWebViewPlatform) {
      return WebViewWidget.fromPlatformCreationParams(
        params: AndroidWebViewWidgetCreationParams(
          controller: _webViewController!.platform,
          displayWithHybridComposition: false, // Texture Layer mode: eliminates surface tearing, clipping, and card flashing
          gestureRecognizers: gestureRecognizers,
        ),
      );
    }
    return WebViewWidget(
      controller: _webViewController!,
      gestureRecognizers: gestureRecognizers,
    );
  }

  void _loadSavedMode() async {
    final prefs = await SharedPreferences.getInstance();
    final savedMode = prefs.getBool(_prefKeyWebMode) ?? false;
    if (savedMode && mounted) {
      setState(() {
        _isWebViewMode = true;
      });
    }
  }

  void _setWebViewMode(bool enabled) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool(_prefKeyWebMode, enabled);
    if (mounted) {
      setState(() {
        _isWebViewMode = enabled;
      });
      if (enabled) {
        // Pause background polling and clock on TV to conserve CPU and RAM
        _refreshTimer?.cancel();
        _clockTimer?.cancel();
        Timer(const Duration(milliseconds: 3500), () {
          if (mounted && _isWebLoading) {
            setState(() => _isWebLoading = false);
          }
        });
      } else {
        // Resume clock and immediately fetch latest snapshot for Native board
        _startClockTimer();
        _fetchData();
      }
    }
  }

  void _loadSavedZoom() async {
    final prefs = await SharedPreferences.getInstance();
    final savedZoom = prefs.getDouble(_prefKeyZoom) ?? 1.0;
    if (mounted) {
      setState(() {
        _zoomLevel = savedZoom;
      });
    }
  }

  void _loadSavedThemeMode() async {
    final prefs = await SharedPreferences.getInstance();
    if (prefs.containsKey(_prefKeyDarkMode)) {
      final saved = prefs.getBool(_prefKeyDarkMode);
      if (mounted) {
        setState(() {
          _isDarkModeOverride = saved;
        });
      }
    }
  }

  void _toggleDarkMode() async {
    final currentIsDark = _isDarkModeOverride ??
        (_model != null ? BoardThemeData.fromMode(_model!.themeMode).isDark : true);
    final newMode = !currentIsDark;
    setState(() {
      _isDarkModeOverride = newMode;
    });
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool(_prefKeyDarkMode, newMode);
    _showZoomFeedback(newMode ? 'حالت تاریک فعال شد' : 'حالت روشن فعال شد');
  }

  void _zoomIn() async {
    final newZoom = (_zoomLevel + 0.05).clamp(0.70, 1.35);
    final rounded = double.parse(newZoom.toStringAsFixed(2));
    setState(() => _zoomLevel = rounded);
    final prefs = await SharedPreferences.getInstance();
    await prefs.setDouble(_prefKeyZoom, rounded);
    if (_isWebViewMode) {
      _webViewController?.runJavaScript("window.dispatchEvent(new KeyboardEvent('keydown', { key: '+' }));");
    }
    _showZoomFeedback('بزرگ‌نمایی: ${PersianUtils.toPersianDigits((rounded * 100).round().toString())}٪');
  }

  void _zoomOut() async {
    final newZoom = (_zoomLevel - 0.05).clamp(0.70, 1.35);
    final rounded = double.parse(newZoom.toStringAsFixed(2));
    setState(() => _zoomLevel = rounded);
    final prefs = await SharedPreferences.getInstance();
    await prefs.setDouble(_prefKeyZoom, rounded);
    if (_isWebViewMode) {
      _webViewController?.runJavaScript("window.dispatchEvent(new KeyboardEvent('keydown', { key: '-' }));");
    }
    _showZoomFeedback('کوچک‌نمایی: ${PersianUtils.toPersianDigits((rounded * 100).round().toString())}٪');
  }

  void _resetZoom() async {
    setState(() => _zoomLevel = 1.0);
    final prefs = await SharedPreferences.getInstance();
    await prefs.setDouble(_prefKeyZoom, 1.0);
    if (_isWebViewMode) {
      _webViewController?.runJavaScript("window.dispatchEvent(new KeyboardEvent('keydown', { key: '0' }));");
    }
    _showZoomFeedback('مقیاس: ۱۰۰٪');
  }

  void _showZoomFeedback(String text) {
    _zoomFeedbackTimer?.cancel();
    if (mounted) {
      setState(() {
        _zoomFeedbackText = text;
      });
    }
    _zoomFeedbackTimer = Timer(const Duration(seconds: 2), () {
      if (mounted) {
        setState(() {
          _zoomFeedbackText = null;
        });
      }
    });
  }

  void _loadInstalledVersion() async {
    final info = await UpdateService.getAppVersion();
    if (mounted) {
      setState(() {
        _installedVersion = info['versionName'] as String;
      });
    }
  }

  void _fetchData() async {
    final model = await ApiService.fetchSnapshot(widget.username);

    if (!mounted) return;

    if (model != null) {
      setState(() {
        _model = model;
        _isLoading = false;
        _isOffline = false;
      });

      _scheduleNextRefresh(model.refreshIntervalSeconds);
    } else {
      setState(() {
        _isOffline = true;
        _isLoading = false;
      });
      _scheduleNextRefresh(15);
    }
  }

  void _scheduleNextRefresh(int seconds) {
    _refreshTimer?.cancel();
    _refreshTimer = Timer(Duration(seconds: seconds), () {
      if (mounted) _fetchData();
    });
  }

  @override
  void dispose() {
    _clockTimer?.cancel();
    _refreshTimer?.cancel();
    _updateCheckTimer?.cancel();
    _zoomFeedbackTimer?.cancel();
    _focusNode.dispose();
    _timeNotifier.dispose();
    super.dispose();
  }

  void _handleKey(KeyEvent event) {
    if (event is KeyDownEvent) {
      if (event.logicalKey == LogicalKeyboardKey.contextMenu ||
          event.logicalKey == LogicalKeyboardKey.keyM ||
          event.logicalKey == LogicalKeyboardKey.select) {
        if (!_isSettingsOpen) {
          _showSettingsMenu();
        }
        return;
      }
      if (event.logicalKey == LogicalKeyboardKey.arrowUp ||
          event.logicalKey == LogicalKeyboardKey.pageUp) {
        if (!_isSettingsOpen) {
          _zoomIn();
          return;
        }
      }
      if (event.logicalKey == LogicalKeyboardKey.arrowDown ||
          event.logicalKey == LogicalKeyboardKey.pageDown) {
        if (!_isSettingsOpen) {
          _zoomOut();
          return;
        }
      }
      if (event.logicalKey == LogicalKeyboardKey.escape ||
          event.logicalKey == LogicalKeyboardKey.backspace) {
        if (_isSettingsOpen) {
          return;
        }
        if (_isWebViewMode) {
          _setWebViewMode(false);
        } else {
          _showExitDialog();
        }
      }
    }
  }


  void _showSettingsMenu() {
    if (_isSettingsOpen) return;
    _isSettingsOpen = true;
    _nativeChannel.invokeMethod('setDialogState', {'isOpen': true});

    showDialog(
      context: context,
      barrierColor: Colors.black.withOpacity(0.7),
      builder: (ctx) => BackdropFilter(
        filter: ImageFilter.blur(sigmaX: 12, sigmaY: 12),
        child: StatefulBuilder(
          builder: (dialogCtx, setDialogState) => Dialog(
            backgroundColor: const Color(0xFF0F172A).withOpacity(0.96),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(24),
              side: BorderSide(color: const Color(0xFFF59E0B).withOpacity(0.4), width: 1.5),
            ),
            insetPadding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            child: Container(
              constraints: const BoxConstraints(maxWidth: 680, maxHeight: 420),
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 18),
              child: Directionality(
                textDirection: TextDirection.rtl,
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  children: [
                    // Header Row
                    Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(8),
                          decoration: BoxDecoration(
                            color: const Color(0xFFF59E0B).withOpacity(0.15),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Icon(Icons.settings_outlined, color: Color(0xFFF59E0B), size: 22),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: Row(
                            children: [
                              const Text(
                                'تنظیمات تابلوی طلالایو',
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 16,
                                  fontWeight: FontWeight.w900,
                                  fontFamily: 'Vazirmatn',
                                ),
                              ),
                              const SizedBox(width: 12),
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                                decoration: BoxDecoration(
                                  color: (_isOffline ? Colors.redAccent : const Color(0xFF10B981)).withOpacity(0.2),
                                  borderRadius: BorderRadius.circular(8),
                                  border: Border.all(color: (_isOffline ? Colors.redAccent : const Color(0xFF10B981)).withOpacity(0.4)),
                                ),
                                child: Text(
                                  _isOffline ? 'آفلاین' : 'برخط',
                                  style: TextStyle(
                                    color: _isOffline ? Colors.redAccent : const Color(0xFF10B981),
                                    fontSize: 11,
                                    fontFamily: 'Vazirmatn',
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ),
                              const SizedBox(width: 8),
                              Text(
                                'نسخه ${PersianUtils.toPersianDigits(_installedVersion)}',
                                style: const TextStyle(color: Color(0xFF94A3B8), fontSize: 11, fontFamily: 'Vazirmatn'),
                              ),
                            ],
                          ),
                        ),
                        IconButton(
                          onPressed: () => Navigator.of(ctx).pop(),
                          icon: const Icon(Icons.close, color: Colors.white70, size: 20),
                          padding: EdgeInsets.zero,
                          constraints: const BoxConstraints(),
                        ),
                      ],
                    ),

                    const SizedBox(height: 12),
                    const Divider(color: Color(0xFF334155), height: 1),
                    const SizedBox(height: 12),

                    // Grid Layout: 2 Columns x 2 Cards (Compact & Fits TV screen without scroll)
                    Expanded(
                      child: Row(
                        crossAxisAlignment: CrossAxisAlignment.stretch,
                        children: [
                          // Column 1: Mode Switch + Zoom
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.stretch,
                              children: [
                                // Box 1: Mode Switch
                                Container(
                                  padding: const EdgeInsets.all(12),
                                  decoration: BoxDecoration(
                                    color: const Color(0xFF1E293B),
                                    borderRadius: BorderRadius.circular(16),
                                    border: Border.all(color: const Color(0xFF334155)),
                                  ),
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      const Text(
                                        'حالت نمایش تابلو:',
                                        style: TextStyle(color: Color(0xFF94A3B8), fontSize: 11, fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn'),
                                      ),
                                      const SizedBox(height: 8),
                                      Row(
                                        children: [
                                          // Native
                                          Expanded(
                                            child: InkWell(
                                              onTap: () {
                                                Navigator.of(ctx).pop();
                                                if (_isWebViewMode) _setWebViewMode(false);
                                              },
                                              borderRadius: BorderRadius.circular(10),
                                              child: Container(
                                                padding: const EdgeInsets.symmetric(vertical: 8),
                                                decoration: BoxDecoration(
                                                  color: !_isWebViewMode ? const Color(0xFFF59E0B).withOpacity(0.2) : Colors.transparent,
                                                  borderRadius: BorderRadius.circular(10),
                                                  border: Border.all(
                                                    color: !_isWebViewMode ? const Color(0xFFF59E0B) : const Color(0xFF475569),
                                                  ),
                                                ),
                                                child: Row(
                                                  mainAxisAlignment: MainAxisAlignment.center,
                                                  children: [
                                                    Icon(Icons.bolt, size: 16, color: !_isWebViewMode ? const Color(0xFFF59E0B) : Colors.white60),
                                                    const SizedBox(width: 4),
                                                    Text(
                                                      'بومی (نیتیو)',
                                                      style: TextStyle(
                                                        color: !_isWebViewMode ? Colors.white : Colors.white60,
                                                        fontSize: 12,
                                                        fontWeight: FontWeight.bold,
                                                        fontFamily: 'Vazirmatn',
                                                      ),
                                                    ),
                                                  ],
                                                ),
                                              ),
                                            ),
                                          ),
                                          const SizedBox(width: 8),
                                          // Web
                                          Expanded(
                                            child: InkWell(
                                              onTap: () {
                                                Navigator.of(ctx).pop();
                                                if (!_isWebViewMode) _setWebViewMode(true);
                                              },
                                              borderRadius: BorderRadius.circular(10),
                                              child: Container(
                                                padding: const EdgeInsets.symmetric(vertical: 8),
                                                decoration: BoxDecoration(
                                                  color: _isWebViewMode ? const Color(0xFF3B82F6).withOpacity(0.2) : Colors.transparent,
                                                  borderRadius: BorderRadius.circular(10),
                                                  border: Border.all(
                                                    color: _isWebViewMode ? const Color(0xFF3B82F6) : const Color(0xFF475569),
                                                  ),
                                                ),
                                                child: Row(
                                                  mainAxisAlignment: MainAxisAlignment.center,
                                                  children: [
                                                    Icon(Icons.language, size: 16, color: _isWebViewMode ? const Color(0xFF3B82F6) : Colors.white60),
                                                    const SizedBox(width: 4),
                                                    Text(
                                                      'زنده وب',
                                                      style: TextStyle(
                                                        color: _isWebViewMode ? Colors.white : Colors.white60,
                                                        fontSize: 12,
                                                        fontWeight: FontWeight.bold,
                                                        fontFamily: 'Vazirmatn',
                                                      ),
                                                    ),
                                                  ],
                                                ),
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),

                                const SizedBox(height: 10),

                                // Box 2: Zoom Controls
                                Expanded(
                                  child: Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                                    decoration: BoxDecoration(
                                      color: const Color(0xFF1E293B),
                                      borderRadius: BorderRadius.circular(16),
                                      border: Border.all(color: const Color(0xFF334155)),
                                    ),
                                    child: Column(
                                      mainAxisAlignment: MainAxisAlignment.center,
                                      crossAxisAlignment: CrossAxisAlignment.stretch,
                                      children: [
                                        Row(
                                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                          children: [
                                            const Text(
                                              'بزرگ‌نمایی تابلو:',
                                              style: TextStyle(color: Color(0xFF94A3B8), fontSize: 11, fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn'),
                                            ),
                                            const Text(
                                              '(جهت‌های ↑ و ↓ کنترل)',
                                              style: TextStyle(color: Color(0xFF64748B), fontSize: 10, fontFamily: 'Vazirmatn'),
                                            ),
                                          ],
                                        ),
                                        const SizedBox(height: 4),
                                        Row(
                                          mainAxisAlignment: MainAxisAlignment.center,
                                          children: [
                                            // Zoom Out
                                            IconButton(
                                              onPressed: () {
                                                _zoomOut();
                                                setDialogState(() {});
                                              },
                                              icon: const Icon(Icons.remove_circle_outline, color: Colors.white70, size: 24),
                                              tooltip: 'کوچک‌نمایی',
                                              padding: EdgeInsets.zero,
                                              constraints: const BoxConstraints(minWidth: 36, minHeight: 36),
                                            ),
                                            const SizedBox(width: 8),
                                            // Percentage button
                                            InkWell(
                                              onTap: () {
                                                _resetZoom();
                                                setDialogState(() {});
                                              },
                                              borderRadius: BorderRadius.circular(8),
                                              child: Container(
                                                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 4),
                                                decoration: BoxDecoration(
                                                  color: const Color(0xFF0F172A),
                                                  borderRadius: BorderRadius.circular(8),
                                                  border: Border.all(color: const Color(0xFFF59E0B).withOpacity(0.5)),
                                                ),
                                                child: Text(
                                                  '${PersianUtils.toPersianDigits((_zoomLevel * 100).round().toString())}٪',
                                                  style: const TextStyle(
                                                    color: Color(0xFFF59E0B),
                                                    fontWeight: FontWeight.w900,
                                                    fontSize: 16,
                                                    fontFamily: 'Vazirmatn',
                                                  ),
                                                ),
                                              ),
                                            ),
                                            const SizedBox(width: 8),
                                            // Zoom In
                                            IconButton(
                                              onPressed: () {
                                                _zoomIn();
                                                setDialogState(() {});
                                              },
                                              icon: const Icon(Icons.add_circle_outline, color: Color(0xFFF59E0B), size: 24),
                                              tooltip: 'بزرگ‌نمایی',
                                              padding: EdgeInsets.zero,
                                              constraints: const BoxConstraints(minWidth: 36, minHeight: 36),
                                            ),
                                          ],
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),

                          const SizedBox(width: 12),

                          // Column 2: OTA Update + Quick Actions
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.stretch,
                              children: [
                                // Box 3: OTA Update Card
                                Container(
                                  padding: const EdgeInsets.all(12),
                                  decoration: BoxDecoration(
                                    color: const Color(0xFF1E293B),
                                    borderRadius: BorderRadius.circular(16),
                                    border: Border.all(
                                      color: _availableUpdate != null
                                          ? const Color(0xFF10B981).withOpacity(0.6)
                                          : const Color(0xFF38BDF8).withOpacity(0.3),
                                    ),
                                  ),
                                  child: Row(
                                    children: [
                                      Container(
                                        padding: const EdgeInsets.all(8),
                                        decoration: BoxDecoration(
                                          color: (_availableUpdate != null ? const Color(0xFF10B981) : const Color(0xFF38BDF8)).withOpacity(0.15),
                                          borderRadius: BorderRadius.circular(10),
                                        ),
                                        child: Icon(
                                          _availableUpdate != null ? Icons.system_update_rounded : Icons.cloud_download_outlined,
                                          color: _availableUpdate != null ? const Color(0xFF10B981) : const Color(0xFF38BDF8),
                                          size: 20,
                                        ),
                                      ),
                                      const SizedBox(width: 10),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Text(
                                              _availableUpdate != null ? 'نسخه جدید آماده نصب است' : 'بروزرسانی آنلاین (OTA)',
                                              style: TextStyle(
                                                color: _availableUpdate != null ? const Color(0xFF34D399) : Colors.white,
                                                fontWeight: FontWeight.bold,
                                                fontSize: 12,
                                                fontFamily: 'Vazirmatn',
                                              ),
                                            ),
                                            const SizedBox(height: 2),
                                            Text(
                                              _availableUpdate != null
                                                  ? 'نسخه ${PersianUtils.toPersianDigits(_availableUpdate!.remoteVersion)}'
                                                  : 'نسخه شما: ${PersianUtils.toPersianDigits(_installedVersion)}',
                                              style: const TextStyle(color: Color(0xFF94A3B8), fontSize: 10, fontFamily: 'Vazirmatn'),
                                            ),
                                          ],
                                        ),
                                      ),
                                      ElevatedButton(
                                        onPressed: () {
                                          Navigator.of(ctx).pop();
                                          if (_availableUpdate != null) {
                                            _showUpdateDialog(_availableUpdate!);
                                          } else {
                                            _checkForUpdate(manual: true);
                                          }
                                        },
                                        style: ElevatedButton.styleFrom(
                                          backgroundColor: _availableUpdate != null ? const Color(0xFF10B981) : const Color(0xFF38BDF8),
                                          foregroundColor: Colors.white,
                                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                                          minimumSize: Size.zero,
                                          tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                                        ),
                                        child: Text(
                                          _availableUpdate != null ? 'نصب آپدیت' : 'بررسی',
                                          style: const TextStyle(fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn', fontSize: 11),
                                        ),
                                      ),
                                    ],
                                  ),
                                ),

                                const SizedBox(height: 10),

                                // Box 4: Quick Actions (Refresh & Exit)
                                Expanded(
                                  child: Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                                    decoration: BoxDecoration(
                                      color: const Color(0xFF1E293B),
                                      borderRadius: BorderRadius.circular(16),
                                      border: Border.all(color: const Color(0xFF334155)),
                                    ),
                                    child: Row(
                                      children: [
                                        // Refresh Button
                                        Expanded(
                                          child: OutlinedButton.icon(
                                            onPressed: () {
                                              Navigator.of(ctx).pop();
                                              if (_isWebViewMode) {
                                                _webViewController?.reload();
                                              } else {
                                                _fetchData();
                                              }
                                            },
                                            icon: const Icon(Icons.refresh, size: 16, color: Color(0xFFF59E0B)),
                                            label: const Text('بروزرسانی داده', style: TextStyle(color: Colors.white, fontFamily: 'Vazirmatn', fontSize: 11)),
                                            style: OutlinedButton.styleFrom(
                                              side: const BorderSide(color: Color(0xFF334155)),
                                              padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 8),
                                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                            ),
                                          ),
                                        ),
                                        const SizedBox(width: 8),
                                        // Exit / Unpair
                                        Expanded(
                                          child: OutlinedButton.icon(
                                            onPressed: () {
                                              Navigator.of(ctx).pop();
                                              _showExitDialog();
                                            },
                                            icon: const Icon(Icons.link_off, size: 16, color: Colors.redAccent),
                                            label: const Text('خروج / لغو اتصال', style: TextStyle(color: Colors.redAccent, fontFamily: 'Vazirmatn', fontSize: 11)),
                                            style: OutlinedButton.styleFrom(
                                              side: BorderSide(color: Colors.redAccent.withOpacity(0.4)),
                                              padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 8),
                                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),

                    const SizedBox(height: 10),
                    // Quick Remote Help Bar
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
                      decoration: BoxDecoration(
                        color: const Color(0xFF0F172A),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: const Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.tv_rounded, size: 14, color: Color(0xFF94A3B8)),
                          SizedBox(width: 6),
                          Text(
                            'کنترل تلویزیون: کلید Menu برای بازکردن منو  •  کلیدهای ↑ و ↓ برای بزرگ‌نمایی/کوچک‌نمایی',
                            style: TextStyle(color: Color(0xFF94A3B8), fontSize: 10, fontFamily: 'Vazirmatn'),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    ).then((_) {
      _isSettingsOpen = false;
      _nativeChannel.invokeMethod('setDialogState', {'isOpen': false});
      _focusNode.requestFocus();
    });
  }

  void _showExitDialog() {
    _isSettingsOpen = true;
    _nativeChannel.invokeMethod('setDialogState', {'isOpen': true});

    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: const Color(0xFF0F172A),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        title: const Text(
          'خروج یا لغو اتصال تلویزیون',
          textDirection: TextDirection.rtl,
          style: TextStyle(color: Color(0xFFF59E0B), fontWeight: FontWeight.w900),
        ),
        content: const Text(
          'آیا می‌خواهید از برنامه خارج شوید یا اتصال این تلویزیون به گالری را قطع فرمایید؟',
          textDirection: TextDirection.rtl,
          style: TextStyle(color: Color(0xFFCBD5E1), height: 1.5),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(ctx).pop(),
            child: const Text('انصراف', style: TextStyle(color: Color(0xFF94A3B8))),
          ),
          TextButton(
            onPressed: () async {
              Navigator.of(ctx).pop();
              await ApiService.unpair();
              if (mounted) {
                Navigator.of(context).pushReplacement(
                  MaterialPageRoute(builder: (_) => const PairingScreen()),
                );
              }
            },
            child: const Text('قطع اتصال (Unpair)', style: TextStyle(color: Colors.redAccent, fontWeight: FontWeight.bold)),
          ),
          ElevatedButton(
            onPressed: () {
              SystemNavigator.pop();
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFFF59E0B),
              foregroundColor: Colors.black,
            ),
            child: const Text('خروج از اپ'),
          ),
        ],
      ),
    ).then((_) {
      _isSettingsOpen = false;
      _nativeChannel.invokeMethod('setDialogState', {'isOpen': false});
      _focusNode.requestFocus();
    });
  }


  void _checkForUpdate({bool manual = false}) async {
    if (manual) {
      showDialog(
        context: context,
        barrierDismissible: false,
        barrierColor: Colors.black54,
        builder: (ctx) => Center(
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 20),
            decoration: BoxDecoration(
              color: const Color(0xFF0F172A),
              borderRadius: BorderRadius.circular(20),
              border: Border.all(color: const Color(0xFF38BDF8).withOpacity(0.5)),
              boxShadow: [
                BoxShadow(color: Colors.black.withOpacity(0.5), blurRadius: 20, offset: const Offset(0, 8)),
              ],
            ),
            child: const Directionality(
              textDirection: TextDirection.rtl,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  SizedBox(
                    width: 24,
                    height: 24,
                    child: CircularProgressIndicator(color: Color(0xFF38BDF8), strokeWidth: 2.5),
                  ),
                  SizedBox(width: 16),
                  Text(
                    'در حال بررسی آخرین نسخه طلالایو...',
                    style: TextStyle(color: Colors.white, fontFamily: 'Vazirmatn', fontSize: 14),
                  ),
                ],
              ),
            ),
          ),
        ),
      );
    }

    final update = await UpdateService.checkUpdate();

    if (manual && mounted) {
      Navigator.of(context, rootNavigator: true).pop();
    }

    if (!mounted) return;

    if (update.hasUpdate) {
      setState(() => _availableUpdate = update);
      _showUpdateDialog(update);
    } else if (manual) {
      _showUpToDateDialog();
    }
  }

  void _showUpToDateDialog() {
    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: const Color(0xFF0F172A),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(24),
          side: BorderSide(color: const Color(0xFF10B981).withOpacity(0.4)),
        ),
        title: Row(
          mainAxisAlignment: MainAxisAlignment.end,
          children: [
            const Text(
              'برنامه کاملاً بروز است',
              style: TextStyle(color: Color(0xFF10B981), fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn', fontSize: 16),
              textDirection: TextDirection.rtl,
            ),
            const SizedBox(width: 10),
            Container(
              padding: const EdgeInsets.all(6),
              decoration: BoxDecoration(
                color: const Color(0xFF10B981).withOpacity(0.2),
                shape: BoxShape.circle,
              ),
              child: const Icon(Icons.check_circle_outline, color: Color(0xFF10B981), size: 24),
            ),
          ],
        ),
        content: Directionality(
          textDirection: TextDirection.rtl,
          child: Text(
            'شما در حال حاضر از آخرین نسخه پایدار طلالایو TV (نسخه ${PersianUtils.toPersianDigits(_installedVersion)}) استفاده می‌فرمایید.',
            style: const TextStyle(color: Color(0xFFCBD5E1), fontFamily: 'Vazirmatn', fontSize: 14, height: 1.6),
          ),
        ),
        actions: [
          ElevatedButton(
            onPressed: () => Navigator.of(ctx).pop(),
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF10B981),
              foregroundColor: Colors.white,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
            ),
            child: const Text('متوجه شدم', style: TextStyle(fontFamily: 'Vazirmatn', fontWeight: FontWeight.bold)),
          ),
        ],
      ),
    );
  }

  void _showUpdateDialog(UpdateInfo info) {
    _isSettingsOpen = true;
    _nativeChannel.invokeMethod('setDialogState', {'isOpen': true});

    bool isDownloading = false;
    double progress = 0.0;
    int receivedBytes = 0;
    int totalBytes = 0;
    String statusMessage = '';
    String? errorMessage;
    bool isCancelled = false;

    showDialog(
      context: context,
      barrierDismissible: !info.isMandatory && !isDownloading,
      barrierColor: Colors.black.withOpacity(0.75),
      builder: (ctx) => BackdropFilter(
        filter: ImageFilter.blur(sigmaX: 12, sigmaY: 12),
        child: StatefulBuilder(
          builder: (dialogCtx, setDialogState) {
            final percentInt = (progress * 100).round();
            final receivedMb = (receivedBytes / (1024 * 1024)).toStringAsFixed(1);
            final totalMb = totalBytes > 0
                ? (totalBytes / (1024 * 1024)).toStringAsFixed(1)
                : info.fileSize;

            return Dialog(
              backgroundColor: const Color(0xFF0F172A).withOpacity(0.96),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(28),
                side: BorderSide(
                  color: const Color(0xFFF59E0B).withOpacity(0.5),
                  width: 1.5,
                ),
              ),
              insetPadding: const EdgeInsets.symmetric(horizontal: 28, vertical: 24),
              child: Container(
                constraints: const BoxConstraints(maxWidth: 560, maxHeight: 580),
                padding: const EdgeInsets.all(24),
                child: Directionality(
                  textDirection: TextDirection.rtl,
                  child: SingleChildScrollView(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        // Header
                        Row(
                          children: [
                            Container(
                              padding: const EdgeInsets.all(12),
                              decoration: BoxDecoration(
                                gradient: const LinearGradient(
                                  colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                                  begin: Alignment.topLeft,
                                  end: Alignment.bottomRight,
                                ),
                                borderRadius: BorderRadius.circular(16),
                                boxShadow: [
                                  BoxShadow(
                                    color: const Color(0xFFF59E0B).withOpacity(0.35),
                                    blurRadius: 12,
                                    offset: const Offset(0, 4),
                                  ),
                                ],
                              ),
                              child: const Icon(
                                Icons.system_update_rounded,
                                color: Colors.black,
                                size: 28,
                              ),
                            ),
                            const SizedBox(width: 14),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    info.title,
                                    style: const TextStyle(
                                      color: Colors.white,
                                      fontSize: 17,
                                      fontWeight: FontWeight.w900,
                                      fontFamily: 'Vazirmatn',
                                    ),
                                  ),
                                  const SizedBox(height: 2),
                                  const Text(
                                    'نسخه جدید طلالایو TV آماده دریافت و نصب خودکار است',
                                    style: TextStyle(
                                      color: Color(0xFF94A3B8),
                                      fontSize: 12,
                                      fontFamily: 'Vazirmatn',
                                    ),
                                  ),
                                ],
                              ),
                            ),
                            if (!info.isMandatory && !isDownloading)
                              IconButton(
                                onPressed: () => Navigator.of(dialogCtx).pop(),
                                icon: const Icon(Icons.close, color: Colors.white70),
                              ),
                          ],
                        ),

                        const SizedBox(height: 18),
                        const Divider(color: Color(0xFF334155), height: 1),
                        const SizedBox(height: 16),

                        // Version Comparison & File Size Badge
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
                          decoration: BoxDecoration(
                            color: const Color(0xFF1E293B),
                            borderRadius: BorderRadius.circular(16),
                            border: Border.all(color: const Color(0xFF334155)),
                          ),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              // Old vs New
                              Row(
                                children: [
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                    decoration: BoxDecoration(
                                      color: const Color(0xFF334155),
                                      borderRadius: BorderRadius.circular(8),
                                    ),
                                    child: Text(
                                      'نسخه کنونی: ${PersianUtils.toPersianDigits(info.currentVersion)}',
                                      style: const TextStyle(color: Color(0xFFCBD5E1), fontSize: 11, fontFamily: 'Vazirmatn'),
                                    ),
                                  ),
                                  const Padding(
                                    padding: EdgeInsets.symmetric(horizontal: 8),
                                    child: Icon(Icons.arrow_back_rounded, color: Color(0xFFF59E0B), size: 16),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                    decoration: BoxDecoration(
                                      color: const Color(0xFFF59E0B).withOpacity(0.2),
                                      border: Border.all(color: const Color(0xFFF59E0B)),
                                      borderRadius: BorderRadius.circular(8),
                                    ),
                                    child: Text(
                                      'نسخه جدید: ${PersianUtils.toPersianDigits(info.remoteVersion)}',
                                      style: const TextStyle(color: Color(0xFFF59E0B), fontSize: 11, fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn'),
                                    ),
                                  ),
                                ],
                              ),
                              // File Size
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                decoration: BoxDecoration(
                                  color: const Color(0xFF0F172A),
                                  borderRadius: BorderRadius.circular(8),
                                ),
                                child: Text(
                                  'حجم: ${PersianUtils.toPersianDigits(info.fileSize)}',
                                  style: const TextStyle(color: Color(0xFF94A3B8), fontSize: 11, fontFamily: 'Vazirmatn'),
                                ),
                              ),
                            ],
                          ),
                        ),

                        const SizedBox(height: 16),

                        // Changelog Box
                        const Text(
                          'تغییرات و امکانات جدید این نسخه:',
                          style: TextStyle(
                            color: Color(0xFF94A3B8),
                            fontSize: 13,
                            fontWeight: FontWeight.bold,
                            fontFamily: 'Vazirmatn',
                          ),
                        ),
                        const SizedBox(height: 8),
                        Container(
                          padding: const EdgeInsets.all(14),
                          decoration: BoxDecoration(
                            color: const Color(0xFF020617).withOpacity(0.6),
                            borderRadius: BorderRadius.circular(16),
                            border: Border.all(color: const Color(0xFF334155)),
                          ),
                          child: Text(
                            info.changelog,
                            style: const TextStyle(
                              color: Color(0xFFE2E8F0),
                              fontSize: 13,
                              height: 1.8,
                              fontFamily: 'Vazirmatn',
                            ),
                          ),
                        ),

                        // Error Banner (if any)
                        if (errorMessage != null) ...[
                          const SizedBox(height: 14),
                          Container(
                            padding: const EdgeInsets.all(12),
                            decoration: BoxDecoration(
                              color: Colors.redAccent.withOpacity(0.15),
                              borderRadius: BorderRadius.circular(12),
                              border: Border.all(color: Colors.redAccent.withOpacity(0.4)),
                            ),
                            child: Row(
                              children: [
                                const Icon(Icons.error_outline, color: Colors.redAccent, size: 20),
                                const SizedBox(width: 8),
                                Expanded(
                                  child: Text(
                                    errorMessage!,
                                    style: const TextStyle(color: Colors.redAccent, fontSize: 12, fontFamily: 'Vazirmatn'),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],

                        // Downloading State
                        if (isDownloading) ...[
                          const SizedBox(height: 20),
                          Container(
                            padding: const EdgeInsets.all(16),
                            decoration: BoxDecoration(
                              color: const Color(0xFF1E293B),
                              borderRadius: BorderRadius.circular(16),
                              border: Border.all(color: const Color(0xFFF59E0B).withOpacity(0.3)),
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.stretch,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Text(
                                      statusMessage.isNotEmpty ? statusMessage : 'در حال دانلود فایل بروزرسانی...',
                                      style: const TextStyle(color: Colors.white, fontSize: 12, fontWeight: FontWeight.bold, fontFamily: 'Vazirmatn'),
                                    ),
                                    Text(
                                      '${PersianUtils.toPersianDigits(percentInt.toString())}٪',
                                      style: const TextStyle(color: Color(0xFFF59E0B), fontSize: 14, fontWeight: FontWeight.w900, fontFamily: 'Vazirmatn'),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 10),
                                ClipRRect(
                                  borderRadius: BorderRadius.circular(8),
                                  child: LinearProgressIndicator(
                                    value: progress > 0 ? progress : null,
                                    minHeight: 8,
                                    backgroundColor: const Color(0xFF334155),
                                    valueColor: const AlwaysStoppedAnimation<Color>(Color(0xFFF59E0B)),
                                  ),
                                ),
                                const SizedBox(height: 8),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Text(
                                      '${PersianUtils.toPersianDigits(receivedMb)} مگابایت از ${PersianUtils.toPersianDigits(totalMb)}',
                                      style: const TextStyle(color: Color(0xFF94A3B8), fontSize: 11, fontFamily: 'Vazirmatn'),
                                    ),
                                    const Text(
                                      'لطفاً تلویزیون را خاموش نکنید',
                                      style: TextStyle(color: Color(0xFF64748B), fontSize: 10, fontFamily: 'Vazirmatn'),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ],

                        const SizedBox(height: 20),

                        // Action Buttons
                        if (!isDownloading) ...[
                          Row(
                            children: [
                              Expanded(
                                flex: 3,
                                child: ElevatedButton.icon(
                                  onPressed: () {
                                    setDialogState(() {
                                      isDownloading = true;
                                      errorMessage = null;
                                      statusMessage = 'در حال برقراری ارتباط با سرور...';
                                      progress = 0.0;
                                      receivedBytes = 0;
                                    });

                                    UpdateService.downloadAndInstall(
                                      downloadUrl: info.downloadUrl,
                                      onProgress: (received, total) {
                                        setDialogState(() {
                                          receivedBytes = received;
                                          totalBytes = total;
                                          progress = total > 0 ? (received / total).clamp(0.0, 1.0) : 0.0;
                                          statusMessage = 'در حال دریافت فایل بروزرسانی...';
                                        });
                                      },
                                      onInstallStarted: () {
                                        setDialogState(() {
                                          statusMessage = 'دانلود کامل شد! در حال اجرای نصاب اندروید...';
                                        });
                                      },
                                      onError: (err) {
                                        setDialogState(() {
                                          isDownloading = false;
                                          errorMessage = err;
                                        });
                                      },
                                      isCancelled: () => isCancelled,
                                    );
                                  },
                                  icon: const Icon(Icons.download_rounded, size: 20),
                                  label: const Text(
                                    'دانلود و نصب خودکار',
                                    style: TextStyle(fontFamily: 'Vazirmatn', fontWeight: FontWeight.bold, fontSize: 14),
                                  ),
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: const Color(0xFFF59E0B),
                                    foregroundColor: Colors.black,
                                    padding: const EdgeInsets.symmetric(vertical: 14),
                                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                                    elevation: 4,
                                  ),
                                ),
                              ),
                              if (!info.isMandatory) ...[
                                const SizedBox(width: 12),
                                Expanded(
                                  flex: 1,
                                  child: OutlinedButton(
                                    onPressed: () => Navigator.of(dialogCtx).pop(),
                                    style: OutlinedButton.styleFrom(
                                      side: const BorderSide(color: Color(0xFF334155)),
                                      foregroundColor: const Color(0xFF94A3B8),
                                      padding: const EdgeInsets.symmetric(vertical: 14),
                                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                                    ),
                                    child: const Text('انصراف', style: TextStyle(fontFamily: 'Vazirmatn', fontSize: 13)),
                                  ),
                                ),
                              ],
                            ],
                          ),
                        ] else ...[
                          OutlinedButton(
                            onPressed: () {
                              isCancelled = true;
                              Navigator.of(dialogCtx).pop();
                            },
                            style: OutlinedButton.styleFrom(
                              side: const BorderSide(color: Color(0xFF475569)),
                              foregroundColor: const Color(0xFFCBD5E1),
                              padding: const EdgeInsets.symmetric(vertical: 12),
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                            ),
                            child: const Text('لغو دانلود', style: TextStyle(fontFamily: 'Vazirmatn', fontSize: 13)),
                          ),
                        ],
                      ],
                    ),
                  ),
                ),
              ),
            );
          },
        ),
      ),
    ).then((_) {
      _isSettingsOpen = false;
      _nativeChannel.invokeMethod('setDialogState', {'isOpen': false});
      _focusNode.requestFocus();
    });
  }

  @override
  Widget build(BuildContext context) {

    // =========================================================================
    // 1. Web View Mode (Smooth & Hybrid Composition without flickering)
    // =========================================================================
    if (_isWebViewMode) {
      return KeyboardListener(
        focusNode: _focusNode,
        onKeyEvent: _handleKey,
        child: Scaffold(
          backgroundColor: const Color(0xFF020617),
          body: GestureDetector(
            onLongPress: _showSettingsMenu,
            behavior: HitTestBehavior.translucent,
            child: Stack(
              children: [
                _buildWebViewWidget(),

                // Smooth Loading Indicator
                if (_isWebLoading)
                  Container(
                    color: const Color(0xFF020617),
                    alignment: Alignment.center,
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const CircularProgressIndicator(color: Color(0xFFF59E0B)),
                        const SizedBox(height: 20),
                        Text(
                          'در حال بارگذاری تابلوی زنده وب طلالایو (${widget.username})...',
                          style: const TextStyle(color: Colors.white70, fontSize: 18),
                        ),
                      ],
                    ),
                  ),

                // Zoom Feedback HUD
                if (_zoomFeedbackText != null)
                  Positioned(
                    bottom: 30,
                    left: 0,
                    right: 0,
                    child: Center(
                      child: Container(
                        padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 10),
                        decoration: BoxDecoration(
                          color: const Color(0xFF0F172A).withOpacity(0.92),
                          borderRadius: BorderRadius.circular(20),
                          border: Border.all(color: const Color(0xFFF59E0B), width: 1.5),
                          boxShadow: [
                            BoxShadow(color: Colors.black.withOpacity(0.6), blurRadius: 16, offset: const Offset(0, 4)),
                          ],
                        ),
                        child: Text(
                          _zoomFeedbackText!,
                          style: const TextStyle(
                            color: Color(0xFFF59E0B),
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            fontFamily: 'Vazirmatn',
                          ),
                        ),
                      ),
                    ),
                  ),
              ],
            ),
          ),
        ),
      );
    }

    // =========================================================================
    // 2. High-Fidelity Native Flutter Board Mode
    // =========================================================================
    final isDark = _isDarkModeOverride ??
        (_model != null ? BoardThemeData.fromMode(_model!.themeMode).isDark : true);
    final theme = isDark ? BoardThemeData.onyxGold : BoardThemeData.imperialPearl;

    return KeyboardListener(
      focusNode: _focusNode,
      onKeyEvent: _handleKey,
      child: Scaffold(
        backgroundColor: theme.backgroundColor,
        body: GestureDetector(
          onLongPress: _showSettingsMenu,
          behavior: HitTestBehavior.translucent,
          child: Stack(
            children: [
              Center(
                child: Transform.scale(
                  scale: _zoomLevel,
                  child: FittedBox(
                    fit: BoxFit.contain,
                    child: Container(
                      width: 1920,
                      height: 1080,
                      padding: const EdgeInsets.symmetric(horizontal: 36, vertical: 20),
                      child: Stack(
                        children: [
                          // Ambient Background Glow Orbs (Isolated by RepaintBoundary to avoid GPU redraw)
                          Positioned.fill(
                            child: RepaintBoundary(
                              child: Stack(
                                children: [
                                  Positioned(
                                    top: -80,
                                    right: 150,
                                    child: Container(
                                      width: 500,
                                      height: 500,
                                      decoration: BoxDecoration(
                                        shape: BoxShape.circle,
                                        gradient: RadialGradient(
                                          colors: [
                                            theme.goldPrimary.withOpacity(theme.isDark ? 0.08 : 0.05),
                                            Colors.transparent,
                                          ],
                                        ),
                                      ),
                                    ),
                                  ),
                                  Positioned(
                                    bottom: 0,
                                    left: 80,
                                    child: Container(
                                      width: 450,
                                      height: 450,
                                      decoration: BoxDecoration(
                                        shape: BoxShape.circle,
                                        gradient: RadialGradient(
                                          colors: [
                                            (theme.isDark ? theme.greenUp : theme.goldSecondary)
                                                .withOpacity(theme.isDark ? 0.06 : 0.04),
                                            Colors.transparent,
                                          ],
                                        ),
                                      ),
                                    ),
                                  ),
                                  Positioned(
                                    top: 250,
                                    left: 550,
                                    child: Container(
                                      width: 400,
                                      height: 400,
                                      decoration: BoxDecoration(
                                        shape: BoxShape.circle,
                                        gradient: RadialGradient(
                                          colors: [
                                            theme.goldSecondary.withOpacity(theme.isDark ? 0.05 : 0.03),
                                            Colors.transparent,
                                          ],
                                        ),
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ),

                  // Main Content
                  _isLoading
                      ? Center(
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              CircularProgressIndicator(color: theme.goldPrimary),
                              const SizedBox(height: 20),
                              Text(
                                'در حال دریافت مظنه‌های لحظه‌ای طلالایو...',
                                style: TextStyle(color: theme.textSecondary, fontSize: 20),
                              ),
                            ],
                          ),
                        )
                      : _model == null
                          ? Center(
                              child: Column(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  Text(
                                    'خطا در دریافت اطلاعات (${widget.username}). اتصال اینترنت را بررسی فرمایید.',
                                    style: TextStyle(color: theme.redDown, fontSize: 22),
                                  ),
                                  const SizedBox(height: 16),
                                  ElevatedButton(
                                    onPressed: () {
                                      setState(() => _isLoading = true);
                                      _fetchData();
                                    },
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: theme.goldPrimary,
                                      foregroundColor: Colors.black,
                                    ),
                                    child: const Text('تلاش مجدد'),
                                  ),
                                ],
                              ),
                            )
                          : Column(
                              children: [
                                // 1. Header (zero-overhead clock)
                                BoardHeader(
                                  model: _model!,
                                  theme: theme,
                                  timeNotifier: _timeNotifier,
                                  isOffline: _isOffline,
                                ),
                                const SizedBox(height: 14),

                                // 2. Main Body (Right: Slider 35%, Left: All Cards Grid 65%)
                                Expanded(
                                  child: _buildBody(theme),
                                ),
                                const SizedBox(height: 12),

                                // 3. Footer
                                _buildFooter(theme),
                              ],
                            ),
                    ],
                  ),
                ),
              ),
            ),
          ),

          // Zoom Feedback HUD in Native Mode
          if (_zoomFeedbackText != null)
            Positioned(
              bottom: 30,
              left: 0,
              right: 0,
              child: Center(
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 10),
                  decoration: BoxDecoration(
                    color: const Color(0xFF0F172A).withOpacity(0.92),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: const Color(0xFFF59E0B), width: 1.5),
                    boxShadow: [
                      BoxShadow(color: Colors.black.withOpacity(0.6), blurRadius: 16, offset: const Offset(0, 4)),
                    ],
                  ),
                  child: Text(
                    _zoomFeedbackText!,
                    style: const TextStyle(
                      color: Color(0xFFF59E0B),
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      fontFamily: 'Vazirmatn',
                    ),
                  ),
                ),
              ),
            ),
        ],
      ),
    ),
  ),
);
}

  Widget _buildBody(BoardThemeData theme) {
    final hasProducts = _model!.products.isNotEmpty;
    final allRows = _model!.rows;

    final gold18Row = allRows.firstWhere(
      (r) => r.symbol == 'gold18',
      orElse: () => allRows.isNotEmpty
          ? allRows.first
          : const PriceRow(
              symbol: '',
              title: '',
              sellPrice: '0',
              unit: '',
              changeDirection: 0,
              isStale: false,
            ),
    );

    num parsePrice(String raw) {
      final clean = raw.trim();
      if (clean.isEmpty) return 0;
      if (clean.contains('.')) {
        final parts = clean.split('.');
        final intPart = num.tryParse(parts[0].replaceAll(RegExp(r'[^\d]'), '')) ?? 0;
        final decPart = parts[1].replaceAll(RegExp(r'[^\d]'), '');
        if (decPart.isEmpty) return intPart;
        return num.tryParse('$intPart.$decPart') ?? intPart;
      }
      return num.tryParse(clean.replaceAll(RegExp(r'[^\d]'), '')) ?? 0;
    }

    final gold18Price = parsePrice(gold18Row.sellPrice);

    return Row(
      textDirection: TextDirection.rtl,
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        // =====================================================================
        // 1. RIGHT SIDE: Product Slider (35% width in RTL)
        // =====================================================================
        if (hasProducts) ...[
          Expanded(
            flex: 7, // 35% of total width
            child: RepaintBoundary(
              child: ProductSlider(
                products: _model!.products,
                intervalSec: _model!.sliderIntervalSec,
                theme: theme,
                gold18Price: gold18Price,
              ),
            ),
          ),
          const SizedBox(width: 16),
        ],

        // =====================================================================
        // 2. LEFT SIDE: ALL Cards Grid (65% width, or 100% if no products)
        // =====================================================================
        Expanded(
          flex: hasProducts ? 13 : 20, // 65% or 100%
          child: RepaintBoundary(
            child: _buildPriceGrid(allRows, theme),
          ),
        ),
      ],
    );
  }

  Widget _buildPriceGrid(List<PriceRow> rows, BoardThemeData theme) {
    if (rows.isEmpty) {
      return Center(
        child: Text(
          'در حال حاضر نرخی برای نمایش تنظیم نشده است.',
          style: TextStyle(color: theme.textSecondary, fontSize: 22),
        ),
      );
    }

    // Row 1 (Top Row): First 3 cards (Large)
    final topCards = rows.take(3).toList();
    final remainingCards = rows.skip(3).toList();

    // Chunk remaining cards into rows of 4 (Smaller)
    final remainingRows = <List<PriceRow>>[];
    for (var i = 0; i < remainingCards.length; i += 4) {
      final end = (i + 4).clamp(0, remainingCards.length);
      remainingRows.add(remainingCards.sublist(i, end));
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        // Top Row: 3 Large Cards
        Expanded(
          flex: 14, // 1.4x height for prominent top 3 items
          child: Row(
            textDirection: TextDirection.rtl,
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: topCards.asMap().entries.map((entry) {
              final index = entry.key;
              final row = entry.value;
              return Expanded(
                child: Padding(
                  padding: EdgeInsets.only(
                    left: index == topCards.length - 1 ? 0 : 5,
                    right: index == 0 ? 0 : 5,
                    bottom: 5,
                  ),
                  child: PriceCard(
                    row: row,
                    theme: theme,
                    isHero: index == 0 && row.symbol == 'gold18',
                    isTopRow: true,
                  ),
                ),
              );
            }).toList(),
          ),
        ),

        // Remaining Rows: 4 Smaller Cards per row
        ...remainingRows.map((chunk) {
          return Expanded(
            flex: 10, // 1.0x height
            child: Row(
              textDirection: TextDirection.rtl,
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: List.generate(4, (colIdx) {
                if (colIdx < chunk.length) {
                  final row = chunk[colIdx];
                  return Expanded(
                    child: Padding(
                      padding: EdgeInsets.only(
                        left: colIdx == 3 ? 0 : 5,
                        right: colIdx == 0 ? 0 : 5,
                        top: 5,
                        bottom: 5,
                      ),
                      child: PriceCard(
                        row: row,
                        theme: theme,
                        isHero: false,
                        isTopRow: false,
                      ),
                    ),
                  );
                } else {
                  return const Expanded(child: SizedBox.shrink());
                }
              }),
            ),
          );
        }),
      ],
    );
  }

  Widget _buildFooter(BoardThemeData theme) {
    final updateTime = _model!.updatedAtText.isNotEmpty
        ? _model!.updatedAtText.replaceAll('T', ' ').substring(0, 16.clamp(0, _model!.updatedAtText.length))
        : PersianUtils.formatClock(_timeNotifier.value);

    return Container(
      height: 54,
      padding: const EdgeInsets.symmetric(horizontal: 24),
      decoration: BoxDecoration(
        color: theme.footerBackground.withOpacity(theme.isDark ? 0.85 : 0.95),
        borderRadius: BorderRadius.circular(24),
        border: Border.all(
          color: theme.goldPrimary.withOpacity(theme.isDark ? 0.30 : 0.20),
          width: 1.2,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(theme.isDark ? 0.35 : 0.06),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        textDirection: TextDirection.rtl,
        children: [
          // Right: TalaLive.ir badge with pulsing dot
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
            decoration: BoxDecoration(
              color: theme.goldPrimary.withOpacity(0.12),
              borderRadius: BorderRadius.circular(20),
              border: Border.all(color: theme.goldPrimary.withOpacity(0.35)),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  width: 7,
                  height: 7,
                  decoration: BoxDecoration(
                    color: theme.goldPrimary,
                    shape: BoxShape.circle,
                  ),
                ),
                const SizedBox(width: 8),
                Text(
                  'راه‌اندازی تابلوی هوشمند:',
                  style: TextStyle(
                    color: theme.textPrimary,
                    fontSize: 12,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                const SizedBox(width: 6),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                  decoration: BoxDecoration(
                    color: theme.goldPrimary.withOpacity(0.2),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Text(
                    'TalaLive.ir',
                    style: TextStyle(
                      color: theme.goldPrimary,
                      fontSize: 12,
                      fontWeight: FontWeight.w900,
                      fontFamily: 'monospace',
                    ),
                  ),
                ),
              ],
            ),
          ),

          const Spacer(),

          // Center: Platform & Developer Credit
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Text(
                'پلتفرم هوشمند نمایش نرخ و ویترین آنلاین طلا',
                style: TextStyle(
                  color: theme.textSecondary,
                  fontSize: 12,
                  fontWeight: FontWeight.w700,
                ),
              ),
              const SizedBox(width: 8),
              Text(
                '✦',
                style: TextStyle(
                  color: theme.goldPrimary.withOpacity(0.6),
                  fontSize: 10,
                ),
              ),
              const SizedBox(width: 8),
              Text(
                'By Bahman Dev',
                style: TextStyle(
                  color: theme.textMuted,
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                  fontFamily: 'monospace',
                ),
              ),
            ],
          ),

          const Spacer(),

          // Left: Theme Switcher + Disconnect + Web Switcher + Update Time
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Dark / Light Mode Toggle button
              InkWell(
                onTap: _toggleDarkMode,
                borderRadius: BorderRadius.circular(14),
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                  decoration: BoxDecoration(
                    color: (theme.isDark ? const Color(0xFFF59E0B) : const Color(0xFF3B82F6)).withOpacity(0.15),
                    borderRadius: BorderRadius.circular(14),
                    border: Border.all(
                      color: (theme.isDark ? const Color(0xFFF59E0B) : const Color(0xFF3B82F6)).withOpacity(0.35),
                    ),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text(theme.isDark ? '☀️' : '🌙', style: const TextStyle(fontSize: 12)),
                      const SizedBox(width: 4),
                      Text(
                        theme.isDark ? 'حالت روشن' : 'حالت تاریک',
                        style: TextStyle(
                          color: theme.isDark ? theme.goldPrimary : const Color(0xFF2563EB),
                          fontSize: 11,
                          fontWeight: FontWeight.w800,
                          fontFamily: 'Vazirmatn',
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(width: 10),

              // Disconnect button
              InkWell(
                onTap: _showExitDialog,
                borderRadius: BorderRadius.circular(14),
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                  decoration: BoxDecoration(
                    color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.06),
                    borderRadius: BorderRadius.circular(14),
                    border: Border.all(
                      color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.12),
                    ),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const Text('🔌', style: TextStyle(fontSize: 12)),
                      const SizedBox(width: 4),
                      Text(
                        'خروج',
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 11,
                          fontWeight: FontWeight.w800,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(width: 10),

              // Switch to Web button
              InkWell(
                onTap: () => _setWebViewMode(true),
                borderRadius: BorderRadius.circular(14),
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                  decoration: BoxDecoration(
                    color: theme.goldPrimary.withOpacity(0.15),
                    borderRadius: BorderRadius.circular(14),
                    border: Border.all(color: theme.goldPrimary.withOpacity(0.35)),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const Text('🌐', style: TextStyle(fontSize: 12)),
                      const SizedBox(width: 4),
                      Text(
                        'نسخه وب',
                        style: TextStyle(
                          color: theme.goldPrimary,
                          fontSize: 11,
                          fontWeight: FontWeight.w800,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(width: 12),

              // Update time pill
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                decoration: BoxDecoration(
                  color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.06),
                  borderRadius: BorderRadius.circular(14),
                  border: Border.all(
                    color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.12),
                  ),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Container(
                      width: 6,
                      height: 6,
                      decoration: BoxDecoration(
                        color: theme.greenUp,
                        shape: BoxShape.circle,
                      ),
                    ),
                    const SizedBox(width: 6),
                    Text(
                      PersianUtils.toPersianDigits(updateTime),
                      style: TextStyle(
                        color: theme.textSecondary,
                        fontSize: 12,
                        fontWeight: FontWeight.w700,
                        fontFamily: 'Vazirmatn',
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
