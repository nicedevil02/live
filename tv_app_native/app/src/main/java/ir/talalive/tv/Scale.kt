package ir.talalive.tv

import android.content.Context
import android.util.TypedValue
import android.widget.TextView

object Scale {
    // همهٔ اندازه‌ها کسری از ارتفاع صفحه هستند، نه dp و نه sp
    fun px(ctx: Context, fractionOfHeight: Float): Float =
        ctx.resources.displayMetrics.heightPixels * fractionOfHeight

    fun applyTextSize(tv: TextView, fractionOfHeight: Float) {
        tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, px(tv.context, fractionOfHeight))
    }
}
