import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:webview_flutter_android/webview_flutter_android.dart';
import '../models/board_model.dart';
import '../services/api_service.dart';
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
  DateTime _currentDateTime = DateTime.now();

  Timer? _clockTimer;
  Timer? _refreshTimer;

  static const String _prefKeyWebMode = 'tv_webview_mode';

  @override
  void initState() {
    super.initState();
    if (!kIsWeb) {
      _initWebViewController();
    }
    _loadSavedMode();
    _fetchData();

    // Clock timer (every 1 second)
    _clockTimer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (mounted) {
        setState(() {
          _currentDateTime = DateTime.now();
        });
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
                  .ambient-orb-container { display: none !important; }
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
    if (WebViewPlatform.instance is AndroidWebViewPlatform) {
      return WebViewWidget.fromPlatformCreationParams(
        params: AndroidWebViewWidgetCreationParams(
          controller: _webViewController!.platform,
          displayWithHybridComposition: false, // Texture Layer mode: eliminates surface tearing, clipping, and card flashing
        ),
      );
    }
    return WebViewWidget(controller: _webViewController!);
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
        Timer(const Duration(milliseconds: 3500), () {
          if (mounted && _isWebLoading) {
            setState(() => _isWebLoading = false);
          }
        });
      }
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
    super.dispose();
  }

  void _handleKey(KeyEvent event) {
    if (event is KeyDownEvent) {
      if (event.logicalKey == LogicalKeyboardKey.escape ||
          event.logicalKey == LogicalKeyboardKey.backspace) {
        if (_isWebViewMode) {
          _setWebViewMode(false);
        } else {
          _showExitDialog();
        }
      }
    }
  }

  void _showExitDialog() {
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
    );
  }

  @override
  Widget build(BuildContext context) {
    // =========================================================================
    // 1. Web View Mode (Smooth & Hybrid Composition without flickering)
    // =========================================================================
    if (_isWebViewMode) {
      return KeyboardListener(
        focusNode: FocusNode()..requestFocus(),
        onKeyEvent: _handleKey,
        child: Scaffold(
          backgroundColor: const Color(0xFF020617),
          body: Stack(
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

              // Floating Switch Back Button
              Positioned(
                bottom: 24,
                left: 24,
                child: Material(
                  color: Colors.transparent,
                  child: InkWell(
                    onTap: () => _setWebViewMode(false),
                    borderRadius: BorderRadius.circular(30),
                    child: Container(
                      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                        ),
                        borderRadius: BorderRadius.circular(30),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.6),
                            blurRadius: 18,
                            offset: const Offset(0, 6),
                          ),
                        ],
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Text('⚡', style: TextStyle(fontSize: 18)),
                          SizedBox(width: 8),
                          Text(
                            'بازگشت به نسخه نیتیو',
                            style: TextStyle(
                              color: Colors.black,
                              fontSize: 15,
                              fontWeight: FontWeight.w900,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      );
    }

    // =========================================================================
    // 2. High-Fidelity Native Flutter Board Mode
    // =========================================================================
    final theme = _model != null
        ? BoardThemeData.fromMode(_model!.themeMode)
        : BoardThemeData.onyxGold;

    return KeyboardListener(
      focusNode: FocusNode()..requestFocus(),
      onKeyEvent: _handleKey,
      child: Scaffold(
        backgroundColor: theme.backgroundColor,
        body: Center(
          child: FittedBox(
            fit: BoxFit.contain,
            child: Container(
              width: 1920,
              height: 1080,
              padding: const EdgeInsets.symmetric(horizontal: 36, vertical: 20),
              child: Stack(
                children: [
                  // Ambient Background Glow Orbs
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
                                // 1. Header (with Switch to Web button)
                                BoardHeader(
                                  model: _model!,
                                  theme: theme,
                                  currentDateTime: _currentDateTime,
                                  isOffline: _isOffline,
                                  onSwitchToWeb: () => _setWebViewMode(true),
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
            child: ProductSlider(
              products: _model!.products,
              intervalSec: _model!.sliderIntervalSec,
              theme: theme,
              gold18Price: gold18Price,
            ),
          ),
          const SizedBox(width: 16),
        ],

        // =====================================================================
        // 2. LEFT SIDE: ALL Cards Grid (65% width, or 100% if no products)
        // =====================================================================
        Expanded(
          flex: hasProducts ? 13 : 20, // 65% or 100%
          child: _buildPriceGrid(allRows, theme),
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
        : PersianUtils.formatClock(_currentDateTime);

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

          // Left: Web Switcher + Disconnect + Update Time
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
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
