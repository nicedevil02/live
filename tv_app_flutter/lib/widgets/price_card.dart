import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class PriceCard extends StatelessWidget {
  final PriceRow row;
  final BoardThemeData theme;

  const PriceCard({
    super.key,
    required this.row,
    required this.theme,
  });

  @override
  Widget build(BuildContext context) {
    final hasBuy = row.buyPrice != null && row.buyPrice!.trim().isNotEmpty;

    return Container(
      margin: const EdgeInsets.symmetric(vertical: 4, horizontal: 4),
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
      decoration: BoxDecoration(
        gradient: theme.cardGradient,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: theme.cardStrokeColor,
          width: 1.3,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(theme.isDark ? 0.3 : 0.05),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
          if (theme.isDark)
            BoxShadow(
              color: theme.goldPrimary.withOpacity(0.04),
              blurRadius: 20,
              spreadRadius: 1,
            ),
        ],
      ),
      child: Row(
        textDirection: TextDirection.rtl,
        children: [
          // 1. Commodity Title (Right side in RTL)
          Expanded(
            flex: 11,
            child: Row(
              children: [
                Container(
                  width: 8,
                  height: 8,
                  decoration: BoxDecoration(
                    color: theme.goldPrimary,
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: theme.goldPrimary.withOpacity(0.6),
                        blurRadius: 4,
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: Text(
                    row.title,
                    style: TextStyle(
                      color: theme.textPrimary,
                      fontSize: 18,
                      fontWeight: FontWeight.w800,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ),
              ],
            ),
          ),

          // 2. Main Price (Center)
          Expanded(
            flex: 14,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                // Sell Price
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  crossAxisAlignment: CrossAxisAlignment.baseline,
                  textBaseline: TextBaseline.alphabetic,
                  children: [
                    Text(
                      PersianUtils.formatPriceString(row.sellPrice),
                      style: TextStyle(
                        color: theme.goldPrimary,
                        fontSize: 22,
                        fontWeight: FontWeight.w900,
                        letterSpacing: 0.5,
                      ),
                    ),
                    const SizedBox(width: 6),
                    Text(
                      row.unit,
                      style: TextStyle(
                        color: theme.textMuted,
                        fontSize: 11,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),

                // Buy Price (if enabled)
                if (hasBuy) ...[
                  const SizedBox(height: 2),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        'خرید: ',
                        style: TextStyle(
                          color: theme.textMuted,
                          fontSize: 11,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                      Text(
                        PersianUtils.formatPriceString(row.buyPrice!),
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 12,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
                    ],
                  ),
                ],
              ],
            ),
          ),

          // 3. Direction & Change (Left side in RTL)
          Expanded(
            flex: 8,
            child: Align(
              alignment: Alignment.centerLeft,
              child: _buildChangeBadge(),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildChangeBadge() {
    Color badgeColor;
    Color textColor;
    String arrow;

    if (row.changeDirection > 0) {
      badgeColor = theme.greenUp.withOpacity(0.18);
      textColor = theme.greenUp;
      arrow = '▲';
    } else if (row.changeDirection < 0) {
      badgeColor = theme.redDown.withOpacity(0.18);
      textColor = theme.redDown;
      arrow = '▼';
    } else {
      badgeColor = theme.textMuted.withOpacity(0.15);
      textColor = theme.textMuted;
      arrow = '●';
    }

    final changeStr = row.changePercent != null && row.changePercent!.isNotEmpty
        ? PersianUtils.toPersianDigits('${row.changePercent!}%')
        : '';

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
      decoration: BoxDecoration(
        color: badgeColor,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: textColor.withOpacity(0.35),
          width: 1,
        ),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            arrow,
            style: TextStyle(
              color: textColor,
              fontSize: 12,
              fontWeight: FontWeight.w900,
            ),
          ),
          if (changeStr.isNotEmpty) ...[
            const SizedBox(width: 5),
            Text(
              changeStr,
              style: TextStyle(
                color: textColor,
                fontSize: 12,
                fontWeight: FontWeight.w800,
              ),
            ),
          ],
        ],
      ),
    );
  }
}
