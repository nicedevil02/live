import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/board_model.dart';

class ApiService {
  static const List<String> baseUrls = [
    'https://talalive.ir',
    'https://talalive.com',
  ];

  static const String _prefKeyUsername = 'tv_username';
  static const String _prefKeyDeviceToken = 'tv_device_token';
  static const String _prefKeyLastSnapshot = 'tv_last_snapshot';

  // =========================================================================
  // Preferences
  // =========================================================================
  static Future<bool> isPaired() async {
    final prefs = await SharedPreferences.getInstance();
    final username = prefs.getString(_prefKeyUsername);
    return username != null && username.trim().isNotEmpty;
  }

  static Future<String?> getSavedUsername() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_prefKeyUsername);
  }

  static Future<String?> getSavedDeviceToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_prefKeyDeviceToken);
  }

  static Future<void> savePairing(String username, String? token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_prefKeyUsername, username);
    if (token != null) {
      await prefs.setString(_prefKeyDeviceToken, token);
    }
  }

  static Future<void> unpair() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(_prefKeyUsername);
    await prefs.remove(_prefKeyDeviceToken);
  }

  // =========================================================================
  // Pairing API
  // =========================================================================
  static Future<Map<String, dynamic>?> createPairingSession() async {
    for (final base in baseUrls) {
      try {
        final url = Uri.parse('$base/api/tv/register-session');
        final headers = {
          'Content-Type': 'application/json; charset=UTF-8',
          'Accept': 'application/json',
          if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.0',
        };
        final response = await http.post(
          url,
          headers: headers,
          body: json.encode({}),
        ).timeout(const Duration(seconds: 8));

        if (response.statusCode >= 200 && response.statusCode < 300) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          return data;
        }
      } catch (e) {
        debugPrint('[TalaLiveTV] createPairingSession error on $base: $e');
      }
    }
    return null;
  }

  static Future<Map<String, dynamic>?> checkPairingStatus(String sessionCode) async {
    for (final base in baseUrls) {
      try {
        final url = Uri.parse('$base/api/tv/check/$sessionCode');
        final headers = {
          'Accept': 'application/json',
          if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.0',
        };
        final response = await http.get(
          url,
          headers: headers,
        ).timeout(const Duration(seconds: 5));

        if (response.statusCode >= 200 && response.statusCode < 300) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          return data;
        }
      } catch (e) {
        debugPrint('[TalaLiveTV] checkPairingStatus error on $base: $e');
      }
    }
    return null;
  }

  // =========================================================================
  // Board Snapshot API
  // =========================================================================
  static Future<BoardModel?> fetchSnapshot(String username) async {
    final prefs = await SharedPreferences.getInstance();

    for (final base in baseUrls) {
      try {
        final url = Uri.parse('$base/api/display/snapshot/$username?t=${DateTime.now().millisecondsSinceEpoch}');
        debugPrint('[TalaLiveTV] Fetching snapshot from: $url');
        final headers = {
          'Accept': 'application/json',
          'Cache-Control': 'no-cache',
          if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.0',
        };
        final response = await http.get(
          url,
          headers: headers,
        ).timeout(const Duration(seconds: 8));

        debugPrint('[TalaLiveTV] Snapshot response HTTP ${response.statusCode} from $base');

        if (response.statusCode == 200) {
          final rawBody = response.body;
          debugPrint('[TalaLiveTV] Snapshot body length: ${rawBody.length}');
          try {
            final jsonMap = json.decode(rawBody) as Map<String, dynamic>;
            final model = BoardModel.fromJson(jsonMap, rawBody);

            // Save last good snapshot to offline cache
            await prefs.setString(_prefKeyLastSnapshot, rawBody);
            debugPrint('[TalaLiveTV] Successfully parsed BoardModel: ${model.rows.length} rows, ${model.products.length} products');
            return model;
          } catch (parseErr, stack) {
            debugPrint('[TalaLiveTV] ERROR parsing snapshot JSON: $parseErr');
            debugPrint('$stack');
          }
        } else {
          debugPrint('[TalaLiveTV] Snapshot HTTP ${response.statusCode}: ${response.body.substring(0, response.body.length.clamp(0, 300))}');
        }
      } catch (e, stack) {
        debugPrint('[TalaLiveTV] Snapshot fetch error on $base: $e');
        debugPrint('$stack');
      }
    }

    // Offline Fallback: Load cached snapshot
    final cached = prefs.getString(_prefKeyLastSnapshot);
    if (cached != null && cached.isNotEmpty) {
      try {
        debugPrint('[TalaLiveTV] Attempting offline fallback from cache');
        final jsonMap = json.decode(cached) as Map<String, dynamic>;
        jsonMap['isStale'] = true;
        return BoardModel.fromJson(jsonMap, cached);
      } catch (e) {
        debugPrint('[TalaLiveTV] Offline fallback error: $e');
        return null;
      }
    }

    return null;
  }

  // =========================================================================
  // Chart Series API (1d, 7d, 30d, 1y)
  // =========================================================================
  static Future<Map<String, dynamic>?> fetchChartSeries(
    String username,
    String symbol,
    String range,
  ) async {
    for (final base in baseUrls) {
      try {
        final url = Uri.parse(
          '$base/api/display/chart/${Uri.encodeComponent(username)}/${Uri.encodeComponent(symbol)}?range=${Uri.encodeComponent(range)}',
        );
        final response = await http.get(
          url,
          headers: {
            'Accept': 'application/json',
            'Cache-Control': 'no-cache',
            if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.1',
          },
        ).timeout(const Duration(seconds: 10));

        if (response.statusCode == 200) {
          final decoded = json.decode(response.body);
          if (decoded is Map<String, dynamic>) {
            return decoded;
          }
        }
      } catch (e) {
        debugPrint('[TalaLiveTV] fetchChartSeries error on $base: $e');
      }
    }
    return null;
  }

  // =========================================================================
  // Device Heartbeat & Remote Revocation Check
  // =========================================================================
  static Future<Map<String, dynamic>?> sendHeartbeat({
    required String appVersion,
    required int appVersionCode,
    required String androidRelease,
    required String webviewVersion,
    required String renderMode,
  }) async {
    final token = await getSavedDeviceToken();
    if (token == null || token.trim().isEmpty) {
      return null;
    }

    for (final base in baseUrls) {
      try {
        final url = Uri.parse('$base/api/tv/heartbeat');
        final response = await http.post(
          url,
          headers: {
            'Content-Type': 'application/json; charset=UTF-8',
            'Accept': 'application/json',
            if (!kIsWeb) 'User-Agent': 'TalaLiveTV-Flutter/2.1',
          },
          body: json.encode({
            'device_token': token,
            'app_version': appVersion,
            'app_version_code': appVersionCode,
            'android_release': androidRelease,
            'webview_version': webviewVersion,
            'render_mode': renderMode,
          }),
        ).timeout(const Duration(seconds: 8));

        if (response.statusCode >= 200 && response.statusCode < 500) {
          final decoded = json.decode(response.body);
          if (decoded is Map<String, dynamic>) {
            return decoded;
          }
        }
      } catch (e) {
        debugPrint('[TalaLiveTV] heartbeat error on $base: $e');
      }
    }
    return null;
  }
}
