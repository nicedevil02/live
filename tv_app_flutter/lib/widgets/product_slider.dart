import 'dart:async';
import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class ProductSlider extends StatefulWidget {
  final List<ProductItem> products;
  final int intervalSec;
  final BoardThemeData theme;
  final num gold18Price;

  const ProductSlider({
    super.key,
    required this.products,
    required this.intervalSec,
    required this.theme,
    this.gold18Price = 0,
  });

  @override
  State<ProductSlider> createState() => _ProductSliderState();
}

class _ProductSliderState extends State<ProductSlider> {
  int _currentIndex = 0;
  Timer? _timer;

  @override
  void initState() {
    super.initState();
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
      }
    });
  }

  @override
  void didUpdateWidget(covariant ProductSlider oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (oldWidget.intervalSec != widget.intervalSec ||
        oldWidget.products.length != widget.products.length) {
      _startTimer();
    }
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  String _normalizeImageUrl(String raw) {
    var url = raw.trim();
    if (url.isEmpty) return '';
    if (url.startsWith('//')) {
      return 'https:$url';
    }
    if (url.startsWith('/')) {
      return 'https://talalive.ir$url';
    }
    if (!url.startsWith('http://') && !url.startsWith('https://')) {
      if (url.startsWith('storage/')) {
        return 'https://talalive.ir/$url';
      }
      return 'https://talalive.ir/storage/$url';
    }
    return url;
  }

  @override
  Widget build(BuildContext context) {
    if (widget.products.isEmpty) {
      return Container(
        decoration: BoxDecoration(
          color: widget.theme.cardGradient.colors.first.withOpacity(0.5),
          borderRadius: BorderRadius.circular(40),
          border: Border.all(color: widget.theme.cardStrokeColor, width: 1.5),
        ),
        alignment: Alignment.center,
        child: Icon(
          Icons.diamond_outlined,
          size: 100,
          color: widget.theme.goldPrimary.withOpacity(0.2),
        ),
      );
    }

    final product = widget.products[_currentIndex.clamp(0, widget.products.length - 1)];
    final rawUrl = product.imageUrls.isNotEmpty ? product.imageUrls.first : '';
    final imageUrl = _normalizeImageUrl(rawUrl);

    return Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(40),
        border: Border.all(
          color: widget.theme.cardStrokeColor,
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(widget.theme.isDark ? 0.50 : 0.12),
            blurRadius: 30,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(40),
        child: Stack(
          fit: StackFit.expand,
          children: [
            // =================================================================
            // 1. Full Cover Image
            // =================================================================
            imageUrl.isNotEmpty
                ? Image.network(
                    imageUrl,
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stackTrace) => _buildPlaceholder(),
                    loadingBuilder: (context, child, loadingProgress) {
                      if (loadingProgress == null) return child;
                      return Center(
                        child: CircularProgressIndicator(
                          strokeWidth: 3,
                          valueColor: AlwaysStoppedAnimation<Color>(widget.theme.goldPrimary),
                        ),
                      );
                    },
                  )
                : _buildPlaceholder(),

            // =================================================================
            // 2. Scrim Gradient Overlay at bottom
            // =================================================================
            Positioned(
              left: 0,
              right: 0,
              bottom: 0,
              height: 280,
              child: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: widget.theme.isDark
                        ? [
                            Colors.transparent,
                            const Color(0xCC05070C),
                            const Color(0xF505070C),
                          ]
                        : [
                            Colors.transparent,
                            const Color(0xAAFFFFFF),
                            const Color(0xF5FFFFFF),
                          ],
                  ),
                ),
              ),
            ),

            // =================================================================
            // 3. Top-Left Badge: "پیشنهاد شگفت‌انگیز"
            // =================================================================
            Positioned(
              top: 20,
              left: 20,
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [
                      Color(0xFFE11D48),
                      Color(0xFFBE123C),
                      Color(0xFFB45309),
                    ],
                  ),
                  borderRadius: BorderRadius.circular(30),
                  border: Border.all(color: Colors.white.withOpacity(0.35), width: 1.5),
                  boxShadow: [
                    BoxShadow(
                      color: const Color(0xFFE11D48).withOpacity(0.4),
                      blurRadius: 18,
                      offset: const Offset(0, 6),
                    ),
                  ],
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Container(
                      width: 10,
                      height: 10,
                      decoration: const BoxDecoration(
                        color: Colors.white,
                        shape: BoxShape.circle,
                      ),
                    ),
                    const SizedBox(width: 8),
                    const Text(
                      'پیشنهاد شگفت‌انگیز',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 14,
                        fontWeight: FontWeight.w900,
                        letterSpacing: -0.3,
                      ),
                    ),
                  ],
                ),
              ),
            ),

            // =================================================================
            // 4. Top-Right Story Indicator Dots
            // =================================================================
            if (widget.products.length > 1)
              Positioned(
                top: 24,
                right: 24,
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: List.generate(widget.products.length, (index) {
                    final isActive = index == _currentIndex;
                    return AnimatedContainer(
                      duration: const Duration(milliseconds: 300),
                      margin: const EdgeInsets.only(left: 6),
                      width: isActive ? 34 : 10,
                      height: 6,
                      decoration: BoxDecoration(
                        color: isActive
                            ? (widget.theme.isDark ? Colors.white : const Color(0xFF0F172A))
                            : (widget.theme.isDark ? Colors.white38 : Colors.black26),
                        borderRadius: BorderRadius.circular(4),
                      ),
                    );
                  }),
                ),
              ),

            // =================================================================
            // 5. Bottom Floating Glass Dock
            // =================================================================
            Positioned(
              left: 18,
              right: 18,
              bottom: 18,
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                decoration: BoxDecoration(
                  color: widget.theme.headerBackground.withOpacity(widget.theme.isDark ? 0.88 : 0.94),
                  borderRadius: BorderRadius.circular(28),
                  border: Border.all(
                    color: widget.theme.cardStrokeColor,
                    width: 1.5,
                  ),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(widget.theme.isDark ? 0.45 : 0.10),
                      blurRadius: 20,
                      offset: const Offset(0, 8),
                    ),
                  ],
                ),
                child: Row(
                  textDirection: TextDirection.rtl,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    // Right: Title & Chips
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Text(
                            product.title,
                            style: TextStyle(
                              color: widget.theme.textPrimary,
                              fontSize: 22,
                              fontWeight: FontWeight.w900,
                            ),
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                          ),
                          const SizedBox(height: 8),
                          Row(
                            children: [
                              if (product.weightGram != null && product.weightGram!.isNotEmpty) ...[
                                _buildChip('وزن:', '${product.weightGram!} گرم'),
                                const SizedBox(width: 8),
                              ],
                              if (product.profitValue != null && product.profitValue!.isNotEmpty && product.profitValue != '0') ...[
                                _buildChip('سود:', '${product.profitValue}%'),
                                const SizedBox(width: 8),
                              ] else if (product.laborFee != null && product.laborFee!.isNotEmpty && product.laborFee != '0') ...[
                                _buildChip('اجرت:', product.laborFee!),
                                const SizedBox(width: 8),
                              ],
                            ],
                          ),
                        ],
                      ),
                    ),
                    const SizedBox(width: 16),

                    // Left: Price Box (مبلغ نهایی ویترین)
                    _buildPriceBox(product),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildPriceBox(ProductItem product) {
    final displayPrice = product.getDisplayPrice(widget.gold18Price);
    final hasValidPrice = displayPrice != '۰' && (num.tryParse(displayPrice) ?? 0) > 0;

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
      decoration: BoxDecoration(
        gradient: widget.theme.heroCardGradient,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: widget.theme.heroStrokeColor, width: 1.5),
        boxShadow: [
          BoxShadow(
            color: widget.theme.goldPrimary.withOpacity(0.25),
            blurRadius: 14,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.end,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 6,
                height: 6,
                decoration: BoxDecoration(
                  color: widget.theme.goldPrimary,
                  shape: BoxShape.circle,
                ),
              ),
              const SizedBox(width: 5),
              Text(
                'مبلغ نهایی ویترین',
                style: TextStyle(
                  color: widget.theme.heroTextColor,
                  fontSize: 10,
                  fontWeight: FontWeight.w900,
                  fontFamily: 'Vazirmatn',
                ),
              ),
            ],
          ),
          const SizedBox(height: 4),
          if (hasValidPrice)
            Row(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.baseline,
              textBaseline: TextBaseline.alphabetic,
              children: [
                Text(
                  PersianUtils.formatPriceString(displayPrice),
                  style: TextStyle(
                    color: widget.theme.heroTextColor,
                    fontSize: 28,
                    fontWeight: FontWeight.w900,
                    fontFamily: 'Vazirmatn',
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(width: 4),
                Text(
                  'تومان',
                  style: TextStyle(
                    color: widget.theme.heroTextColor.withOpacity(0.85),
                    fontSize: 12,
                    fontWeight: FontWeight.w800,
                    fontFamily: 'Vazirmatn',
                  ),
                ),
              ],
            )
          else
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
              decoration: BoxDecoration(
                color: widget.theme.goldPrimary.withOpacity(0.2),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Text(
                'در حال استعلام نرخ...',
                style: TextStyle(
                  color: widget.theme.heroTextColor,
                  fontSize: 11,
                  fontWeight: FontWeight.w800,
                  fontFamily: 'Vazirmatn',
                ),
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildChip(String label, String value) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(
        color: (widget.theme.isDark ? Colors.white : Colors.black).withOpacity(0.06),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: (widget.theme.isDark ? Colors.white : Colors.black).withOpacity(0.12),
        ),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            label,
            style: TextStyle(
              color: widget.theme.textSecondary,
              fontSize: 11,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(width: 4),
          Text(
            PersianUtils.toPersianDigits(value),
            style: TextStyle(
              color: widget.theme.goldPrimary,
              fontSize: 11,
              fontWeight: FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPlaceholder() {
    return Container(
      color: widget.theme.isDark ? const Color(0xFF0F172A) : const Color(0xFFE2E8F0),
      alignment: Alignment.center,
      child: Icon(
        Icons.diamond_outlined,
        size: 72,
        color: widget.theme.goldPrimary.withOpacity(0.35),
      ),
    );
  }
}
