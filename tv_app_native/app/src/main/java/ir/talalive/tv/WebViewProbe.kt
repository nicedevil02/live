package ir.talalive.tv

import android.content.Context
import android.content.pm.PackageInfo
import android.os.Build
import android.util.Log
import android.webkit.WebSettings
import java.util.regex.Pattern

object WebViewProbe {
    private const val TAG = "TalaTV.Probe"

    data class Info(
        val available: Boolean,
        val packageName: String?,
        val versionName: String?,
        val majorVersion: Int
    )

    fun probe(ctx: Context): Info {
        val pkg = currentPackage(ctx)
        if (pkg != null) {
            val major = pkg.versionName?.substringBefore('.')?.toIntOrNull() ?: 0
            return Info(true, pkg.packageName, pkg.versionName, major)
        }
        val ua = try { WebSettings.getDefaultUserAgent(ctx) } catch (e: Throwable) {
            Log.w(TAG, "getDefaultUserAgent failed: ${e.message}")
            return Info(false, null, null, 0)
        }
        val m = Pattern.compile("Chrome/([0-9]+)").matcher(ua)
        val major = if (m.find()) m.group(1)?.toIntOrNull() ?: 0 else 0
        return Info(true, null, null, major)
    }

    private fun currentPackage(ctx: Context): PackageInfo? {
        return try {
            if (Build.VERSION.SDK_INT >= 26) {
                val cls = Class.forName("android.webkit.WebViewFactory")
                cls.getMethod("getLoadedPackageInfo").invoke(null) as? PackageInfo
            } else null
        } catch (e: Throwable) {
            Log.w(TAG, "WebViewFactory reflection failed: ${e.message}")
            null
        }
    }
}
