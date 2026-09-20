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
}
