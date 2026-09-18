package ir.talalive.tv

import android.annotation.TargetApi
import android.app.Activity
import android.app.AlertDialog
import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.content.IntentFilter
import android.graphics.Color
import android.graphics.Typeface
import android.net.ConnectivityManager
import android.net.Network
import android.net.NetworkCapabilities
import android.net.NetworkRequest
import android.net.http.SslError
import android.os.Build
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.util.Log
import android.util.TypedValue
import android.view.Gravity
import android.view.KeyEvent
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import android.webkit.WebSettings
import android.webkit.WebView
import android.widget.*
import java.text.SimpleDateFormat
import java.util.Calendar
import java.util.Date
import java.util.Locale
import java.util.concurrent.Executors
import java.util.regex.Pattern

class BoardActivity : Activity() {
    private val tag = "TalaTV.Board"
    private val executor = Executors.newSingleThreadExecutor()
    private val handler = Handler(Looper.getMainLooper())

    private lateinit var rootContainer: FrameLayout
    private var webView: WebView? = null
    private lateinit var offlineOverlay: LinearLayout
    private lateinit var tvOfflineRate: TextView
    private lateinit var tvOfflineCountdown: TextView
    private lateinit var diagnosticOverlay: LinearLayout
    private lateinit var tvDiagTitle: TextView
    private lateinit var tvDiagDesc: TextView
    private lateinit var btnDiagAction: Button

    private lateinit var updateOverlay: LinearLayout
    private lateinit var tvUpdateTitle: TextView
    private lateinit var tvUpdateStatus: TextView
    private lateinit var btnUpdateInstall: Button
    private var isUpdating = false

    private var isBoardReady = false
    private var lastTickTime = 0L
    private var backPressedTime = 0L
    private var okKeyDownTime = 0L
    private var isOkLongPressHandled = false
    private var retryCount = 0
    private var retryCountdownSec = 5
    private var isDestroyedActivity = false

    private val readyWatchdogRunnable = Runnable {
        if (!isBoardReady) {
            Log.w(tag, "Board ready timeout (25s) elapsed without onBoardReady call")
            showDiagnostic(
                getString(R.string.webview_outdated_title, getChromeVersion()),
                getString(R.string.webview_outdated_desc),
                getString(R.string.btn_try_anyway)
            ) {
                hideDiagnostic()
                recreateWebView()
            }
        }
    }

    private val tickWatchdogRunnable = object : Runnable {
        override fun run() {
            if (isBoardReady && lastTickTime > 0) {
                val elapsed = System.currentTimeMillis() - lastTickTime
                if (elapsed > 300_000L) { // 5 دقیقه
                    Log.w(tag, "No price tick in 5 minutes. Recreating webview.")
                    recreateWebView()
                }
            }
            handler.postDelayed(this, 60_000L)
        }
    }

    private var isRevokedDialogShown = false
    private var currentHeartbeatIntervalMs = 30_000L
    private val heartbeatRunnable = object : Runnable {
        override fun run() {
            performHeartbeat()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        handleIntent(intent)

        if (!TvPrefs.isPaired(this)) {
            startActivity(Intent(this, PairingActivity::class.java))
            finish()
            return
        }

        window.addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)
        hideSystemUi()

        buildViews()
        initAndLoadWebView()

        setupNetworkMonitoring()
        scheduleDailyReload()
        handler.postDelayed(tickWatchdogRunnable, 60_000L)
        handler.post(heartbeatRunnable)
    }

    override fun onNewIntent(newIntent: Intent?) {
        super.onNewIntent(newIntent)
        setIntent(newIntent)
        handleIntent(newIntent)

        if (BuildConfig.DEBUG) {
            if (newIntent?.getBooleanExtra("clear_pairing", false) == true) {
                TvPrefs.clearPairing(this)
                startActivity(Intent(this, PairingActivity::class.java))
                finish()
                return
            }

            if (newIntent?.getBooleanExtra("test_offline", false) == true) {
                showOfflineOverlay()
            } else if (newIntent?.getBooleanExtra("test_recreate", false) == true) {
                recreateWebView()
            } else if (newIntent?.getBooleanExtra("test_ssl_diag", false) == true) {
                showDiagnostic(
                    getString(R.string.ssl_error_title),
                    getString(R.string.ssl_error_desc, "1970/01/01 00:00", "1405/06/27 12:00"),
                    getString(R.string.menu_reload)
                ) {
                    recreateWebView()
                }
            } else if (newIntent?.hasExtra("test_min_chrome") == true) {
                val minChrome = newIntent.getIntExtra("test_min_chrome", 80)
                val cur = getChromeVersionInt()
                if (cur < minChrome) {
                    showDiagnostic(
                        getString(R.string.webview_outdated_title, cur.toString()),
                        getString(R.string.webview_outdated_desc),
                        getString(R.string.btn_try_anyway)
                    ) {
                        hideDiagnostic()
                        initAndLoadWebView()
                    }
                }
            } else if (newIntent?.hasExtra("pair_board_url") == true) {
                recreateWebView()
            }
        }
    }

    private fun handleIntent(inIntent: Intent?) {
        if (!BuildConfig.DEBUG || inIntent == null) return
        if (inIntent.getBooleanExtra("clear_pairing", false)) {
            TvPrefs.clearPairing(this)
            return
        }
        val pairUrl = inIntent.getStringExtra("pair_board_url")
        val token = inIntent.getStringExtra("pair_token")
        if (!pairUrl.isNullOrBlank() && !token.isNullOrBlank()) {
            val user = inIntent.getStringExtra("pair_username") ?: "tv_demo"
            TvPrefs.savePairing(this, user, token, pairUrl)
        }
    }

    override fun onResume() {
        super.onResume()
        hideSystemUi()
        webView?.onResume()
    }

    override fun onPause() {
        super.onPause()
        webView?.onPause()
    }

    override fun onDestroy() {
        super.onDestroy()
        isDestroyedActivity = true
        handler.removeCallbacksAndMessages(null)
        destroyCurrentWebView()
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

    private fun buildViews() {
        rootContainer = FrameLayout(this).apply {
            setBackgroundColor(Color.parseColor("#020617"))
            layoutParams = ViewGroup.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.MATCH_PARENT
            )
        }

        buildOfflineOverlay()
        buildDiagnosticOverlay()
        buildUpdateOverlay()

        setContentView(rootContainer)
    }

    private fun buildUpdateOverlay() {
        updateOverlay = LinearLayout(this).apply {
            orientation = LinearLayout.VERTICAL
            gravity = Gravity.CENTER
            setBackgroundColor(Color.parseColor("#F5020617"))
            visibility = View.GONE
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
        }

        tvUpdateTitle = TextView(this).apply {
            text = getString(R.string.update_mandatory_title)
            setTextColor(Color.parseColor("#EAB308"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 28f)
            typeface = Typeface.DEFAULT_BOLD
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(16))
        }

        tvUpdateStatus = TextView(this).apply {
            text = ""
            setTextColor(Color.parseColor("#E2E8F0"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 20f)
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(24))
        }

        btnUpdateInstall = Button(this).apply {
            text = getString(R.string.update_btn_install)
            setBackgroundColor(Color.parseColor("#CA8A04"))
            setTextColor(Color.BLACK)
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 20f)
            typeface = Typeface.DEFAULT_BOLD
            setPadding(dp(32), dp(12), dp(32), dp(12))
            isFocusable = true
            visibility = View.GONE
        }

        updateOverlay.addView(tvUpdateTitle)
        updateOverlay.addView(tvUpdateStatus)
        updateOverlay.addView(btnUpdateInstall)
        rootContainer.addView(updateOverlay)
    }

    private fun buildOfflineOverlay() {
        offlineOverlay = LinearLayout(this).apply {
            orientation = LinearLayout.VERTICAL
            gravity = Gravity.CENTER
            setBackgroundColor(Color.parseColor("#E6020617"))
            visibility = View.GONE
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
        }

        val tvTitle = TextView(this).apply {
            text = getString(R.string.offline_title)
            setTextColor(Color.parseColor("#EF4444"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 32f)
            typeface = Typeface.DEFAULT_BOLD
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(16))
        }
        offlineOverlay.addView(tvTitle)

        tvOfflineRate = TextView(this).apply {
            text = getString(R.string.offline_last_rate, TvPrefs.getLastRateTime(this@BoardActivity))
            setTextColor(Color.parseColor("#FDE68A"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 22f)
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(12))
        }
        offlineOverlay.addView(tvOfflineRate)

        tvOfflineCountdown = TextView(this).apply {
            text = getString(R.string.offline_retry_countdown, 5)
            setTextColor(Color.parseColor("#94A3B8"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
            gravity = Gravity.CENTER
        }
        offlineOverlay.addView(tvOfflineCountdown)

        rootContainer.addView(offlineOverlay)
    }

    private fun buildDiagnosticOverlay() {
        diagnosticOverlay = LinearLayout(this).apply {
            orientation = LinearLayout.VERTICAL
            gravity = Gravity.CENTER
            setBackgroundColor(Color.parseColor("#F0020617"))
            visibility = View.GONE
            setPadding(dp(48), dp(32), dp(48), dp(32))
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
        }

        tvDiagTitle = TextView(this).apply {
            setTextColor(Color.parseColor("#F59E0B"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 28f)
            typeface = Typeface.DEFAULT_BOLD
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(16))
        }
        diagnosticOverlay.addView(tvDiagTitle)

        tvDiagDesc = TextView(this).apply {
            setTextColor(Color.parseColor("#E2E8F0"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
            gravity = Gravity.CENTER
            setPadding(0, 0, 0, dp(24))
        }
        diagnosticOverlay.addView(tvDiagDesc)

        btnDiagAction = Button(this).apply {
            setBackgroundColor(Color.parseColor("#F59E0B"))
            setTextColor(Color.parseColor("#020617"))
            setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
            typeface = Typeface.DEFAULT_BOLD
            setPadding(dp(32), dp(12), dp(32), dp(12))
            isFocusable = true
        }
        diagnosticOverlay.addView(btnDiagAction)

        rootContainer.addView(diagnosticOverlay)
    }

    private fun initAndLoadWebView() {
        destroyCurrentWebView()

        val wv = WebView(this).apply {
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
            setBackgroundColor(Color.parseColor("#020617"))
            isVerticalScrollBarEnabled = false
            isHorizontalScrollBarEnabled = false

            settings.apply {
                javaScriptEnabled = true
                domStorageEnabled = true
                databaseEnabled = true
                allowFileAccess = true
                allowContentAccess = true
                loadsImagesAutomatically = true
                mediaPlaybackRequiresUserGesture = false
                cacheMode = WebSettings.LOAD_DEFAULT
                useWideViewPort = true
                loadWithOverviewMode = true
                setSupportZoom(false)
                builtInZoomControls = false
                displayZoomControls = false
                textZoom = 100
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                    mixedContentMode = WebSettings.MIXED_CONTENT_ALWAYS_ALLOW
                }
                userAgentString = "Mozilla/5.0 (Linux; Android 10; SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 TalaLiveTV/1.0"
            }

            setLayerType(View.LAYER_TYPE_HARDWARE, null)

            webViewClient = TalaWebViewClient(this@BoardActivity)
            addJavascriptInterface(TalaTvBridge(this@BoardActivity), "TalaTV")
        }

        webView = wv
        rootContainer.addView(wv, 0)

        loadBoardUrl()
    }

    private fun loadBoardUrl() {
        val customBoardUrl = TvPrefs.getBoardUrl(this)
        val targetUrl = if (!customBoardUrl.isNullOrBlank()) {
            customBoardUrl
        } else {
            val username = TvPrefs.getUsername(this) ?: "admin"
            val base = Config.baseUrls(this)[0]
            "$base/$username?tv=1"
        }

        Log.i(tag, "Loading board URL: $targetUrl")
        isBoardReady = false
        handler.removeCallbacks(readyWatchdogRunnable)
        webView?.loadUrl(targetUrl)
    }

    private fun destroyCurrentWebView() {
        webView?.let { wv ->
            rootContainer.removeView(wv)
            wv.stopLoading()
            wv.clearHistory()
            wv.removeAllViews()
            wv.destroy()
        }
        webView = null
    }

    fun recreateWebView() {
        runOnUiThread {
            Log.i(tag, "Recreating WebView instance")
            hideOfflineOverlay()
            hideDiagnostic()
            initAndLoadWebView()
        }
    }

    fun onPageLoadFinished() {
        Log.i(tag, "onPageLoadFinished received. Starting 25s watchdog.")
        handler.removeCallbacks(readyWatchdogRunnable)
        handler.postDelayed(readyWatchdogRunnable, 25_000L)
    }

    fun markBoardReady() {
        Log.i(tag, "TalaTV.onBoardReady signal received! Board successfully rendered.")
        isBoardReady = true
        handler.removeCallbacks(readyWatchdogRunnable)
        hideOfflineOverlay()
        hideDiagnostic()
    }

    fun markPriceTick(updatedAt: String, isStale: Boolean) {
        lastTickTime = System.currentTimeMillis()
        if (updatedAt.isNotBlank()) {
            TvPrefs.updateTick(this, updatedAt)
        }
        if (isBoardReady) {
            hideOfflineOverlay()
        }
    }

    fun showOfflineOverlay() {
        runOnUiThread {
            hideDiagnostic()
            tvOfflineRate.text = getString(R.string.offline_last_rate, TvPrefs.getLastRateTime(this))
            offlineOverlay.visibility = View.VISIBLE

            retryCount++
            retryCountdownSec = when {
                retryCount <= 2 -> 5
                retryCount <= 4 -> 10
                retryCount <= 6 -> 20
                else -> 60
            }

            startCountdownAndRetry()
        }
    }

    fun hideOfflineOverlay() {
        runOnUiThread {
            offlineOverlay.visibility = View.GONE
            retryCount = 0
        }
    }

    private fun startCountdownAndRetry() {
        handler.removeCallbacks(countdownRunnable)
        handler.post(countdownRunnable)
    }

    private val countdownRunnable = object : Runnable {
        override fun run() {
            if (offlineOverlay.visibility != View.VISIBLE) return
            if (retryCountdownSec > 0) {
                tvOfflineCountdown.text = getString(R.string.offline_retry_countdown, retryCountdownSec)
                retryCountdownSec--
                handler.postDelayed(this, 1000L)
            } else {
                tvOfflineCountdown.text = "در حال اتصال مجدد..."
                loadBoardUrl()
            }
        }
    }

    fun showSslDiagnostic(error: SslError) {
        val cert = error.certificate
        val notBefore = cert?.validNotBeforeDate
        val notAfter = cert?.validNotAfterDate
        val deviceEpoch = System.currentTimeMillis()

        val isDateInvalid = error.hasError(SslError.SSL_DATE_INVALID) ||
                (notBefore != null && deviceEpoch < notBefore.time) ||
                (notAfter != null && deviceEpoch > notAfter.time)

        if (isDateInvalid) {
            val sdf = SimpleDateFormat("yyyy/MM/dd HH:mm", Locale.US)
            val devDate = sdf.format(Date(deviceEpoch))
            val srvDate = if (notBefore != null) sdf.format(notBefore) else "نامشخص"

            showDiagnostic(
                getString(R.string.ssl_error_title),
                getString(R.string.ssl_error_desc, devDate, srvDate),
                getString(R.string.menu_reload)
            ) {
                recreateWebView()
            }
            return
        }

        showDiagnostic(
            "خطای گواهی امنیتی SSL",
            "امکان برقراری ارتباط امن با سرور مقدور نیست (کد خطا: ${error.primaryError}).",
            getString(R.string.menu_reload)
        ) {
            recreateWebView()
        }
    }

    fun showDiagnostic(title: String, desc: String, btnText: String, onAction: () -> Unit) {
        runOnUiThread {
            tvDiagTitle.text = title
            tvDiagDesc.text = desc
            btnDiagAction.text = btnText
            btnDiagAction.setOnClickListener { onAction() }
            diagnosticOverlay.visibility = View.VISIBLE
            btnDiagAction.requestFocus()
        }
    }

    fun hideDiagnostic() {
        runOnUiThread {
            diagnosticOverlay.visibility = View.GONE
        }
    }

    private fun getChromeVersion(): String {
        val ua = try { WebSettings.getDefaultUserAgent(this) } catch (e: Exception) { "" }
        val p = Pattern.compile("Chrome/([0-9]+)")
        val m = p.matcher(ua)
        return if (m.find()) m.group(1) ?: "Unknown" else "Unknown"
    }

    private fun getChromeVersionInt(): Int {
        val v = getChromeVersion()
        return v.toIntOrNull() ?: 0
    }

    private fun setupNetworkMonitoring() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            val cm = getSystemService(Context.CONNECTIVITY_SERVICE) as? ConnectivityManager
            val request = NetworkRequest.Builder()
                .addCapability(NetworkCapabilities.NET_CAPABILITY_INTERNET)
                .build()

            cm?.registerNetworkCallback(request, object : ConnectivityManager.NetworkCallback() {
                override fun onAvailable(network: Network) {
                    Log.i(tag, "Network restored via NetworkCallback. Reloading board.")
                    runOnUiThread {
                        if (offlineOverlay.visibility == View.VISIBLE) {
                            hideOfflineOverlay()
                            loadBoardUrl()
                        }
                    }
                }
            })
        } else {
            val filter = IntentFilter(ConnectivityManager.CONNECTIVITY_ACTION)
            registerReceiver(object : BroadcastReceiver() {
                override fun onReceive(context: Context?, intent: Intent?) {
                    val cm = getSystemService(Context.CONNECTIVITY_SERVICE) as? ConnectivityManager
                    val net = cm?.activeNetworkInfo
                    if (net != null && net.isConnected) {
                        if (offlineOverlay.visibility == View.VISIBLE) {
                            hideOfflineOverlay()
                            loadBoardUrl()
                        }
                    }
                }
            }, filter)
        }
    }

    private fun scheduleDailyReload() {
        // محاسبه زمان ۴:۰۰ بامداد بعدی
        val now = Calendar.getInstance()
        val target = Calendar.getInstance().apply {
            set(Calendar.HOUR_OF_DAY, 4)
            set(Calendar.MINUTE, 0)
            set(Calendar.SECOND, 0)
            set(Calendar.MILLISECOND, 0)
            if (before(now)) {
                add(Calendar.DAY_OF_YEAR, 1)
            }
        }
        val delay = target.timeInMillis - now.timeInMillis
        handler.postDelayed({
            Log.i(tag, "4:00 AM Scheduled Reload triggered")
            val pendingUpdate = UpdateManager.getUpdateApkFile(this)
            if (pendingUpdate.exists() && UpdateManager.validateApk(this, pendingUpdate)) {
                Log.i(tag, "Applying validated pending update at 4:00 AM")
                UpdateManager.installApk(this, pendingUpdate)
            } else {
                recreateWebView()
            }
            scheduleDailyReload() // برای روز بعد
        }, delay)
    }

    override fun onTrimMemory(level: Int) {
        super.onTrimMemory(level)
        if (level >= TRIM_MEMORY_RUNNING_CRITICAL) {
            Log.w(tag, "TRIM_MEMORY_RUNNING_CRITICAL reached, clearing webview cache")
            webView?.clearCache(false)
        }
    }

    private fun performHeartbeat() {
        val token = TvPrefs.getDeviceToken(this)
        if (token == null) {
            handler.removeCallbacks(heartbeatRunnable)
            handler.postDelayed(heartbeatRunnable, currentHeartbeatIntervalMs)
            return
        }
        val verCode = UpdateManager.getCurrentVersionCode(this)
        val androidRel = Build.VERSION.RELEASE ?: "Unknown"
        val webViewVer = getChromeVersion()

        executor.execute {
            val hb = Api.heartbeat(this, token, verCode, androidRel, webViewVer)
            handler.post {
                try {
                    if (hb != null) {
                        if (hb.revoked) {
                            Log.w(tag, "Device revoked from admin panel!")
                            isRevokedDialogShown = true
                            currentHeartbeatIntervalMs = 15_000L
                            try {
                                webView?.stopLoading()
                                webView?.loadUrl("about:blank")
                            } catch (e: Exception) {
                                Log.e(tag, "Error stopping webview on revocation", e)
                            }
                            showDiagnostic(
                                getString(R.string.device_revoked_title),
                                getString(R.string.device_revoked_desc),
                                getString(R.string.btn_get_new_code)
                            ) {
                                TvPrefs.clearPairing(this)
                                startActivity(Intent(this, PairingActivity::class.java))
                                finish()
                            }
                        } else {
                            if (isRevokedDialogShown) {
                                Log.i(tag, "Device re-activated from panel! Restoring board.")
                                isRevokedDialogShown = false
                                hideDiagnostic()
                                loadBoardUrl()
                            }
                            if (hb.intervalSeconds > 0) {
                                currentHeartbeatIntervalMs = (hb.intervalSeconds.coerceIn(10, 900)) * 1000L
                            }
                            TvPrefs.saveHeartbeat(
                                this,
                                hb.boardUrl,
                                hb.baseUrlsJson,
                                hb.latestVersionCode,
                                hb.minVersionCode,
                                hb.apkUrl
                            )

                            val curVer = UpdateManager.getCurrentVersionCode(this)
                            val latestVer = hb.latestVersionCode
                            val minVer = hb.minVersionCode
                            val apkUrl = hb.apkUrl

                            if (latestVer > curVer && !apkUrl.isNullOrBlank() && !isUpdating) {
                                if (curVer < minVer) {
                                    triggerMandatoryUpdate(apkUrl, latestVer)
                                } else {
                                    triggerOptionalUpdate(apkUrl, latestVer)
                                }
                            }
                        }
                    }
                } finally {
                    if (!isDestroyedActivity) {
                        handler.removeCallbacks(heartbeatRunnable)
                        handler.postDelayed(heartbeatRunnable, currentHeartbeatIntervalMs)
                    }
                }
            }
        }
    }

    private fun triggerMandatoryUpdate(apkUrl: String, newVer: Int) {
        isUpdating = true
        runOnUiThread {
            updateOverlay.visibility = View.VISIBLE
            tvUpdateStatus.text = getString(R.string.update_downloading, 0)
            btnUpdateInstall.visibility = View.GONE
        }

        executor.execute {
            val file = UpdateManager.downloadApk(this, apkUrl) { pct ->
                runOnUiThread {
                    tvUpdateStatus.text = getString(R.string.update_downloading, pct)
                }
            }

            if (file != null && UpdateManager.validateApk(this, file)) {
                runOnUiThread {
                    tvUpdateStatus.text = getString(R.string.update_ready_notice)
                    btnUpdateInstall.visibility = View.VISIBLE
                    btnUpdateInstall.setOnClickListener {
                        UpdateManager.installApk(this, file)
                    }
                    btnUpdateInstall.requestFocus()
                    UpdateManager.installApk(this, file)
                }
            } else {
                runOnUiThread {
                    tvUpdateStatus.text = getString(R.string.update_failed)
                    isUpdating = false
                    handler.postDelayed({
                        updateOverlay.visibility = View.GONE
                    }, 10000L)
                }
            }
        }
    }

    private fun triggerOptionalUpdate(apkUrl: String, newVer: Int) {
        val existing = UpdateManager.getUpdateApkFile(this)
        if (existing.exists() && UpdateManager.validateApk(this, existing)) {
            return
        }

        executor.execute {
            val file = UpdateManager.downloadApk(this, apkUrl) { _ -> }
            if (file != null && UpdateManager.validateApk(this, file)) {
                Log.i(tag, "Optional update downloaded and validated. Ready for nightly restart.")
            }
        }
    }

    override fun onKeyDown(keyCode: Int, event: KeyEvent?): Boolean {
        // دکمه بازگشت (Back)
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            val now = System.currentTimeMillis()
            if (now - backPressedTime < 3000L) {
                finishAffinity()
            } else {
                backPressedTime = now
                Toast.makeText(this, getString(R.string.remote_back_exit_toast), Toast.LENGTH_SHORT).show()
            }
            return true
        }

        // دکمه منو
        if (keyCode == KeyEvent.KEYCODE_MENU) {
            showTvMenu()
            return true
        }

        // نگه داشتن کلید OK / DPAD_CENTER به مدت ۳ ثانیه
        if (keyCode == KeyEvent.KEYCODE_DPAD_CENTER || keyCode == KeyEvent.KEYCODE_ENTER) {
            if (event?.repeatCount == 0) {
                okKeyDownTime = System.currentTimeMillis()
                isOkLongPressHandled = false
            } else if (!isOkLongPressHandled && (System.currentTimeMillis() - okKeyDownTime) >= 2500L) {
                isOkLongPressHandled = true
                showTvMenu()
                return true
            }
        }

        return super.onKeyDown(keyCode, event)
    }

    override fun onKeyUp(keyCode: Int, event: KeyEvent?): Boolean {
        if (keyCode == KeyEvent.KEYCODE_DPAD_CENTER || keyCode == KeyEvent.KEYCODE_ENTER) {
            okKeyDownTime = 0L
            if (isOkLongPressHandled) {
                return true
            }
        }
        return super.onKeyUp(keyCode, event)
    }

    private fun showTvMenu() {
        val items = arrayOf(
            getString(R.string.menu_reload),
            getString(R.string.menu_device_info),
            getString(R.string.menu_disconnect)
        )

        AlertDialog.Builder(this)
            .setTitle(getString(R.string.menu_title))
            .setItems(items) { _, which ->
                when (which) {
                    0 -> recreateWebView()
                    1 -> showDeviceInfoDialog()
                    2 -> confirmDisconnect()
                }
            }
            .show()
    }

    private fun showDeviceInfoDialog() {
        val username = TvPrefs.getUsername(this) ?: "---"
        val pInfo = try { packageManager.getPackageInfo(packageName, 0) } catch (e: Exception) { null }
        val appVer = pInfo?.versionName ?: "1.0.0"
        val appCode = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            pInfo?.longVersionCode?.toInt() ?: 1
        } else {
            @Suppress("DEPRECATION")
            pInfo?.versionCode ?: 1
        }
        val wvVer = getChromeVersion()
        val lastRate = TvPrefs.getLastRateTime(this)

        val info = getString(R.string.device_info_format, username, appVer, appCode, wvVer, lastRate)

        AlertDialog.Builder(this)
            .setTitle(getString(R.string.menu_device_info))
            .setMessage(info)
            .setPositiveButton("بستن", null)
            .show()
    }

    private fun confirmDisconnect() {
        AlertDialog.Builder(this)
            .setTitle(getString(R.string.disconnect_confirm_title))
            .setMessage(getString(R.string.disconnect_confirm_desc))
            .setPositiveButton(getString(R.string.btn_disconnect_confirm)) { _, _ ->
                TvPrefs.clearPairing(this)
                startActivity(Intent(this, PairingActivity::class.java))
                finish()
            }
            .setNegativeButton(getString(R.string.btn_cancel), null)
            .show()
    }

    private fun dp(v: Int): Int {
        return (v * resources.displayMetrics.density + 0.5f).toInt()
    }
}
