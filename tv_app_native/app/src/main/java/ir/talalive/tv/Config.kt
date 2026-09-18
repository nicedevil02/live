package ir.talalive.tv

import android.content.Context
import android.util.Log
import org.json.JSONArray

object Config {
    // تنها مقدار هاردکد در کل اپ: نقطهٔ شروع اولیه (D-05, A-04)
    private const val BOOTSTRAP_BASE = "https://talalive.ir"

    fun baseUrls(ctx: Context): List<String> {
        val stored = TvPrefs.get(ctx).getString("base_urls", null)
        if (!stored.isNullOrBlank()) {
            try {
                val arr = JSONArray(stored)
                val out = ArrayList<String>(arr.length())
                for (i in 0 until arr.length()) {
                    val u = arr.getString(i).trimEnd('/')
                    if (u.isNotBlank()) out.add(u)
                }
                if (out.isNotEmpty()) return out
            } catch (e: Exception) {
                Log.w("TalaTV", "base_urls parse failed, falling back", e)
            }
        }
        return listOf(BOOTSTRAP_BASE)
    }
}
