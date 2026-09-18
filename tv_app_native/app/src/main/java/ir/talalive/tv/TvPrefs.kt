package ir.talalive.tv

import android.content.Context
import android.content.SharedPreferences

object TvPrefs {
    private const val FILE = "tala_tv"

    fun get(ctx: Context): SharedPreferences = ctx.getSharedPreferences(FILE, Context.MODE_PRIVATE)

    fun isPaired(ctx: Context): Boolean = !get(ctx).getString("device_token", null).isNullOrBlank()

    fun getUsername(ctx: Context): String? = get(ctx).getString("username", null)

    fun getDeviceToken(ctx: Context): String? = get(ctx).getString("device_token", null)

    fun getBoardUrl(ctx: Context): String? = get(ctx).getString("board_url", null)

    fun getLastRateTime(ctx: Context): String = get(ctx).getString("last_known_rate_time", "---") ?: "---"

    fun savePairing(ctx: Context, username: String, deviceToken: String, boardUrl: String?) {
        get(ctx).edit()
            .putString("username", username)
            .putString("device_token", deviceToken)
            .putString("board_url", boardUrl)
            .apply()
    }

    fun clearPairing(ctx: Context) {
        get(ctx).edit()
            .remove("username")
            .remove("device_token")
            .remove("board_url")
            .apply()
    }

    fun updateTick(ctx: Context, timeText: String) {
        get(ctx).edit()
            .putString("last_known_rate_time", timeText)
            .putLong("last_ok_tick_millis", System.currentTimeMillis())
            .apply()
    }

    fun saveHeartbeat(ctx: Context, boardUrl: String?, baseUrlsJson: String?, latestVersion: Int, minVersion: Int, apkUrl: String?) {
        val editor = get(ctx).edit()
        if (!boardUrl.isNullOrBlank()) editor.putString("board_url", boardUrl)
        if (!baseUrlsJson.isNullOrBlank()) editor.putString("base_urls", baseUrlsJson)
        if (latestVersion > 0) editor.putInt("latest_version_code", latestVersion)
        if (minVersion > 0) editor.putInt("min_version_code", minVersion)
        if (!apkUrl.isNullOrBlank()) editor.putString("apk_url", apkUrl)
        editor.apply()
    }
}
