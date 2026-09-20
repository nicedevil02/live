class PriceRow {
  final String symbol;
  final String title;
  final String sellPrice;
  final String? buyPrice;
  final String unit;
  final int changeDirection; // -1 (down), 0 (flat), +1 (up)
  final String? changePercent;
  final bool isStale;

  const PriceRow({
    required this.symbol,
    required this.title,
    required this.sellPrice,
    this.buyPrice,
    required this.unit,
    required this.changeDirection,
    this.changePercent,
    required this.isStale,
  });
}

class ProductItem {
  final String id;
  final String title;
  final String? weightGram;
  final String? finalPrice;
  final String? laborFee;
  final List<String> imageUrls;

  const ProductItem({
    required this.id,
    required this.title,
    this.weightGram,
    this.finalPrice,
    this.laborFee,
    required this.imageUrls,
  });
}

class BoardModel {
  final String username;
  final String shopName;
  final String subtitle;
  final String phone;
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
    final dataAgeSec = (json['dataAgeSeconds'] as num?)?.toInt() ?? 0;
    final isStale = json['isStale'] == true;
    final refreshSec = ((json['refreshIntervalSeconds'] as num?)?.toInt() ?? 60).clamp(5, 300);

    final settings = json['settings'] as Map<String, dynamic>?;
    final shopName = settings?['shop_name']?.toString().trim().isNotEmpty == true
        ? settings!['shop_name'].toString()
        : 'گالری طلا و جواهر طلالایو';
    final subtitle = settings?['subtitle']?.toString() ?? 'تابلوی رسمی نرخ لحظه‌ای طلا، سکه و ارز';
    final phone = settings?['phone']?.toString() ?? '';
    final themeMode = settings?['theme_mode']?.toString() ?? 'luxury-dark';
    final sliderInterval = ((settings?['slider_interval_sec'] as num?)?.toInt() ?? 8).clamp(3, 60);
    final customMessage = settings?['custom_message']?.toString() ??
        'به سامانه تابلوی هوشمند نرخ لحظه‌ای طلالایو خوش آمدید • نمایش دقیق و لحظه‌ای مظنه طلا، سکه و مسکوکات';

    // 1. PriceFeed map
    final priceFeedMap = <String, Map<String, dynamic>>{};
    final feedList = json['priceFeed'] as List<dynamic>? ?? [];
    for (final item in feedList) {
      if (item is Map<String, dynamic>) {
        final symbol = item['symbol']?.toString().trim() ?? '';
        if (symbol.isNotEmpty) {
          priceFeedMap[symbol] = item;
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
        if (d is Map<String, dynamic>) {
          final enabled = d['enabled'] != false;
          if (enabled) {
            entries.add(d);
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
          final itemStale = feed['is_stale'] == true;

          rows.add(PriceRow(
            symbol: key,
            title: title,
            sellPrice: val,
            buyPrice: buyVal,
            unit: unit,
            changeDirection: dirInt,
            changePercent: chgPct,
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
        final itemStale = feed['is_stale'] == true;

        rows.add(PriceRow(
          symbol: entry.key,
          title: title,
          sellPrice: val,
          buyPrice: buyVal,
          unit: unit,
          changeDirection: dirInt,
          changePercent: chgPct,
          isStale: itemStale,
        ));
      }
    }

    // 3. Products
    final products = <ProductItem>[];
    final prodList = json['products'] as List<dynamic>?;
    if (prodList != null) {
      for (final p in prodList) {
        if (p is Map<String, dynamic>) {
          final isVisible = p['is_visible'];
          final visible = isVisible == true || isVisible == '1' || isVisible == 1;
          if (!visible) continue;

          final id = p['id']?.toString() ?? '';
          final title = p['title']?.toString() ?? '';
          final weight = p['weight_gram']?.toString();
          final price = p['final_price']?.toString();
          final labor = p['labor_fee']?.toString();

          final imgList = <String>[];
          final rawImgs = p['image_urls'] as List<dynamic>?;
          if (rawImgs != null) {
            for (final u in rawImgs) {
              if (u != null && u.toString().trim().isNotEmpty) {
                imgList.add(u.toString().trim());
              }
            }
          }
          if (imgList.isEmpty) {
            final single = p['image_url']?.toString().trim();
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
