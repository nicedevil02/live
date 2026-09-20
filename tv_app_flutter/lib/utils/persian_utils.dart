import 'package:shamsi_date/shamsi_date.dart';

class PersianUtils {
  static const List<String> _persianDigits = [
    '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'
  ];

  static String toPersianDigits(String input) {
    var result = input;
    for (var i = 0; i <= 9; i++) {
      result = result.replaceAll(i.toString(), _persianDigits[i]);
    }
    return result;
  }

  static String formatNumber(num value, [int decimals = 0]) {
    if (decimals > 0) {
      final fixed = value.toStringAsFixed(decimals);
      final parts = fixed.split('.');
      final intPart = _groupDigits(parts[0]);
      return toPersianDigits('$intPart/${parts[1]}');
    }
    return toPersianDigits(_groupDigits(value.round().toString()));
  }

  static String formatPrice(dynamic raw, {int decimals = 0, String symbol = ''}) {
    if (raw == null) return '۰';
    if (symbol == 'ounce' || symbol == 'bitcoin') {
      decimals = 2;
    }

    num n = 0;
    if (raw is num) {
      n = raw;
    } else if (raw is String) {
      final clean = raw.trim();
      if (clean.isEmpty) return '۰';
      if (clean.contains('.')) {
        final parts = clean.split('.');
        final intPart = num.tryParse(parts[0].replaceAll(RegExp(r'[^\d]'), '')) ?? 0;
        final decPart = parts[1].replaceAll(RegExp(r'[^\d]'), '');
        if (decPart.isEmpty) {
          n = intPart;
        } else {
          n = num.tryParse('$intPart.$decPart') ?? intPart;
        }
      } else {
        n = num.tryParse(clean.replaceAll(RegExp(r'[^\d]'), '')) ?? 0;
      }
    }

    return formatNumber(n, decimals);
  }

  static String formatPriceString(String raw, {String symbol = ''}) {
    final clean = raw.trim();
    if (clean.isEmpty) return '۰';
    final decimals = (symbol == 'ounce' || symbol == 'bitcoin') ? 2 : 0;
    return formatPrice(raw, decimals: decimals);
  }

  static String formatSignedPercent(dynamic val) {
    if (val == null) return '۰/۰۰%';
    num n = 0;
    if (val is num) {
      n = val;
    } else if (val is String) {
      n = double.tryParse(val.replaceAll('%', '').trim()) ?? 0;
    }
    final sign = n > 0 ? '+' : (n < 0 ? '-' : '');
    final absVal = n.abs();
    final fixed = absVal.toStringAsFixed(2);
    final parts = fixed.split('.');
    final formatted = '${parts[0]}/${parts[1]}';
    return toPersianDigits('$sign$formatted%');
  }

  static String formatSignedChangeValue(dynamic val, {String symbol = ''}) {
    if (val == null) return '۰';
    final decimals = (symbol == 'ounce' || symbol == 'bitcoin') ? 2 : 0;
    num n = 0;
    if (val is num) {
      n = val;
    } else if (val is String) {
      n = double.tryParse(val.trim()) ?? 0;
    }
    final sign = n > 0 ? '+' : (n < 0 ? '-' : '');
    final absVal = n.abs();
    final formatted = formatNumber(absVal, decimals);
    return toPersianDigits('$sign$formatted');
  }

  static String formatSignedNumber(dynamic val, [int decimals = 0]) {
    if (val == null) return '۰';
    num n = 0;
    if (val is num) {
      n = val;
    } else if (val is String) {
      n = double.tryParse(val) ?? 0;
    }
    final sign = n > 0 ? '+' : (n < 0 ? '-' : '');
    final absVal = n.abs();
    final formatted = formatNumber(absVal, decimals);
    return toPersianDigits('$sign$formatted');
  }

  static String _groupDigits(String digits) {
    if (digits.length <= 3) return digits;
    final buffer = StringBuffer();
    final reversed = digits.split('').reversed.toList();
    for (var i = 0; i < reversed.length; i++) {
      if (i > 0 && i % 3 == 0) {
        buffer.write(',');
      }
      buffer.write(reversed[i]);
    }
    return buffer.toString().split('').reversed.join();
  }

  static String getShamsiDateString([DateTime? dateTime]) {
    final dt = dateTime ?? DateTime.now();
    final jalali = Jalali.fromDateTime(dt);
    final dayName = _getDayOfWeekName(jalali.weekDay);
    final monthName = jalali.formatter.mN;
    final day = jalali.day;
    final year = jalali.year;

    return toPersianDigits('$dayName، $day $monthName $year');
  }

  static String _getDayOfWeekName(int weekDay) {
    switch (weekDay) {
      case 1:
        return 'شنبه';
      case 2:
        return 'یکشنبه';
      case 3:
        return 'دوشنبه';
      case 4:
        return 'سه‌شنبه';
      case 5:
        return 'چهارشنبه';
      case 6:
        return 'پنج‌شنبه';
      case 7:
        return 'جمعه';
      default:
        return '';
    }
  }

  static String formatClock(DateTime dt) {
    final h = dt.hour.toString().padLeft(2, '0');
    final m = dt.minute.toString().padLeft(2, '0');
    final s = dt.second.toString().padLeft(2, '0');
    return toPersianDigits('$h:$m:$s');
  }

  static String resolveCityName(String? input) {
    if (input == null || input.trim().isEmpty) return 'تهران';
    final clean = input.trim();

    // If already in Persian (contains Persian letters)
    if (RegExp(r'[\u0600-\u06FF]').hasMatch(clean)) {
      return clean;
    }

    final slug = clean.toLowerCase();
    const cityMap = {
      'hamedan': 'همدان',
      'malayer': 'همدان (ملایر)',
      'nahavand': 'همدان (نهاوند)',
      'tuyserkan': 'همدان (تویسرکان)',
      'asadabad': 'همدان (اسدآباد)',
      'bahar': 'همدان (بهار)',
      'kabudarahang': 'همدان (کبودرآهنگ)',
      'razan': 'همدان (رزن)',
      'famenin': 'همدان (فامنین)',
      'dargazin': 'همدان (درگزین)',
      'tehran': 'تهران',
      'rey': 'تهران (ری)',
      'shahriar': 'تهران (شهریار)',
      'islamshahr': 'تهران (اسلامشهر)',
      'varamin': 'تهران (ورامین)',
      'qods': 'تهران (قدس)',
      'pardis': 'تهران (پردیس)',
      'damavand': 'تهران (دماوند)',
      'pakdasht': 'تهران (پاکدشت)',
      'baharestan': 'تهران (بهارستان)',
      'robat-karim': 'تهران (رباط‌کریم)',
      'malard': 'تهران (ملارد)',
      'qarchak': 'تهران (قرچک)',
      'pishva': 'تهران (پیشوا)',
      'isfahan': 'اصفهان',
      'kashan': 'اصفهان (کاشان)',
      'najafabad': 'اصفهان (نجف‌آباد)',
      'khomeinishahr': 'اصفهان (خمینی‌شهر)',
      'shahinshahr': 'اصفهان (شاهین‌شهر)',
      'shahr-e-kord': 'شهرکرد',
      'mashhad': 'مشهد',
      'neyshabur': 'مشهد (نیشابور)',
      'sabzevar': 'مشهد (سبزوار)',
      'torbat-heydariyeh': 'مشهد (تربت حیدریه)',
      'tabriz': 'تبریز',
      'maragheh': 'آذربایجان شرقی (مراغه)',
      'marand': 'آذربایجان شرقی (مرند)',
      'shiraz': 'شیراز',
      'marvdasht': 'فارس (مرودشت)',
      'jahrom': 'فارس (جهرم)',
      'fasa': 'فارس (فسا)',
      'ahvaz': 'اهواز',
      'dezful': 'خوزستان (دزفول)',
      'abadan': 'خوزستان (آبادان)',
      'khorramshahr': 'خوزستان (خرمشهر)',
      'mahshahr': 'خوزستان (ماهشهر)',
      'qom': 'قم',
      'karaj': 'کرج',
      'fardis': 'کرج (فردیس)',
      'hashtgerd': 'البرز (هشتگرد)',
      'rasht': 'رشت',
      'anzali': 'گیلان (انزلی)',
      'lahijan': 'گیلان (لاهیجان)',
      'urmia': 'ارومیه',
      'khoy': 'آذربایجان غربی (خوی)',
      'bukan': 'آذربایجان غربی (بوکان)',
      'mahabad': 'آذربایجان غربی (مهاباد)',
      'kermanshah': 'کرمانشاه',
      'zahedan': 'زاهدان',
      'zabol': 'سیستان و بلوچستان (زابل)',
      'kerman': 'کرمان',
      'rafsanjan': 'کرمان (رفسنجان)',
      'sirjan': 'کرمان (سیرجان)',
      'yazd': 'یزد',
      'meybod': 'یزد (میبد)',
      'ardakan': 'یزد (اردکان)',
      'arak': 'اراک',
      'saveh': 'مرکزی (ساوه)',
      'qazvin': 'قزوین',
      'zanjan': 'زنجان',
      'abhar': 'زنجان (ابهر)',
      'khorramabad': 'خرم‌آباد',
      'borujerd': 'لرستان (بروجرد)',
      'sari': 'ساری',
      'babol': 'مازندران (بابل)',
      'amol': 'مازندران (آمل)',
      'qaemshahr': 'مازندران (قائم‌شهر)',
      'gorgan': 'گرگان',
      'gonbad': 'گلستان (گنبد کاووس)',
      'sanandaj': 'سنندج',
      'saqqez': 'کردستان (سقز)',
      'marivan': 'کردستان (مریوان)',
      'bandar-abbas': 'بندرعباس',
      'qeshm': 'هرمزگان (قشم)',
      'kish': 'هرمزگان (کیش)',
      'bushehr': 'بوشهر',
      'borazjan': 'بوشهر (برازجان)',
      'birjand': 'بیرجند',
      'bojnurd': 'بجنورد',
      'semnan': 'سمنان',
      'shahrud': 'سمنان (شاهرود)',
      'ilam': 'ایلام',
      'yasuj': 'یاسوج',
      'iran': 'ایران',
    };

    return cityMap[slug] ?? clean;
  }
}
