import 'package:flutter/material.dart';

class BoardThemeData {
  final String themeKey;
  final bool isDark;
  final Color backgroundColor;

  bool get isBingTheme => themeKey.startsWith('bing-');
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

  // Ambient Floating Orb Colors
  final List<Color> orbColors;

  const BoardThemeData({
    this.themeKey = 'imperial-onyx',
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
    required this.orbColors,
  });

  // 1. Imperial Onyx (Default Luxury 24K Gold Dark Mode)
  static const BoardThemeData onyxGold = BoardThemeData(
    themeKey: 'imperial-onyx',
    isDark: true,
    backgroundColor: Color(0xFF05070C),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB8161C2A), Color(0xCC0A0E17)],
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
    orbColors: [
      Color(0xFFFBBF24),
      Color(0xFFF59E0B),
      Color(0xFFFEF08A),
      Color(0xFFD97706),
      Color(0xFFFCD34D),
      Color(0xFFB45309),
    ],
  );

  // 2. Imperial Pearl (Luxurious Champagne Light Mode)
  static const BoardThemeData imperialPearl = BoardThemeData(
    themeKey: 'imperial-pearl',
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
    orbColors: [
      Color(0xFF38BDF8),
      Color(0xFFF43F5E),
      Color(0xFFF59E0B),
      Color(0xFF10B981),
      Color(0xFF3B82F6),
      Color(0xFFA855F7),
    ],
  );

  // 3. Gold Royal (Rich Amber Gold)
  static const BoardThemeData goldRoyal = BoardThemeData(
    themeKey: 'gold-royal',
    isDark: true,
    backgroundColor: Color(0xFF0A0702),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB8241708), Color(0xCC150D03)],
    ),
    cardStrokeColor: Color(0x80F59E0B),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF078350F), Color(0xF0451A03), Color(0xFA1E0B02)],
    ),
    heroStrokeColor: Color(0xFFFCD34D),
    heroTextColor: Color(0xFFFEF08A),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFEF08A), Color(0xFFF59E0B), Color(0xFFD97706)],
    ),
    goldPrimary: Color(0xFFF59E0B),
    goldSecondary: Color(0xFFFCD34D),
    textPrimary: Color(0xFFFFFBEB),
    textSecondary: Color(0xFFFDE68A),
    textMuted: Color(0xFFB45309),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC1A0E04),
    headerBackground: Color(0xCC150B03),
    footerBackground: Color(0xCC150B03),
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
    unitBadgeBg: Color(0x66241708),
    unitBadgeBorder: Color(0x59F59E0B),
    unitBadgeText: Color(0xFFFDE68A),
    orbColors: [
      Color(0xFFFBBF24),
      Color(0xFFF59E0B),
      Color(0xFFFDE047),
      Color(0xFFD97706),
      Color(0xFFFCD34D),
      Color(0xFFB45309),
    ],
  );

  // 4. Emerald Night (Deep Emerald, Mint & Jade)
  static const BoardThemeData emeraldNight = BoardThemeData(
    themeKey: 'emerald-night',
    isDark: true,
    backgroundColor: Color(0xFF02130E),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB8062C21), Color(0xCC031B14)],
    ),
    cardStrokeColor: Color(0x8010B981),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF0064E3B), Color(0xF0022C22), Color(0xFA011A14)],
    ),
    heroStrokeColor: Color(0xFF34D399),
    heroTextColor: Color(0xFFA7F3D0),
    titleGradient: LinearGradient(
      colors: [Color(0xFFA7F3D0), Color(0xFF34D399), Color(0xFF10B981)],
    ),
    goldPrimary: Color(0xFF10B981),
    goldSecondary: Color(0xFF34D399),
    textPrimary: Color(0xFFECFDF5),
    textSecondary: Color(0xFFA7F3D0),
    textMuted: Color(0xFF047857),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC041F17),
    headerBackground: Color(0xCC031B14),
    footerBackground: Color(0xCC031B14),
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
    unitBadgeBg: Color(0x66062C21),
    unitBadgeBorder: Color(0x5910B981),
    unitBadgeText: Color(0xFFA7F3D0),
    orbColors: [
      Color(0xFF10B981),
      Color(0xFF34D399),
      Color(0xFF059669),
      Color(0xFF6EE7B7),
      Color(0xFF047857),
      Color(0xFF10B981),
    ],
  );

  // 5. Blue Ocean (Sapphire, Deep Oceanic Cyan & Azure)
  static const BoardThemeData blueOcean = BoardThemeData(
    themeKey: 'blue-ocean',
    isDark: true,
    backgroundColor: Color(0xFF030D1A),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB80A2540), Color(0xCC051628)],
    ),
    cardStrokeColor: Color(0x8006B6D4),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF0083344), Color(0xF00C4A6E), Color(0xFA021F3F)],
    ),
    heroStrokeColor: Color(0xFF38BDF8),
    heroTextColor: Color(0xFFBAE6FD),
    titleGradient: LinearGradient(
      colors: [Color(0xFFBAE6FD), Color(0xFF38BDF8), Color(0xFF06B6D4)],
    ),
    goldPrimary: Color(0xFF06B6D4),
    goldSecondary: Color(0xFF38BDF8),
    textPrimary: Color(0xFFF0F9FF),
    textSecondary: Color(0xFFBAE6FD),
    textMuted: Color(0xFF0369A1),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC051D33),
    headerBackground: Color(0xCC04172B),
    footerBackground: Color(0xCC04172B),
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
    unitBadgeBg: Color(0x660A2540),
    unitBadgeBorder: Color(0x5906B6D4),
    unitBadgeText: Color(0xFFBAE6FD),
    orbColors: [
      Color(0xFF06B6D4),
      Color(0xFF0EA5E9),
      Color(0xFF22D3EE),
      Color(0xFF38BDF8),
      Color(0xFF0284C7),
      Color(0xFF06B6D4),
    ],
  );

  // 6. Purple Haze (Royal Amethyst, Neon Violet & Fuchsia)
  static const BoardThemeData purpleHaze = BoardThemeData(
    themeKey: 'purple-haze',
    isDark: true,
    backgroundColor: Color(0xFF10051C),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB8260D3E), Color(0xCC160624)],
    ),
    cardStrokeColor: Color(0x80C026D3),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF04A044E), Color(0xF03B0764), Color(0xFA1E0538)],
    ),
    heroStrokeColor: Color(0xFFE879F9),
    heroTextColor: Color(0xFFF5D0FE),
    titleGradient: LinearGradient(
      colors: [Color(0xFFF5D0FE), Color(0xFFE879F9), Color(0xFFC026D3)],
    ),
    goldPrimary: Color(0xFFC026D3),
    goldSecondary: Color(0xFFE879F9),
    textPrimary: Color(0xFFFAF5FF),
    textSecondary: Color(0xFFF5D0FE),
    textMuted: Color(0xFF9333EA),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC1F0833),
    headerBackground: Color(0xCC1A072B),
    footerBackground: Color(0xCC1A072B),
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
    unitBadgeBg: Color(0x66260D3E),
    unitBadgeBorder: Color(0x59C026D3),
    unitBadgeText: Color(0xFFF5D0FE),
    orbColors: [
      Color(0xFFC026D3),
      Color(0xFFA855F7),
      Color(0xFFD946EF),
      Color(0xFF9333EA),
      Color(0xFFE879F9),
      Color(0xFFC026D3),
    ],
  );

  // 7. Rose Dark (Ruby Crimson & Dark Garnet)
  static const BoardThemeData roseDark = BoardThemeData(
    themeKey: 'rose-dark',
    isDark: true,
    backgroundColor: Color(0xFF17030A),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB8380B1B), Color(0xCC20040E)],
    ),
    cardStrokeColor: Color(0x80F43F5E),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF04C0519), Color(0xF0881337), Color(0xFA24020B)],
    ),
    heroStrokeColor: Color(0xFFFB7185),
    heroTextColor: Color(0xFFFECDD3),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFECDD3), Color(0xFFFB7185), Color(0xFFF43F5E)],
    ),
    goldPrimary: Color(0xFFF43F5E),
    goldSecondary: Color(0xFFFB7185),
    textPrimary: Color(0xFFFFF1F2),
    textSecondary: Color(0xFFFECDD3),
    textMuted: Color(0xFFBE123C),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC2A0614),
    headerBackground: Color(0xCC220510),
    footerBackground: Color(0xCC220510),
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
    unitBadgeBg: Color(0x66380B1B),
    unitBadgeBorder: Color(0x59F43F5E),
    unitBadgeText: Color(0xFFFECDD3),
    orbColors: [
      Color(0xFFF43F5E),
      Color(0xFFFB7185),
      Color(0xFFE11D48),
      Color(0xFFFDA4AF),
      Color(0xFFBE123C),
      Color(0xFFF43F5E),
    ],
  );

  // 8. Pure Black (AMOLED Pure Black & Titanium Silver)
  static const BoardThemeData pureBlack = BoardThemeData(
    themeKey: 'pure-black',
    isDark: true,
    backgroundColor: Color(0xFF000000),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFF0C0C0E), Color(0xFF040405)],
    ),
    cardStrokeColor: Color(0x4D52525B), // 30% zinc-600
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFF1E1E24), Color(0xFF111115), Color(0xFF050507)],
    ),
    heroStrokeColor: Color(0xFFA1A1AA),
    heroTextColor: Color(0xFFF4F4F5),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFFFFFF), Color(0xFFD4D4D8), Color(0xFFA1A1AA)],
    ),
    goldPrimary: Color(0xFFE4E4E7),
    goldSecondary: Color(0xFFA1A1AA),
    textPrimary: Color(0xFFFFFFFF),
    textSecondary: Color(0xFFA1A1AA),
    textMuted: Color(0xFF71717A),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC09090B),
    headerBackground: Color(0xCC050506),
    footerBackground: Color(0xCC050506),
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
    unitBadgeBg: Color(0x6618181B),
    unitBadgeBorder: Color(0x4DA1A1AA),
    unitBadgeText: Color(0xFFE4E4E7),
    orbColors: [], // Orbs completely disabled for OLED pure black
  );

  // 9. Dark Glass (Classic Apple Dark Glass with Indigo & Amber orbs)
  static const BoardThemeData darkGlass = BoardThemeData(
    themeKey: 'dark-glass',
    isDark: true,
    backgroundColor: Color(0xFF0B1120),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB31E293B), Color(0xCC0F172A)],
    ),
    cardStrokeColor: Color(0x4D64748B),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xF0451A03), Color(0xF01E0B02)],
    ),
    heroStrokeColor: Color(0xFFFBBF24),
    heroTextColor: Color(0xFFFEF08A),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFDE68A), Color(0xFFFACC15)],
    ),
    goldPrimary: Color(0xFFF59E0B),
    goldSecondary: Color(0xFFFBBF24),
    textPrimary: Color(0xFFFFFFFF),
    textSecondary: Color(0xFFCBD5E1),
    textMuted: Color(0xFF64748B),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC0F172A),
    headerBackground: Color(0xCC0B1120),
    footerBackground: Color(0xCC0B1120),
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
    unitBadgeBg: Color(0x661E293B),
    unitBadgeBorder: Color(0x4DFBBF24),
    unitBadgeText: Color(0xFFFDE68A),
    orbColors: [
      Color(0xFF4F46E5),
      Color(0xFF7C3AED),
      Color(0xFFF59E0B),
    ],
  );

  // 10. Light Modern (Clean Bright White & Light Slate)
  static const BoardThemeData lightModern = BoardThemeData(
    themeKey: 'light-modern',
    isDark: false,
    backgroundColor: Color(0xFFF8FAFC),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFFFFFFFF), Color(0xFFF1F5F9)],
    ),
    cardStrokeColor: Color(0x40CBD5E1),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFFFFFBEB), Color(0xFFFEF3C7)],
    ),
    heroStrokeColor: Color(0xFFD97706),
    heroTextColor: Color(0xFF78350F),
    titleGradient: LinearGradient(
      colors: [Color(0xFFB45309), Color(0xFFD97706)],
    ),
    goldPrimary: Color(0xFFD97706),
    goldSecondary: Color(0xFFB45309),
    textPrimary: Color(0xFF0F172A),
    textSecondary: Color(0xFF334155),
    textMuted: Color(0xFF64748B),
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
    orbColors: [
      Color(0xFF38BDF8),
      Color(0xFFF43F5E),
      Color(0xFFF59E0B),
      Color(0xFF10B981),
      Color(0xFF818CF8),
      Color(0xFFA855F7),
    ],
  );

  // 11. Bing Daily (Obsidian Dark Glass with Amber Accent)
  static const BoardThemeData bingDaily = BoardThemeData(
    themeKey: 'bing-daily',
    isDark: true,
    backgroundColor: Color(0xFF090D16),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB30F172A), Color(0xD9020617)],
    ),
    cardStrokeColor: Color(0x66F59E0B),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xE6451A03), Color(0xF21C0B03)],
    ),
    heroStrokeColor: Color(0xFFFBBF24),
    heroTextColor: Color(0xFFFEF08A),
    titleGradient: LinearGradient(
      colors: [Color(0xFFFEF08A), Color(0xFFF59E0B)],
    ),
    goldPrimary: Color(0xFFF59E0B),
    goldSecondary: Color(0xFFFBBF24),
    textPrimary: Color(0xFFFFFFFF),
    textSecondary: Color(0xFFCBD5E1),
    textMuted: Color(0xFF64748B),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC090D16),
    headerBackground: Color(0xCC090D16),
    footerBackground: Color(0xCC090D16),
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
    orbColors: [
      Color(0xFFFBBF24),
      Color(0xFFF59E0B),
      Color(0xFFFEF08A),
      Color(0xFFD97706),
      Color(0xFFFCD34D),
      Color(0xFFB45309),
    ],
  );

  // 12. Bing Studio (Studio Glass with Indigo & Cyan Accents)
  static const BoardThemeData bingStudio = BoardThemeData(
    themeKey: 'bing-studio',
    isDark: true,
    backgroundColor: Color(0xFF0A0F1D),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xB31E1B4B), Color(0xD90F172A)],
    ),
    cardStrokeColor: Color(0x666366F1),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xE6312E81), Color(0xF21E1B4B)],
    ),
    heroStrokeColor: Color(0xFF818CF8),
    heroTextColor: Color(0xFFE0E7FF),
    titleGradient: LinearGradient(
      colors: [Color(0xFFE0E7FF), Color(0xFF818CF8)],
    ),
    goldPrimary: Color(0xFF6366F1),
    goldSecondary: Color(0xFF818CF8),
    textPrimary: Color(0xFFFFFFFF),
    textSecondary: Color(0xFFC7D2FE),
    textMuted: Color(0xFF6366F1),
    greenUp: Color(0xFF34D399),
    redDown: Color(0xFFFB7185),
    tickerBackground: Color(0xCC0A0F1D),
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
    unitBadgeBg: Color(0x661E1B4B),
    unitBadgeBorder: Color(0x59818CF8),
    unitBadgeText: Color(0xFFE0E7FF),
    orbColors: [
      Color(0xFF818CF8),
      Color(0xFF6366F1),
      Color(0xFF38BDF8),
      Color(0xFFC084FC),
      Color(0xFF0EA5E9),
      Color(0xFF4F46E5),
    ],
  );

  // 13. Bing Ceramic (Porcelain White Ceramic with Slate & Gold Accents)
  static const BoardThemeData bingCeramic = BoardThemeData(
    themeKey: 'bing-ceramic',
    isDark: false,
    backgroundColor: Color(0xFFF1F5F9),
    cardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xEBFFFFFF), Color(0xD9E2E8F0)],
    ),
    cardStrokeColor: Color(0x6694A3B8),
    heroCardGradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [Color(0xFFFFFBEB), Color(0xFFFDE68A)],
    ),
    heroStrokeColor: Color(0xFFD97706),
    heroTextColor: Color(0xFF451A03),
    titleGradient: LinearGradient(
      colors: [Color(0xFF334155), Color(0xFF0F172A)],
    ),
    goldPrimary: Color(0xFFD97706),
    goldSecondary: Color(0xFFB45309),
    textPrimary: Color(0xFF0F172A),
    textSecondary: Color(0xFF334155),
    textMuted: Color(0xFF64748B),
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
    orbColors: [
      Color(0xFFFDE68A),
      Color(0xFF93C5FD),
      Color(0xFFFCA5A5),
      Color(0xFF86EFAC),
      Color(0xFFC4B5FD),
      Color(0xFFFCD34D),
    ],
  );

  static BoardThemeData fromKey(String? key) {
    if (key == null) return onyxGold;
    final clean = key.toLowerCase().trim();

    // 1. Imperial Onyx
    if (clean == 'imperial-onyx' || clean == 'onyx-gold') {
      return onyxGold;
    }
    // 2. Imperial Pearl
    if (clean == 'imperial-pearl') {
      return imperialPearl;
    }
    // 3. Gold Royal
    if (clean == 'gold-royal' || clean.contains('royal')) {
      return goldRoyal;
    }
    // 4. Emerald Night
    if (clean == 'emerald-night' || clean.contains('emerald')) {
      return emeraldNight;
    }
    // 5. Blue Ocean
    if (clean == 'blue-ocean' || clean.contains('ocean')) {
      return blueOcean;
    }
    // 6. Purple Haze
    if (clean == 'purple-haze' || clean.contains('purple') || clean.contains('haze')) {
      return purpleHaze;
    }
    // 7. Rose Dark
    if (clean == 'rose-dark' || clean.contains('rose')) {
      return roseDark;
    }
    // 8. Pure Black
    if (clean == 'pure-black' || clean.contains('pure') || clean == 'black') {
      return pureBlack;
    }
    // 9. Dark Glass
    if (clean == 'dark-glass' || clean.contains('dark')) {
      return darkGlass;
    }
    // 10. Light Modern
    if (clean == 'light-modern' || clean == 'light') {
      return lightModern;
    }
    // 11. Bing Daily (Obsidian)
    if (clean == 'bing-daily' || clean.contains('obsidian')) {
      return bingDaily;
    }
    // 12. Bing Studio
    if (clean == 'bing-studio' || clean.contains('studio')) {
      return bingStudio;
    }
    // 13. Bing Ceramic
    if (clean == 'bing-ceramic' || clean.contains('ceramic')) {
      return bingCeramic;
    }

    if (clean.contains('light') || clean.contains('pearl')) {
      return imperialPearl;
    }
    return onyxGold;
  }

  static BoardThemeData fromMode(String mode) {
    return fromKey(mode);
  }
}
