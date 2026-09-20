import 'package:flutter/material.dart';

class BoardThemeData {
  final bool isDark;
  final Color backgroundColor;
  final LinearGradient cardGradient;
  final Color cardStrokeColor;
  final LinearGradient heroCardGradient;
  final Color heroStrokeColor;
  final Color heroTextColor;
  final LinearGradient titleGradient;
  final Color goldPrimary;
  final Color goldSecondary;
  final Color textPrimary;
  final Color textSecondary;
  final Color textMuted;
  final Color greenUp;
  final Color redDown;
  final Color tickerBackground;
  final Color headerBackground;
  final Color footerBackground;

  // Status Badge Colors
  final Color statusLiveBg;
  final Color statusLiveBorder;
  final Color statusLiveText;
  final Color statusStaleBg;
  final Color statusStaleBorder;
  final Color statusStaleText;

  // Change Pill Colors
  final Color pillUpBg;
  final Color pillUpBorder;
  final Color pillUpText;
  final Color pillDownBg;
  final Color pillDownBorder;
  final Color pillDownText;
  final Color pillFlatBg;
  final Color pillFlatBorder;
  final Color pillFlatText;

  // Unit Badge Colors
  final Color unitBadgeBg;
  final Color unitBadgeBorder;
  final Color unitBadgeText;

  const BoardThemeData({
    required this.isDark,
    required this.backgroundColor,
    required this.cardGradient,
    required this.cardStrokeColor,
    required this.heroCardGradient,
    required this.heroStrokeColor,
    required this.heroTextColor,
    required this.titleGradient,
    required this.goldPrimary,
    required this.goldSecondary,
    required this.textPrimary,
    required this.textSecondary,
    required this.textMuted,
    required this.greenUp,
    required this.redDown,
    required this.tickerBackground,
    required this.headerBackground,
    required this.footerBackground,
    required this.statusLiveBg,
    required this.statusLiveBorder,
    required this.statusLiveText,
    required this.statusStaleBg,
    required this.statusStaleBorder,
    required this.statusStaleText,
    required this.pillUpBg,
    required this.pillUpBorder,
    required this.pillUpText,
    required this.pillDownBg,
    required this.pillDownBorder,
    required this.pillDownText,
    required this.pillFlatBg,
    required this.pillFlatBorder,
    required this.pillFlatText,
    required this.unitBadgeBg,
    required this.unitBadgeBorder,
    required this.unitBadgeText,
  });

  static const BoardThemeData onyxGold = BoardThemeData(
    isDark: true,
    backgroundColor: Color(0xFF05070C),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xE6161C2A), Color(0xF20A0E17)],
    ),
    cardStrokeColor: Color(0x66FBBF24), // 40% amber-400
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xE0451A03), Color(0xF01E0B02), Color(0xFA0F0501)],
    ),
    heroStrokeColor: Color(0xFFFBBF24),
    heroTextColor: Color(0xFFFEF08A),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFDE68A), Color(0xFFFACC15), Color(0xFFFCD34D)],
    ),
    goldPrimary: Color(0xFFF59E0B),
    goldSecondary: Color(0xFFFBBF24),
    textPrimary: Color(0xFFF8FAFC),
    textSecondary: Color(0xFFCBD5E1),
    textMuted: Color(0xFF64748B),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC0F172A),
    headerBackground: Color(0xCC0A0F1D),
    footerBackground: Color(0xCC0A0F1D),
    statusLiveBg: Color(0x33064E3B),
    statusLiveBorder: Color(0x5934D399),
    statusLiveText: Color(0xFF6EE7B7),
    statusStaleBg: Color(0x3378350F),
    statusStaleBorder: Color(0x59F59E0B),
    statusStaleText: Color(0xFFFCD34D),
    pillUpBg: Color(0x33064E3B),
    pillUpBorder: Color(0x6634D399),
    pillUpText: Color(0xFF34D399),
    pillDownBg: Color(0x33881337),
    pillDownBorder: Color(0x66FB7185),
    pillDownText: Color(0xFFFB7185),
    pillFlatBg: Color(0x331E293B),
    pillFlatBorder: Color(0x3394A3B8),
    pillFlatText: Color(0xFF94A3B8),
    unitBadgeBg: Color(0x660F172A),
    unitBadgeBorder: Color(0x4DFBBF24),
    unitBadgeText: Color(0xFFFDE68A),
  );

  static const BoardThemeData imperialPearl = BoardThemeData(
    isDark: false,
    backgroundColor: Color(0xFFF6F7FB),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF5FFFFFF), Color(0xEBFAFBFD)],
    ),
    cardStrokeColor: Color(0x59D97706), // 35% amber-600
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFFFFFDF5), Color(0xFFFEF3C7), Color(0xFFFDE68A)],
    ),
    heroStrokeColor: Color(0xFFD97706),
    heroTextColor: Color(0xFF451A03),
    titleGradient: LinearGradient(
      colors: [Color(0xFFB45309), Color(0xFFCA8A04), Color(0xFF92400E)],
    ),
    goldPrimary: Color(0xFFD97706),
    goldSecondary: Color(0xFFB45309),
    textPrimary: Color(0xFF0F172A),
    textSecondary: Color(0xFF475569),
    textMuted: Color(0xFF94A3B8),
    greenUp: Color(0xFF059669),
    redDown: Color(0xFFE11D48),
    tickerBackground: Color(0xE6FFFFFF),
    headerBackground: Color(0xF2FFFFFF),
    footerBackground: Color(0xF2FFFFFF),
    statusLiveBg: Color(0xE6ECFDF5),
    statusLiveBorder: Color(0x6610B981),
    statusLiveText: Color(0xFF047857),
    statusStaleBg: Color(0xE6FFFBEB),
    statusStaleBorder: Color(0x66F59E0B),
    statusStaleText: Color(0xFFB45309),
    pillUpBg: Color(0xE6D1FAE5),
    pillUpBorder: Color(0x66059669),
    pillUpText: Color(0xFF065F46),
    pillDownBg: Color(0xE6FFE4E6),
    pillDownBorder: Color(0x66E11D48),
    pillDownText: Color(0xFF9F1239),
    pillFlatBg: Color(0xE6F1F5F9),
    pillFlatBorder: Color(0x66CBD5E1),
    pillFlatText: Color(0xFF475569),
    unitBadgeBg: Color(0xE6F1F5F9),
    unitBadgeBorder: Color(0x59D97706),
    unitBadgeText: Color(0xFF78350F),
  );

  static BoardThemeData fromMode(String mode) {
    if (mode.contains('light') || mode.contains('pearl')) {
      return imperialPearl;
    }
    return onyxGold;
  }
}
