import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'screens/pairing_screen.dart';
import 'screens/board_screen.dart';
import 'services/api_service.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // 1. Force landscape orientation for TV
  await SystemChrome.setPreferredOrientations([
    DeviceOrientation.landscapeLeft,
    DeviceOrientation.landscapeRight,
  ]);

  // 2. Hide system bars (Immersive Fullscreen for TV)
  await SystemChrome.setEnabledSystemUIMode(SystemUiMode.immersiveSticky);

  // 3. Check if already paired
  final paired = await ApiService.isPaired();
  final username = await ApiService.getSavedUsername();

  runApp(TalaLiveTvApp(
    isPaired: paired && username != null && username.isNotEmpty,
    savedUsername: username,
  ));
}

class TalaLiveTvApp extends StatelessWidget {
  final bool isPaired;
  final String? savedUsername;

  const TalaLiveTvApp({
    super.key,
    required this.isPaired,
    this.savedUsername,
  });

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'طلالایو TV',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        brightness: Brightness.dark,
        scaffoldBackgroundColor: const Color(0xFF020617),
        fontFamily: 'Vazirmatn',
        useMaterial3: true,
      ),
      builder: (context, child) {
        return Directionality(
          textDirection: TextDirection.rtl,
          child: child ?? const SizedBox.shrink(),
        );
      },
      home: isPaired
          ? BoardScreen(username: savedUsername!)
          : const PairingScreen(),
    );
  }
}
