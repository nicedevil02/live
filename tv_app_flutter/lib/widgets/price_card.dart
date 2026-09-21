import 'dart:math' as math;
import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class PriceCard extends StatefulWidget {
  final PriceRow row;
  final BoardThemeData theme;
  final bool isHero;
  final bool isTopRow;

  const PriceCard({
    super.key,
    required this.row,
    required this.theme,
    this.isHero = false,
    this.isTopRow = false,
  });

  @override
  State<PriceCard> createState() => _PriceCardState();
}

class _PriceCardState extends State<PriceCard> with TickerProviderStateMixin {
  AnimationController? _shimmerController;
  AnimationController? _flashController;
  Animation<double>? _flashAnimation;
  String _currentPriceFormatted = '';
  int _diffStartIndex = -1;
  bool _isPriceUp = true;

  @override
  void initState() {
    super.initState();
    _currentPriceFormatted = PersianUtils.formatPrice(widget.row.sellPrice, symbol: widget.row.symbol);
    _flashController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 2300),
    );
    _flashAnimation = CurvedAnimation(parent: _flashController!, curve: Curves.linear);

    final isGold18 = widget.isHero || widget.row.symbol == 'gold18';
    if (isGold18) {
      _shimmerController = AnimationController(
        vsync: this,
        duration: const Duration(seconds: 6),
      )..repeat();
    }
  }

  @override
  void didUpdateWidget(covariant PriceCard oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (widget.row.sellPrice != oldWidget.row.sellPrice) {
      final oldFormatted = PersianUtils.formatPrice(oldWidget.row.sellPrice, symbol: oldWidget.row.symbol);
      final newFormatted = PersianUtils.formatPrice(widget.row.sellPrice, symbol: widget.row.symbol);
      _currentPriceFormatted = newFormatted;

      final oldVal = double.tryParse(oldWidget.row.sellPrice.replaceAll(',', '').replaceAll(' ', '')) ?? 0.0;
      final newVal = double.tryParse(widget.row.sellPrice.replaceAll(',', '').replaceAll(' ', '')) ?? 0.0;

      if (oldVal != newVal) {
        _isPriceUp = newVal > oldVal;
        int i = 0;
        final minLen = math.min(oldFormatted.length, newFormatted.length);
        while (i < minLen && oldFormatted[i] == newFormatted[i]) {
          i++;
        }
        _diffStartIndex = i;
        _flashController?.forward(from: 0.0);
      } else {
        _diffStartIndex = -1;
      }
    } else {
      _currentPriceFormatted = PersianUtils.formatPrice(widget.row.sellPrice, symbol: widget.row.symbol);
    }
  }

  @override
  void dispose() {
    _shimmerController?.dispose();
    _flashController?.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final row = widget.row;
    final theme = widget.theme;
    final isTopRow = widget.isTopRow;
    final hasBuy = row.buyPrice != null && row.buyPrice!.trim().isNotEmpty;
    final isGold18 = widget.isHero || row.symbol == 'gold18';

    final cardBg = isGold18 ? theme.heroCardGradient : theme.cardGradient;
    final cardBorder = isGold18 ? theme.heroStrokeColor : theme.cardStrokeColor;
    final titleColor = isGold18 ? theme.heroTextColor : theme.textPrimary;
    final priceColor = isGold18
        ? theme.heroTextColor
        : (theme.isDark ? theme.goldPrimary : const Color(0xFF0F172A));

    return Container(
      decoration: BoxDecoration(
        gradient: cardBg,
        borderRadius: BorderRadius.circular(26),
        border: Border.all(
          color: cardBorder,
          width: isGold18 ? 2.0 : 1.2,
        ),
        boxShadow: [
          BoxShadow(
            color: isGold18
                ? theme.goldPrimary.withOpacity(theme.isDark ? 0.35 : 0.25)
                : Colors.black.withOpacity(theme.isDark ? 0.35 : 0.06),
            blurRadius: isGold18 ? 22 : 14,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Stack(
        children: [
          // 1. Shimmer Beam Animation for Gold 18
          if (isGold18) _buildShimmerBeam(),

          // 2. Main Content
          Padding(
            padding: EdgeInsets.symmetric(
              horizontal: isTopRow ? 20 : 16,
              vertical: isTopRow ? 16 : 12,
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                // =============================================================
                // Card Header: Title + Status + Trend Icon
                // =============================================================
                Row(
                  textDirection: TextDirection.rtl,
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    // Title & Sparkle
                    Expanded(
                      child: Row(
                        textDirection: TextDirection.rtl,
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          if (isGold18) ...[
                            _buildSparkle(),
                            const SizedBox(width: 6),
                          ],
                          Flexible(
                            child: Text(
                              row.title,
                              style: TextStyle(
                                color: titleColor,
                                fontSize: isTopRow ? 22 : 17,
                                fontWeight: FontWeight.w900,
                                fontFamily: 'Vazirmatn',
                                letterSpacing: -0.3,
                              ),
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                            ),
                          ),
                          const SizedBox(width: 8),

                          // Status Pill (لحظه‌ای / قدیمی)
                          _buildStatusPill(),
                        ],
                      ),
                    ),

                    // Trend Icon Pill
                    _buildTrendIcon(),
                  ],
                ),

                // =============================================================
                // Card Body: Super-Featured Price Number
                // =============================================================
                Padding(
                  padding: EdgeInsets.symmetric(vertical: isTopRow ? 6 : 2),
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      FittedBox(
                        fit: BoxFit.scaleDown,
                        child: _buildPriceNumber(priceColor, isTopRow ? 58 : 38),
                      ),
                      if (hasBuy) ...[
                        const SizedBox(height: 3),
                        FittedBox(
                          fit: BoxFit.scaleDown,
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                'خرید: ',
                                style: TextStyle(
                                  color: theme.textMuted,
                                  fontSize: isTopRow ? 14 : 12,
                                  fontWeight: FontWeight.w700,
                                  fontFamily: 'Vazirmatn',
                                ),
                              ),
                              Text(
                                PersianUtils.formatPrice(row.buyPrice!, symbol: row.symbol),
                                style: TextStyle(
                                  color: theme.textSecondary,
                                  fontSize: isTopRow ? 17 : 15,
                                  fontWeight: FontWeight.w800,
                                  fontFamily: 'Vazirmatn',
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ],
                  ),
                ),

                // =============================================================
                // Card Footer: Change Pill (with value) & Currency Unit Badge
                // =============================================================
                Container(
                  padding: const EdgeInsets.only(top: 8),
                  decoration: BoxDecoration(
                    border: Border(
                      top: BorderSide(
                        color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.08),
                        width: 1,
                      ),
                    ),
                  ),
                  child: Row(
                    textDirection: TextDirection.rtl,
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      // Change Pill (Apple Stocks Style with optional value)
                      _buildChangePill(),

                      // Currency Unit Badge
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                        decoration: BoxDecoration(
                          color: theme.unitBadgeBg,
                          borderRadius: BorderRadius.circular(12),
                          border: Border.all(color: theme.unitBadgeBorder),
                        ),
                        child: Text(
                          row.unit,
                          style: TextStyle(
                            color: theme.unitBadgeText,
                            fontSize: isTopRow ? 12 : 11,
                            fontWeight: FontWeight.w800,
                            fontFamily: 'Vazirmatn',
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildShimmerBeam() {
    if (_shimmerController == null) return const SizedBox.shrink();

    return AnimatedBuilder(
      animation: _shimmerController!,
      builder: (context, child) {
        final progress = _shimmerController!.value;
        if (progress > 0.35) return const SizedBox.shrink();

        final sweepPos = (progress / 0.35) * 3.0 - 1.0;

        return Positioned.fill(
          child: ClipRRect(
            borderRadius: BorderRadius.circular(26),
            child: Transform.rotate(
              angle: 0.48, // ~28 degrees matching live.blade.php
              child: FractionalTranslation(
                translation: Offset(sweepPos, 0),
                child: Container(
                  width: 140,
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: [
                        Colors.transparent,
                        Colors.white.withOpacity(widget.theme.isDark ? 0.12 : 0.30),
                        const Color(0xFFFDE68A).withOpacity(widget.theme.isDark ? 0.22 : 0.35),
                        Colors.transparent,
                      ],
                      stops: const [0.0, 0.45, 0.55, 1.0],
                    ),
                  ),
                ),
              ),
            ),
          ),
        );
      },
    );
  }

  Widget _buildSparkle() {
    if (_shimmerController == null) {
      return const Text(
        '✦',
        style: TextStyle(
          color: Color(0xFFF59E0B),
          fontSize: 16,
          fontWeight: FontWeight.w900,
        ),
      );
    }
    return AnimatedBuilder(
      animation: _shimmerController!,
      builder: (context, child) {
        final t = _shimmerController!.value * 6;
        final phase = (t - t.floor());
        final scale = 0.85 + 0.35 * (phase < 0.5 ? phase * 2 : 2 - phase * 2);
        return Transform.scale(
          scale: scale,
          child: const Text(
            '✦',
            style: TextStyle(
              color: Color(0xFFF59E0B),
              fontSize: 16,
              fontWeight: FontWeight.w900,
            ),
          ),
        );
      },
    );
  }

  Widget _buildStatusPill() {
    final theme = widget.theme;
    final row = widget.row;
    final isStale = row.isStale;

    final bg = isStale ? theme.statusStaleBg : theme.statusLiveBg;
    final border = isStale ? theme.statusStaleBorder : theme.statusLiveBorder;
    final text = isStale ? theme.statusStaleText : theme.statusLiveText;
    final label = isStale ? 'قدیمی' : 'لحظه‌ای';
    final dotColor = isStale ? theme.goldPrimary : theme.greenUp;

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: border, width: 1),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 6,
            height: 6,
            decoration: BoxDecoration(
              color: dotColor,
              shape: BoxShape.circle,
              boxShadow: [
                BoxShadow(
                  color: dotColor.withOpacity(0.6),
                  blurRadius: 4,
                ),
              ],
            ),
          ),
          const SizedBox(width: 4),
          Text(
            label,
            style: TextStyle(
              color: text,
              fontSize: 10,
              fontWeight: FontWeight.w700,
              fontFamily: 'Vazirmatn',
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTrendIcon() {
    final theme = widget.theme;
    final row = widget.row;
    Color bg;
    Color border;
    IconData icon;
    Color iconColor;

    if (row.changeDirection > 0) {
      bg = theme.pillUpBg;
      border = theme.pillUpBorder;
      icon = Icons.arrow_upward;
      iconColor = theme.greenUp;
    } else if (row.changeDirection < 0) {
      bg = theme.pillDownBg;
      border = theme.pillDownBorder;
      icon = Icons.arrow_downward;
      iconColor = theme.redDown;
    } else {
      bg = theme.pillFlatBg;
      border = theme.pillFlatBorder;
      icon = Icons.remove;
      iconColor = theme.pillFlatText;
    }

    return Container(
      padding: const EdgeInsets.all(5),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(10),
        border: Border.all(color: border, width: 1),
      ),
      child: Icon(
        icon,
        size: 14,
        color: iconColor,
      ),
    );
  }

  Widget _buildChangePill() {
    final theme = widget.theme;
    final row = widget.row;
    Color bg;
    Color border;
    Color text;

    if (row.changeDirection > 0) {
      bg = theme.pillUpBg;
      border = theme.pillUpBorder;
      text = theme.pillUpText;
    } else if (row.changeDirection < 0) {
      bg = theme.pillDownBg;
      border = theme.pillDownBorder;
      text = theme.pillDownText;
    } else {
      bg = theme.pillFlatBg;
      border = theme.pillFlatBorder;
      text = theme.pillFlatText;
    }

    final pctStr = PersianUtils.formatSignedPercent(row.changePercent);
    final valStr = PersianUtils.formatSignedChangeValue(row.changeValue, symbol: row.symbol);
    final displayText = '$pctStr | $valStr';

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 9, vertical: 3),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: border),
      ),
      child: Text(
        displayText,
        style: TextStyle(
          color: text,
          fontSize: widget.isTopRow ? 12 : 11,
          fontWeight: FontWeight.w900,
          fontFamily: 'Vazirmatn',
        ),
        textDirection: TextDirection.ltr,
      ),
    );
  }

  Widget _buildPriceNumber(Color defaultColor, double fontSize) {
    if (_diffStartIndex < 0 ||
        _diffStartIndex >= _currentPriceFormatted.length ||
        _flashController == null ||
        !_flashController!.isAnimating) {
      return Text(
        _currentPriceFormatted,
        style: TextStyle(
          color: defaultColor,
          fontSize: fontSize,
          fontWeight: FontWeight.w900,
          fontFamily: 'Vazirmatn',
          letterSpacing: -1.0,
          height: 1.05,
        ),
        textAlign: TextAlign.center,
        maxLines: 1,
      );
    }

    return AnimatedBuilder(
      animation: _flashAnimation!,
      builder: (context, child) {
        final t = _flashAnimation!.value;
        final flashColor = _isPriceUp ? const Color(0xFF10B981) : const Color(0xFFF43F5E);
        final Color animatedColor;
        if (t < 0.87) {
          animatedColor = flashColor;
        } else {
          final fadeProgress = ((t - 0.87) / 0.13).clamp(0.0, 1.0);
          animatedColor = Color.lerp(flashColor, defaultColor, fadeProgress) ?? defaultColor;
        }

        final prefix = _currentPriceFormatted.substring(0, _diffStartIndex);
        final suffix = _currentPriceFormatted.substring(_diffStartIndex);

        return Text.rich(
          TextSpan(
            children: [
              if (prefix.isNotEmpty)
                TextSpan(
                  text: prefix,
                  style: TextStyle(
                    color: defaultColor,
                    fontSize: fontSize,
                    fontWeight: FontWeight.w900,
                    fontFamily: 'Vazirmatn',
                    letterSpacing: -1.0,
                    height: 1.05,
                  ),
                ),
              TextSpan(
                text: suffix,
                style: TextStyle(
                  color: animatedColor,
                  fontSize: fontSize,
                  fontWeight: FontWeight.w900,
                  fontFamily: 'Vazirmatn',
                  letterSpacing: -1.0,
                  height: 1.05,
                ),
              ),
            ],
          ),
          textAlign: TextAlign.center,
          maxLines: 1,
        );
      },
    );
  }
}
