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

  static String formatNumber(num value) {
    final str = value.toString();
    if (str.contains('.')) {
      final parts = str.split('.');
      final intPart = _groupDigits(parts[0]);
      return toPersianDigits('$intPart.${parts[1]}');
    }
    return toPersianDigits(_groupDigits(str));
  }

  static String formatPriceString(String raw) {
    final clean = raw.trim();
    if (clean.isEmpty) return '۰';

    if (clean.contains('.')) {
      final parts = clean.split('.');
      final intPart = parts[0].replaceAll(RegExp(r'[^\d]'), '');
      final formattedInt = _groupDigits(intPart.isEmpty ? '0' : intPart);
      final decimal = parts[1].replaceAll(RegExp(r'0+$'), '');
      if (decimal.isEmpty) {
        return toPersianDigits(formattedInt);
      }
      return toPersianDigits('$formattedInt.$decimal');
    }

    final digitsOnly = clean.replaceAll(RegExp(r'[^\d]'), '');
    if (digitsOnly.isEmpty) return toPersianDigits(clean);
    return toPersianDigits(_groupDigits(digitsOnly));
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
    final formatted = decimals > 0 ? absVal.toStringAsFixed(decimals) : formatPriceString(absVal.toString());
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
