import 'dart:math' as math;
import 'package:flutter/material.dart';

/// 12 GPU-accelerated ambient glowing orbs with subtle floating animation.
/// Adapts dynamically to active theme colors with zero layout redraw overhead.
class AmbientOrbsBackground extends StatefulWidget {
  final List<Color> orbColors;

  const AmbientOrbsBackground({
    super.key,
    required this.orbColors,
  });

  @override
  State<AmbientOrbsBackground> createState() => _AmbientOrbsBackgroundState();
}

class _AmbientOrbsBackgroundState extends State<AmbientOrbsBackground>
    with SingleTickerProviderStateMixin {
  late final AnimationController _controller;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 24),
    )..repeat();
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    if (widget.orbColors.isEmpty) {
      return const SizedBox.shrink();
    }

    return RepaintBoundary(
      child: AnimatedBuilder(
        animation: _controller,
        builder: (context, _) {
          return CustomPaint(
            size: const Size(1920, 1080),
            painter: _AmbientOrbsPainter(
              progress: _controller.value,
              colors: widget.orbColors,
            ),
          );
        },
      ),
    );
  }
}

class _OrbConfig {
  final double xRatio;
  final double yRatio;
  final double radius;
  final double speedMultiplier;
  final double phaseShift;
  final int colorIndex;
  final double opacity;

  const _OrbConfig({
    required this.xRatio,
    required this.yRatio,
    required this.radius,
    required this.speedMultiplier,
    required this.phaseShift,
    required this.colorIndex,
    required this.opacity,
  });
}

class _AmbientOrbsPainter extends CustomPainter {
  final double progress;
  final List<Color> colors;

  static const List<_OrbConfig> _configs = [
    // 1. Top Right
    _OrbConfig(xRatio: 0.82, yRatio: 0.12, radius: 460, speedMultiplier: 1.0, phaseShift: 0.0, colorIndex: 0, opacity: 0.70),
    // 2. Top Left
    _OrbConfig(xRatio: 0.15, yRatio: 0.18, radius: 420, speedMultiplier: 1.2, phaseShift: 1.2, colorIndex: 1, opacity: 0.65),
    // 3. Center Right
    _OrbConfig(xRatio: 0.74, yRatio: 0.48, radius: 400, speedMultiplier: 0.9, phaseShift: 2.4, colorIndex: 2, opacity: 0.68),
    // 4. Bottom Left
    _OrbConfig(xRatio: 0.18, yRatio: 0.82, radius: 500, speedMultiplier: 1.1, phaseShift: 3.6, colorIndex: 3, opacity: 0.62),
    // 5. Bottom Right
    _OrbConfig(xRatio: 0.88, yRatio: 0.86, radius: 450, speedMultiplier: 0.8, phaseShift: 4.8, colorIndex: 4, opacity: 0.65),
    // 6. Center Stage
    _OrbConfig(xRatio: 0.48, yRatio: 0.42, radius: 480, speedMultiplier: 1.3, phaseShift: 0.8, colorIndex: 5, opacity: 0.58),
    // 7. Top Center
    _OrbConfig(xRatio: 0.52, yRatio: 0.08, radius: 380, speedMultiplier: 1.0, phaseShift: 2.0, colorIndex: 0, opacity: 0.62),
    // 8. Mid Left
    _OrbConfig(xRatio: 0.28, yRatio: 0.46, radius: 400, speedMultiplier: 0.85, phaseShift: 3.2, colorIndex: 1, opacity: 0.56),
    // 9. Mid Top Left
    _OrbConfig(xRatio: 0.34, yRatio: 0.24, radius: 420, speedMultiplier: 1.15, phaseShift: 4.4, colorIndex: 2, opacity: 0.60),
    // 10. Mid Bottom Left
    _OrbConfig(xRatio: 0.36, yRatio: 0.74, radius: 390, speedMultiplier: 0.95, phaseShift: 5.6, colorIndex: 3, opacity: 0.56),
    // 11. Mid Top Right
    _OrbConfig(xRatio: 0.62, yRatio: 0.22, radius: 410, speedMultiplier: 1.05, phaseShift: 1.6, colorIndex: 4, opacity: 0.60),
    // 12. Mid Bottom Right
    _OrbConfig(xRatio: 0.64, yRatio: 0.76, radius: 430, speedMultiplier: 0.9, phaseShift: 2.8, colorIndex: 5, opacity: 0.58),
  ];

  _AmbientOrbsPainter({
    required this.progress,
    required this.colors,
  });

  @override
  void paint(Canvas canvas, Size size) {
    if (colors.isEmpty) return;

    for (final cfg in _configs) {
      final color = colors[cfg.colorIndex % colors.length];

      // Subtle sinusoidal 2D displacement
      final angle = (progress * 2 * math.pi * cfg.speedMultiplier) + cfg.phaseShift;
      final dx = math.sin(angle) * 45.0;
      final dy = math.cos(angle * 0.8) * 36.0;

      final cx = (size.width * cfg.xRatio) + dx;
      final cy = (size.height * cfg.yRatio) + dy;
      final center = Offset(cx, cy);

      final paint = Paint()
        ..shader = RadialGradient(
          colors: [
            color.withOpacity(cfg.opacity),
            color.withOpacity(cfg.opacity * 0.55),
            color.withOpacity(cfg.opacity * 0.18),
            Colors.transparent,
          ],
          stops: const [0.0, 0.35, 0.70, 1.0],
        ).createShader(Rect.fromCircle(center: center, radius: cfg.radius));

      canvas.drawCircle(center, cfg.radius, paint);
    }
  }

  @override
  bool shouldRepaint(covariant _AmbientOrbsPainter oldDelegate) {
    return oldDelegate.progress != progress || oldDelegate.colors != colors;
  }
}
