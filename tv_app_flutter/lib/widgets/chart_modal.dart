import 'dart:async';
import 'dart:math' as math;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import '../services/api_service.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class ChartModal extends StatefulWidget {
  final String username;
  final String symbol;
  final String initialLabel;
  final String unit;
  final BoardThemeData theme;

  const ChartModal({
    super.key,
    required this.username,
    required this.symbol,
    required this.initialLabel,
    required this.unit,
    required this.theme,
  });

  @override
  State<ChartModal> createState() => _ChartModalState();
}

class _ChartModalState extends State<ChartModal> {
  static const List<String> _ranges = ['1d', '7d', '30d', '1y'];
  static const Map<String, String> _rangeLabels = {
    '1d': '۱ روزه',
    '7d': '۷ روزه',
    '30d': '۳۰ روزه',
    '1y': '۱ ساله',
  };

  final Map<String, Map<String, dynamic>> _cache = {};
  final FocusNode _focusNode = FocusNode();

  String _activeRange = '7d';
  bool _isLoading = true;
  int? _hoverIndex;
  int _autoCloseRemaining = 60;
  Timer? _autoCloseTimer;

  @override
  void initState() {
    super.initState();
    _loadRange('7d');
    _autoCloseTimer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (!mounted) return;
      setState(() {
        _autoCloseRemaining -= 1;
      });
      if (_autoCloseRemaining <= 0) {
        Navigator.of(context).pop();
      }
    });
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (mounted) _focusNode.requestFocus();
    });
  }

  void _resetAutoClose() {
    if (_autoCloseRemaining != 60) {
      _autoCloseRemaining = 60;
    }
  }

  Future<void> _loadRange(String range) async {
    _resetAutoClose();
    if (_cache.containsKey(range)) {
      setState(() {
        _activeRange = range;
        _isLoading = false;
        _hoverIndex = null;
      });
      return;
    }

    setState(() {
      _activeRange = range;
      _isLoading = true;
      _hoverIndex = null;
    });

    final data = await ApiService.fetchChartSeries(widget.username, widget.symbol, range);
    if (!mounted) return;

    if (data != null) {
      _cache[range] = data;
    }

    setState(() {
      if (_activeRange == range) {
        _isLoading = false;
      }
    });
  }

  @override
  void dispose() {
    _autoCloseTimer?.cancel();
    _focusNode.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final series = _cache[_activeRange];
    final theme = widget.theme;
    final isDark = theme.isDark;
    final surface = isDark ? const Color(0xFF0F1319) : const Color(0xFFFFFFFF);
    final inset = isDark ? const Color(0xFF171C24) : const Color(0xFFF1EDE4);
    final border = isDark ? Colors.white.withOpacity(0.12) : Colors.black.withOpacity(0.10);
    final textPrimary = isDark ? const Color(0xFFF8FAFC) : const Color(0xFF0F172A);
    final textSecondary = isDark ? const Color(0xFF94A3B8) : const Color(0xFF475569);

    final rawPts = (series?['points'] as List<dynamic>?) ?? const [];
    final points = <Map<String, dynamic>>[];
    for (final p in rawPts) {
      if (p is Map) {
        final price = (p['price'] as num?)?.toDouble() ?? 0;
        if (price > 0) {
          points.add(Map<String, dynamic>.from(p));
        }
      }
    }

    final decimals = (series?['decimals'] as num?)?.toInt() ??
        (['ounce', 'bitcoin', 'oil_brent', 'silver_ounce'].contains(widget.symbol) ? 2 : 0);
    final currentPrice = (series?['currentPrice'] as num?)?.toDouble() ?? 0;
    final startPrice = (series?['startPrice'] as num?)?.toDouble() ?? currentPrice;
    final highPrice = (series?['highPrice'] as num?)?.toDouble() ?? currentPrice;
    final lowPrice = (series?['lowPrice'] as num?)?.toDouble() ?? currentPrice;

    final activePt = (_hoverIndex != null && _hoverIndex! >= 0 && _hoverIndex! < points.length)
        ? points[_hoverIndex!]
        : null;
    final shownPrice = (activePt?['price'] as num?)?.toDouble() ?? currentPrice;
    final shownDelta = activePt != null
        ? (shownPrice - startPrice)
        : ((series?['changeValue'] as num?)?.toDouble() ?? 0);
    final shownPct = activePt != null
        ? (startPrice > 0 ? (shownDelta / startPrice) * 100 : 0.0)
        : ((series?['changePercent'] as num?)?.toDouble() ?? 0);

    final Color trendColor = shownDelta > 0.0001
        ? (isDark ? const Color(0xFF34D399) : const Color(0xFF047857))
        : (shownDelta < -0.0001
            ? (isDark ? const Color(0xFFFB7185) : const Color(0xFFBE123C))
            : const Color(0xFFF59E0B));

    return KeyboardListener(
      focusNode: _focusNode,
      onKeyEvent: (event) {
        if (event is KeyDownEvent) {
          _resetAutoClose();
          if (event.logicalKey == LogicalKeyboardKey.escape ||
              event.logicalKey == LogicalKeyboardKey.backspace) {
            Navigator.of(context).pop();
          } else if (event.logicalKey == LogicalKeyboardKey.arrowLeft) {
            final idx = (_ranges.indexOf(_activeRange) + 1) % _ranges.length;
            _loadRange(_ranges[idx]);
          } else if (event.logicalKey == LogicalKeyboardKey.arrowRight) {
            final idx = (_ranges.indexOf(_activeRange) - 1 + _ranges.length) % _ranges.length;
            _loadRange(_ranges[idx]);
          }
        }
      },
      child: Dialog.fullscreen(
        backgroundColor: isDark ? const Color(0xFF0B0C0E) : const Color(0xFFF7F5F0),
        child: Directionality(
          textDirection: TextDirection.rtl,
          child: Padding(
            padding: const EdgeInsets.all(18),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                // Top Bar
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                  decoration: BoxDecoration(
                    color: surface,
                    borderRadius: BorderRadius.circular(18),
                    border: Border.all(color: border),
                  ),
                  child: Row(
                    children: [
                      ElevatedButton.icon(
                        onPressed: () => Navigator.of(context).pop(),
                        icon: const Icon(Icons.chevron_right, size: 20),
                        label: const Text(
                          'بازگشت به تابلو',
                          style: TextStyle(fontFamily: 'Vazirmatn', fontWeight: FontWeight.w900),
                        ),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFFF59E0B).withOpacity(0.16),
                          foregroundColor: isDark ? const Color(0xFFFBBF24) : const Color(0xFFB45309),
                          elevation: 0,
                          side: BorderSide(color: const Color(0xFFF59E0B).withOpacity(0.35)),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                        ),
                      ),
                      const SizedBox(width: 14),
                      Text(
                        series?['label']?.toString() ?? widget.initialLabel,
                        style: TextStyle(
                          color: textPrimary,
                          fontSize: 20,
                          fontWeight: FontWeight.w900,
                          fontFamily: 'Vazirmatn',
                        ),
                      ),
                      const Spacer(),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                        decoration: BoxDecoration(
                          color: inset,
                          borderRadius: BorderRadius.circular(999),
                          border: Border.all(color: border),
                        ),
                        child: Text(
                          'بازگشت خودکار: ${PersianUtils.toPersianDigits(_autoCloseRemaining.toString())} ثانیه',
                          style: TextStyle(
                            color: textSecondary,
                            fontSize: 12,
                            fontWeight: FontWeight.w700,
                            fontFamily: 'Vazirmatn',
                          ),
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 12),

                // Main Card
                Expanded(
                  child: Container(
                    padding: const EdgeInsets.all(18),
                    decoration: BoxDecoration(
                      color: surface,
                      borderRadius: BorderRadius.circular(22),
                      border: Border.all(color: border),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.end,
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                                  decoration: BoxDecoration(
                                    color: inset,
                                    borderRadius: BorderRadius.circular(999),
                                    border: Border.all(color: border),
                                  ),
                                  child: Text(
                                    activePt?['label']?.toString() ?? 'نرخ لحظه‌ای تابلو',
                                    style: TextStyle(
                                      color: textSecondary,
                                      fontSize: 12,
                                      fontWeight: FontWeight.w700,
                                      fontFamily: 'Vazirmatn',
                                    ),
                                  ),
                                ),
                                const SizedBox(height: 8),
                                Row(
                                  crossAxisAlignment: CrossAxisAlignment.baseline,
                                  textBaseline: TextBaseline.alphabetic,
                                  children: [
                                    Text(
                                      shownPrice > 0
                                          ? PersianUtils.formatNumber(shownPrice, decimals)
                                          : '---',
                                      style: TextStyle(
                                        color: textPrimary,
                                        fontSize: 38,
                                        fontWeight: FontWeight.w900,
                                        fontFamily: 'Vazirmatn',
                                        fontFeatures: const [FontFeature.tabularFigures()],
                                      ),
                                    ),
                                    const SizedBox(width: 8),
                                    Text(
                                      series?['unit']?.toString() ?? widget.unit,
                                      style: TextStyle(
                                        color: textSecondary,
                                        fontSize: 15,
                                        fontWeight: FontWeight.w800,
                                        fontFamily: 'Vazirmatn',
                                      ),
                                    ),
                                    const SizedBox(width: 12),
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
                                      decoration: BoxDecoration(
                                        color: trendColor.withOpacity(0.14),
                                        borderRadius: BorderRadius.circular(999),
                                      ),
                                      child: Text(
                                        '${PersianUtils.formatSignedPercent(shownPct)} | ${PersianUtils.formatSignedNumber(shownDelta, decimals)}',
                                        textDirection: TextDirection.ltr,
                                        style: TextStyle(
                                          color: trendColor,
                                          fontSize: 14,
                                          fontWeight: FontWeight.w900,
                                          fontFamily: 'Vazirmatn',
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                            const Spacer(),
                            Container(
                              padding: const EdgeInsets.all(4),
                              decoration: BoxDecoration(
                                color: inset,
                                borderRadius: BorderRadius.circular(14),
                                border: Border.all(color: border),
                              ),
                              child: Row(
                                mainAxisSize: MainAxisSize.min,
                                children: _ranges.map((r) {
                                  final selected = r == _activeRange;
                                  return Padding(
                                    padding: const EdgeInsets.symmetric(horizontal: 2),
                                    child: InkWell(
                                      onTap: () => _loadRange(r),
                                      borderRadius: BorderRadius.circular(10),
                                      child: Container(
                                        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                                        decoration: BoxDecoration(
                                          color: selected ? surface : Colors.transparent,
                                          borderRadius: BorderRadius.circular(10),
                                          border: Border.all(
                                            color: selected
                                                ? const Color(0xFFF59E0B).withOpacity(0.45)
                                                : Colors.transparent,
                                          ),
                                        ),
                                        child: Text(
                                          _rangeLabels[r]!,
                                          style: TextStyle(
                                            color: selected
                                                ? (isDark ? const Color(0xFFFBBF24) : const Color(0xFFB45309))
                                                : textSecondary,
                                            fontSize: 14,
                                            fontWeight: FontWeight.w800,
                                            fontFamily: 'Vazirmatn',
                                          ),
                                        ),
                                      ),
                                    ),
                                  );
                                }).toList(),
                              ),
                            ),
                          ],
                        ),

                        const SizedBox(height: 14),

                        // Chart Canvas
                        Expanded(
                          child: Container(
                            decoration: BoxDecoration(
                              color: inset,
                              borderRadius: BorderRadius.circular(16),
                              border: Border.all(color: border),
                            ),
                            padding: const EdgeInsets.all(14),
                            child: _isLoading
                                ? const Center(child: CircularProgressIndicator(color: Color(0xFFF59E0B)))
                                : points.isEmpty
                                    ? Center(
                                        child: Column(
                                          mainAxisSize: MainAxisSize.min,
                                          children: [
                                            Text(
                                              'داده‌ای برای این بازه زمانی یافت نشد.',
                                              style: TextStyle(color: textSecondary, fontSize: 14, fontFamily: 'Vazirmatn'),
                                            ),
                                            const SizedBox(height: 12),
                                            ElevatedButton(
                                              onPressed: () {
                                                _cache.remove(_activeRange);
                                                _loadRange(_activeRange);
                                              },
                                              child: const Text('تلاش مجدد', style: TextStyle(fontFamily: 'Vazirmatn')),
                                            ),
                                          ],
                                        ),
                                      )
                                    : LayoutBuilder(
                                        builder: (ctx, box) {
                                          return GestureDetector(
                                            onTapDown: (d) => _updateHover(d.localPosition.dx, box.maxWidth, points),
                                            onHorizontalDragUpdate: (d) => _updateHover(d.localPosition.dx, box.maxWidth, points),
                                            onHorizontalDragEnd: (_) => setState(() => _hoverIndex = null),
                                            onTapUp: (_) => setState(() => _hoverIndex = null),
                                            child: CustomPaint(
                                              size: Size(box.maxWidth, box.maxHeight),
                                              painter: _PriceChartPainter(
                                                points: points,
                                                lineColor: trendColor,
                                                gridColor: textSecondary.withOpacity(0.18),
                                                labelColor: textSecondary,
                                                decimals: decimals,
                                                hoverIndex: _hoverIndex,
                                              ),
                                            ),
                                          );
                                        },
                                      ),
                          ),
                        ),

                        const SizedBox(height: 14),

                        // 4 Summary Metrics
                        Row(
                          children: [
                            Expanded(child: _statTile('نرخ فعلی', currentPrice > 0 ? '${PersianUtils.formatNumber(currentPrice, decimals)} ${widget.unit}' : '---', inset, border, textPrimary, textSecondary)),
                            const SizedBox(width: 10),
                            Expanded(child: _statTile('سقف بازه', highPrice > 0 ? '${PersianUtils.formatNumber(highPrice, decimals)} ${widget.unit}' : '---', inset, border, textPrimary, textSecondary)),
                            const SizedBox(width: 10),
                            Expanded(child: _statTile('کف بازه', lowPrice > 0 ? '${PersianUtils.formatNumber(lowPrice, decimals)} ${widget.unit}' : '---', inset, border, textPrimary, textSecondary)),
                            const SizedBox(width: 10),
                            Expanded(child: _statTile('تغییر بازه', '${PersianUtils.formatSignedPercent(shownPct)} (${PersianUtils.formatSignedNumber(shownDelta, decimals)})', inset, border, trendColor, textSecondary)),
                          ],
                        ),
                      ],
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  void _updateHover(double dx, double width, List<Map<String, dynamic>> points) {
    _resetAutoClose();
    if (points.isEmpty) return;
    const padLeft = 24.0;
    const padRight = 98.0;
    final plotW = math.max(40.0, width - padLeft - padRight);
    final frac = ((dx - padLeft) / plotW).clamp(0.0, 1.0);
    final idx = (frac * (points.length - 1)).round().clamp(0, points.length - 1);
    if (_hoverIndex != idx) {
      setState(() => _hoverIndex = idx);
    }
  }

  Widget _statTile(String title, String value, Color bg, Color border, Color valueColor, Color labelColor) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(title, style: TextStyle(color: labelColor, fontSize: 12, fontWeight: FontWeight.w700, fontFamily: 'Vazirmatn')),
          const SizedBox(height: 4),
          Text(
            value,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: valueColor,
              fontSize: 16,
              fontWeight: FontWeight.w900,
              fontFamily: 'Vazirmatn',
              fontFeatures: const [FontFeature.tabularFigures()],
            ),
          ),
        ],
      ),
    );
  }
}

class _PriceChartPainter extends CustomPainter {
  final List<Map<String, dynamic>> points;
  final Color lineColor;
  final Color gridColor;
  final Color labelColor;
  final int decimals;
  final int? hoverIndex;

  _PriceChartPainter({
    required this.points,
    required this.lineColor,
    required this.gridColor,
    required this.labelColor,
    required this.decimals,
    this.hoverIndex,
  });

  @override
  void paint(Canvas canvas, Size size) {
    if (points.isEmpty) return;

    const padLeft = 24.0;
    const padRight = 98.0;
    const padTop = 18.0;
    const padBottom = 34.0;
    final plotW = math.max(40.0, size.width - padLeft - padRight);
    final plotH = math.max(40.0, size.height - padTop - padBottom);

    final prices = points.map((p) => (p['price'] as num).toDouble()).toList();
    double minP = prices.reduce(math.min);
    double maxP = prices.reduce(math.max);
    final rawSpan = maxP - minP;
    final minSpan = math.max(maxP * 0.0025, decimals > 0 ? 0.5 : 100.0);
    if (rawSpan < minSpan) {
      final mid = (maxP + minP) / 2;
      minP = mid - (minSpan / 2);
      maxP = mid + (minSpan / 2);
    } else {
      final pad = rawSpan * 0.12;
      minP = math.max(0, minP - pad);
      maxP = maxP + pad;
    }
    final span = math.max(maxP - minP, 1.0);

    // Gridlines + Y-axis labels
    final gridPaint = Paint()
      ..color = gridColor
      ..strokeWidth = 1.0;

    for (var g = 0; g <= 4; g++) {
      final frac = g / 4.0;
      final gy = padTop + (plotH * frac);
      final val = maxP - (span * frac);
      canvas.drawLine(Offset(padLeft, gy), Offset(size.width - padRight, gy), gridPaint);

      final tp = TextPainter(
        text: TextSpan(
          text: PersianUtils.formatNumber(val, decimals),
          style: TextStyle(color: labelColor, fontSize: 11, fontWeight: FontWeight.w700, fontFamily: 'Vazirmatn'),
        ),
        textDirection: TextDirection.ltr,
      )..layout();
      tp.paint(canvas, Offset(size.width - padRight + 10, gy - tp.height / 2));
    }

    // Coordinates (time-based if ts exists)
    final count = points.length;
    final hasTs = points.every((p) => p['ts'] is num);
    final t0 = hasTs ? (points.first['ts'] as num).toDouble() : 0.0;
    final t1 = hasTs ? (points.last['ts'] as num).toDouble() : 0.0;
    final useTs = hasTs && (t1 > t0);

    final offsets = <Offset>[];
    for (var i = 0; i < count; i++) {
      final ratioX = useTs
          ? (((points[i]['ts'] as num).toDouble() - t0) / (t1 - t0))
          : (count > 1 ? (i / (count - 1)) : 0.5);
      final px = padLeft + (plotW * ratioX);
      final py = padTop + ((maxP - (points[i]['price'] as num).toDouble()) / span) * plotH;
      offsets.add(Offset(px, py));
    }

    if (offsets.length == 1) {
      offsets.add(Offset(padLeft + plotW, offsets.first.dy));
    }

    final linePath = Path()..moveTo(offsets.first.dx, offsets.first.dy);
    if (offsets.length > 2) {
      for (var i = 1; i < offsets.length - 1; i++) {
        final xc = (offsets[i].dx + offsets[i + 1].dx) / 2;
        final yc = (offsets[i].dy + offsets[i + 1].dy) / 2;
        linePath.quadraticBezierTo(offsets[i].dx, offsets[i].dy, xc, yc);
      }
      linePath.lineTo(offsets.last.dx, offsets.last.dy);
    } else {
      linePath.lineTo(offsets.last.dx, offsets.last.dy);
    }

    final areaPath = Path.from(linePath)
      ..lineTo(offsets.last.dx, padTop + plotH)
      ..lineTo(offsets.first.dx, padTop + plotH)
      ..close();

    final areaPaint = Paint()
      ..shader = LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: [lineColor.withOpacity(0.32), lineColor.withOpacity(0.01)],
      ).createShader(Rect.fromLTWH(padLeft, padTop, plotW, plotH));

    canvas.drawPath(areaPath, areaPaint);

    final strokePaint = Paint()
      ..color = lineColor
      ..strokeWidth = 3.0
      ..style = PaintingStyle.stroke
      ..strokeCap = StrokeCap.round
      ..strokeJoin = StrokeJoin.round;

    canvas.drawPath(linePath, strokePaint);

    // Endpoint glow
    canvas.drawCircle(offsets.last, 9, Paint()..color = lineColor.withOpacity(0.24));
    canvas.drawCircle(offsets.last, 4.5, Paint()..color = lineColor);

    // Hover indicator
    if (hoverIndex != null && hoverIndex! >= 0 && hoverIndex! < offsets.length) {
      final hOff = offsets[hoverIndex!];
      canvas.drawLine(
        Offset(hOff.dx, padTop),
        Offset(hOff.dx, padTop + plotH),
        Paint()..color = lineColor.withOpacity(0.45)..strokeWidth = 1.5,
      );
      canvas.drawCircle(hOff, 6.5, Paint()..color = Colors.white);
      canvas.drawCircle(hOff, 4.5, Paint()..color = lineColor);
    }

    // Bottom X-axis labels
    final tickCount = math.min(5, offsets.length);
    for (var k = 0; k < tickCount; k++) {
      final targetX = padLeft + (plotW * (tickCount == 1 ? 0 : k / (tickCount - 1)));
      var bestIdx = 0;
      var bestDist = double.infinity;
      for (var q = 0; q < math.min(offsets.length, points.length); q++) {
        final d = (offsets[q].dx - targetX).abs();
        if (d < bestDist) {
          bestDist = d;
          bestIdx = q;
        }
      }
      final lbl = points[bestIdx]['short']?.toString() ?? points[bestIdx]['label']?.toString() ?? '';
      if (lbl.isEmpty) continue;
      final tp = TextPainter(
        text: TextSpan(
          text: lbl,
          style: TextStyle(color: labelColor, fontSize: 11, fontWeight: FontWeight.w700, fontFamily: 'Vazirmatn'),
        ),
        textDirection: TextDirection.ltr,
      )..layout();
      double lx = offsets[bestIdx].dx - tp.width / 2;
      lx = lx.clamp(padLeft, size.width - padRight - tp.width);
      tp.paint(canvas, Offset(lx, padTop + plotH + 10));
    }
  }

  @override
  bool shouldRepaint(covariant _PriceChartPainter oldDelegate) {
    return oldDelegate.points != points ||
        oldDelegate.hoverIndex != hoverIndex ||
        oldDelegate.lineColor != lineColor;
  }
}
