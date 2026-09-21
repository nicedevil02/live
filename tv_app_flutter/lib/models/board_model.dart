import '../utils/persian_utils.dart';

class PriceRow {
  final String symbol;
  final String title;
  final String sellPrice;
  final String? buyPrice;
  final String unit;
  final int changeDirection; // -1 (down), 0 (flat), +1 (up)
  final String? changePercent;
  final String? changeValue;
  final bool isStale;

  const PriceRow({
    required this.symbol,
    required this.title,
    required this.sellPrice,
    this.buyPrice,
    required this.unit,
    required this.changeDirection,
    this.changePercent,
    this.changeValue,
    required this.isStale,
  });
}

class ProductItem {
  final String id;
  final String title;
  final String? weightGram;
  final String? finalPrice;
  final String? laborFee;
  final String? profitValue;
  final String? profitType;
  final String? badge;
  final int? sortOrder;
  final List<String> imageUrls;

  const ProductItem({
    required this.id,
    required this.title,
    this.weightGram,
    this.finalPrice,
    this.laborFee,
    this.profitValue,
    this.profitType,
    this.badge,
    this.sortOrder,
    required this.imageUrls,
  });

  String getDisplayPrice(num gold18Price) {
    final w = num.tryParse(weightGram ?? '') ?? 0;
    final l = num.tryParse(laborFee ?? '') ?? 0;
    final pv = num.tryParse(profitValue ?? '') ?? 0;
    if (gold18Price > 0 && w > 0) {
      final base = (gold18Price * w) + l;
      num profit = 0;
      if (profitType == 'percent') {
        profit = base * (pv / 100);
      } else if (profitType == 'amount_per_gram') {
        profit = pv * w;
      } else {
        profit = pv;
      }
      final calc = (base + profit).round();
      if (calc > 0) return calc.toString();
    }
    if (finalPrice != null && finalPrice!.isNotEmpty && finalPrice != '0') {
      return finalPrice!;
    }
    return '۰';
  }
}

int _parseInt(dynamic val, int def) {
  if (val == null) return def;
  if (val is num) return val.toInt();
  if (val is String) {
    return int.tryParse(val) ?? (double.tryParse(val)?.toInt() ?? def);
  }
  return def;
}

bool _parseBool(dynamic val, bool def) {
  if (val == null) return def;
  if (val is bool) return val;
  if (val is num) return val != 0;
  if (val is String) {
    final s = val.toLowerCase().trim();
    if (s == 'true' || s == '1') return true;
    if (s == 'false' || s == '0') return false;
  }
  return def;
}

class BoardModel {
  final String username;
  final String shopName;
  final String subtitle;
  final String phone;
  final String? instagram;
  final String? rubika;
  final String? qrLink;
  final String? qrLabel;
  final String? qrDesc;
  final String? cityFullDisplay;
  final String? cityName;
  final String? galleryDisplayName;
  final String? bingWallpaperUrl;
  final String themeMode;
  final int sliderIntervalSec;
  final String customMessage;
  final List<PriceRow> rows;
  final List<ProductItem> products;
  final String updatedAtText;
  final int dataAgeSeconds;
  final bool isStale;
  final int refreshIntervalSeconds;
  final String rawJson;

  const BoardModel({
    required this.username,
    required this.shopName,
    required this.subtitle,
    required this.phone,
    this.instagram,
    this.rubika,
    this.qrLink,
    this.qrLabel,
    this.qrDesc,
    this.cityFullDisplay,
    this.cityName,
    this.galleryDisplayName,
    this.bingWallpaperUrl,
    required this.themeMode,
    required this.sliderIntervalSec,
    required this.customMessage,
    required this.rows,
    required this.products,
    required this.updatedAtText,
    required this.dataAgeSeconds,
    required this.isStale,
    required this.refreshIntervalSeconds,
    required this.rawJson,
  });

  factory BoardModel.fromJson(Map<String, dynamic> json, String rawString) {
    final username = json['username']?.toString() ?? '';
    final updatedAt = json['updatedAt']?.toString() ?? '';
    final dataAgeSec = _parseInt(json['dataAgeSeconds'], 0);
    final isStale = _parseBool(json['isStale'], false);
    final refreshSec = _parseInt(json['refreshIntervalSeconds'], 60).clamp(5, 300);

    final rawSettings = json['settings'];
    final settings = rawSettings is Map ? Map<String, dynamic>.from(rawSettings) : null;
    final shopName = json['shopName']?.toString().trim().isNotEmpty == true
        ? json['shopName'].toString().trim()
        : (settings?['shop_name']?.toString().trim().isNotEmpty == true
            ? settings!['shop_name'].toString().trim()
            : 'طلا و جواهر طلالایو');
    final galleryDisplayName = json['galleryDisplayName']?.toString().trim().isNotEmpty == true
        ? json['galleryDisplayName'].toString().trim()
        : shopName;

    String? bingWallpaperUrl;
    final rawBing = json['bingWallpaper'];
    if (rawBing is Map) {
      final url = rawBing['url']?.toString();
      if (url != null && url.isNotEmpty) {
        bingWallpaperUrl = url.startsWith('/') ? 'https://talalive.ir$url' : url;
      }
    } else if (rawBing is String && rawBing.isNotEmpty) {
      bingWallpaperUrl = rawBing.startsWith('/') ? 'https://talalive.ir$rawBing' : rawBing;
    }
    final subtitle = settings?['subtitle']?.toString() ?? 'تابلوی رسمی نرخ لحظه‌ای طلا، سکه و ارز';
    final phone = settings?['phone']?.toString() ?? '';
    final instagram = settings?['instagram']?.toString();
    final rubika = settings?['rubika']?.toString();
    final qrLink = settings?['qr_link']?.toString();
    final qrLabel = settings?['qr_label']?.toString();
    final qrDesc = settings?['qr_desc']?.toString();
    final rawCitySlug = json['citySlug']?.toString() ?? settings?['city_slug']?.toString();
    final rawCityName = json['cityName']?.toString() ?? settings?['city_name']?.toString();
    final rawCityFull = json['cityFullDisplay']?.toString() ?? settings?['city_full_display']?.toString();

    final cityFullDisplay = (rawCityFull != null && rawCityFull.trim().isNotEmpty && rawCityFull.trim() != 'null')
        ? PersianUtils.resolveCityName(rawCityFull.trim())
        : ((rawCityName != null && rawCityName.trim().isNotEmpty && rawCityName.trim() != 'null')
            ? PersianUtils.resolveCityName(rawCityName.trim())
            : PersianUtils.resolveCityName(rawCitySlug));
    final cityName = (rawCityName != null && rawCityName.trim().isNotEmpty && rawCityName.trim() != 'null')
        ? PersianUtils.resolveCityName(rawCityName.trim())
        : PersianUtils.resolveCityName(rawCitySlug);
    final themeMode = settings?['theme_mode']?.toString() ?? 'luxury-dark';
    final sliderInterval = _parseInt(settings?['slider_interval_sec'], 8).clamp(3, 60);
    final customMessage = settings?['custom_message']?.toString() ??
        'به سامانه تابلوی هوشمند نرخ لحظه‌ای طلالایو خوش آمدید • نمایش دقیق و لحظه‌ای مظنه طلا، سکه و مسکوکات';

    // 1. PriceFeed map
    final priceFeedMap = <String, Map<String, dynamic>>{};
    final feedList = json['priceFeed'] as List<dynamic>? ?? [];
    for (final item in feedList) {
      if (item is Map) {
        final map = Map<String, dynamic>.from(item);
        final symbol = map['symbol']?.toString().trim() ?? '';
        if (symbol.isNotEmpty) {
          priceFeedMap[symbol] = map;
        }
      }
    }

    // 2. Parse DisplayItems or fallback to priceFeed
    final rows = <PriceRow>[];
    final displayItems = json['displayItems'] as List<dynamic>?;

    if (displayItems != null && displayItems.isNotEmpty) {
      final entries = <Map<String, dynamic>>[];
      for (var i = 0; i < displayItems.length; i++) {
        final d = displayItems[i];
        if (d is Map) {
          final dMap = Map<String, dynamic>.from(d);
          final enabled = dMap['enabled'] != false;
          if (enabled) {
            entries.add(dMap);
          }
        }
      }

      for (final entry in entries) {
        final key = entry['key']?.toString().trim() ?? '';
        final feed = priceFeedMap[key];
        if (feed != null) {
          final customLabel = entry['label']?.toString().trim() ?? '';
          final defaultLabel = feed['label']?.toString().trim() ?? key;
          final title = customLabel.isNotEmpty ? customLabel : defaultLabel;
          final val = feed['value']?.toString() ?? '۰';
          final buyVal = feed['buy_price']?.toString();
          final unit = feed['unit']?.toString() ?? 'تومان';
          final dirStr = feed['direction']?.toString().toLowerCase() ?? 'flat';
          final dirInt = dirStr == 'up' ? 1 : (dirStr == 'down' ? -1 : 0);
          final chgPct = feed['change_percent']?.toString().trim();
          final chgVal = feed['change_value']?.toString().trim();
          final itemStale = _parseBool(feed['is_stale'], false);

          rows.add(PriceRow(
            symbol: key,
            title: title,
            sellPrice: val,
            buyPrice: buyVal,
            unit: unit,
            changeDirection: dirInt,
            changePercent: chgPct,
            changeValue: chgVal,
            isStale: itemStale,
          ));
        }
      }
    } else {
      // Fallback: Direct priceFeed
      for (final entry in priceFeedMap.entries) {
        final feed = entry.value;
        final title = feed['label']?.toString().trim() ?? entry.key;
        final val = feed['value']?.toString() ?? '۰';
        final buyVal = feed['buy_price']?.toString();
        final unit = feed['unit']?.toString() ?? 'تومان';
        final dirStr = feed['direction']?.toString().toLowerCase() ?? 'flat';
        final dirInt = dirStr == 'up' ? 1 : (dirStr == 'down' ? -1 : 0);
        final chgPct = feed['change_percent']?.toString().trim();
        final chgVal = feed['change_value']?.toString().trim();
        final itemStale = _parseBool(feed['is_stale'], false);

        rows.add(PriceRow(
          symbol: entry.key,
          title: title,
          sellPrice: val,
          buyPrice: buyVal,
          unit: unit,
          changeDirection: dirInt,
          changePercent: chgPct,
          changeValue: chgVal,
          isStale: itemStale,
        ));
      }
    }

    // 3. Products
    final products = <ProductItem>[];
    final prodList = json['products'] as List<dynamic>?;
    if (prodList != null) {
      for (final p in prodList) {
        if (p is Map) {
          final pMap = Map<String, dynamic>.from(p);
          final visible = _parseBool(pMap['is_visible'], true);
          if (!visible) continue;

          final id = pMap['id']?.toString() ?? '';
          final title = pMap['title']?.toString() ?? '';
          final weight = pMap['weight_gram']?.toString();
          final price = pMap['final_price']?.toString();
          final labor = pMap['labor_fee']?.toString();
          final profitVal = pMap['profit_value']?.toString();
          final profitTyp = pMap['profit_type']?.toString();
          final badge = pMap['badge']?.toString();
          final sortOrder = _parseInt(pMap['sort_order'], 0);

          final imgList = <String>[];
          // 1. Eloquent 'images' relationship: [{url: "..."}, ...]
          final imagesList = pMap['images'] as List<dynamic>?;
          if (imagesList != null) {
            for (final img in imagesList) {
              if (img is Map) {
                final u = img['url']?.toString().trim();
                if (u != null && u.isNotEmpty) {
                  imgList.add(u);
                }
              } else if (img is String && img.trim().isNotEmpty) {
                imgList.add(img.trim());
              }
            }
          }
          // 2. Fallback: image_urls
          final rawImgs = pMap['image_urls'] as List<dynamic>?;
          if (rawImgs != null) {
            for (final u in rawImgs) {
              if (u != null && u.toString().trim().isNotEmpty) {
                imgList.add(u.toString().trim());
              }
            }
          }
          // 3. Fallback: image_url
          if (imgList.isEmpty) {
            final single = pMap['image_url']?.toString().trim();
            if (single != null && single.isNotEmpty) {
              imgList.add(single);
            }
          }

          products.add(ProductItem(
            id: id,
            title: title,
            weightGram: weight,
            finalPrice: price,
            laborFee: labor,
            profitValue: profitVal,
            profitType: profitTyp,
            badge: badge,
            sortOrder: sortOrder,
            imageUrls: imgList,
          ));
        }
      }
    }

    return BoardModel(
      username: username,
      shopName: shopName,
      subtitle: subtitle,
      phone: phone,
      instagram: instagram,
      rubika: rubika,
      qrLink: qrLink,
      qrLabel: qrLabel,
      qrDesc: qrDesc,
      cityFullDisplay: cityFullDisplay,
      cityName: cityName,
      galleryDisplayName: galleryDisplayName,
      bingWallpaperUrl: bingWallpaperUrl,
      themeMode: themeMode,
      sliderIntervalSec: sliderInterval,
      customMessage: customMessage,
      rows: rows,
      products: products,
      updatedAtText: updatedAt,
      dataAgeSeconds: dataAgeSec,
      isStale: isStale,
      refreshIntervalSeconds: refreshSec,
      rawJson: rawString,
    );
  }
}
