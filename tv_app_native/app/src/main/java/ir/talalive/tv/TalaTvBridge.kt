package ir.talalive.tv

import android.webkit.JavascriptInterface

class TalaTvBridge(private val host: BoardActivity) {

    @JavascriptInterface
    fun onBoardReady() {
        host.runOnUiThread { host.markBoardReady() }
    }

    @JavascriptInterface
    fun onPriceTick(updatedAt: String, isStale: Int) {
        host.runOnUiThread { host.markPriceTick(updatedAt, isStale == 1) }
    }
}
