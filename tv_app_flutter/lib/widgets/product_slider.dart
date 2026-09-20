import 'dart:async';
import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class ProductSlider extends StatefulWidget {
  final List<ProductItem> products;
  final int intervalSec;
  final BoardThemeData theme;

  const ProductSlider({
    super.key,
    required this.products,
    required this.intervalSec,
    required this.theme,
  });

  @override
  State<ProductSlider> createState() => _ProductSliderState();
}

class _ProductSliderState extends State<ProductSlider> with SingleTickerProviderStateMixin {
  int _currentIndex = 0;
  Timer? _timer;
  late AnimationController _progressController;

  @override
  void initState() {
    super.initState();
    _progressController = AnimationController(
      vsync: this,
      duration: Duration(seconds: widget.intervalSec),
    )..forward();

    _startTimer();
  }

  void _startTimer() {
    _timer?.cancel();
    if (widget.products.length <= 1) return;

    _timer = Timer.periodic(Duration(seconds: widget.intervalSec), (timer) {
      if (mounted) {
        setState(() {
          _currentIndex = (_currentIndex + 1) % widget.products.length;
        });
        _progressController.reset();
        _progressController.forward();
      }
    });
  }

  @override
  void didUpdateWidget(covariant ProductSlider oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (oldWidget.intervalSec != widget.intervalSec ||
        oldWidget.products.length != widget.products.length) {
      _progressController.duration = Duration(seconds: widget.intervalSec);
      _startTimer();
    }
  }

  @override
  void dispose() {
    _timer?.cancel();
    _progressController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    if (widget.products.isEmpty) return const SizedBox.shrink();

    final product = widget.products[_currentIndex.clamp(0, widget.products.length - 1)];
    final imageUrl = product.imageUrls.isNotEmpty ? product.imageUrls.first : null;

    return Container(
      decoration: BoxDecoration(
        gradient: widget.theme.cardGradient,
        borderRadius: BorderRadius.circular(22),
        border: Border.all(
          color: widget.theme.goldPrimary.withOpacity(0.4),
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(widget.theme.isDark ? 0.35 : 0.08),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      padding: const EdgeInsets.all(16),
      child: Column(
        children: [
          // 1. Story Progress Bar at top
          if (widget.products.length > 1) ...[
            ClipRRect(
              borderRadius: BorderRadius.circular(4),
              child: AnimatedBuilder(
                animation: _progressController,
                builder: (context, child) {
                  return LinearProgressIndicator(
                    value: _progressController.value,
                    minHeight: 3,
                    backgroundColor: widget.theme.goldPrimary.withOpacity(0.15),
                    valueColor: AlwaysStoppedAnimation<Color>(widget.theme.goldPrimary),
                  );
                },
              ),
            ),
            const SizedBox(height: 12),
          ],

          // 2. Product Image
          Expanded(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(16),
              child: imageUrl != null && imageUrl.isNotEmpty
                  ? Image.network(
                      imageUrl,
                      fit: BoxFit.contain,
                      errorBuilder: (context, error, stackTrace) => _buildPlaceholder(),
                      loadingBuilder: (context, child, loadingProgress) {
                        if (loadingProgress == null) return child;
                        return Center(
                          child: CircularProgressIndicator(
                            strokeWidth: 2,
                            valueColor: AlwaysStoppedAnimation<Color>(widget.theme.goldPrimary),
                          ),
                        );
                      },
                    )
                  : _buildPlaceholder(),
            ),
          ),
          const SizedBox(height: 12),

          // 3. Product Title
          Text(
            product.title,
            style: TextStyle(
              color: widget.theme.goldPrimary,
              fontSize: 19,
              fontWeight: FontWeight.w900,
            ),
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 6),

          // 4. Weight / Labor / Price
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              if (product.weightGram != null && product.weightGram!.isNotEmpty) ...[
                Text(
                  'وزن: ${PersianUtils.toPersianDigits(product.weightGram!)} گرم',
                  style: TextStyle(
                    color: widget.theme.textSecondary,
                    fontSize: 13,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
              if (product.finalPrice != null && product.finalPrice!.isNotEmpty) ...[
                const SizedBox(width: 10),
                Text(
                  '•  مظنه: ${PersianUtils.formatPriceString(product.finalPrice!)} تومان',
                  style: TextStyle(
                    color: widget.theme.goldSecondary,
                    fontSize: 13,
                    fontWeight: FontWeight.w800,
                  ),
                ),
              ],
            ],
          ),
          const SizedBox(height: 6),

          // 5. Counter
          if (widget.products.length > 1)
            Text(
              PersianUtils.toPersianDigits('${_currentIndex + 1} از ${widget.products.length}'),
              style: TextStyle(
                color: widget.theme.textMuted,
                fontSize: 11,
                fontWeight: FontWeight.w600,
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildPlaceholder() {
    return Container(
      color: Colors.black.withOpacity(0.2),
      alignment: Alignment.center,
      child: Icon(
        Icons.diamond_outlined,
        size: 54,
        color: widget.theme.goldPrimary.withOpacity(0.4),
      ),
    );
  }
}
