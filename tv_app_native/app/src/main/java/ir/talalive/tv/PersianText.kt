package ir.talalive.tv

object PersianText {
    private val digits = charArrayOf('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹')

    fun toPersianDigits(s: String): String {
        val sb = StringBuilder(s.length)
        for (c in s) sb.append(if (c in '0'..'9') digits[c - '0'] else c)
        return sb.toString()
    }

    fun groupThousands(raw: String): String {
        val clean = raw.trim()
        if (clean.isEmpty()) return raw

        // Handle decimal numbers like 4378.08
        if (clean.contains('.')) {
            val parts = clean.split('.', limit = 2)
            val intPart = parts[0].filter { it.isDigit() }
            val formattedInt = if (intPart.isNotEmpty()) {
                intPart.reversed().chunked(3).joinToString(",").reversed()
            } else {
                "0"
            }
            return "$formattedInt.${parts[1]}"
        }

        val digitsOnly = clean.filter { it.isDigit() }
        if (digitsOnly.isEmpty()) return raw
        return digitsOnly.reversed().chunked(3).joinToString(",").reversed()
    }

    fun formatPrice(raw: String): String {
        return toPersianDigits(groupThousands(raw))
    }

    private val persianMonths = arrayOf(
        "فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور",
        "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"
    )

    private val persianDays = arrayOf(
        "یکشنبه", "دوشنبه", "سه‌شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"
    )

    fun getShamsiDate(calendar: java.util.Calendar = java.util.Calendar.getInstance()): String {
        val gy = calendar.get(java.util.Calendar.YEAR)
        val gm = calendar.get(java.util.Calendar.MONTH) + 1
        val gd = calendar.get(java.util.Calendar.DAY_OF_MONTH)
        val dayOfWeek = calendar.get(java.util.Calendar.DAY_OF_WEEK) // 1=Sunday, 7=Saturday
        val dayName = persianDays[(dayOfWeek - 1) % 7]

        val gDaysInMonth = intArrayOf(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334)
        var gy2 = if (gm > 2) gy + 1 else gy
        var gDayNo = 365 * gy + (gy2 + 3) / 4 - (gy2 + 99) / 100 + (gy2 + 399) / 400 - 80 + gd + gDaysInMonth[gm - 1]
        gy2 += gDayNo / 12053
        gDayNo %= 12053
        var jy = 979 + 33 * gy2 + 4 * (gDayNo / 1461)
        gDayNo %= 1461
        if (gDayNo >= 366) {
            jy += (gDayNo - 1) / 365
            gDayNo = (gDayNo - 1) % 365
        }
        val jm: Int
        val jd: Int
        if (gDayNo < 186) {
            jm = 1 + gDayNo / 31
            jd = 1 + gDayNo % 31
        } else {
            jm = 7 + (gDayNo - 186) / 30
            jd = 1 + (gDayNo - 186) % 30
        }
        val monthName = persianMonths[jm - 1]
        return toPersianDigits("$dayName، $jd $monthName $jy")
    }
}

