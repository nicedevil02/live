package ir.talalive.tv

import android.app.Activity
import android.app.AlertDialog
import android.content.Context
import android.content.Intent
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.graphics.Color
import android.graphics.Typeface
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.text.InputType
import android.util.Log
import android.util.TypedValue
import android.view.Gravity
import android.view.View
import android.view.WindowManager
import android.webkit.WebSettings
import android.widget.*
import java.net.HttpURLConnection
import java.net.URL
import java.util.concurrent.Executors
import java.util.regex.Pattern

class PairingActivity : Activity() {
    private val tag = "TalaTV.Pairing"
    private val executor = Executors.newSingleThreadExecutor()
    private val handler = Handler(Looper.getMainLooper())

    private var currentSessionCode: String? = null
    private var currentActivationCode: String? = null
    private var pollIntervalSec = 3
    private var isPolling = false
    private var isDestroyedActivity = false

    private lateinit var tvCode: TextView
    private lateinit var tvStatus: TextView
    private lateinit var ivQr: ImageView
    private lateinit var btnSms: Button
    private lateinit var progressBar: ProgressBar
    private lateinit var tvFooter: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        // بررسی اتصال قبلی
        if (TvPrefs.isPaired(this)) {
            startActivity(Intent(this, BoardActivity::class.java))
            finish()
            return
        }

        window.addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)
        hideSystemUi()

        buildNativeUi()
        fetchNewSession()
    }

    override fun onResume() {
        super.onResume()
        hideSystemUi()
        if (TvPrefs.isPaired(this)) {
            startActivity(Intent(this, BoardActivity::class.java))
            finish()
            return
        }
        if (!isPolling && currentSessionCode != null) {
            startPolling()
        }
    }

    override fun onPause() {
        super.onPause()
        stopPolling()
    }

    override fun onDestroy() {
        super.onDestroy()
        isDestroyedActivity = true
        stopPolling()
    }

    @Suppress("DEPRECATION")
    private fun hideSystemUi() {
        window.decorView.systemUiVisibility = (
            View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY
            or View.SYSTEM_UI_FLAG_LAYOUT_STABLE
            or View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
            or View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN
            or View.SYSTEM_UI_FLAG_HIDE_NAVIGATION
            or View.SYSTEM_UI_FLAG_FULLSCREEN
        )
    }

    private fun buildNativeUi() {
        val root = FrameLayout(this).apply {
            setBackgroundColor(Color.parseColor("#020617"))
            setPadding(dp(32), dp(24), dp(32), dp(24))
        }

        val scroll = ScrollView(this).apply {
            isFillViewport = true
        }

        val content = LinearLayout(this).apply {
            orientation = LinearLayout.VERTICAL
            gravity = Gravity.CENTER_HORIZONTAL
        }

        // 1. عنوان برنامه
        val tvAppTitle = TextView(this).apply {
            text = getString(R.string.app_name)
            setTextColor(Color.parseColor("#F59E0B"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 36f)
            typeface = Typeface.DEFAULT_BOLD
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(8))
        }
        content.addView(tvAppTitle)

        // 2. توضیحات اتصال
        val tvDesc = TextView(this).apply {
            text = getString(R.string.pairing_desc)
            setTextColor(Color.parseColor("#94A3B8"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(24))
        }
        content.addView(tvDesc)

        // 3. کادر کد فعال‌سازی
        val codeBox = FrameLayout(this).apply {
            setBackgroundColor(Color.parseColor("#0F172A"))
            setPadding(dp(36), dp(16), dp(36), dp(16))
            val lp = LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.WRAP_CONTENT,
                LinearLayout.LayoutParams.WRAP_CONTENT
            ).apply {
                gravity = Gravity.CENTER_HORIZONTAL
                bottomMargin = dp(20)
            }
            layoutParams = lp
        }

        tvCode = TextView(this).apply {
            text = "------"
            setTextColor(Color.parseColor("#FDE68A"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 56f)
            typeface = Typeface.MONOSPACE
            gravity = Gravity.CENTER
            letterSpacing = 0.25f
        }
        codeBox.addView(tvCode)
        content.addView(codeBox)

        // 4. نوار وضعیت و لودینگ
        val statusLayout = LinearLayout(this).apply {
            orientation = LinearLayout.HORIZONTAL
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(16))
        }
        progressBar = ProgressBar(this).apply {
            val lp = LinearLayout.LayoutParams(dp(24), dp(24)).apply { rightMargin = dp(12) }
            layoutParams = lp
        }
        tvStatus = TextView(this).apply {
            text = getString(R.string.pairing_waiting)
            setTextColor(Color.parseColor("#64748B"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 14f)
        }
        statusLayout.addView(progressBar)
        statusLayout.addView(tvStatus)
        content.addView(statusLayout)

        // 5. بخش QR Code و دکمه پیامک
        val actionsRow = LinearLayout(this).apply {
            orientation = LinearLayout.HORIZONTAL
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(20))
        }

        ivQr = ImageView(this).apply {
            val lp = LinearLayout.LayoutParams(dp(130), dp(130)).apply {
                rightMargin = dp(28)
            }
            layoutParams = lp
            setBackgroundColor(Color.WHITE)
            visibility = View.GONE
        }
        actionsRow.addView(ivQr)

        btnSms = Button(this).apply {
            text = getString(R.string.btn_send_sms)
            setBackgroundColor(Color.parseColor("#F59E0B"))
            setTextColor(Color.parseColor("#020617"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
            typeface = Typeface.DEFAULT_BOLD
            setPadding(dp(24), dp(14), dp(24), dp(14))
            isFocusable = true
            isFocusableInTouchMode = true
            setOnClickListener { showMobileInputDialog() }
        }
        actionsRow.addView(btnSms)
        content.addView(actionsRow)

        // 6. فوتر مشخصات
        val pInfo = try { packageManager.getPackageInfo(packageName, 0) } catch (e: Exception) { null }
        val appVer = pInfo?.versionName ?: "1.0.0"
        val webViewUa = try { WebSettings.getDefaultUserAgent(this) } catch (e: Exception) { "Unknown" }
        val chromeVer = extractChromeVersion(webViewUa)
        tvFooter = TextView(this).apply {
            text = "TalaLive TV v$appVer · WebView: $chromeVer"
            setTextColor(Color.parseColor("#475569"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 12f)
            gravity = Gravity.CENTER
            setPadding(0, dp(16), 0, 0)
        }
        content.addView(tvFooter)

        scroll.addView(content)
        root.addView(scroll)
        setContentView(root)

        btnSms.requestFocus()
    }

    private fun extractChromeVersion(ua: String): String {
        val p = Pattern.compile("Chrome/([0-9]+)")
        val m = p.matcher(ua)
        return if (m.find()) m.group(1) ?: "Unknown" else "Unknown"
    }

    private fun fetchNewSession() {
        progressBar.visibility = View.VISIBLE
        tvStatus.text = getString(R.string.pairing_waiting)

        executor.execute {
            val result = Api.registerSession(this)
            handler.post {
                if (isDestroyedActivity) return@post
                progressBar.visibility = View.GONE
                if (result != null) {
                    currentSessionCode = result.sessionCode
                    currentActivationCode = result.activationCode
                    pollIntervalSec = result.pollIntervalSeconds
                    tvCode.text = result.activationCode

                    loadQrCode(result.activationCode)
                    startPolling()

                    // بازانقضا: پس از پایان زمان سشن، خودکار کد جدید بگیرد
                    handler.postDelayed({
                        if (!isDestroyedActivity && !TvPrefs.isPaired(this)) {
                            fetchNewSession()
                        }
                    }, (result.expiresInSeconds * 1000L).coerceAtLeast(30000L))
                } else {
                    tvStatus.text = "خطا در اتصال به سرور طلالایو. تلاش مجدد..."
                    handler.postDelayed({ fetchNewSession() }, 5000)
                }
            }
        }
    }

    private fun loadQrCode(code: String) {
        val base = Config.baseUrls(this)[0]
        val qrImgUrl = "$base/api/tv/qr/$code"

        executor.execute {
            try {
                val conn = URL(qrImgUrl).openConnection() as HttpURLConnection
                conn.connectTimeout = 5000
                conn.readTimeout = 5000
                conn.doInput = true
                conn.connect()
                if (conn.responseCode == 200) {
                    val bitmap = BitmapFactory.decodeStream(conn.inputStream)
                    if (bitmap != null) {
                        handler.post {
                            if (!isDestroyedActivity) {
                                ivQr.setImageBitmap(bitmap)
                                ivQr.visibility = View.VISIBLE
                            }
                        }
                    }
                }
            } catch (e: Exception) {
                Log.w(tag, "Local QR fetch failed: ${e.message}")
            }
        }
    }

    private val pollRunnable: Runnable = object : Runnable {
        override fun run() {
            val sCode = currentSessionCode ?: return
            executor.execute {
                val res = Api.checkPairing(this@PairingActivity, sCode)
                handler.post {
                    if (isDestroyedActivity) return@post
                    if (res != null && res.paired && !res.username.isNullOrBlank() && !res.deviceToken.isNullOrBlank()) {
                        Log.i(tag, "Device successfully paired with user ${res.username}")
                        stopPolling()
                        TvPrefs.savePairing(this@PairingActivity, res.username, res.deviceToken, null)
                        startActivity(Intent(this@PairingActivity, BoardActivity::class.java))
                        finish()
                    } else {
                        if (isPolling) {
                            val interval = (res?.pollIntervalSeconds ?: pollIntervalSec).coerceAtLeast(2)
                            handler.postDelayed(this@PairingActivity.pollRunnable, interval * 1000L)
                        }
                    }
                }
            }
        }
    }

    private fun startPolling() {
        stopPolling()
        isPolling = true
        handler.post(pollRunnable)
    }

    private fun stopPolling() {
        isPolling = false
        handler.removeCallbacks(pollRunnable)
    }

    private fun showMobileInputDialog() {
        val sCode = currentSessionCode
        if (sCode.isNullOrBlank()) {
            Toast.makeText(this, "لطفاً تا دریافت کد منتظر بمانید", Toast.LENGTH_SHORT).show()
            return
        }

        val input = EditText(this).apply {
            inputType = InputType.TYPE_CLASS_PHONE
            hint = getString(R.string.enter_mobile_hint)
            gravity = Gravity.CENTER
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 22f)
            setTextColor(Color.WHITE)
            setHintTextColor(Color.parseColor("#64748B"))
            setPadding(dp(16), dp(16), dp(16), dp(16))
            setBackgroundColor(Color.parseColor("#1E293B"))
        }

        val container = FrameLayout(this).apply {
            setPadding(dp(24), dp(16), dp(24), dp(8))
            addView(input)
        }

        val dialog = AlertDialog.Builder(this)
            .setTitle(getString(R.string.enter_mobile_title))
            .setView(container)
            .setPositiveButton(getString(R.string.btn_confirm)) { _, _ ->
                val mobile = input.text.toString().trim()
                sendSms(sCode, mobile)
            }
            .setNegativeButton(getString(R.string.btn_cancel), null)
            .create()

        dialog.show()
        input.requestFocus()
    }

    private fun sendSms(sessionCode: String, mobile: String) {
        val cleanMobile = mobile.replace("[^0-9]".toRegex(), "")
        if (cleanMobile.length != 11 || !cleanMobile.startsWith("09")) {
            Toast.makeText(this, "شماره موبایل باید ۱۱ رقم بوده و با ۰۹ شروع شود", Toast.LENGTH_LONG).show()
            return
        }

        progressBar.visibility = View.VISIBLE
        executor.execute {
            val res = Api.requestMagicSms(this, sessionCode, cleanMobile)
            handler.post {
                progressBar.visibility = View.GONE
                if (res.success) {
                    Toast.makeText(this, getString(R.string.sms_sent_success), Toast.LENGTH_LONG).show()
                } else {
                    Toast.makeText(this, res.message.ifBlank { getString(R.string.sms_failed) }, Toast.LENGTH_LONG).show()
                }
            }
        }
    }

    private fun dp(v: Int): Int {
        return (v * resources.displayMetrics.density + 0.5f).toInt()
    }
}
