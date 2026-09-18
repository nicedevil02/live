package ir.talalive.tv

import android.content.Context
import android.util.Log
import org.json.JSONObject
import java.io.BufferedReader
import java.io.InputStreamReader
import java.io.OutputStreamWriter
import java.net.HttpURLConnection
import java.net.URL
import java.text.SimpleDateFormat
import java.util.Locale
import java.util.TimeZone

object Api {
    private const val TAG = "TalaTV.Api"
    private const val USER_AGENT = "TalaLiveTV/1.0 (Android)"
    private const val CONNECT_TIMEOUT = 8000
    private const val READ_TIMEOUT = 8000

    data class SessionResult(
        val sessionCode: String,
        val activationCode: String,
        val pollIntervalSeconds: Int,
        val expiresInSeconds: Int
    )

    data class PairingResult(
        val paired: Boolean,
        val username: String?,
        val deviceToken: String?,
        val pollIntervalSeconds: Int
    )

    data class HeartbeatResult(
        val revoked: Boolean,
        val boardUrl: String?,
        val baseUrlsJson: String?,
        val latestVersionCode: Int,
        val minVersionCode: Int,
        val apkUrl: String?,
        val intervalSeconds: Int
    )

    data class SmsResult(
        val success: Boolean,
        val message: String
    )

    private fun openConnection(urlStr: String, method: String): HttpURLConnection {
        val url = URL(urlStr)
        val conn = url.openConnection() as HttpURLConnection
        conn.requestMethod = method
        conn.connectTimeout = CONNECT_TIMEOUT
        conn.readTimeout = READ_TIMEOUT
        conn.setRequestProperty("User-Agent", USER_AGENT)
        conn.setRequestProperty("Accept", "application/json")
        conn.useCaches = false
        return conn
    }

    private fun readResponse(conn: HttpURLConnection): String {
        val stream = if (conn.responseCode in 200..299) conn.inputStream else (conn.errorStream ?: conn.inputStream)
        BufferedReader(InputStreamReader(stream, "UTF-8")).use { reader ->
            val sb = StringBuilder()
            var line: String?
            while (reader.readLine().also { line = it } != null) {
                sb.append(line)
            }
            return sb.toString()
        }
    }

    fun registerSession(ctx: Context): SessionResult? {
        val bases = Config.baseUrls(ctx)
        for (base in bases) {
            try {
                val conn = openConnection("$base/api/tv/register-session", "POST")
                conn.doOutput = true
                conn.setRequestProperty("Content-Type", "application/json; charset=UTF-8")
                OutputStreamWriter(conn.outputStream, "UTF-8").use { it.write("{}") }

                if (conn.responseCode in 200..299) {
                    val raw = readResponse(conn)
                    val json = JSONObject(raw)
                    val sCode = json.optString("session_code", "")
                    val aCode = json.optString("activation_code", "")
                    if (sCode.isNotBlank() && aCode.isNotBlank()) {
                        val poll = json.optInt("poll_interval_seconds", 3)
                        val expires = json.optInt("expires_in_seconds", 7200)
                        return SessionResult(sCode, aCode, poll, expires)
                    }
                } else {
                    Log.w(TAG, "registerSession failed on $base with code ${conn.responseCode}")
                }
            } catch (e: Exception) {
                Log.w(TAG, "registerSession error on $base: ${e.message}")
            }
        }
        return null
    }

    private fun optNullableString(json: JSONObject, key: String): String? {
        if (!json.has(key) || json.isNull(key)) return null
        val v = json.optString(key, "").trim()
        return if (v.isEmpty()) null else v
    }

    fun checkPairing(ctx: Context, sessionCode: String): PairingResult? {
        val bases = Config.baseUrls(ctx)
        for (base in bases) {
            try {
                val conn = openConnection("$base/api/tv/check/$sessionCode", "GET")
                if (conn.responseCode in 200..299) {
                    val raw = readResponse(conn)
                    val json = JSONObject(raw)
                    val paired = json.optBoolean("paired", false)
                    val username = optNullableString(json, "username")
                    val token = optNullableString(json, "device_token") ?: optNullableString(json, "token")
                    val poll = json.optInt("poll_interval_seconds", 3)
                    return PairingResult(paired, username, token, poll)
                }
            } catch (e: Exception) {
                Log.w(TAG, "checkPairing error on $base: ${e.message}")
            }
        }
        return null
    }

    fun heartbeat(
        ctx: Context,
        deviceToken: String,
        versionCode: Int,
        androidRelease: String,
        webViewVersion: String
    ): HeartbeatResult? {
        val bases = Config.baseUrls(ctx)
        for (base in bases) {
            try {
                val conn = openConnection("$base/api/tv/heartbeat", "POST")
                conn.doOutput = true
                conn.setRequestProperty("Content-Type", "application/json; charset=UTF-8")

                val payload = JSONObject().apply {
                    put("device_token", deviceToken)
                    put("app_version_code", versionCode)
                    put("android_release", androidRelease)
                    put("webview_version", webViewVersion)
                }

                OutputStreamWriter(conn.outputStream, "UTF-8").use { it.write(payload.toString()) }

                if (conn.responseCode in 200..299) {
                    val raw = readResponse(conn)
                    val json = JSONObject(raw)
                    val revoked = json.optBoolean("revoked", false)
                    val boardUrl = optNullableString(json, "board_url")
                    val baseUrlsArr = json.optJSONArray("base_urls")
                    val latestVer = json.optInt("latest_version_code", 0)
                    val minVer = json.optInt("min_version_code", 0)
                    val apkUrl = optNullableString(json, "apk_url")
                    val interval = json.optInt("heartbeat_interval_seconds", 900)

                    return HeartbeatResult(
                        revoked = revoked,
                        boardUrl = boardUrl,
                        baseUrlsJson = baseUrlsArr?.toString(),
                        latestVersionCode = latestVer,
                        minVersionCode = minVer,
                        apkUrl = apkUrl,
                        intervalSeconds = interval
                    )
                }
            } catch (e: Exception) {
                Log.w(TAG, "heartbeat error on $base: ${e.message}")
            }
        }
        return null
    }

    fun requestMagicSms(ctx: Context, sessionCode: String, mobile: String): SmsResult {
        val bases = Config.baseUrls(ctx)
        for (base in bases) {
            try {
                val conn = openConnection("$base/api/tv/magic-sms", "POST")
                conn.doOutput = true
                conn.setRequestProperty("Content-Type", "application/json; charset=UTF-8")

                val payload = JSONObject().apply {
                    put("session_code", sessionCode)
                    put("mobile", mobile)
                }

                OutputStreamWriter(conn.outputStream, "UTF-8").use { it.write(payload.toString()) }

                val raw = readResponse(conn)
                val json = JSONObject(raw)
                val success = json.optBoolean("success", conn.responseCode in 200..299)
                val msg = json.optString("message", "")
                return SmsResult(success, msg)
            } catch (e: Exception) {
                Log.w(TAG, "magic-sms error on $base: ${e.message}")
            }
        }
        return SmsResult(false, "Connection error")
    }

    fun fetchServerEpochMillis(ctx: Context): Long? {
        val bases = Config.baseUrls(ctx)
        for (base in bases) {
            try {
                val conn = openConnection(base, "HEAD")
                val dateHeader = conn.getHeaderField("Date")
                if (!dateHeader.isNullOrBlank()) {
                    val format = SimpleDateFormat("EEE, dd MMM yyyy HH:mm:ss z", Locale.US).apply {
                        timeZone = TimeZone.getTimeZone("GMT")
                    }
                    val parsed = format.parse(dateHeader)
                    if (parsed != null) return parsed.time
                }
            } catch (e: Exception) {
                Log.w(TAG, "fetchServerEpochMillis error on $base: ${e.message}")
            }
        }
        return null
    }
}
