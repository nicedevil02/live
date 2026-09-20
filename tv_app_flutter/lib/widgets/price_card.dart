import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class PriceCard extends StatelessWidget {
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
  Widget build(BuildContext context) {
    final hasBuy = row.buyPrice != null && row.buyPrice!.trim().isNotEmpty;
    final isGold18 = isHero || row.symbol == 'gold18';

    final cardBg = isGold18 ? theme.heroCardGradient : theme.cardGradient;
    final cardBorder = isGold18 ? theme.heroStrokeColor : theme.cardStrokeColor;
    final titleColor = isGold18 ? theme.heroTextColor : theme.textPrimary;
    final priceColor = isGold18 ? theme.heroTextColor : (theme.isDark ? theme.goldPrimary : const Color(0xFFB45309));

    return Container(
      padding: EdgeInsets.symmetric(
        horizontal: isTopRow ? 20 : 16,
        vertical: isTopRow ? 16 : 12,
      ),
      decoration: BoxDecoration(
        gradient: cardBg,
        borderRadius: BorderRadius.circular(26),
        border: Border.all(
          color: cardBorder,
          width: isGold18 ? 1.8 : 1.2,
        ),
        boxShadow: [
          BoxShadow(
            color: isGold18
                ? theme.goldPrimary.withOpacity(0.3)
                : Colors.black.withOpacity(theme.isDark ? 0.35 : 0.06),
            blurRadius: isGold18 ? 20 : 14,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          // ===================================================================
          // 1. Card Header: Title + Status + Trend Icon
          // ===================================================================
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
                      const Text(
                        '✦',
                        style: TextStyle(
                          color: Color(0xFFF59E0B),
                          fontSize: 16,
                          fontWeight: FontWeight.w900,
                        ),
                      ),
                      const SizedBox(width: 6),
                    ],
                    Flexible(
                      child: Text(
                        row.title,
                        style: TextStyle(
                          color: titleColor,
                          fontSize: isTopRow ? 21 : 17,
                          fontWeight: FontWeight.w900,
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

          // ===================================================================
          // 2. Card Body: Price Number
          // ===================================================================
          Padding(
            padding: EdgeInsets.symmetric(vertical: isTopRow ? 10 : 6),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  PersianUtils.formatPriceString(row.sellPrice),
                  style: TextStyle(
                    color: priceColor,
                    fontSize: isTopRow ? 34 : 28,
                    fontWeight: FontWeight.w900,
                    fontFamily: 'monospace',
                    letterSpacing: -1,
                    height: 1.0,
                  ),
                  textAlign: TextAlign.center,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
                if (hasBuy) ...[
                  const SizedBox(height: 4),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        'خرید: ',
                        style: TextStyle(
                          color: theme.textMuted,
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      Text(
                        PersianUtils.formatPriceString(row.buyPrice!),
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 13,
                          fontWeight: FontWeight.w800,
                          fontFamily: 'monospace',
                        ),
                      ),
                    ],
                  ),
                ],
              ],
            ),
          ),

          // ===================================================================
          // 3. Card Footer: Change Pill & Currency Unit Badge
          // ===================================================================
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
                      fontSize: 11,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                ),

                // Change Pill (Apple Stocks Style)
                _buildChangePill(),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatusPill() {
    final isStale = row.isStale;
    final bgColor = isStale ? theme.statusStaleBg : theme.statusLiveBg;
    final borderColor = isStale ? theme.statusStaleBorder : theme.statusLiveBorder;
    final textColor = isStale ? theme.statusStaleText : theme.statusLiveText;
    final label = isStale ? 'قدیمی' : 'لحظه‌ای';

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 7, vertical: 2),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(10),
        border: Border.all(color: borderColor, width: 0.8),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 5,
            height: 5,
            decoration: BoxDecoration(
              color: textColor,
              shape: BoxShape.circle,
            ),
          ),
          const SizedBox(width: 4),
          Text(
            label,
            style: TextStyle(
              color: textColor,
              fontSize: 9,
              fontWeight: FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTrendIcon() {
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

    final pctStr = row.changePercent != null && row.changePercent!.isNotEmpty
        ? row.changePercent!
        : '۰';
    final sign = row.changeDirection > 0 ? '+' : (row.changeDirection < 0 ? '-' : '');

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 9, vertical: 3),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: border),
      ),
      child: Text(
        PersianUtils.toPersianDigits('$sign$pctStr%'),
        style: TextStyle(
          color: text,
          fontSize: 11,
          fontWeight: FontWeight.w900,
          fontFamily: 'monospace',
        ),
        textDirection: TextDirection.ltr,
      ),
    );
  }
}
