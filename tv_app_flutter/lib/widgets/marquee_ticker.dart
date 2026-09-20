import 'package:flutter/material.dart';
import '../theme/board_theme.dart';

class MarqueeTicker extends StatefulWidget {
  final String text;
  final BoardThemeData theme;
  final double velocity; // Pixels per second

  const MarqueeTicker({
    super.key,
    required this.text,
    required this.theme,
    this.velocity = 45.0,
  });

  @override
  State<MarqueeTicker> createState() => _MarqueeTickerState();
}

class _MarqueeTickerState extends State<MarqueeTicker> with SingleTickerProviderStateMixin {
  late ScrollController _scrollController;
  late AnimationController _animationController;

  @override
  void initState() {
    super.initState();
    _scrollController = ScrollController();
    _animationController = AnimationController(vsync: this);
    WidgetsBinding.instance.addPostFrameCallback((_) => _startScrolling());
  }

  void _startScrolling() async {
    if (!mounted) return;
    final maxScroll = _scrollController.position.maxScrollExtent;
    if (maxScroll <= 0) return;

    final duration = Duration(
      milliseconds: ((maxScroll / widget.velocity) * 1000).toInt(),
    );

    _animationController.duration = duration;

    while (mounted) {
      if (!_scrollController.hasClients) break;
      await _scrollController.animateTo(
        _scrollController.position.maxScrollExtent,
        duration: duration,
        curve: Curves.linear,
      );
      if (!mounted) break;
      _scrollController.jumpTo(0);
      await Future.delayed(const Duration(milliseconds: 500));
    }
  }

  @override
  void dispose() {
    _scrollController.dispose();
    _animationController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      decoration: BoxDecoration(
        color: widget.theme.tickerBackground.withOpacity(widget.theme.isDark ? 0.85 : 0.95),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: widget.theme.goldPrimary.withOpacity(0.3),
          width: 1.2,
        ),
      ),
      child: Row(
        textDirection: TextDirection.rtl,
        children: [
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(
              color: widget.theme.goldPrimary.withOpacity(0.18),
              borderRadius: BorderRadius.circular(10),
              border: Border.all(
                color: widget.theme.goldPrimary.withOpacity(0.4),
                width: 1,
              ),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(
                  Icons.campaign_rounded,
                  size: 16,
                  color: widget.theme.goldPrimary,
                ),
                const SizedBox(width: 5),
                Text(
                  'پیام تابلو',
                  style: TextStyle(
                    color: widget.theme.goldPrimary,
                    fontSize: 12,
                    fontWeight: FontWeight.w800,
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: SingleChildScrollView(
              controller: _scrollController,
              scrollDirection: Axis.horizontal,
              physics: const NeverScrollableScrollPhysics(),
              child: Text(
                '${widget.text}               ${widget.text}               ${widget.text}',
                style: TextStyle(
                  color: widget.theme.isDark ? const Color(0xFFFDE68A) : widget.theme.textPrimary,
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  letterSpacing: 0.2,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
