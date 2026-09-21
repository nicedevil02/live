import 'dart:async';
import 'dart:ui';
import 'package:flutter/material.dart';
import '../models/board_model.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';

class ProductSlider extends StatefulWidget {
  final List<ProductItem> products;
  final int intervalSec;
  final BoardThemeData theme;
  final num gold18Price;
  final bool isEcoMode;
  final String emptyShowcaseMode;
  final String emptyShowcaseTitle;
  final String emptyShowcaseText;
  final String emptyShowcaseTheme;
  final String shopName;

  const ProductSlider({
    super.key,
    required this.products,
    required this.intervalSec,
    required this.theme,
    this.gold18Price = 0,
    this.isEcoMode = false,
    this.emptyShowcaseMode = 'guide',
    this.emptyShowcaseTitle = '',
    this.emptyShowcaseText = '',
    this.emptyShowcaseTheme = 'gold',
    this.shopName = 'طلا و جواهر طلالایو',
  });

  @override
  State<ProductSlider> createState() => _ProductSliderState();
}

class _ProductSliderState extends State<ProductSlider>
    with TickerProviderStateMixin {
  int _currentIndex = 0;
  int _emptyGuideIndex = 0;
  Timer? _emptyGuideTimer;
  late AnimationController _progressController;
  late AnimationController _kenBurnsController;
  late Animation<double> _kenBurnsScale;
  late Animation<Offset> _kenBurnsOffset;

  @override
  void initState() {
    super.initState();

    final duration = Duration(seconds: widget.intervalSec.clamp(3, 120));

    // 1. Story progress controller: runs from 0.0 to 1.0 over intervalSec
    _progressController = AnimationController(
      vsync: this,
      duration: duration,
    );

    // 2. Ken-Burns subtle cinematic camera movement
    _kenBurnsController = AnimationController(
      vsync: this,
      duration: duration,
    );

    _kenBurnsScale = Tween<double>(begin: 1.0, end: 1.08).animate(
      CurvedAnimation(parent: _kenBurnsController, curve: Curves.linear),
    );

    _kenBurnsOffset = Tween<Offset>(
      begin: const Offset(0.0, 0.0),
      end: const Offset(-0.02, 0.015),
    ).animate(
      CurvedAnimation(parent: _kenBurnsController, curve: Curves.linear),
    );

    _progressController.addStatusListener((status) {
      if (status == AnimationStatus.completed) {
        _goToNextSlide();
      }
    });

    if (widget.products.isEmpty) {
      if (widget.emptyShowcaseMode != 'custom_message') {
        _startEmptyGuideTimer();
      }
    } else {
      _startSlide();
    }
  }

  void _startEmptyGuideTimer() {
    _emptyGuideTimer?.cancel();
    if (widget.products.isEmpty && widget.emptyShowcaseMode != 'custom_message') {
      _emptyGuideTimer = Timer.periodic(const Duration(seconds: 8), (timer) {
        if (!mounted) return;
        setState(() {
          _emptyGuideIndex = (_emptyGuideIndex + 1) % 3;
        });
      });
    }
  }

  void _startSlide() {
    if (widget.products.isEmpty) return;
    _progressController.reset();
    _kenBurnsController.reset();

    if (widget.products.length > 1) {
      _progressController.forward();
      _kenBurnsController.forward();
    }
  }

  void _goToNextSlide() {
    if (!mounted || widget.products.length <= 1) return;
    setState(() {
      _currentIndex = (_currentIndex + 1) % widget.products.length;
    });
    _startSlide();
  }

  @override
  void didUpdateWidget(covariant ProductSlider oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (widget.products.isEmpty) {
      if (widget.emptyShowcaseMode == 'custom_message') {
        _emptyGuideTimer?.cancel();
        _emptyGuideTimer = null;
      } else if (_emptyGuideTimer == null) {
        _startEmptyGuideTimer();
      }
    } else {
      _emptyGuideTimer?.cancel();
      _emptyGuideTimer = null;
    }

    if (oldWidget.intervalSec != widget.intervalSec) {
      final newDuration = Duration(seconds: widget.intervalSec.clamp(3, 120));
      _progressController.duration = newDuration;
      _kenBurnsController.duration = newDuration;
      _startSlide();
    } else if (oldWidget.products.length != widget.products.length) {
      if (_currentIndex >= widget.products.length) {
        _currentIndex = 0;
      }
      _startSlide();
    }
  }

  @override
  void dispose() {
    _emptyGuideTimer?.cancel();
    _progressController.dispose();
    _kenBurnsController.dispose();
    super.dispose();
  }

  String _normalizeImageUrl(String raw) {
    var url = raw.trim();
    if (url.isEmpty) return 'https://talalive.ir/icons/icon-512x512.png';
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
      final placeholder = Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(40),
          border: Border.all(color: widget.theme.cardStrokeColor, width: 1.5),
        ),
        child: _buildEmptyShowcaseGuide(),
      );
      return ClipRRect(
        borderRadius: BorderRadius.circular(40),
        child: widget.isEcoMode
            ? placeholder
            : BackdropFilter(
                filter: ImageFilter.blur(sigmaX: 12, sigmaY: 12),
                child: placeholder,
              ),
      );
    }

    final product = widget.products[_currentIndex.clamp(0, widget.products.length - 1)];
    final rawUrl = product.imageUrls.isNotEmpty ? product.imageUrls.first : '';
    final imageUrl = _normalizeImageUrl(rawUrl);

    final sliderStack = Stack(
      fit: StackFit.expand,
      children: [
            // =================================================================
            // 1. Ken-Burns Animated Product Image with Smooth Cross-Fade
            // =================================================================
            AnimatedSwitcher(
              duration: const Duration(milliseconds: 700),
              switchInCurve: Curves.easeInOut,
              switchOutCurve: Curves.easeInOut,
              child: SizedBox.expand(
                key: ValueKey<String>('$imageUrl-$_currentIndex'),
                child: AnimatedBuilder(
                  animation: _kenBurnsController,
                  builder: (context, child) {
                    return FractionalTranslation(
                      translation: _kenBurnsOffset.value,
                      child: Transform.scale(
                        scale: _kenBurnsScale.value,
                        child: child,
                      ),
                    );
                  },
                  child: _buildProductImage(imageUrl),
                ),
              ),
            ),

            // =================================================================
            // 2. Scrim Gradient Overlay at bottom for readable text dock
            // =================================================================
            Positioned(
              left: 0,
              right: 0,
              bottom: 0,
              height: 320,
              child: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: widget.theme.isDark
                        ? [
                            Colors.transparent,
                            const Color(0x9905070C),
                            const Color(0xFA05070C),
                          ]
                        : [
                            Colors.transparent,
                            const Color(0x99FFFFFF),
                            const Color(0xFAFFFFFF),
                          ],
                  ),
                ),
              ),
            ),

            // =================================================================
            // 3. Top-Left Badge: Dynamic Marketing Badge with Pulsing Live Dot
            // =================================================================
            Positioned(
              top: 22,
              left: 22,
              child: _buildDynamicTopBadge(product),
            ),

            // =================================================================
            // 4. Top-Right Story Progress Bar (Instagram / TikTok Style)
            // =================================================================
            if (widget.products.length > 1)
              Positioned(
                top: 26,
                right: 24,
                child: _buildSegmentedStoryBar(),
              ),

            // =================================================================
            // 5. Bottom Floating Glass Dock
            // =================================================================
            Positioned(
              left: 18,
              right: 18,
              bottom: 18,
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 18),
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
                              fontFamily: 'Vazirmatn',
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
                              if (product.profitValue != null &&
                                  product.profitValue!.isNotEmpty &&
                                  product.profitValue != '0') ...[
                                if (product.profitType == 'percent') ...[
                                  _buildChip('سود:', '${product.profitValue}%'),
                                ] else if (product.profitType == 'amount_per_gram') ...[
                                  _buildChip('اجرت:', '${PersianUtils.formatPrice(product.profitValue)} ت/گرم'),
                                ] else ...[
                                  _buildChip('اجرت:', '${PersianUtils.formatPrice(product.profitValue)} ت'),
                                ],
                                const SizedBox(width: 8),
                              ] else if (product.laborFee != null &&
                                  product.laborFee!.isNotEmpty &&
                                  product.laborFee != '0') ...[
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
        );

    final Widget glassSlider;
    if (!widget.isEcoMode) {
      glassSlider = ClipRRect(
        borderRadius: BorderRadius.circular(40),
        child: BackdropFilter(
          filter: ImageFilter.blur(sigmaX: 12, sigmaY: 12),
          child: sliderStack,
        ),
      );
    } else {
      glassSlider = ClipRRect(
        borderRadius: BorderRadius.circular(40),
        child: sliderStack,
      );
    }

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
      child: glassSlider,
    );
  }

  /// Segmented story progress bar (fills across intervalSec)
  Widget _buildSegmentedStoryBar() {
    return AnimatedBuilder(
      animation: _progressController,
      builder: (context, _) {
        final count = widget.products.length;
        return Row(
          mainAxisSize: MainAxisSize.min,
          children: List.generate(count, (index) {
            double fillRatio = 0.0;
            if (index < _currentIndex) {
              fillRatio = 1.0;
            } else if (index == _currentIndex) {
              fillRatio = _progressController.value;
            } else {
              fillRatio = 0.0;
            }

            final barWidth = count > 8 ? 20.0 : (count > 4 ? 32.0 : 44.0);

            return Container(
              margin: const EdgeInsets.only(left: 6),
              width: barWidth,
              height: 5,
              decoration: BoxDecoration(
                color: widget.theme.isDark ? Colors.white24 : Colors.black26,
                borderRadius: BorderRadius.circular(3),
              ),
              child: FractionallySizedBox(
                alignment: Alignment.centerLeft,
                widthFactor: fillRatio,
                child: Container(
                  decoration: BoxDecoration(
                    color: widget.theme.isDark ? Colors.white : const Color(0xFF0F172A),
                    borderRadius: BorderRadius.circular(3),
                    boxShadow: [
                      if (fillRatio > 0)
                        BoxShadow(
                          color: (widget.theme.isDark ? Colors.white : const Color(0xFF0F172A)).withOpacity(0.5),
                          blurRadius: 4,
                        ),
                    ],
                  ),
                ),
              ),
            );
          }),
        );
      },
    );
  }

  Widget _buildDynamicTopBadge(ProductItem product) {
    String badgeText = 'پیشنهاد شگفت‌انگیز';
    List<Color> colors = const [
      Color(0xFFE11D48),
      Color(0xFFBE123C),
      Color(0xFFB45309),
    ];
    Color shadowColor = const Color(0xFFE11D48);

    if (product.badge == 'no_wage') {
      badgeText = 'بدون اجرت / کم‌اجرت';
      colors = const [Color(0xFF059669), Color(0xFF0D9488), Color(0xFFD97706)];
      shadowColor = const Color(0xFF059669);
    } else if (product.badge == 'best_seller') {
      badgeText = 'پرفروش‌ترین ویترین';
      colors = const [Color(0xFF7C3AED), Color(0xFF6D28D9), Color(0xFFDB2777)];
      shadowColor = const Color(0xFF7C3AED);
    } else if (product.badge == 'new_collection') {
      badgeText = 'کالکشن جدید';
      colors = const [Color(0xFF0284C7), Color(0xFF2563EB), Color(0xFFF59E0B)];
      shadowColor = const Color(0xFF0284C7);
    } else if (product.badge == 'special_discount') {
      badgeText = 'تخفیف ویژه امروز';
      colors = const [Color(0xFFE11D48), Color(0xFFDC2626), Color(0xFFB45309)];
      shadowColor = const Color(0xFFE11D48);
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: colors,
        ),
        borderRadius: BorderRadius.circular(30),
        border: Border.all(color: Colors.white.withOpacity(0.40), width: 1.5),
        boxShadow: [
          BoxShadow(
            color: shadowColor.withOpacity(0.45),
            blurRadius: 18,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          const PulsingLiveDot(color: Colors.white, size: 8),
          const SizedBox(width: 9),
          Text(
            badgeText,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 14,
              fontWeight: FontWeight.w900,
              fontFamily: 'Vazirmatn',
              letterSpacing: -0.3,
            ),
          ),
        ],
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
              PulsingLiveDot(
                color: widget.theme.goldPrimary,
                size: 6,
              ),
              const SizedBox(width: 6),
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
              textDirection: TextDirection.rtl,
              children: [
                Text(
                  PersianUtils.formatPrice(displayPrice),
                  style: TextStyle(
                    color: widget.theme.heroTextColor,
                    fontSize: 28,
                    fontWeight: FontWeight.w900,
                    fontFamily: 'Vazirmatn',
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(width: 5),
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
              fontFamily: 'Vazirmatn',
            ),
          ),
          const SizedBox(width: 4),
          Text(
            PersianUtils.toPersianDigits(value),
            style: TextStyle(
              color: widget.theme.goldPrimary,
              fontSize: 11,
              fontWeight: FontWeight.w800,
              fontFamily: 'Vazirmatn',
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProductImage(String imageUrl) {
    final isDefaultIcon = imageUrl.isEmpty || imageUrl.contains('icon-512x512');
    if (isDefaultIcon) {
      return _buildPlaceholder();
    }
    return Image.network(
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
    );
  }

  Widget _buildEmptyShowcaseGuide() {
    if (widget.emptyShowcaseMode == 'custom_message') {
      return _buildCustomMessageBanner();
    }

    return Container(
      color: widget.theme.isDark ? const Color(0xFF0B0F19) : const Color(0xFFF8FAFC),
      padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 22),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          // 1. Top Bar: Badge + Progress Indicators
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 7),
                decoration: BoxDecoration(
                  color: widget.theme.goldPrimary.withOpacity(0.12),
                  borderRadius: BorderRadius.circular(20),
                  border: Border.all(
                    color: widget.theme.goldPrimary.withOpacity(0.25),
                  ),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    PulsingLiveDot(
                      color: widget.theme.goldPrimary,
                      size: 8,
                    ),
                    const SizedBox(width: 8),
                    Text(
                      '✨ راهنمای هوشمند ویترین طلا',
                      style: TextStyle(
                        fontSize: 13.5,
                        fontWeight: FontWeight.w900,
                        color: widget.theme.isDark
                            ? widget.theme.goldPrimary
                            : const Color(0xFF78350F),
                      ),
                    ),
                  ],
                ),
              ),
              Row(
                mainAxisSize: MainAxisSize.min,
                children: List.generate(3, (i) {
                  final isActive = i == _emptyGuideIndex;
                  return AnimatedContainer(
                    duration: const Duration(milliseconds: 400),
                    margin: const EdgeInsets.only(left: 6),
                    width: isActive ? 30 : 7,
                    height: 6,
                    decoration: BoxDecoration(
                      color: isActive
                          ? widget.theme.goldPrimary
                          : (widget.theme.isDark
                              ? Colors.white24
                              : Colors.black12),
                      borderRadius: BorderRadius.circular(3),
                    ),
                  );
                }),
              ),
            ],
          ),

          const SizedBox(height: 16),

          // 2. Main Multi-Slide Content
          Expanded(
            child: AnimatedSwitcher(
              duration: const Duration(milliseconds: 500),
              switchInCurve: Curves.easeOut,
              switchOutCurve: Curves.easeIn,
              child: _buildEmptyGuideSlide(_emptyGuideIndex),
            ),
          ),

          const SizedBox(height: 12),

          // 3. Footer Bar
          Container(
            padding: const EdgeInsets.only(top: 12),
            decoration: BoxDecoration(
              border: Border(
                top: BorderSide(
                  color: widget.theme.cardStrokeColor.withOpacity(0.4),
                ),
              ),
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'ثبت و ویرایش محصولات: پنل کاربری طلالایو',
                  style: TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.w700,
                    color: widget.theme.textSecondary.withOpacity(0.85),
                  ),
                ),
                const Text(
                  'talalive.ir/admin',
                  style: TextStyle(
                    fontSize: 13,
                    fontFamily: 'monospace',
                    fontWeight: FontWeight.w800,
                    color: Color(0xFFD97706),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildCustomMessageBanner() {
    final isDark = widget.theme.isDark;

    // Theme configurations
    final String themeKey = widget.emptyShowcaseTheme;
    final Color accentColor;
    final Color glowColor;
    final List<Color> bgGradientColors;
    final String emoji;

    switch (themeKey) {
      case 'celebration':
        accentColor = const Color(0xFFEC4899);
        glowColor = const Color(0xFFEC4899).withOpacity(0.25);
        bgGradientColors = isDark
            ? [const Color(0xFF200B1A), const Color(0xFF100612), const Color(0xFF240D1D)]
            : [const Color(0xFFFDF2F8), const Color(0xFFFCE7F3), const Color(0xFFFFF1F2)];
        emoji = '🌸';
        break;
      case 'royal':
        accentColor = const Color(0xFF38BDF8);
        glowColor = const Color(0xFF0284C7).withOpacity(0.25);
        bgGradientColors = isDark
            ? [const Color(0xFF0B172E), const Color(0xFF070C18), const Color(0xFF0C1830)]
            : [const Color(0xFFF0F9FF), const Color(0xFFE0F2FE), const Color(0xFFF8FAFC)];
        emoji = '👑';
        break;
      case 'special_offer':
        accentColor = const Color(0xFF10B981);
        glowColor = const Color(0xFF059669).withOpacity(0.25);
        bgGradientColors = isDark
            ? [const Color(0xFF092418), const Color(0xFF05130D), const Color(0xFF0A261A)]
            : [const Color(0xFFECFDF5), const Color(0xFFD1FAE5), const Color(0xFFF8FAFC)];
        emoji = '🎁';
        break;
      case 'gold':
      default:
        accentColor = widget.theme.goldPrimary;
        glowColor = widget.theme.goldPrimary.withOpacity(0.25);
        bgGradientColors = isDark
            ? [const Color(0xFF1F180B), const Color(0xFF0E0D0A), const Color(0xFF1C150A)]
            : [const Color(0xFFFFFBEB), const Color(0xFFFEF3C7), const Color(0xFFF8FAFC)];
        emoji = '💎';
        break;
    }

    final title = widget.emptyShowcaseTitle.trim().isNotEmpty
        ? widget.emptyShowcaseTitle.trim()
        : 'خوش‌آمدگویی به مشتریان محترم گالری';

    final text = widget.emptyShowcaseText.trim().isNotEmpty
        ? widget.emptyShowcaseText.trim()
        : 'به گالری طلا و جواهر ما خوش آمدید. افتخار ما همراهی با شما در انتخاب زیباترین زیورآلات و طلا با بهترین کیفیت و مناسب‌ترین اجرت است.';

    return Container(
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topRight,
          end: Alignment.bottomLeft,
          colors: bgGradientColors,
        ),
      ),
      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          // 1. Top Bar: Special Message Badge + Shop Name
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 7),
                decoration: BoxDecoration(
                  color: accentColor.withOpacity(0.15),
                  borderRadius: BorderRadius.circular(20),
                  border: Border.all(
                    color: accentColor.withOpacity(0.4),
                  ),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text('✦', style: TextStyle(color: accentColor, fontSize: 13, fontWeight: FontWeight.bold)),
                    const SizedBox(width: 6),
                    Text(
                      'پیام ویژه گالری',
                      style: TextStyle(
                        fontSize: 13.5,
                        fontWeight: FontWeight.w900,
                        color: isDark ? accentColor : const Color(0xFF1E293B),
                      ),
                    ),
                    const SizedBox(width: 6),
                    Text('✦', style: TextStyle(color: accentColor, fontSize: 13, fontWeight: FontWeight.bold)),
                  ],
                ),
              ),
              Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Text('✨', style: TextStyle(fontSize: 14)),
                  const SizedBox(width: 6),
                  Text(
                    widget.shopName,
                    style: TextStyle(
                      fontSize: 13.5,
                      fontWeight: FontWeight.w700,
                      color: widget.theme.textSecondary.withOpacity(0.85),
                    ),
                  ),
                ],
              ),
            ],
          ),

          // 2. Middle Content: Centered Big Icon, Prominent Title & Large Message
          Expanded(
            child: Center(
              child: SingleChildScrollView(
                physics: const BouncingScrollPhysics(),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    // Ornate Theme Icon Container
                    Container(
                      width: 84,
                      height: 84,
                      decoration: BoxDecoration(
                        color: accentColor.withOpacity(0.18),
                        borderRadius: BorderRadius.circular(26),
                        border: Border.all(
                          color: accentColor.withOpacity(0.5),
                          width: 2,
                        ),
                        boxShadow: [
                          BoxShadow(
                            color: glowColor,
                            blurRadius: 24,
                            spreadRadius: 4,
                          ),
                        ],
                      ),
                      child: Center(
                        child: Text(
                          emoji,
                          style: const TextStyle(fontSize: 42),
                        ),
                      ),
                    ),
                    const SizedBox(height: 20),

                    // Big Title
                    Text(
                      title,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 25,
                        fontWeight: FontWeight.w900,
                        color: widget.theme.textPrimary,
                        height: 1.35,
                      ),
                    ),
                    const SizedBox(height: 14),

                    // Decorative Divider
                    Container(
                      width: 140,
                      height: 3,
                      decoration: BoxDecoration(
                        gradient: LinearGradient(
                          colors: [
                            Colors.transparent,
                            accentColor,
                            Colors.transparent,
                          ],
                        ),
                        borderRadius: BorderRadius.circular(2),
                      ),
                    ),
                    const SizedBox(height: 18),

                    // Message Text (Significantly Enlarged for TV Visibility)
                    Text(
                      text,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 16.5,
                        height: 1.8,
                        fontWeight: FontWeight.w700,
                        color: isDark ? const Color(0xFFE2E8F0) : const Color(0xFF334155),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),

          // 3. Footer Bar
          Container(
            padding: const EdgeInsets.only(top: 14),
            decoration: BoxDecoration(
              border: Border(
                top: BorderSide(
                  color: widget.theme.cardStrokeColor.withOpacity(0.4),
                ),
              ),
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const PulsingLiveDot(
                      color: Color(0xFF10B981),
                      size: 8,
                    ),
                    const SizedBox(width: 8),
                    Text(
                      widget.shopName,
                      style: TextStyle(
                        fontSize: 13.5,
                        fontWeight: FontWeight.w900,
                        color: widget.theme.textPrimary,
                      ),
                    ),
                  ],
                ),
                Text(
                  'خرید و مشاوره حضوری در مغازه',
                  style: TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.w700,
                    color: widget.theme.textSecondary.withOpacity(0.85),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildEmptyGuideSlide(int index) {
    switch (index) {
      case 0:
        return _buildEmptySlideOverview();
      case 1:
        return _buildEmptySlideSteps();
      case 2:
      default:
        return _buildEmptySlideTips();
    }
  }

  Widget _buildEmptySlideOverview() {
    return Column(
      key: const ValueKey<int>(0),
      crossAxisAlignment: CrossAxisAlignment.stretch,
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        _buildGuideHeader(
          icon: Icon(
            Icons.diamond_rounded,
            color: widget.theme.goldPrimary,
            size: 30,
          ),
          title: 'ویترین هوشمند گالری چیست؟',
          subtitle: 'نمایشگر دیجیتال زیورآلات متصل به بازار لحظه‌ای طلا',
        ),
        _buildGuideCard(
          leading: Text('⚡', style: TextStyle(fontSize: 22, color: widget.theme.goldPrimary)),
          title: 'محاسبه آنلاین قیمت فروش',
          desc: 'مبلغ نهایی هر کار بر اساس وزن، اجرت و آخرین نرخ ثانیه‌ای طلا ۱۸ عیار اتحادیه خودکار آپدیت می‌شود.',
        ),
        _buildGuideCard(
          leading: const Text('🏷️', style: TextStyle(fontSize: 22)),
          title: 'برچسب‌های جذاب بازاریابی',
          desc: 'نشان‌های «بدون اجرت»، «پرفروش‌ترین»، «کالکشن جدید» و «تخفیف ویژه» جهت جلب توجه خریداران.',
        ),
        _buildGuideCard(
          leading: const Text('✨', style: TextStyle(fontSize: 22)),
          title: 'افکت‌های سینمایی متحرک',
          desc: 'چرخش خودکار اسلایدر و جلوه زوم آرام (Ken Burns) تصاویر طلا با کیفیت بالا.',
        ),
      ],
    );
  }

  Widget _buildEmptySlideSteps() {
    return Column(
      key: const ValueKey<int>(1),
      crossAxisAlignment: CrossAxisAlignment.stretch,
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        _buildGuideHeader(
          icon: Icon(
            Icons.smartphone_rounded,
            color: widget.theme.goldPrimary,
            size: 30,
          ),
          title: 'چگونه محصول اضافه کنیم؟',
          subtitle: 'فعال‌سازی در کمتر از ۱ دقیقه با ۳ مرحله ساده',
        ),
        _buildGuideCard(
          leading: Container(
            width: 28,
            height: 28,
            decoration: BoxDecoration(
              color: widget.theme.goldPrimary,
              shape: BoxShape.circle,
            ),
            child: const Center(
              child: Text(
                '۱',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w900,
                  color: Colors.black,
                ),
              ),
            ),
          ),
          title: 'ورود به پنل مدیریت',
          desc: 'با گوشی یا رایانه وارد آدرس talalive.ir/admin شوید.',
        ),
        _buildGuideCard(
          leading: Container(
            width: 28,
            height: 28,
            decoration: BoxDecoration(
              color: widget.theme.goldPrimary,
              shape: BoxShape.circle,
            ),
            child: const Center(
              child: Text(
                '۲',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w900,
                  color: Colors.black,
                ),
              ),
            ),
          ),
          title: 'انتخاب «ویترین طلا (اسلایدر)»',
          desc: 'از منوی کناری، روی گزینه ویترین طلا کلیک کنید.',
        ),
        _buildGuideCard(
          leading: Container(
            width: 28,
            height: 28,
            decoration: BoxDecoration(
              color: widget.theme.goldPrimary,
              shape: BoxShape.circle,
            ),
            child: const Center(
              child: Text(
                '۳',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w900,
                  color: Colors.black,
                ),
              ),
            ),
          ),
          title: 'افزودن عکس، وزن و اجرت',
          desc: 'عکس زیورآلات را انتخاب و مشخصات را ثبت کنید (حجم عکس خودکار بهینه می‌شود).',
        ),
      ],
    );
  }

  Widget _buildEmptySlideTips() {
    return Column(
      key: const ValueKey<int>(2),
      crossAxisAlignment: CrossAxisAlignment.stretch,
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        _buildGuideHeader(
          icon: Icon(
            Icons.star_rounded,
            color: widget.theme.goldPrimary,
            size: 30,
          ),
          title: 'افزایش فروش با ویترین هوشمند',
          subtitle: 'راهکارهایی برای بهره‌وری حداکثری از تابلوی مغازه',
        ),
        _buildGuideCard(
          leading: const Text('📸', style: TextStyle(fontSize: 22)),
          title: 'عکاسی با موبایل زیر نور مغازه',
          desc: 'عکسبرداری روی استند یا مانکن زیر نور ویترین جلوه لوکسی روی تلویزیون ایجاد می‌کند.',
        ),
        _buildGuideCard(
          leading: const Text('🔥', style: TextStyle(fontSize: 22)),
          title: 'معرفی کارهای کم‌اجرت و بدون اجرت',
          desc: 'با نشان «بدون اجرت»، کارهای مناسب سرمایه‌گذاری را سریع‌تر به فروش برسانید.',
        ),
        _buildGuideCard(
          leading: const Text('🔄', style: TextStyle(fontSize: 22)),
          title: 'تنوع تا ۱۰ اسلایدر همزمان',
          desc: 'می‌توانید تا ۱۰ محصول مختلف را ثبت کنید تا مشتریان در مغازه مجموعه‌ای از کارهایتان را ببینند.',
        ),
      ],
    );
  }

  Widget _buildGuideHeader({
    required Widget icon,
    required String title,
    required String subtitle,
  }) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 14),
      child: Row(
        children: [
          Container(
            width: 52,
            height: 52,
            decoration: BoxDecoration(
              color: widget.theme.goldPrimary.withOpacity(0.15),
              borderRadius: BorderRadius.circular(16),
              border: Border.all(
                color: widget.theme.goldPrimary.withOpacity(0.35),
              ),
            ),
            child: Center(child: icon),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  title,
                  style: TextStyle(
                    fontSize: 19,
                    fontWeight: FontWeight.w900,
                    color: widget.theme.textPrimary,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  subtitle,
                  style: TextStyle(
                    fontSize: 13.5,
                    fontWeight: FontWeight.w600,
                    color: widget.theme.textSecondary.withOpacity(0.85),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildGuideCard({
    required Widget leading,
    required String title,
    required String desc,
  }) {
    final isDark = widget.theme.isDark;
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      decoration: BoxDecoration(
        color: isDark ? const Color(0x1AFFFFFF) : const Color(0x0A000000),
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: widget.theme.cardStrokeColor.withOpacity(0.4),
        ),
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          leading,
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  title,
                  style: TextStyle(
                    fontSize: 15.5,
                    fontWeight: FontWeight.w900,
                    color: widget.theme.textPrimary,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  desc,
                  style: TextStyle(
                    fontSize: 13.5,
                    height: 1.4,
                    fontWeight: FontWeight.w600,
                    color: widget.theme.textSecondary.withOpacity(0.9),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPlaceholder() {
    return Container(
      color: widget.theme.isDark ? const Color(0xFF0F172A) : Colors.white,
      alignment: Alignment.center,
      child: Image.asset(
        'assets/images/icon-512x512.png',
        fit: BoxFit.contain,
        width: double.infinity,
        height: double.infinity,
        errorBuilder: (context, error, stackTrace) => Container(
          color: widget.theme.isDark ? const Color(0xFF0F172A) : const Color(0xFFF8FAFC),
          alignment: Alignment.center,
          child: Icon(
            Icons.diamond_outlined,
            size: 72,
            color: widget.theme.goldPrimary.withOpacity(0.35),
          ),
        ),
      ),
    );
  }
}

/// A pulsing live dot that mimics CSS `animate-ping` with expanding halo
class PulsingLiveDot extends StatefulWidget {
  final Color color;
  final double size;

  const PulsingLiveDot({
    super.key,
    required this.color,
    this.size = 8,
  });

  @override
  State<PulsingLiveDot> createState() => _PulsingLiveDotState();
}

class _PulsingLiveDotState extends State<PulsingLiveDot>
    with SingleTickerProviderStateMixin {
  late final AnimationController _controller;
  late final Animation<double> _scaleAnimation;
  late final Animation<double> _fadeAnimation;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1600),
    )..repeat();

    _scaleAnimation = Tween<double>(begin: 1.0, end: 2.4).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeOut),
    );

    _fadeAnimation = Tween<double>(begin: 0.8, end: 0.0).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeOut),
    );
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: widget.size * 2.2,
      height: widget.size * 2.2,
      child: Stack(
        alignment: Alignment.center,
        children: [
          // Expanding & fading halo
          AnimatedBuilder(
            animation: _controller,
            builder: (context, child) {
              return Transform.scale(
                scale: _scaleAnimation.value,
                child: Opacity(
                  opacity: _fadeAnimation.value,
                  child: Container(
                    width: widget.size,
                    height: widget.size,
                    decoration: BoxDecoration(
                      color: widget.color,
                      shape: BoxShape.circle,
                    ),
                  ),
                ),
              );
            },
          ),
          // Solid core dot
          Container(
            width: widget.size,
            height: widget.size,
            decoration: BoxDecoration(
              color: widget.color,
              shape: BoxShape.circle,
            ),
          ),
        ],
      ),
    );
  }
}
