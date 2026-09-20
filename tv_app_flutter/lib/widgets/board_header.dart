import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class BoardHeader extends StatelessWidget {
  final BoardModel model;
  final BoardThemeData theme;
  final DateTime currentDateTime;
  final bool isOffline;

  const BoardHeader({
    super.key,
    required this.model,
    required this.theme,
    required this.currentDateTime,
    this.isOffline = false,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 16),
      decoration: BoxDecoration(
        color: theme.headerBackground.withOpacity(theme.isDark ? 0.85 : 0.95),
        borderRadius: BorderRadius.circular(24),
        border: Border.all(
          color: theme.goldPrimary.withOpacity(0.35),
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(theme.isDark ? 0.35 : 0.08),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        textDirection: TextDirection.rtl,
        children: [
          // 1. Logo Monogram
          Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [
                  theme.goldSecondary,
                  theme.goldPrimary,
                  const Color(0xFFB45309),
                ],
              ),
              boxShadow: [
                BoxShadow(
                  color: theme.goldPrimary.withOpacity(0.4),
                  blurRadius: 14,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            alignment: Alignment.center,
            child: const Text(
              'زر',
              style: TextStyle(
                color: Color(0xFF020617),
                fontSize: 26,
                fontWeight: FontWeight.w900,
              ),
            ),
          ),
          const SizedBox(width: 18),

          // 2. Shop Name & Subtitle
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  model.shopName,
                  style: TextStyle(
                    color: theme.goldPrimary,
                    fontSize: 24,
                    fontWeight: FontWeight.w900,
                    letterSpacing: -0.5,
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
                const SizedBox(height: 3),
                Text(
                  model.subtitle,
                  style: TextStyle(
                    color: theme.textSecondary,
                    fontSize: 13,
                    fontWeight: FontWeight.w500,
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),

          // 3. Status Badge (Live / Backup / Offline)
          _buildStatusBadge(),
          const SizedBox(width: 24),

          // 4. Digital Clock & Shamsi Date
          Column(
            crossAxisAlignment: CrossAxisAlignment.end,
            mainAxisSize: MainAxisSize.min,
            children: [
              Text(
                PersianUtils.formatClock(currentDateTime),
                style: TextStyle(
                  color: theme.textPrimary,
                  fontSize: 26,
                  fontWeight: FontWeight.w900,
                  fontFamily: 'monospace',
                  letterSpacing: 1,
                ),
              ),
              const SizedBox(height: 2),
              Text(
                PersianUtils.getShamsiDateString(currentDateTime),
                style: TextStyle(
                  color: theme.textMuted,
                  fontSize: 13,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildStatusBadge() {
    Color bgColor;
    Color strokeColor;
    Color textColor;
    String text;
    bool hasPulse = false;

    if (isOffline) {
      bgColor = const Color(0xFF7F1D1D).withOpacity(0.6);
      strokeColor = theme.redDown;
      textColor = theme.redDown;
      text = '● عدم ارتباط با سرور';
    } else if (model.isStale || model.dataAgeSeconds > 180) {
      bgColor = const Color(0xFF78350F).withOpacity(0.6);
      strokeColor = theme.goldPrimary;
      textColor = theme.goldPrimary;
      text = '● حالت پشتیبان';
    } else {
      bgColor = const Color(0xFF14532D).withOpacity(0.6);
      strokeColor = theme.greenUp;
      textColor = theme.greenUp;
      text = '● نرخ لحظه‌ای';
      hasPulse = true;
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 7),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: strokeColor, width: 1.2),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          if (hasPulse) ...[
            Container(
              width: 8,
              height: 8,
              decoration: BoxDecoration(
                color: textColor,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: textColor.withOpacity(0.8),
                    blurRadius: 6,
                    spreadRadius: 2,
                  ),
                ],
              ),
            ),
            const SizedBox(width: 7),
          ],
          Text(
            text,
            style: TextStyle(
              color: textColor,
              fontSize: 13,
              fontWeight: FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }
}
