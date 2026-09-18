package ir.talalive.tv

import android.content.Context
import android.content.Intent
import android.content.pm.PackageInfo
import android.content.pm.PackageManager
import android.net.Uri
import android.os.Build
import android.os.StrictMode
import android.util.Log
import java.io.File
import java.io.FileOutputStream
import java.io.InputStream
import java.net.HttpURLConnection
import java.net.URL
import java.security.MessageDigest
import java.util.Arrays

object UpdateManager {

    private const val TAG = "TalaTVUpdate"

    fun getCurrentVersionCode(context: Context): Int {
        return try {
            val pInfo = context.packageManager.getPackageInfo(context.packageName, 0)
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                pInfo.longVersionCode.toInt()
            } else {
                @Suppress("DEPRECATION")
                pInfo.versionCode
            }
        } catch (e: Exception) {
            Log.e(TAG, "Failed to get current version code", e)
            1
        }
    }

    fun getUpdateApkFile(context: Context): File {
        return File(context.getExternalFilesDir(null), "talalive-tv-update.apk")
    }

    fun downloadApk(
        context: Context,
        apkUrl: String,
        onProgress: (percent: Int) -> Unit
    ): File? {
        val targetFile = getUpdateApkFile(context)
        if (targetFile.exists()) {
            targetFile.delete()
        }

        var conn: HttpURLConnection? = null
        var inStream: InputStream? = null
        var outStream: FileOutputStream? = null

        try {
            var currentUrl = apkUrl
            var redirectCount = 0
            while (redirectCount < 5) {
                val urlObj = URL(currentUrl)
                conn = urlObj.openConnection() as HttpURLConnection
                conn.connectTimeout = 15000
                conn.readTimeout = 30000
                conn.instanceFollowRedirects = true
                conn.setRequestProperty("User-Agent", "TalaLiveTV/1.0 (Android)")
                conn.connect()

                val code = conn.responseCode
                if (code == HttpURLConnection.HTTP_MOVED_PERM || code == HttpURLConnection.HTTP_MOVED_TEMP) {
                    val loc = conn.getHeaderField("Location") ?: break
                    currentUrl = loc
                    redirectCount++
                    conn.disconnect()
                } else {
                    break
                }
            }

            if (conn?.responseCode != HttpURLConnection.HTTP_OK) {
                Log.e(TAG, "Download failed with HTTP " + conn?.responseCode)
                return null
            }

            val totalLength = conn.contentLength
            inStream = conn.inputStream
            outStream = FileOutputStream(targetFile)

            val buffer = ByteArray(8192)
            var bytesRead: Int
            var totalRead = 0L

            while (inStream.read(buffer).also { bytesRead = it } != -1) {
                outStream.write(buffer, 0, bytesRead)
                totalRead += bytesRead
                if (totalLength > 0) {
                    val pct = ((totalRead * 100) / totalLength).toInt()
                    onProgress(pct.coerceIn(0, 100))
                }
            }

            outStream.flush()
            Log.i(TAG, "Download completed: " + targetFile.length() + " bytes")
            return targetFile

        } catch (e: Exception) {
            Log.e(TAG, "Error downloading APK from $apkUrl", e)
            if (targetFile.exists()) targetFile.delete()
            return null
        } finally {
            try { inStream?.close() } catch (ignored: Exception) {}
            try { outStream?.close() } catch (ignored: Exception) {}
            try { conn?.disconnect() } catch (ignored: Exception) {}
        }
    }

    fun validateApk(context: Context, apkFile: File): Boolean {
        if (!apkFile.exists() || apkFile.length() < 1024) {
            Log.e(TAG, "Validation failed: APK file missing or too small (${apkFile.length()} bytes)")
            return false
        }

        try {
            val pm = context.packageManager
            val currentPkg = context.packageName

            // 1. Check Version Code
            val archiveInfo = pm.getPackageArchiveInfo(apkFile.absolutePath, 0)
            if (archiveInfo == null) {
                Log.e(TAG, "Validation failed: Could not parse archive info")
                return false
            }

            val newVersionCode = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                archiveInfo.longVersionCode.toInt()
            } else {
                @Suppress("DEPRECATION")
                archiveInfo.versionCode
            }

            val currentVersionCode = getCurrentVersionCode(context)
            if (newVersionCode <= currentVersionCode) {
                Log.e(TAG, "Validation failed: New version $newVersionCode not greater than current $currentVersionCode")
                return false
            }

            // 2. Check Package Name
            if (archiveInfo.packageName != currentPkg) {
                Log.e(TAG, "Validation failed: Package mismatch (${archiveInfo.packageName} vs $currentPkg)")
                return false
            }

            // 3. Verify Signature
            val isSignatureValid = verifySignatures(context, apkFile)
            if (!isSignatureValid) {
                Log.e(TAG, "Validation failed: Signature mismatch between current app and update APK!")
                return false
            }

            Log.i(TAG, "APK validation passed: Version $newVersionCode, signatures verified.")
            return true

        } catch (e: Exception) {
            Log.e(TAG, "Validation exception", e)
            return false
        }
    }

    @Suppress("DEPRECATION")
    private fun verifySignatures(context: Context, apkFile: File): Boolean {
        val pm = context.packageManager
        try {
            val currentSha = getAppSignatureSha256(context) ?: return false

            val archiveInfo = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                pm.getPackageArchiveInfo(apkFile.absolutePath, PackageManager.GET_SIGNING_CERTIFICATES)
            } else {
                pm.getPackageArchiveInfo(apkFile.absolutePath, PackageManager.GET_SIGNATURES)
            } ?: return false

            val archiveSigs = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                archiveInfo.signingInfo?.apkContentsSigners
            } else {
                archiveInfo.signatures
            }

            if (archiveSigs.isNullOrEmpty()) {
                Log.e(TAG, "No signatures found in archive")
                return false
            }

            val archiveSha = sha256(archiveSigs[0].toByteArray())
            val matched = currentSha.equals(archiveSha, ignoreCase = true)
            if (!matched) {
                Log.e(TAG, "Signature SHA256 mismatch! Current: $currentSha, Archive: $archiveSha")
            }
            return matched

        } catch (e: Exception) {
            Log.e(TAG, "Signature verification error", e)
            return false
        }
    }

    @Suppress("DEPRECATION")
    private fun getAppSignatureSha256(context: Context): String? {
        val pm = context.packageManager
        try {
            val currentSigs = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
                val info = pm.getPackageInfo(context.packageName, PackageManager.GET_SIGNING_CERTIFICATES)
                info.signingInfo?.apkContentsSigners
            } else {
                val info = pm.getPackageInfo(context.packageName, PackageManager.GET_SIGNATURES)
                info.signatures
            }
            if (currentSigs.isNullOrEmpty()) return null
            return sha256(currentSigs[0].toByteArray())
        } catch (e: Exception) {
            Log.e(TAG, "Failed to get current app signature", e)
            return null
        }
    }

    private fun sha256(bytes: ByteArray): String {
        val md = MessageDigest.getInstance("SHA-256")
        val digest = md.digest(bytes)
        val sb = StringBuilder()
        for (b in digest) {
            sb.append(String.format("%02X", b))
        }
        return sb.toString()
    }

    fun installApk(context: Context, apkFile: File) {
        try {
            val apkUri = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
                Uri.parse("content://ir.talalive.tv.fileprovider/talalive-tv-update.apk")
            } else {
                Uri.fromFile(apkFile)
            }

            val intent = Intent(Intent.ACTION_VIEW).apply {
                setDataAndType(apkUri, "application/vnd.android.package-archive")
                addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION)
                addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
            }

            context.startActivity(intent)
            Log.i(TAG, "Package installer triggered for $apkUri")

        } catch (e: Exception) {
            Log.e(TAG, "Failed to launch package installer", e)
        }
    }
}
