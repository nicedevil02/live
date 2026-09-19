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
}
