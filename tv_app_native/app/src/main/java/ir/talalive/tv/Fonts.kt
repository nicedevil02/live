package ir.talalive.tv

import android.content.Context
import android.graphics.Typeface
import android.util.Log

object Fonts {
    private var regular: Typeface? = null
    private var bold: Typeface? = null

    fun regular(ctx: Context): Typeface {
        regular?.let { return it }
        val t = load(ctx, "fonts/Vazirmatn-Regular.ttf") ?: Typeface.DEFAULT
        regular = t
        return t
    }

    fun bold(ctx: Context): Typeface {
        bold?.let { return it }
        val t = load(ctx, "fonts/Vazirmatn-Bold.ttf") ?: Typeface.DEFAULT_BOLD
        bold = t
        return t
    }

    private fun load(ctx: Context, path: String): Typeface? = try {
        Typeface.createFromAsset(ctx.assets, path)
    } catch (e: Throwable) {
        Log.e("TalaTV.Fonts", "font load failed: $path", e)
        null
    }
}
