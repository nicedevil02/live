import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart' as http;

class UpdateInfo {
  final bool hasUpdate;
  final String currentVersion;
  final int currentVersionCode;
  final String remoteVersion;
  final int remoteVersionCode;
  final String downloadUrl;
  final String fileSize;
  final String changelog;
  final bool isMandatory;
  final String title;
  final String? error;

  const UpdateInfo({
    required this.hasUpdate,
    required this.currentVersion,
    required this.currentVersionCode,
    required this.remoteVersion,
    required this.remoteVersionCode,
    required this.downloadUrl,
    required this.fileSize,
    required this.changelog,
    this.isMandatory = false,
    this.title = 'بروزرسانی جدید طلالایو TV',
    this.error,
  });

  factory UpdateInfo.noUpdate({
    required String currentVersion,
    required int currentVersionCode,
  }) {
    return UpdateInfo(
      hasUpdate: false,
      currentVersion: currentVersion,
      currentVersionCode: currentVersionCode,
      remoteVersion: currentVersion,
      remoteVersionCode: currentVersionCode,
      downloadUrl: '',
      fileSize: '',
      changelog: '',
    );
  }

  factory UpdateInfo.withError(
    String message, {
    String currentVersion = '1.0.0',
    int currentVersionCode = 1,
  }) {
    return UpdateInfo(
      hasUpdate: false,
      currentVersion: currentVersion,
      currentVersionCode: currentVersionCode,
      remoteVersion: '',
      remoteVersionCode: 0,
      downloadUrl: '',
      fileSize: '',
      changelog: '',
      error: message,
    );
  }
}

class UpdateService {
  static const MethodChannel _channel = MethodChannel('ir.talalive.tv/updater');

  static const List<String> baseUrls = [
    'https://talalive.ir',
    'https://talalive.com',
  ];

  /// دریافت مشخصات نسخه نصب‌شده فعلی
  static Future<Map<String, dynamic>> getAppVersion() async {
    if (kIsWeb || !Platform.isAndroid) {
      return {'versionCode': 1, 'versionName': '1.0.0'};
    }
    try {
      final res = await _channel.invokeMethod<Map<dynamic, dynamic>>('getAppVersion');
      if (res != null) {
        return {
          'versionCode': (res['versionCode'] as num?)?.toInt() ?? 1,
          'versionName': (res['versionName'] as String?) ?? '1.0.0',
        };
      }
    } catch (e) {
      debugPrint('[UpdateService] getAppVersion error: $e');
    }
    return {'versionCode': 1, 'versionName': '1.0.0'};
  }

  /// استعلام نسخه از سرور و مقایسه با نسخه فعلی (پشتیبانی دوگانه از API و فایل مانیفست)
  static Future<UpdateInfo> checkUpdate() async {
    final localInfo = await getAppVersion();
    final localVersionCode = localInfo['versionCode'] as int;
    final localVersionName = localInfo['versionName'] as String;

    String? lastError;

    for (final base in baseUrls) {
      // ۱. تلاش اول: اندپوینت اختصاصی OTA
      try {
        final url = Uri.parse('$base/api/tv/version?t=${DateTime.now().millisecondsSinceEpoch}');
        final response = await http.get(
          url,
          headers: {
            'Accept': 'application/json',
            'Cache-Control': 'no-cache',
            if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.0',
          },
        ).timeout(const Duration(seconds: 8));

        if (response.statusCode == 200) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          final remoteCode = (data['version_code'] as num?)?.toInt() ?? 0;
          final remoteName = (data['version'] as String?) ?? '1.0.8';
          final downloadUrl = (data['download_url'] as String?) ?? '$base/downloads/talalive-tv.apk';
          final fileSize = (data['file_size'] as String?) ?? '46.4 MB';
          final changelog = (data['changelog'] as String?) ?? 'بهبود کارایی و پایداری سامانه';
          final isMandatory = (data['mandatory'] as bool?) ?? false;
          final title = (data['title'] as String?) ?? 'بروزرسانی جدید طلالایو TV';

          final hasUpdate = remoteCode > localVersionCode;

          if (hasUpdate) {
            return UpdateInfo(
              hasUpdate: true,
              currentVersion: localVersionName,
              currentVersionCode: localVersionCode,
              remoteVersion: remoteName,
              remoteVersionCode: remoteCode,
              downloadUrl: downloadUrl,
              fileSize: fileSize,
              changelog: changelog,
              isMandatory: isMandatory,
              title: title,
            );
          }
        }
      } catch (e) {
        lastError = e.toString();
        debugPrint('[UpdateService] checkUpdate API error on $base: $e');
      }

      // ۲. تلاش دوم: فایل مانیفست استاتیک talalive-tv.json (فال‌بک در صورت اختلال در سرور لاراول)
      try {
        final url = Uri.parse('$base/downloads/talalive-tv.json?t=${DateTime.now().millisecondsSinceEpoch}');
        final response = await http.get(
          url,
          headers: {
            'Accept': 'application/json',
            'Cache-Control': 'no-cache',
            if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.0',
          },
        ).timeout(const Duration(seconds: 8));

        if (response.statusCode == 200) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          final remoteCode = (data['version_code'] as num?)?.toInt() ?? 0;
          final remoteName = (data['version_name'] as String?) ?? (data['version'] as String?) ?? '1.0.8';
          final downloadUrl = (data['download_url'] as String?) ?? '$base/downloads/talalive-tv.apk';
          final fileSize = (data['size_formatted'] as String?) ?? (data['file_size'] as String?) ?? '46.4 MB';
          final changelog = (data['changelog'] as String?) ?? 'به‌روزرسانی و ارتقای کارایی نرم‌افزار';
          final isMandatory = (data['mandatory'] as bool?) ?? false;
          final title = (data['title'] as String?) ?? 'بروزرسانی جدید طلالایو TV';

          final hasUpdate = remoteCode > localVersionCode;

          if (hasUpdate) {
            return UpdateInfo(
              hasUpdate: true,
              currentVersion: localVersionName,
              currentVersionCode: localVersionCode,
              remoteVersion: remoteName,
              remoteVersionCode: remoteCode,
              downloadUrl: downloadUrl,
              fileSize: fileSize,
              changelog: changelog,
              isMandatory: isMandatory,
              title: title,
            );
          }
        }
      } catch (e) {
        lastError = e.toString();
        debugPrint('[UpdateService] checkUpdate manifest fallback error on $base: $e');
      }
    }

    if (lastError != null) {
      return UpdateInfo.withError(
        'عدم دسترسی به سرور به‌روزرسانی',
        currentVersion: localVersionName,
        currentVersionCode: localVersionCode,
      );
    }

    return UpdateInfo.noUpdate(
      currentVersion: localVersionName,
      currentVersionCode: localVersionCode,
    );
  }

  /// بررسی امکان درخواست نصب برنامه‌ها
  static Future<bool> canRequestPackageInstalls() async {
    if (kIsWeb || !Platform.isAndroid) return true;
    try {
      final res = await _channel.invokeMethod<bool>('canRequestPackageInstalls');
      return res ?? true;
    } catch (e) {
      return true;
    }
  }

  /// باز کردن صفحه تنظیمات مجاز کردن نصب برای برنامه
  static Future<void> openInstallPermissionSettings() async {
    if (kIsWeb || !Platform.isAndroid) return;
    try {
      await _channel.invokeMethod('openInstallPermissionSettings');
    } catch (e) {
      debugPrint('[UpdateService] openInstallPermissionSettings error: $e');
    }
  }

  /// دانلود و نصب APK با گزارش زنده درصد پیشرفت
  static Future<void> downloadAndInstall({
    required String downloadUrl,
    required void Function(int received, int total) onProgress,
    required void Function(String error) onError,
    required void Function() onInstallStarted,
    bool Function()? isCancelled,
  }) async {
    if (kIsWeb || !Platform.isAndroid) {
      onError('قابلیت نصب خودکار تنها در دستگاه‌های اندرویدی در دسترس است.');
      return;
    }

    HttpClient? httpClient;
    IOSink? sink;

    try {
      // 1. دریافت مسیر پوشه کش از متد چنل یا پوشه موقت
      String cacheDirPath = '';
      try {
        final res = await _channel.invokeMethod<String>('getCacheDir');
        if (res != null && res.isNotEmpty) {
          cacheDirPath = res;
        }
      } catch (_) {}

      if (cacheDirPath.isEmpty) {
        cacheDirPath = Directory.systemTemp.path;
      }

      final targetFile = File('$cacheDirPath/talalive-tv-update.apk');

      if (targetFile.existsSync()) {
        try {
          targetFile.deleteSync();
        } catch (_) {}
      }


      // 2. شروع دانلود فایل با HttpClient استاندارد دارت
      httpClient = HttpClient();
      httpClient.connectionTimeout = const Duration(seconds: 15);

      final uri = Uri.parse(downloadUrl);
      final request = await httpClient.getUrl(uri);
      request.headers.set(HttpHeaders.userAgentHeader, 'TalaLiveTV-Flutter/2.0');
      request.headers.set(HttpHeaders.acceptHeader, '*/*');

      final response = await request.close();

      if (response.statusCode < 200 || response.statusCode >= 300) {
        onError('خطا در دریافت فایل از سرور (کد خطا: ${response.statusCode})');
        return;
      }

      final totalBytes = response.contentLength;
      int receivedBytes = 0;

      sink = targetFile.openWrite();

      await for (final chunk in response) {
        if (isCancelled != null && isCancelled()) {
          await sink.close();
          if (targetFile.existsSync()) {
            try {
              targetFile.deleteSync();
            } catch (_) {}
          }
          return;
        }

        receivedBytes += chunk.length;
        sink.add(chunk);
        onProgress(receivedBytes, totalBytes);
      }

      await sink.flush();
      await sink.close();
      sink = null;

      // 3. بررسی فایل نهایی
      if (!targetFile.existsSync() || targetFile.lengthSync() == 0) {
        onError('فایل بروزرسانی به صورت کامل دریافت نشد.');
        return;
      }

      onInstallStarted();

      // 4. فراخوانی اینستالر بومی اندروید از طریق FileProvider
      final installResult = await _channel.invokeMethod<bool>('installApk', {
        'filePath': targetFile.path,
      });

      if (installResult != true) {
        onError('خطا در اجرای برنامه نصب اندروید.');
      }
    } catch (e) {
      debugPrint('[UpdateService] Download/Install error: $e');
      onError('خطا در فرایند دانلود و نصب: $e');
    } finally {
      try {
        await sink?.close();
      } catch (_) {}
      httpClient?.close(force: true);
    }
  }
}
