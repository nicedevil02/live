package ir.talalive.tv

import android.content.Context
import android.util.Log
import java.net.HttpURLConnection
import java.net.URL

object SnapshotApi {
    private const val TAG = "TalaTV.Snapshot"

    fun fetch(ctx: Context, username: String): String? {
        if (username.isBlank()) {
            Log.w(TAG, "fetch aborted: username is blank")
            return null
        }

        for (base in Config.baseUrls(ctx)) {
            try {
                val urlStr = "$base/api/display/snapshot/$username"
                val conn = (URL(urlStr).openConnection() as HttpURLConnection).apply {
                    requestMethod = "GET"
                    connectTimeout = 8000
                    readTimeout = 8000
                    setRequestProperty("User-Agent", "TalaLiveTV/1.0 (Android)")
                    setRequestProperty("Accept", "application/json")
                    useCaches = false
                }
                val code = conn.responseCode
                if (code in 200..299) {
                    val body = conn.inputStream.bufferedReader(Charsets.UTF_8).use { it.readText() }
                    Log.i(TAG, "Snapshot fetched successfully from $base (length=${body.length})")
                    return body
                }
                Log.w(TAG, "HTTP $code on $base")
            } catch (e: Throwable) {
                Log.w(TAG, "fetch failed on $base: ${e.message}")
            }
        }
        return null
    }
}
