package ir.talalive.tv

import android.content.Context
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.util.Log
import java.io.File
import java.io.FileOutputStream
import java.net.HttpURLConnection
import java.net.URL
import java.security.MessageDigest
import java.util.concurrent.Executors

object ImageCache {
    private const val TAG = "TalaTV.ImageCache"
    private const val MAX_CACHED_FILES = 20
    private val executor = Executors.newFixedThreadPool(2)

    private fun getSlideDir(context: Context): File {
        val dir = File(context.cacheDir, "slides")
        if (!dir.exists()) {
            dir.mkdirs()
        }
        return dir
    }

    private fun hashUrl(url: String): String {
        return try {
            val md = MessageDigest.getInstance("MD5")
            val bytes = md.digest(url.toByteArray(Charsets.UTF_8))
            bytes.joinToString("") { "%02x".format(it) }
        } catch (e: Exception) {
            url.hashCode().toString()
        }
    }

    fun loadBitmap(context: Context, urlString: String, onLoaded: (Bitmap?) -> Unit) {
        if (urlString.isBlank()) {
            onLoaded(null)
            return
        }

        executor.execute {
            try {
                val dir = getSlideDir(context)
                val filename = hashUrl(urlString) + ".img"
                val file = File(dir, filename)

                if (!file.exists() || file.length() == 0L) {
                    downloadFile(urlString, file)
                    pruneOldCache(dir)
                }

                if (file.exists() && file.length() > 0L) {
                    file.setLastModified(System.currentTimeMillis())
                    val screenW = context.resources.displayMetrics.widthPixels
                    val screenH = context.resources.displayMetrics.heightPixels
                    val bmp = decodeSampledBitmap(file.absolutePath, screenW, screenH)
                    onLoaded(bmp)
                } else {
                    onLoaded(null)
                }
            } catch (t: Throwable) {
                Log.w(TAG, "Failed to load image from $urlString: ${t.message}")
                onLoaded(null)
            }
        }
    }

    private fun downloadFile(urlString: String, targetFile: File) {
        val tempFile = File(targetFile.parentFile, targetFile.name + ".tmp")
        var conn: HttpURLConnection? = null
        try {
            val url = URL(urlString)
            conn = (url.openConnection() as HttpURLConnection).apply {
                requestMethod = "GET"
                connectTimeout = 8000
                readTimeout = 10000
                setRequestProperty("User-Agent", "TalaLiveTV/1.0 (Android)")
                useCaches = false
            }

            if (conn.responseCode in 200..299) {
                conn.inputStream.use { input ->
                    FileOutputStream(tempFile).use { output ->
                        input.copyTo(output)
                    }
                }
                if (tempFile.length() > 0) {
                    if (targetFile.exists()) targetFile.delete()
                    tempFile.renameTo(targetFile)
                }
            } else {
                Log.w(TAG, "HTTP ${conn.responseCode} downloading $urlString")
            }
        } finally {
            if (tempFile.exists()) tempFile.delete()
            conn?.disconnect()
        }
    }

    private fun decodeSampledBitmap(path: String, maxW: Int, maxH: Int): Bitmap? {
        val options = BitmapFactory.Options().apply {
            inJustDecodeBounds = true
        }
        BitmapFactory.decodeFile(path, options)

        var inSampleSize = 1
        val rawH = options.outHeight
        val rawW = options.outWidth

        if (rawH > maxH || rawW > maxW) {
            val halfH = rawH / 2
            val halfW = rawW / 2
            while ((halfH / inSampleSize) >= maxH && (halfW / inSampleSize) >= maxW) {
                inSampleSize *= 2
            }
        }

        val decodeOptions = BitmapFactory.Options().apply {
            this.inSampleSize = inSampleSize
            inPreferredConfig = Bitmap.Config.RGB_565 // Low memory footprint for TV boxes
        }
        return BitmapFactory.decodeFile(path, decodeOptions)
    }

    private fun pruneOldCache(dir: File) {
        try {
            val files = dir.listFiles() ?: return
            if (files.size > MAX_CACHED_FILES) {
                val sorted = files.sortedBy { it.lastModified() }
                val toDelete = sorted.take(files.size - MAX_CACHED_FILES)
                for (f in toDelete) {
                    f.delete()
                }
            }
        } catch (e: Exception) {
            Log.w(TAG, "pruneOldCache error: ${e.message}")
        }
    }
}
