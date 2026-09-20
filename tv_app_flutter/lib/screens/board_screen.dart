import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
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
  DateTime _currentDateTime = DateTime.now();

  Timer? _clockTimer;
  Timer? _refreshTimer;
  Timer? _pageSwapTimer;

  int _currentPage = 0;
  static const int _itemsPerPage = 8;

  @override
  void initState() {
    super.initState();
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
      _scheduleNextRefresh(15); // Retry sooner on error
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
        _showExitDialog();
      }
    }
  }

  void _showExitDialog() {
    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: const Color(0xFF0F172A),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: const Text(
          'خروج یا لغو اتصال تلویزیون',
          textDirection: TextDirection.rtl,
          style: TextStyle(color: Color(0xFFF59E0B), fontWeight: FontWeight.bold),
        ),
        content: const Text(
          'آیا می‌خواهید از برنامه خارج شوید یا اتصال این تلویزیون به گالری را قطع فرمایید؟',
          textDirection: TextDirection.rtl,
          style: TextStyle(color: Color(0xFFCBD5E1)),
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
            child: const Text('قطع اتصال (Unpair)', style: TextStyle(color: Colors.redAccent)),
          ),
          ElevatedButton(
            onPressed: () {
              SystemNavigator.pop();
            },
            style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFFF59E0B)),
            child: const Text('خروج از اپ', style: TextStyle(color: Colors.black)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
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
              padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 24),
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
                          child: Text(
                            'خطا در دریافت اطلاعات. اتصال اینترنت را بررسی فرمایید.',
                            style: TextStyle(color: theme.redDown, fontSize: 22),
                          ),
                        )
                      : Column(
                          children: [
                            // 1. Header
                            BoardHeader(
                              model: _model!,
                              theme: theme,
                              currentDateTime: _currentDateTime,
                              isOffline: _isOffline,
                            ),
                            const SizedBox(height: 16),

                            // 2. Main Body (Cards Grid + Optional Product Slider)
                            Expanded(
                              child: _buildBody(theme),
                            ),
                            const SizedBox(height: 14),

                            // 3. Marquee Ticker
                            MarqueeTicker(
                              text: _model!.customMessage,
                              theme: theme,
                            ),
                            const SizedBox(height: 10),

                            // 4. Footer
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
        // Price Cards Grid
        Expanded(
          flex: hasProducts ? 14 : 20,
          child: Row(
            textDirection: TextDirection.rtl,
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              Expanded(
                child: Column(
                  children: col1.map((r) => Expanded(child: PriceCard(row: r, theme: theme))).toList(),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: Column(
                  children: col2.map((r) => Expanded(child: PriceCard(row: r, theme: theme))).toList(),
                ),
              ),
            ],
          ),
        ),

        // Product Showcase Sidebar
        if (hasProducts) ...[
          const SizedBox(width: 16),
          Expanded(
            flex: 8,
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
        : '---';

    return Row(
      textDirection: TextDirection.rtl,
      children: [
        Text(
          PersianUtils.toPersianDigits('آخرین به‌روزرسانی مظنه: $updateTime'),
          style: TextStyle(
            color: theme.textMuted,
            fontSize: 14,
            fontWeight: FontWeight.w600,
          ),
        ),
        const Spacer(),
        Text(
          'talalive.ir',
          style: TextStyle(
            color: theme.textMuted,
            fontSize: 14,
            fontWeight: FontWeight.w600,
            fontFamily: 'monospace',
          ),
        ),
      ],
    );
  }
}
