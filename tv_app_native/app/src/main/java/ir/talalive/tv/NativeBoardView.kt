package ir.talalive.tv

import android.animation.Animator
import android.animation.AnimatorListenerAdapter
import android.animation.ObjectAnimator
import android.content.Context
import android.graphics.Color
import android.graphics.drawable.GradientDrawable
import android.os.Build
import android.os.Handler
import android.os.Looper
import android.view.Gravity
import android.view.View
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import java.text.SimpleDateFormat
import java.util.Date
import java.util.Locale

class NativeBoardView(context: Context) : LinearLayout(context) {

    private val handler = Handler(Looper.getMainLooper())
    private var currentModel: BoardModel? = null

    // Header UI
    private val tvShopName: TextView
    private val tvPhone: TextView
    private val tvStatusBadge: TextView
    private val tvClock: TextView

    // Body UI
    private val bodyContainer: LinearLayout
    private val cardsContainer: LinearLayout
    private val slideshowContainer: LinearLayout
    private val ivProduct: ImageView
    private val tvProductTitle: TextView
    private val tvProductDetails: TextView
    private val tvSlideCounter: TextView

    // Footer UI
    private val tvFooterUpdate: TextView
    private val tvFooterDomain: TextView

    // Pagination
    private var currentPage = 0
    private var pageCount = 1
    private val itemsPerPage = 8
    private var isOfflineLong = false

    // Slideshow
    private var currentProductIndex = 0
    private var currentProducts: List<ProductItem> = emptyList()

    private val pageSwapRunnable = object : Runnable {
        override fun run() {
            if (pageCount > 1) {
                currentPage = (currentPage + 1) % pageCount
                renderRowsPage()
            }
            handler.postDelayed(this, 10_000L)
        }
    }

    private val slideSwapRunnable = object : Runnable {
        override fun run() {
            if (currentProducts.size > 1) {
                currentProductIndex = (currentProductIndex + 1) % currentProducts.size
                renderProductSlide()
                val interval = (currentModel?.sliderIntervalSec ?: 8).coerceIn(3, 60) * 1000L
                handler.postDelayed(this, interval)
            }
        }
    }

    init {
        orientation = VERTICAL
        setBackgroundColor(Color.parseColor("#020617")) // Luxury Dark Slate

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN_MR1) {
            layoutDirection = LAYOUT_DIRECTION_RTL
        }

        val padH = Scale.px(context, 0.035f).toInt()
        val padV = Scale.px(context, 0.025f).toInt()
        setPadding(padH, padV, padH, padV)

        // 1. Header (Shop Name + Phone + Status Badge + Clock)
        val headerLayout = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER_VERTICAL
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT).apply {
                bottomMargin = Scale.px(context, 0.018f).toInt()
            }
            layoutParams = lp
        }

        val titleContainer = LinearLayout(context).apply {
            orientation = VERTICAL
            val lp = LayoutParams(0, LayoutParams.WRAP_CONTENT, 1f)
            layoutParams = lp
        }

        tvShopName = TextView(context).apply {
            text = "طلالایو TV"
            setTextColor(Color.parseColor("#F59E0B")) // Gold
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.044f)
        }

        tvPhone = TextView(context).apply {
            text = ""
            setTextColor(Color.parseColor("#94A3B8"))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.020f)
            visibility = View.GONE
        }

        titleContainer.addView(tvShopName)
        titleContainer.addView(tvPhone)

        tvStatusBadge = TextView(context).apply {
            text = "به‌روز"
            setTextColor(Color.parseColor("#22C55E"))
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.022f)
            gravity = Gravity.CENTER
            val pH = Scale.px(context, 0.016f).toInt()
            val pV = Scale.px(context, 0.008f).toInt()
            setPadding(pH, pV, pH, pV)
            background = makeBadgeDrawable("#166534", "#22C55E")
            val lp = LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT).apply {
                rightMargin = Scale.px(context, 0.02f).toInt()
                leftMargin = Scale.px(context, 0.02f).toInt()
            }
            layoutParams = lp
        }

        tvClock = TextView(context).apply {
            text = "۰۰:۰۰:۰۰"
            setTextColor(Color.parseColor("#E2E8F0"))
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.038f)
            gravity = Gravity.LEFT
            val lp = LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT)
            layoutParams = lp
        }

        headerLayout.addView(titleContainer)
        headerLayout.addView(tvStatusBadge)
        headerLayout.addView(tvClock)
        addView(headerLayout)

        // 2. Body Container (Cards Grid + Optional Product Slideshow)
        bodyContainer = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, 0, 1f)
            layoutParams = lp
        }

        cardsContainer = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER
            val lp = LayoutParams(0, LayoutParams.MATCH_PARENT, 1.4f)
            layoutParams = lp
        }
        bodyContainer.addView(cardsContainer)

        slideshowContainer = LinearLayout(context).apply {
            orientation = VERTICAL
            gravity = Gravity.CENTER
            background = makeCardDrawable()
            val pad = Scale.px(context, 0.016f).toInt()
            setPadding(pad, pad, pad, pad)
            val lp = LayoutParams(0, LayoutParams.MATCH_PARENT, 0.85f).apply {
                leftMargin = Scale.px(context, 0.014f).toInt()
            }
            layoutParams = lp
            visibility = View.GONE
        }

        ivProduct = ImageView(context).apply {
            scaleType = ImageView.ScaleType.FIT_CENTER
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, 0, 1f)
            layoutParams = lp
        }

        tvProductTitle = TextView(context).apply {
            setTextColor(Color.parseColor("#F59E0B"))
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.030f)
            gravity = Gravity.CENTER
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT).apply {
                topMargin = Scale.px(context, 0.010f).toInt()
            }
            layoutParams = lp
        }

        tvProductDetails = TextView(context).apply {
            setTextColor(Color.parseColor("#E2E8F0"))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.022f)
            gravity = Gravity.CENTER
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT).apply {
                topMargin = Scale.px(context, 0.005f).toInt()
            }
            layoutParams = lp
        }

        tvSlideCounter = TextView(context).apply {
            setTextColor(Color.parseColor("#64748B"))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.018f)
            gravity = Gravity.CENTER
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT).apply {
                topMargin = Scale.px(context, 0.005f).toInt()
            }
            layoutParams = lp
        }

        slideshowContainer.addView(ivProduct)
        slideshowContainer.addView(tvProductTitle)
        slideshowContainer.addView(tvProductDetails)
        slideshowContainer.addView(tvSlideCounter)
        bodyContainer.addView(slideshowContainer)

        addView(bodyContainer)

        // 3. Footer (Last Updated + Domain)
        val footerLayout = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER_VERTICAL
            val lp = LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT).apply {
                topMargin = Scale.px(context, 0.018f).toInt()
            }
            layoutParams = lp
        }

        tvFooterUpdate = TextView(context).apply {
            text = "آخرین به‌روزرسانی: ---"
            setTextColor(Color.parseColor("#94A3B8"))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.022f)
            val lp = LayoutParams(0, LayoutParams.WRAP_CONTENT, 1f)
            layoutParams = lp
        }

        tvFooterDomain = TextView(context).apply {
            text = "talalive.ir"
            setTextColor(Color.parseColor("#64748B"))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.022f)
            gravity = Gravity.LEFT
            val lp = LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT)
            layoutParams = lp
        }

        footerLayout.addView(tvFooterUpdate)
        footerLayout.addView(tvFooterDomain)
        addView(footerLayout)
    }

    override fun onAttachedToWindow() {
        super.onAttachedToWindow()
        handler.removeCallbacks(pageSwapRunnable)
        handler.postDelayed(pageSwapRunnable, 10_000L)

        handler.removeCallbacks(slideSwapRunnable)
        if (currentProducts.size > 1) {
            val interval = (currentModel?.sliderIntervalSec ?: 8).coerceIn(3, 60) * 1000L
            handler.postDelayed(slideSwapRunnable, interval)
        }
    }

    override fun onDetachedFromWindow() {
        super.onDetachedFromWindow()
        handler.removeCallbacks(pageSwapRunnable)
        handler.removeCallbacks(slideSwapRunnable)
    }

    fun updateData(model: BoardModel) {
        currentModel = model
        tvShopName.text = model.shopName

        if (model.phone.isNotBlank()) {
            tvPhone.text = PersianText.toPersianDigits("تلفن: ${model.phone}")
            tvPhone.visibility = View.VISIBLE
        } else {
            tvPhone.visibility = View.GONE
        }

        // Update Stale Status
        updateStatusBadge(model)

        // Update Footer Last Update text
        val updateTime = if (model.updatedAtText.isNotBlank()) {
            formatIsoTime(model.updatedAtText)
        } else {
            "---"
        }
        tvFooterUpdate.text = PersianText.toPersianDigits("آخرین دریافت مظنه: $updateTime")

        // Handle Products Slideshow
        if (model.products.isNotEmpty()) {
            currentProducts = model.products
            slideshowContainer.visibility = View.VISIBLE
            renderProductSlide()
            handler.removeCallbacks(slideSwapRunnable)
            if (currentProducts.size > 1) {
                val interval = model.sliderIntervalSec.coerceIn(3, 60) * 1000L
                handler.postDelayed(slideSwapRunnable, interval)
            }
        } else {
            currentProducts = emptyList()
            slideshowContainer.visibility = View.GONE
            handler.removeCallbacks(slideSwapRunnable)
        }

        // Calculate pages
        val totalRows = model.rows.size
        pageCount = if (totalRows <= itemsPerPage) 1 else ((totalRows + itemsPerPage - 1) / itemsPerPage)
        if (currentPage >= pageCount) currentPage = 0

        renderRowsPage()
    }

    fun updateClock(timeText: String) {
        tvClock.text = PersianText.toPersianDigits(timeText)
    }

    fun setOfflineStatus(offlineLong: Boolean) {
        isOfflineLong = offlineLong
        currentModel?.let { updateStatusBadge(it) }
    }

    private fun renderProductSlide() {
        if (currentProducts.isEmpty()) {
            slideshowContainer.visibility = View.GONE
            return
        }
        if (currentProductIndex >= currentProducts.size) currentProductIndex = 0
        val p = currentProducts[currentProductIndex]

        ObjectAnimator.ofFloat(slideshowContainer, "alpha", 1f, 0.25f).apply {
            duration = 180
            addListener(object : AnimatorListenerAdapter() {
                override fun onAnimationEnd(animation: Animator) {
                    tvProductTitle.text = p.title

                    val sb = StringBuilder()
                    if (!p.weightGram.isNullOrBlank()) {
                        sb.append("وزن: ").append(PersianText.toPersianDigits(p.weightGram)).append(" گرم")
                    }
                    if (!p.finalPrice.isNullOrBlank()) {
                        if (sb.isNotEmpty()) sb.append("  |  ")
                        sb.append("مظنه: ").append(PersianText.toPersianDigits(PersianText.groupThousands(p.finalPrice))).append(" تومان")
                    }
                    tvProductDetails.text = sb.toString()
                    tvSlideCounter.text = PersianText.toPersianDigits("${currentProductIndex + 1} از ${currentProducts.size}")

                    val firstUrl = p.imageUrls.firstOrNull() ?: ""
                    if (firstUrl.isNotBlank()) {
                        val base = Config.baseUrls(context)[0]
                        val fullUrl = when {
                            firstUrl.startsWith("http") -> firstUrl
                            firstUrl.startsWith("/") -> base + firstUrl
                            else -> "$base/$firstUrl"
                        }
                        ImageCache.loadBitmap(context, fullUrl) { bmp ->
                            post {
                                ivProduct.setImageBitmap(bmp)
                            }
                        }
                    } else {
                        ivProduct.setImageDrawable(null)
                    }

                    ObjectAnimator.ofFloat(slideshowContainer, "alpha", 0.25f, 1f).apply {
                        duration = 220
                        start()
                    }
                }
            })
            start()
        }
    }

    private fun updateStatusBadge(model: BoardModel) {
        if (isOfflineLong) {
            tvStatusBadge.text = "اتصال برقرار نیست"
            tvStatusBadge.setTextColor(Color.parseColor("#EF4444"))
            tvStatusBadge.background = makeBadgeDrawable("#7F1D1D", "#EF4444")
        } else if (model.isStale || model.dataAgeSeconds > 180) {
            val time = formatIsoTime(model.updatedAtText)
            tvStatusBadge.text = PersianText.toPersianDigits("تأخیر در به‌روزرسانی — آخرین نرخ: $time")
            tvStatusBadge.setTextColor(Color.parseColor("#F59E0B"))
            tvStatusBadge.background = makeBadgeDrawable("#78350F", "#F59E0B")
        } else {
            tvStatusBadge.text = "به‌روز"
            tvStatusBadge.setTextColor(Color.parseColor("#22C55E"))
            tvStatusBadge.background = makeBadgeDrawable("#166534", "#22C55E")
        }
    }

    private fun renderRowsPage() {
        val model = currentModel ?: return
        cardsContainer.removeAllViews()

        val allRows = model.rows
        if (allRows.isEmpty()) {
            val emptyTv = TextView(context).apply {
                text = "در حال بارگذاری و دریافت نرخ‌های لحظه‌ای طلا و ارز..."
                setTextColor(Color.parseColor("#94A3B8"))
                typeface = Fonts.regular(context)
                Scale.applyTextSize(this, 0.032f)
                gravity = Gravity.CENTER
            }
            cardsContainer.addView(emptyTv)
            return
        }

        val startIndex = currentPage * itemsPerPage
        val endIndex = Math.min(startIndex + itemsPerPage, allRows.size)
        val pageRows = allRows.subList(startIndex, endIndex)

        // Divide into 2 columns for TV widescreen
        val col1 = LinearLayout(context).apply {
            orientation = VERTICAL
            val lp = LayoutParams(0, LayoutParams.MATCH_PARENT, 1f).apply {
                rightMargin = Scale.px(context, 0.012f).toInt()
            }
            layoutParams = lp
        }

        val col2 = LinearLayout(context).apply {
            orientation = VERTICAL
            val lp = LayoutParams(0, LayoutParams.MATCH_PARENT, 1f).apply {
                leftMargin = Scale.px(context, 0.012f).toInt()
            }
            layoutParams = lp
        }

        val half = (pageRows.size + 1) / 2
        for (i in pageRows.indices) {
            val rowView = buildCardView(pageRows[i])
            if (i < half) {
                col1.addView(rowView)
            } else {
                col2.addView(rowView)
            }
        }

        cardsContainer.addView(col1)
        cardsContainer.addView(col2)
    }

    private fun buildCardView(item: PriceRow): View {
        val card = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER_VERTICAL
            background = makeCardDrawable()

            val pH = Scale.px(context, 0.024f).toInt()
            val pV = Scale.px(context, 0.014f).toInt()
            setPadding(pH, pV, pH, pV)

            val lp = LayoutParams(LayoutParams.MATCH_PARENT, 0, 1f).apply {
                val m = Scale.px(context, 0.008f).toInt()
                setMargins(0, m, 0, m)
            }
            layoutParams = lp
        }

        // Title (Right column in RTL)
        val tvTitle = TextView(context).apply {
            text = item.title
            setTextColor(Color.parseColor("#E2E8F0"))
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.028f)
            val lp = LayoutParams(0, LayoutParams.WRAP_CONTENT, 1.1f)
            layoutParams = lp
        }

        // Price (Center)
        val tvPrice = TextView(context).apply {
            text = PersianText.toPersianDigits(PersianText.groupThousands(item.price))
            setTextColor(Color.parseColor("#F59E0B")) // Gold
            typeface = Fonts.bold(context)
            Scale.applyTextSize(this, 0.038f)
            gravity = Gravity.CENTER
            val lp = LayoutParams(0, LayoutParams.WRAP_CONTENT, 1.4f)
            layoutParams = lp
        }

        // Change & Direction (Left column in RTL)
        val changeLayout = LinearLayout(context).apply {
            orientation = HORIZONTAL
            gravity = Gravity.CENTER_VERTICAL or Gravity.LEFT
            val lp = LayoutParams(0, LayoutParams.WRAP_CONTENT, 0.9f)
            layoutParams = lp
        }

        val tvArrow = TextView(context).apply {
            text = when (item.changeDirection) {
                1 -> "▲"
                -1 -> "▼"
                else -> "●"
            }
            val color = when (item.changeDirection) {
                1 -> "#22C55E" // Green
                -1 -> "#EF4444" // Red
                else -> "#64748B" // Slate
            }
            setTextColor(Color.parseColor(color))
            Scale.applyTextSize(this, 0.026f)
            val lp = LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT).apply {
                leftMargin = Scale.px(context, 0.006f).toInt()
            }
            layoutParams = lp
        }

        val tvChange = TextView(context).apply {
            text = if (!item.changeText.isNullOrBlank()) PersianText.toPersianDigits(item.changeText) else ""
            val color = when (item.changeDirection) {
                1 -> "#22C55E"
                -1 -> "#EF4444"
                else -> "#64748B"
            }
            setTextColor(Color.parseColor(color))
            typeface = Fonts.regular(context)
            Scale.applyTextSize(this, 0.022f)
            val lp = LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT)
            layoutParams = lp
        }

        changeLayout.addView(tvChange)
        changeLayout.addView(tvArrow)

        card.addView(tvTitle)
        card.addView(tvPrice)
        card.addView(changeLayout)

        // Subtle fade-in on mount
        ObjectAnimator.ofFloat(card, "alpha", 0.75f, 1f).apply {
            duration = 300
            start()
        }

        return card
    }

    private fun makeCardDrawable(): GradientDrawable {
        return GradientDrawable().apply {
            shape = GradientDrawable.RECTANGLE
            setColor(Color.parseColor("#0F172A")) // Slate 900
            cornerRadius = Scale.px(context, 0.016f)
            setStroke(Scale.px(context, 0.0015f).toInt().coerceAtLeast(1), Color.parseColor("#1E293B"))
        }
    }

    private fun makeBadgeDrawable(bgColorHex: String, strokeColorHex: String): GradientDrawable {
        return GradientDrawable().apply {
            shape = GradientDrawable.RECTANGLE
            setColor(Color.parseColor(bgColorHex))
            cornerRadius = Scale.px(context, 0.012f)
            setStroke(Scale.px(context, 0.0015f).toInt().coerceAtLeast(1), Color.parseColor(strokeColorHex))
        }
    }

    private fun formatIsoTime(isoStr: String): String {
        return try {
            val sdfInput = SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss", Locale.US)
            val sdfOutput = SimpleDateFormat("HH:mm", Locale.US)
            val clean = if (isoStr.contains(".")) isoStr.substringBefore('.') else isoStr.trimEnd('Z')
            val date = sdfInput.parse(clean)
            if (date != null) sdfOutput.format(date) else isoStr
        } catch (e: Exception) {
            isoStr
        }
    }
}
