import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import '../core/theme/app_colors.dart';
import '../services/api_service.dart';
import '../main.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SettingsScreen extends StatefulWidget {
  const SettingsScreen({super.key});

  @override
  State<SettingsScreen> createState() => _SettingsScreenState();
}

class _SettingsScreenState extends State<SettingsScreen> {
  final ApiService _apiService = ApiService();
  Map<String, String> _settings = {};
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadSettings();
  }

  Future<void> _loadSettings() async {
    try {
      final data = await _apiService.fetchSettings();
      setState(() {
        _settings = data;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
    }
  }

  Future<void> _openUrl(String url) async {
    if (url.isEmpty) return;
    try {
      await launchUrl(Uri.parse(url), mode: LaunchMode.externalApplication);
    } catch (e) {
      // silently fail
    }
  }

  Future<void> _openWhatsApp() async {
    final wa = _settings['contact_whatsapp'] ?? '';
    if (wa.isEmpty) return;
    final phone = wa.startsWith('0') ? '62${wa.substring(1)}' : wa;
    await _openUrl('https://wa.me/$phone');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        title: const Text('Pengaturan', style: TextStyle(fontWeight: FontWeight.w900, fontSize: 22, letterSpacing: -0.5)),
        backgroundColor: Theme.of(context).cardColor,
        surfaceTintColor: Colors.transparent,
        elevation: 0,
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(1),
          child: Container(color: Theme.of(context).dividerColor, height: 1),
        ),
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
          : ListView(
              padding: const EdgeInsets.fromLTRB(24, 24, 24, 100),
              children: [
                // App Info Header Card
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    gradient: AppColors.cardGradient,
                    borderRadius: BorderRadius.circular(24),
                    boxShadow: AppColors.activeShadow(),
                  ),
                  child: Column(
                    children: [

                      const Text(
                        'Jelajahi TMII',
                        style: TextStyle(fontSize: 22, fontWeight: FontWeight.w900, color: Colors.white, letterSpacing: -0.2),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        _settings['site_name'] ?? 'Taman Mini Indonesia Indah',
                        style: TextStyle(fontSize: 13, color: Colors.white.withValues(alpha: 0.85), fontWeight: FontWeight.w500),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 28),

                _buildSectionTitle('TAMPILAN'),
                _buildMenuItem(
                  icon: Icons.brightness_6_outlined,
                  title: 'Tema Aplikasi',
                  subtitle: _getThemeLabel(),
                  onTap: _showThemeDialog,
                ),
                const SizedBox(height: 12),

                // Menu Items
                _buildSectionTitle('INFORMASI'),
                _buildMenuItem(
                  icon: Icons.info_outline_rounded,
                  title: 'Tentang TMII',
                  subtitle: 'Sejarah dan informasi umum',
                  onTap: () => _showAboutDialog(),
                ),
                _buildMenuItem(
                  icon: Icons.phone_outlined,
                  title: 'Hubungi Kami',
                  subtitle: _settings['contact_whatsapp'] ?? '-',
                  onTap: _openWhatsApp,
                ),
                _buildMenuItem(
                  icon: Icons.email_outlined,
                  title: 'Email',
                  subtitle: _settings['contact_email'] ?? '-',
                  onTap: () => _openUrl('mailto:${_settings['contact_email'] ?? ''}'),
                ),

                const SizedBox(height: 20),
                _buildSectionTitle('MEDIA SOSIAL'),
                _buildMenuItem(
                  icon: Icons.camera_alt_outlined,
                  title: 'Instagram',
                  subtitle: '@tmiiofficial',
                  onTap: () => _openUrl(_settings['instagram_url'] ?? ''),
                ),
                _buildMenuItem(
                  icon: Icons.music_note_outlined,
                  title: 'TikTok',
                  subtitle: '@tmiiofficial',
                  onTap: () => _openUrl(_settings['tiktok_url'] ?? ''),
                ),
                _buildMenuItem(
                  icon: Icons.facebook_outlined,
                  title: 'Facebook',
                  subtitle: 'TMII Official',
                  onTap: () => _openUrl(_settings['facebook_url'] ?? ''),
                ),
                _buildMenuItem(
                  icon: Icons.play_circle_outline_rounded,
                  title: 'YouTube',
                  subtitle: 'TMII Official',
                  onTap: () => _openUrl(_settings['youtube_url'] ?? ''),
                ),

                const SizedBox(height: 20),
                _buildSectionTitle('LAINNYA'),
                _buildMenuItem(
                  icon: Icons.star_outline_rounded,
                  title: 'Beri Rating',
                  subtitle: 'Bantu kami berkembang',
                  onTap: () {},
                ),
                _buildMenuItem(
                  icon: Icons.shield_outlined,
                  title: 'Kebijakan Privasi',
                  subtitle: 'Ketentuan penggunaan',
                  onTap: () {},
                ),

                const SizedBox(height: 32),
                const Center(
                  child: Text('Versi 1.0.0', style: TextStyle(fontSize: 12.5, color: AppColors.textHint, fontWeight: FontWeight.w600)),
                ),
              ],
            ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(4, 0, 0, 10),
      child: Text(
        title,
        style: const TextStyle(fontSize: 11.5, fontWeight: FontWeight.w800, color: AppColors.textHint, letterSpacing: 0.8),
      ),
    );
  }

  Widget _buildMenuItem({
    required IconData icon,
    required String title,
    required String subtitle,
    required VoidCallback onTap,
  }) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(18),
        boxShadow: AppColors.premiumShadow(),
        border: Border.all(color: Theme.of(context).dividerColor),
      ),
      child: ListTile(
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
        leading: Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: AppColors.primary.withValues(alpha: 0.1),
            borderRadius: BorderRadius.circular(14),
          ),
          child: Icon(icon, color: AppColors.primary, size: 22),
        ),
        title: Text(title, style: TextStyle(fontWeight: FontWeight.w700, fontSize: 14.5, color: Theme.of(context).colorScheme.onSurface)),
        subtitle: Text(subtitle, style: TextStyle(fontSize: 12.5, color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.6), fontWeight: FontWeight.w500)),
        trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.textHint, size: 22),
        onTap: onTap,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
      ),
    );
  }

  void _showAboutDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        backgroundColor: Theme.of(context).cardColor,
        surfaceTintColor: Colors.transparent,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        title: Text('Tentang TMII', style: TextStyle(fontWeight: FontWeight.w900, color: Theme.of(context).colorScheme.onSurface)),
        content: SingleChildScrollView(
          child: Text(
            _settings['about_history_content'] ?? 'Taman Mini Indonesia Indah adalah kawasan taman wisata bertema budaya Indonesia.',
            style: TextStyle(fontSize: 14.5, height: 1.6, color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.7), fontWeight: FontWeight.w500),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Tutup', style: TextStyle(color: AppColors.primary, fontWeight: FontWeight.w800, fontSize: 14.5)),
          ),
        ],
      ),
    );
  }

  String _getThemeLabel() {
    final mode = JelajahiTMIIApp.themeNotifier.value;
    if (mode == ThemeMode.light) return 'Terang';
    if (mode == ThemeMode.dark) return 'Gelap';
    return 'Ikuti Sistem';
  }

  void _showThemeDialog() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          backgroundColor: Theme.of(context).cardColor,
          surfaceTintColor: Colors.transparent,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
          title: const Text('Pilih Tema', style: TextStyle(fontWeight: FontWeight.w900)),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              _buildThemeOption(ThemeMode.light, 'Terang', Icons.wb_sunny_rounded),
              _buildThemeOption(ThemeMode.dark, 'Gelap', Icons.nightlight_round),
              _buildThemeOption(ThemeMode.system, 'Ikuti Sistem', Icons.settings_brightness_rounded),
            ],
          ),
        );
      },
    );
  }

  Widget _buildThemeOption(ThemeMode mode, String label, IconData icon) {
    final currentMode = JelajahiTMIIApp.themeNotifier.value;
    final isSelected = currentMode == mode;
    return ListTile(
      leading: Icon(icon, color: isSelected ? AppColors.primary : AppColors.textSecondary),
      title: Text(
        label,
        style: TextStyle(
          fontWeight: isSelected ? FontWeight.bold : FontWeight.w500,
          color: isSelected ? AppColors.primary : Theme.of(context).textTheme.bodyLarge?.color,
        ),
      ),
      trailing: isSelected ? const Icon(Icons.check_circle_rounded, color: AppColors.primary) : null,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      onTap: () async {
        Navigator.pop(context);
        final prefs = await SharedPreferences.getInstance();
        String saveVal = 'system';
        if (mode == ThemeMode.light) saveVal = 'light';
        if (mode == ThemeMode.dark) saveVal = 'dark';
        await prefs.setString('theme_mode', saveVal);
        JelajahiTMIIApp.themeNotifier.value = mode;
        setState(() {});
      },
    );
  }
}

