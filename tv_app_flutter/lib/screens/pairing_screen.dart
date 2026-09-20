import 'dart:async';
import 'package:flutter/material.dart';
import 'package:qr_flutter/qr_flutter.dart';
import '../services/api_service.dart';
import '../theme/board_theme.dart';
import '../utils/persian_utils.dart';
import 'board_screen.dart';

class PairingScreen extends StatefulWidget {
  const PairingScreen({super.key});

  @override
  State<PairingScreen> createState() => _PairingScreenState();
}

class _PairingScreenState extends State<PairingScreen> {
  String? _sessionId;
  String? _pairingCode;
  String? _qrUrl;
  bool _isLoading = true;
  String? _errorMessage;
  Timer? _pollingTimer;

  @override
  void initState() {
    super.initState();
    _startPairingProcess();
  }

  void _startPairingProcess() async {
    _pollingTimer?.cancel();
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    final session = await ApiService.createPairingSession();
    if (!mounted) return;

    if (session != null && (session['success'] == true || session['activation_code'] != null)) {
      final code = session['activation_code']?.toString() ?? session['code']?.toString() ?? '';
      final sessId = session['session_code']?.toString() ?? session['session_id']?.toString() ?? '';
      final qr = 'https://talalive.ir/p/$code';

      setState(() {
        _pairingCode = code;
        _sessionId = sessId;
        _qrUrl = qr;
        _isLoading = false;
      });

      _startPolling();
    } else {
      setState(() {
        _isLoading = false;
        _errorMessage = 'خطا در ارتباط با سرور طلالایو. لطفاً اتصال اینترنت تلویزیون را بررسی کنید.';
      });
    }
  }

  void _startPolling() {
    _pollingTimer?.cancel();
    _pollingTimer = Timer.periodic(const Duration(seconds: 3), (timer) async {
      if (_sessionId == null) return;
      final status = await ApiService.checkPairingStatus(_sessionId!);

      if (!mounted) return;

      if (status != null && status['paired'] == true) {
        timer.cancel();
        final username = status['username']?.toString() ?? '';
        final token = status['device_token']?.toString() ?? status['token']?.toString();

        if (username.isNotEmpty) {
          await ApiService.savePairing(username, token);
          if (mounted) {
            Navigator.of(context).pushReplacement(
              MaterialPageRoute(builder: (_) => BoardScreen(username: username)),
            );
          }
        }
      }
    });
  }

  @override
  void dispose() {
    _pollingTimer?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    const theme = BoardThemeData.onyxGold;

    return Scaffold(
      backgroundColor: theme.backgroundColor,
      body: Center(
        child: FittedBox(
          fit: BoxFit.contain,
          child: Container(
            width: 1920,
            height: 1080,
            padding: const EdgeInsets.symmetric(horizontal: 100, vertical: 70),
            child: Row(
              textDirection: TextDirection.rtl,
              children: [
                // 1. Right Column: Instructions & 6-Digit Code
                Expanded(
                  flex: 3,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      // Badge
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 8),
                        decoration: BoxDecoration(
                          color: theme.goldPrimary.withOpacity(0.15),
                          borderRadius: BorderRadius.circular(20),
                          border: Border.all(color: theme.goldPrimary.withOpacity(0.35)),
                        ),
                        child: Text(
                          'اتصال آسان تلویزیون به پنل طلالایو',
                          style: TextStyle(
                            color: theme.goldPrimary,
                            fontSize: 16,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                      ),
                      const SizedBox(height: 24),

                      // Title
                      Text(
                        'جفت‌سازی تابلوی هوشمند طلا',
                        style: TextStyle(
                          color: theme.textPrimary,
                          fontSize: 44,
                          fontWeight: FontWeight.w900,
                          letterSpacing: -1,
                        ),
                      ),
                      const SizedBox(height: 16),

                      Text(
                        'برای فعال‌سازی و نمایش نرخ‌های مغازه روی این تلویزیون، مراحل زیر را دنبال کنید:',
                        style: TextStyle(
                          color: theme.textSecondary,
                          fontSize: 20,
                          fontWeight: FontWeight.w500,
                          height: 1.6,
                        ),
                      ),
                      const SizedBox(height: 36),

                      if (_isLoading) ...[
                        const Center(
                          child: CircularProgressIndicator(color: Color(0xFFF59E0B)),
                        ),
                      ] else if (_errorMessage != null) ...[
                        Container(
                          padding: const EdgeInsets.all(20),
                          decoration: BoxDecoration(
                            color: const Color(0xFF7F1D1D).withOpacity(0.4),
                            borderRadius: BorderRadius.circular(16),
                            border: Border.all(color: Colors.red),
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                _errorMessage!,
                                style: const TextStyle(color: Colors.white, fontSize: 18),
                              ),
                              const SizedBox(height: 16),
                              ElevatedButton(
                                onPressed: _startPairingProcess,
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: theme.goldPrimary,
                                  foregroundColor: Colors.black,
                                ),
                                child: const Text('تلاش مجدد'),
                              ),
                            ],
                          ),
                        ),
                      ] else ...[
                        // Code Box
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 36, vertical: 24),
                          decoration: BoxDecoration(
                            gradient: theme.cardGradient,
                            borderRadius: BorderRadius.circular(24),
                            border: Border.all(color: theme.goldPrimary, width: 2),
                            boxShadow: [
                              BoxShadow(
                                color: theme.goldPrimary.withOpacity(0.2),
                                blurRadius: 30,
                                spreadRadius: 2,
                              ),
                            ],
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                'کد فعال‌سازی ۶ رقمی تلویزیون:',
                                style: TextStyle(
                                  color: theme.textSecondary,
                                  fontSize: 16,
                                  fontWeight: FontWeight.w700,
                                ),
                              ),
                              const SizedBox(height: 12),
                              Text(
                                _pairingCode ?? '------',
                                style: TextStyle(
                                  color: theme.goldPrimary,
                                  fontSize: 64,
                                  fontWeight: FontWeight.w900,
                                  letterSpacing: 16,
                                  fontFamily: 'monospace',
                                ),
                              ),
                            ],
                          ),
                        ),
                        const SizedBox(height: 30),

                        // Steps
                        _buildStepRow('۱', 'با موبایل خود وارد پنل مدیریت طلالایو بخش «تلویزیون‌ها» شوید.'),
                        const SizedBox(height: 14),
                        _buildStepRow('۲', 'کد ۶ رقمی بالا را در کادر اتصال وارد کنید یا بارکد مقابل را اسکن فرمایید.'),
                      ],
                    ],
                  ),
                ),
                const SizedBox(width: 80),

                // 2. Left Column: QR Code Card
                Expanded(
                  flex: 2,
                  child: Container(
                    padding: const EdgeInsets.all(40),
                    decoration: BoxDecoration(
                      gradient: theme.cardGradient,
                      borderRadius: BorderRadius.circular(32),
                      border: Border.all(color: theme.goldPrimary.withOpacity(0.35), width: 1.5),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.4),
                          blurRadius: 30,
                          offset: const Offset(0, 10),
                        ),
                      ],
                    ),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text(
                          'اسکن سریع با دوربین گوشی',
                          style: TextStyle(
                            color: theme.goldPrimary,
                            fontSize: 22,
                            fontWeight: FontWeight.w900,
                          ),
                        ),
                        const SizedBox(height: 10),
                        Text(
                          'دوربین موبایل را مقابل بارکد بگیرید',
                          style: TextStyle(
                            color: theme.textSecondary,
                            fontSize: 14,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        const SizedBox(height: 30),

                        // QR Box
                        Container(
                          padding: const EdgeInsets.all(16),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(24),
                            boxShadow: [
                              BoxShadow(
                                color: theme.goldPrimary.withOpacity(0.3),
                                blurRadius: 20,
                              ),
                            ],
                          ),
                          child: _qrUrl != null
                              ? QrImageView(
                                  data: _qrUrl!,
                                  version: QrVersions.auto,
                                  size: 260.0,
                                )
                              : const SizedBox(
                                  width: 260,
                                  height: 260,
                                  child: Center(
                                    child: CircularProgressIndicator(),
                                  ),
                                ),
                        ),
                        const SizedBox(height: 24),
                        Text(
                          'talalive.ir/tv',
                          style: TextStyle(
                            color: theme.textMuted,
                            fontSize: 16,
                            fontWeight: FontWeight.w700,
                            fontFamily: 'monospace',
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildStepRow(String number, String text) {
    return Row(
      textDirection: TextDirection.rtl,
      children: [
        Container(
          width: 34,
          height: 34,
          decoration: const BoxDecoration(
            color: Color(0xFFF59E0B),
            shape: BoxShape.circle,
          ),
          alignment: Alignment.center,
          child: Text(
            PersianUtils.toPersianDigits(number),
            style: const TextStyle(
              color: Color(0xFF020617),
              fontSize: 16,
              fontWeight: FontWeight.w900,
            ),
          ),
        ),
        const SizedBox(width: 14),
        Expanded(
          child: Text(
            text,
            style: const TextStyle(
              color: Color(0xFFCBD5E1),
              fontSize: 17,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
      ],
    );
  }
}
