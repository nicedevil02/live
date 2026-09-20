import 'package:flutter/material.dart';

class BoardThemeData {
  final bool isDark;
  final Color backgroundColor;
  final LinearGradient cardGradient;
  final Color cardStrokeColor;
  final Color goldPrimary;
  final Color goldSecondary;
  final Color textPrimary;
  final Color textSecondary;
  final Color textMuted;
  final Color greenUp;
  final Color redDown;
  final Color tickerBackground;
  final Color headerBackground;

  const BoardThemeData({
    required this.isDark,
    required this.backgroundColor,
    required this.cardGradient,
    required this.cardStrokeColor,
    required this.goldPrimary,
    required this.goldSecondary,
    required this.textPrimary,
    required this.textSecondary,
    required this.textMuted,
    required this.greenUp,
    required this.redDown,
    required this.tickerBackground,
    required this.headerBackground,
  });

  static const BoardThemeData onyxGold = BoardThemeData(
    isDark: true,
    backgroundColor: Color(0xFF020617),
    cardGradient: LinearGradient(
      begin: Alignment.topCenter,
      end: Alignment.bottomCenter,
      colors: [Color(0xFF111827), Color(0xFF0B0F19)],
    ),
    cardStrokeColor: Color(0x4DF59E0B), // 30% gold border
    goldPrimary: Color(0xFFF59E0B),
    goldSecondary: Color(0xFFFBBF24),
    textPrimary: Color(0xFFF8FAFC),
    textSecondary: Color(0xFFCBD5E1),
    textMuted: Color(0xFF64748B),
    greenUp: Color(0xFF22C55E),
    redDown: Color(0xFFEF4444),
    tickerBackground: Color(0xFF0F172A),
    headerBackground: Color(0xFF0A0F1D),
  );

  static const BoardThemeData imperialPearl = BoardThemeData(
    isDark: false,
    backgroundColor: Color(0xFFF1F5F9),
    cardGradient: LinearGradient(
      begin: Alignment.topCenter,
      end: Alignment.bottomCenter,
      colors: [Color(0xFFFFFFFF), Color(0xFFF8FAFC)],
    ),
    cardStrokeColor: Color(0x59D97706),
    goldPrimary: Color(0xFFD97706),
    goldSecondary: Color(0xFFB45309),
    textPrimary: Color(0xFF0F172A),
    textSecondary: Color(0xFF475569),
    textMuted: Color(0xFF94A3B8),
    greenUp: Color(0xFF16A34A),
    redDown: Color(0xFFDC2626),
    tickerBackground: Color(0xFFE2E8F0),
    headerBackground: Color(0xFFFFFFFF),
  );

  static BoardThemeData fromMode(String mode) {
    if (mode.contains('light') || mode.contains('pearl')) {
      return imperialPearl;
    }
    return onyxGold;
  }
}
