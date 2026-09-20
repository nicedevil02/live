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
        final response = await http.post(
          url,
          headers: {
            'Content-Type': 'application/json; charset=UTF-8',
            'Accept': 'application/json',
            'User-Agent': 'TalaLiveTV-Flutter/2.0',
          },
          body: json.encode({}),
        ).timeout(const Duration(seconds: 8));

        if (response.statusCode >= 200 && response.statusCode < 300) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          return data;
        }
      } catch (e) {
        // Try next base url
      }
    }
    return null;
  }

  static Future<Map<String, dynamic>?> checkPairingStatus(String sessionCode) async {
    for (final base in baseUrls) {
      try {
        final url = Uri.parse('$base/api/tv/check/$sessionCode');
        final response = await http.get(
          url,
          headers: {
            'Accept': 'application/json',
            'User-Agent': 'TalaLiveTV-Flutter/2.0',
          },
        ).timeout(const Duration(seconds: 5));

        if (response.statusCode >= 200 && response.statusCode < 300) {
          final data = json.decode(response.body) as Map<String, dynamic>;
          return data;
        }
      } catch (e) {
        // Try next base url
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
        final response = await http.get(
          url,
          headers: {
            'Accept': 'application/json',
            'User-Agent': 'TalaLiveTV-Flutter/2.0',
            'Cache-Control': 'no-cache',
          },
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
}
