package ir.talalive.tv

import android.annotation.TargetApi
import android.net.http.SslError
import android.os.Build
import android.util.Log
import android.webkit.RenderProcessGoneDetail
import android.webkit.SslErrorHandler
import android.webkit.WebResourceError
import android.webkit.WebResourceRequest
import android.webkit.WebView
import android.webkit.WebViewClient

class TalaWebViewClient(private val host: BoardActivity) : WebViewClient() {
    private val tag = "TalaTV.Client"

    @TargetApi(Build.VERSION_CODES.M)
    override fun onReceivedError(view: WebView, request: WebResourceRequest?, error: WebResourceError?) {
        if (request == null || request.isForMainFrame) {
            Log.w(tag, "Main frame error: ${error?.errorCode}")
            host.showOfflineOverlay()
        }
    }

    @Deprecated("Deprecated in Java")
    @Suppress("DEPRECATION", "OVERRIDE_DEPRECATION")
    override fun onReceivedError(view: WebView, errorCode: Int, description: String?, failingUrl: String?) {
        Log.w(tag, "Legacy onReceivedError: $errorCode for $failingUrl")
        host.showOfflineOverlay()
    }

    override fun onReceivedSslError(view: WebView, handler: SslErrorHandler, error: SslError) {
        Log.w(tag, "SSL error ${error.primaryError} on ${error.url ?: view.url}")
        handler.cancel()
        host.showSslDiagnostic(error)
    }

    override fun onPageFinished(view: WebView, url: String) {
        super.onPageFinished(view, url)
        host.onPageLoadFinished()
    }

    @TargetApi(Build.VERSION_CODES.O)
    override fun onRenderProcessGone(view: WebView, detail: RenderProcessGoneDetail): Boolean {
        Log.e(tag, "Render process gone: didCrash=${detail.didCrash()}")
        host.recreateWebView(fromRenderCrash = true)
        return true
    }
}
