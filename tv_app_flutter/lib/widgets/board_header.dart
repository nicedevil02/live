import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class BoardHeader extends StatelessWidget {
  final BoardModel model;
  final BoardThemeData theme;
  final DateTime currentDateTime;
  final bool isOffline;
  final VoidCallback? onSwitchToWeb;

  const BoardHeader({
    super.key,
    required this.model,
    required this.theme,
    required this.currentDateTime,
    this.isOffline = false,
    this.onSwitchToWeb,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 14),
      decoration: BoxDecoration(
        color: theme.headerBackground.withOpacity(theme.isDark ? 0.85 : 0.95),
        borderRadius: BorderRadius.circular(28),
        border: Border.all(
          color: theme.goldPrimary.withOpacity(theme.isDark ? 0.35 : 0.25),
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(theme.isDark ? 0.40 : 0.08),
            blurRadius: 24,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        textDirection: TextDirection.rtl,
        children: [
          // ===================================================================
          // 1. Right Section: Shop Monogram & Subtitle
          // ===================================================================
          Expanded(
            flex: 3,
            child: Row(
              textDirection: TextDirection.rtl,
              children: [
                // Monogram Circle
                Container(
                  width: 60,
                  height: 60,
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
                        color: theme.goldPrimary.withOpacity(0.45),
                        blurRadius: 16,
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
                const SizedBox(width: 16),

                // Subtitle Info
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text(
                        model.subtitle.isNotEmpty ? model.subtitle : 'تابلوی رسمی نرخ لحظه‌ای طلا، سکه و ارز',
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          height: 1.3,
                        ),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 4),
                      Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                            decoration: BoxDecoration(
                              color: theme.goldPrimary.withOpacity(0.12),
                              borderRadius: BorderRadius.circular(12),
                              border: Border.all(color: theme.goldPrimary.withOpacity(0.25)),
                            ),
                            child: Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Text(
                                  'همراه ما باشید',
                                  style: TextStyle(
                                    color: theme.goldPrimary,
                                    fontSize: 11,
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // ===================================================================
          // 2. Center Section: Shop Name & City Tag
          // ===================================================================
          Expanded(
            flex: 4,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                ShaderMask(
                  shaderCallback: (bounds) => theme.titleGradient.createShader(bounds),
                  child: Text(
                    model.shopName,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 34,
                      fontWeight: FontWeight.w900,
                      letterSpacing: -0.5,
                      height: 1.1,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    textAlign: TextAlign.center,
                  ),
                ),
                const SizedBox(height: 5),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 2),
                  decoration: BoxDecoration(
                    color: theme.goldPrimary.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: theme.goldPrimary.withOpacity(0.25)),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text(
                        '✦  نرخ‌گذاری لحظه‌ای طلا و ارز  ✦',
                        style: TextStyle(
                          color: theme.goldPrimary,
                          fontSize: 11,
                          fontWeight: FontWeight.w800,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // ===================================================================
          // 3. Left Section: Status, Web Switcher, Divider, and Clock
          // ===================================================================
          Expanded(
            flex: 4,
            child: Row(
              textDirection: TextDirection.ltr,
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                // Clock & Date
                Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      PersianUtils.formatClock(currentDateTime),
                      style: TextStyle(
                        color: theme.textPrimary,
                        fontSize: 42,
                        fontWeight: FontWeight.w900,
                        fontFamily: 'monospace',
                        letterSpacing: -1,
                        height: 1.0,
                      ),
                    ),
                    const SizedBox(height: 3),
                    Text(
                      PersianUtils.getShamsiDateString(currentDateTime),
                      style: TextStyle(
                        color: theme.textSecondary,
                        fontSize: 13,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ],
                ),
                const SizedBox(width: 20),

                // Vertical Divider
                Container(
                  width: 1,
                  height: 48,
                  color: (theme.isDark ? Colors.white : Colors.black).withOpacity(0.12),
                ),
                const SizedBox(width: 18),

                // Controls Column (Status Badge + Web Switch Button)
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    _buildStatusBadge(),
                    if (onSwitchToWeb != null) ...[
                      const SizedBox(height: 6),
                      InkWell(
                        onTap: onSwitchToWeb,
                        borderRadius: BorderRadius.circular(14),
                        child: Container(
                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                          decoration: BoxDecoration(
                            color: theme.goldPrimary.withOpacity(0.15),
                            borderRadius: BorderRadius.circular(14),
                            border: Border.all(color: theme.goldPrimary.withOpacity(0.35)),
                          ),
                          child: Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              const Text('🌐', style: TextStyle(fontSize: 12)),
                              const SizedBox(width: 5),
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
                    ],
                  ],
                ),
              ],
            ),
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
      text = 'اتصال قطع است';
    } else if (model.isStale || model.dataAgeSeconds > 180) {
      bgColor = const Color(0xFF78350F).withOpacity(0.6);
      strokeColor = theme.goldPrimary;
      textColor = theme.goldPrimary;
      text = 'حالت پشتیبان';
    } else {
      bgColor = theme.statusLiveBg;
      strokeColor = theme.statusLiveBorder;
      textColor = theme.statusLiveText;
      text = 'وضعیت: برخط';
      hasPulse = true;
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 11, vertical: 5),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: strokeColor, width: 1),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          if (hasPulse) ...[
            Container(
              width: 7,
              height: 7,
              decoration: BoxDecoration(
                color: textColor,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: textColor.withOpacity(0.9),
                    blurRadius: 6,
                    spreadRadius: 2,
                  ),
                ],
              ),
            ),
            const SizedBox(width: 6),
          ],
          Text(
            text,
            style: TextStyle(
              color: textColor,
              fontSize: 11,
              fontWeight: FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }
}
