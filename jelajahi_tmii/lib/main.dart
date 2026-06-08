import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'core/theme/app_theme.dart';
import 'screens/main_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  final prefs = await SharedPreferences.getInstance();
  final themeStr = prefs.getString('theme_mode') ?? 'system';
  ThemeMode initialTheme;
  if (themeStr == 'light') {
    initialTheme = ThemeMode.light;
  } else if (themeStr == 'dark') {
    initialTheme = ThemeMode.dark;
  } else {
    initialTheme = ThemeMode.system;
  }
  JelajahiTMIIApp.themeNotifier.value = initialTheme;
  
  runApp(const JelajahiTMIIApp());
}

class JelajahiTMIIApp extends StatelessWidget {
  const JelajahiTMIIApp({super.key});

  static final ValueNotifier<ThemeMode> themeNotifier = ValueNotifier(ThemeMode.system);

  @override
  Widget build(BuildContext context) {
    return ValueListenableBuilder<ThemeMode>(
      valueListenable: themeNotifier,
      builder: (_, ThemeMode currentMode, _) {
        return MaterialApp(
          title: 'Jelajahi TMII',
          theme: AppTheme.lightTheme,
          darkTheme: AppTheme.darkTheme,
          themeMode: currentMode,
          home: const MainScreen(),
          debugShowCheckedModeBanner: false,
        );
      },
    );
  }
}
