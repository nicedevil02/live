package ir.talalive.tv

import android.app.Notification
import android.app.NotificationChannel
import android.app.NotificationManager
import android.app.PendingIntent
import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.os.Build
import android.util.Log

class BootReceiver : BroadcastReceiver() {
    private val tag = "TalaTV.Boot"

    override fun onReceive(ctx: Context, intent: Intent) {
        val action = intent.action ?: return
        Log.i(tag, "Received broadcast action: $action")

        if (!TvPrefs.isPaired(ctx)) {
            Log.i(tag, "Device not paired, ignoring boot broadcast")
            return
        }

        val target = Intent(ctx, BoardActivity::class.java).apply {
            addFlags(Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TOP)
        }

        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.Q) {
            try {
                ctx.startActivity(target)
                Log.i(tag, "Direct startActivity succeeded for pre-Q")
            } catch (e: Exception) {
                Log.e(tag, "Direct startActivity failed", e)
            }
            return
        }

        postFullScreenNotification(ctx, target)
    }

    private fun postFullScreenNotification(ctx: Context, targetIntent: Intent) {
        try {
            val nm = ctx.getSystemService(Context.NOTIFICATION_SERVICE) as? NotificationManager ?: return
            val channelId = "tala_tv_boot_channel"

            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                val chan = NotificationChannel(
                    channelId,
                    ctx.getString(R.string.app_name),
                    NotificationManager.IMPORTANCE_HIGH
                ).apply {
                    description = "TalaLive TV Autostart"
                    setSound(null, null)
                    enableVibration(false)
                }
                nm.createNotificationChannel(chan)
            }

            val flags = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                PendingIntent.FLAG_UPDATE_CURRENT or PendingIntent.FLAG_IMMUTABLE or PendingIntent.FLAG_ONE_SHOT
            } else {
                PendingIntent.FLAG_UPDATE_CURRENT or PendingIntent.FLAG_ONE_SHOT
            }

            val pi = PendingIntent.getActivity(ctx, 1001, targetIntent, flags)

            @Suppress("DEPRECATION")
            val notifBuilder = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                Notification.Builder(ctx, channelId)
            } else {
                Notification.Builder(ctx)
            }

            val notif = notifBuilder
                .setSmallIcon(R.drawable.ic_launcher)
                .setContentTitle(ctx.getString(R.string.app_name))
                .setContentText("Loading...")
                .setContentIntent(pi)
                .setFullScreenIntent(pi, true)
                .setPriority(Notification.PRIORITY_MAX)
                .setAutoCancel(true)
                .build()

            nm.notify(1001, notif)
            Log.i(tag, "FullScreenNotification posted successfully")
        } catch (e: Exception) {
            Log.e(tag, "postFullScreenNotification failed", e)
        }
    }
}
