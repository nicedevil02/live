import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:webview_flutter/webview_flutter.dart';
import '../models/board_model.dart';
import '../services/api_service.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';
import '../widgets/board_header.dart';
import '../widgets/price_card.dart';
import '../widgets/product_slider.dart';
import '../widgets/marquee_ticker.dart';
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
  late final WebViewController _webViewController;
  DateTime _currentDateTime = DateTime.now();

  Timer? _clockTimer;
  Timer? _refreshTimer;
  Timer? _pageSwapTimer;

  int _currentPage = 0;
  static const int _itemsPerPage = 8;
  static const String _prefKeyWebMode = 'tv_webview_mode';

  @override
  void initState() {
    super.initState();
    _initWebViewController();
    _loadSavedMode();
    _fetchData();

    // 1. Clock timer (every 1 second)
    _clockTimer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (mounted) {
        setState(() {
          _currentDateTime = DateTime.now();
        });
      }
    });

    // 2. Page swap timer (every 10 seconds if multiple pages)
    _pageSwapTimer = Timer.periodic(const Duration(seconds: 10), (_) {
      if (mounted && _model != null && _model!.rows.length > _itemsPerPage) {
        final totalPages = (_model!.rows.length + _itemsPerPage - 1) ~/ _itemsPerPage;
        setState(() {
          _currentPage = (_currentPage + 1) % totalPages;
        });
      }
    });
  }

  void _initWebViewController() {
    final webUrl = 'https://talalive.ir/${widget.username}?tv=1';
    _webViewController = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setBackgroundColor(const Color(0xFF020617))
      ..loadRequest(Uri.parse(webUrl));
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
    _pageSwapTimer?.cancel();
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
    // 1. Web View Mode
    // =========================================================================
    if (_isWebViewMode) {
      return KeyboardListener(
        focusNode: FocusNode()..requestFocus(),
        onKeyEvent: _handleKey,
        child: Scaffold(
          backgroundColor: const Color(0xFF020617),
          body: Stack(
            children: [
              WebViewWidget(controller: _webViewController),
              // Floating Switch Back Button
              Positioned(
                bottom: 20,
                left: 20,
                child: Material(
                  color: Colors.transparent,
                  child: InkWell(
                    onTap: () => _setWebViewMode(false),
                    borderRadius: BorderRadius.circular(30),
                    child: Container(
                      padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 10),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                        ),
                        borderRadius: BorderRadius.circular(30),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.5),
                            blurRadius: 16,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Text('⚡', style: TextStyle(fontSize: 16)),
                          SizedBox(width: 8),
                          Text(
                            'بازگشت به نسخه نیتیو',
                            style: TextStyle(
                              color: Colors.black,
                              fontSize: 14,
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
              child: _isLoading
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

                            // 2. Main Body (Cards Grid + Optional Product Slider)
                            Expanded(
                              child: _buildBody(theme),
                            ),
                            const SizedBox(height: 12),

                            // 3. Marquee Ticker
                            MarqueeTicker(
                              text: _model!.customMessage,
                              theme: theme,
                            ),
                            const SizedBox(height: 10),

                            // 4. Footer (matching live.blade.php)
                            _buildFooter(theme),
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

    final startIndex = _currentPage * _itemsPerPage;
    final endIndex = (startIndex + _itemsPerPage).clamp(0, allRows.length);
    final pageRows = allRows.sublist(startIndex, endIndex);

    final half = (pageRows.length + 1) ~/ 2;
    final col1 = pageRows.sublist(0, half.clamp(0, pageRows.length));
    final col2 = half < pageRows.length ? pageRows.sublist(half) : <PriceRow>[];

    return Row(
      textDirection: TextDirection.rtl,
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        // Price Cards Grid (Right Side in RTL - 65% width)
        Expanded(
          flex: hasProducts ? 13 : 20,
          child: Row(
            textDirection: TextDirection.rtl,
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              Expanded(
                child: Column(
                  children: col1.asMap().entries.map((entry) {
                    final index = entry.key;
                    final row = entry.value;
                    return Expanded(
                      child: Padding(
                        padding: const EdgeInsets.symmetric(vertical: 4),
                        child: PriceCard(
                          row: row,
                          theme: theme,
                          isHero: index == 0 && row.symbol == 'gold18',
                          isTopRow: index == 0,
                        ),
                      ),
                    );
                  }).toList(),
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  children: col2.asMap().entries.map((entry) {
                    final index = entry.key;
                    final row = entry.value;
                    return Expanded(
                      child: Padding(
                        padding: const EdgeInsets.symmetric(vertical: 4),
                        child: PriceCard(
                          row: row,
                          theme: theme,
                          isHero: false,
                          isTopRow: index == 0,
                        ),
                      ),
                    );
                  }).toList(),
                ),
              ),
            ],
          ),
        ),

        // Product Showcase Sidebar (Left Side in RTL - 35% width)
        if (hasProducts) ...[
          const SizedBox(width: 16),
          Expanded(
            flex: 7,
            child: ProductSlider(
              products: _model!.products,
              intervalSec: _model!.sliderIntervalSec,
              theme: theme,
            ),
          ),
        ],
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
                        fontSize: 11,
                        fontWeight: FontWeight.w700,
                        fontFamily: 'monospace',
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
