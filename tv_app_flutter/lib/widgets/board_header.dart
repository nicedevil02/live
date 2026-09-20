import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:qr_flutter/qr_flutter.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class BoardHeader extends StatelessWidget {
  final BoardModel model;
  final BoardThemeData theme;
  final ValueListenable<DateTime> timeNotifier;
  final bool isOffline;
  final VoidCallback? onSwitchToWeb;

  const BoardHeader({
    super.key,
    required this.model,
    required this.theme,
    required this.timeNotifier,
    this.isOffline = false,
    this.onSwitchToWeb,
  });

  @override
  Widget build(BuildContext context) {
    return RepaintBoundary(
      child: Container(
      padding: const EdgeInsets.symmetric(horizontal: 36, vertical: 16),
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
          // 1. Right Section: QR Code Card & Labels
          // ===================================================================
          Expanded(
            flex: 4,
            child: Row(
              textDirection: TextDirection.rtl,
              children: [
                // QR Code Frame
                Container(
                  width: 96,
                  height: 96,
                  padding: const EdgeInsets.all(5),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(18),
                    border: Border.all(color: Colors.white.withOpacity(0.5)),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.18),
                        blurRadius: 14,
                        offset: const Offset(0, 4),
                      ),
                    ],
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(12),
                    child: QrImageView(
                      data: (model.qrLink != null && model.qrLink!.isNotEmpty)
                          ? model.qrLink!
                          : 'https://talalive.ir/${model.username}',
                      version: QrVersions.auto,
                      size: 86,
                      eyeStyle: const QrEyeStyle(
                        eyeShape: QrEyeShape.square,
                        color: Color(0xFF0F172A),
                      ),
                      dataModuleStyle: const QrDataModuleStyle(
                        dataModuleShape: QrDataModuleShape.square,
                        color: Color(0xFF0F172A),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 16),

                // Labels
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text(
                        (model.qrLabel != null && model.qrLabel!.isNotEmpty)
                            ? model.qrLabel!
                            : 'همراه ما باشید',
                        style: TextStyle(
                          color: theme.textPrimary,
                          fontSize: 17,
                          fontWeight: FontWeight.w900,
                          height: 1.2,
                        ),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 4),
                      Text(
                        (model.qrDesc != null && model.qrDesc!.isNotEmpty)
                            ? model.qrDesc!
                            : 'اسکن جهت مشاهده در موبایل',
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 13,
                          fontWeight: FontWeight.w700,
                          height: 1.3,
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // ===================================================================
          // 2. Center Section: Shop Name, City Tag, and Home Link
          // ===================================================================
          Expanded(
            flex: 4,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  model.shopName,
                  style: TextStyle(
                    color: theme.isDark ? const Color(0xFFFDE68A) : const Color(0xFF0F172A),
                    fontSize: 36,
                    fontWeight: FontWeight.w900,
                    letterSpacing: -0.5,
                    height: 1.1,
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 6),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 3),
                  decoration: BoxDecoration(
                    color: theme.isDark
                        ? theme.goldPrimary.withOpacity(0.12)
                        : const Color(0xFF2563EB).withOpacity(0.10),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(
                      color: theme.isDark
                          ? theme.goldPrimary.withOpacity(0.25)
                          : const Color(0xFF2563EB).withOpacity(0.25),
                    ),
                  ),
                  child: Text(
                    '✦  نرخ‌گذاری لحظه‌ای طلا و ارز — ${model.cityFullDisplay ?? 'اصفهان (کاشان)'}  ✦',
                    style: TextStyle(
                      color: theme.isDark ? theme.goldPrimary : const Color(0xFF1D4ED8),
                      fontSize: 12,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                ),
                const SizedBox(height: 5),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 3),
                  decoration: BoxDecoration(
                    color: theme.goldPrimary.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(color: theme.goldPrimary.withOpacity(0.25)),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Container(
                        width: 5,
                        height: 5,
                        decoration: BoxDecoration(
                          color: theme.goldPrimary,
                          shape: BoxShape.circle,
                        ),
                      ),
                      const SizedBox(width: 6),
                      Text(
                        'صفحه اصلی طلالایو',
                        style: TextStyle(
                          color: theme.isDark ? theme.goldPrimary : const Color(0xFF78350F),
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
          // 3. Left Section: Status, Web Switcher, Divider, and Clock (Clock on far left)
          // ===================================================================
          Expanded(
            flex: 4,
            child: Row(
              textDirection: TextDirection.ltr,
              mainAxisAlignment: MainAxisAlignment.start,
              children: [
                // Clock & Date (At the far left edge!)
                ValueListenableBuilder<DateTime>(
                  valueListenable: timeNotifier,
                  builder: (context, dateTime, _) {
                    return Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Text(
                          PersianUtils.formatClock(dateTime),
                          style: TextStyle(
                            color: theme.textPrimary,
                            fontSize: 56,
                            fontWeight: FontWeight.w900,
                            fontFamily: 'Vazirmatn',
                            letterSpacing: -1,
                            height: 1.0,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          PersianUtils.getShamsiDateString(dateTime),
                          style: TextStyle(
                            color: theme.textSecondary,
                            fontSize: 15,
                            fontWeight: FontWeight.w700,
                            fontFamily: 'Vazirmatn',
                          ),
                        ),
                      ],
                    );
                  },
                ),
                const SizedBox(width: 20),

                // Vertical Divider
                Container(
                  width: 1,
                  height: 54,
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
                          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
                          decoration: BoxDecoration(
                            color: theme.goldPrimary.withOpacity(0.15),
                            borderRadius: BorderRadius.circular(14),
                            border: Border.all(color: theme.goldPrimary.withOpacity(0.35)),
                          ),
                          child: Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              const Text('🌐', style: TextStyle(fontSize: 13)),
                              const SizedBox(width: 6),
                              Text(
                                'نسخه وب',
                                style: TextStyle(
                                  color: theme.goldPrimary,
                                  fontSize: 12,
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
