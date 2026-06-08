import 'package:flutter/material.dart';

/// Palet warna terpusat untuk seluruh aplikasi Jelajahi TMII.
/// Sinkron dengan warna website: Teal primary, Purple aksen.
class AppColors {
  AppColors._(); // Prevent instantiation

  // ── Primary ────────────────────────────────────────────
  static const Color primary = Color(0xFF00B4B4);       // Teal
  static const Color primaryLight = Color(0xFF4DD9D9);   // Teal Light
  static const Color primaryDark = Color(0xFF008A8A);    // Teal Dark

  // ── Accent ─────────────────────────────────────────────
  static const Color accent = Color(0xFF9333EA);          // Purple
  static const Color accentLight = Color(0xFFC4B5FD);     // Lavender
  static const Color accentSoft = Color(0xFFF3E8FF);      // Purple very light

  // ── Surface & Background ───────────────────────────────
  static const Color background = Color(0xFFFAFAFA);      // Off-white
  static const Color surface = Color(0xFFFFFFFF);          // White
  static const Color surfaceTint = Color(0xFFF0FDFD);      // Teal tinted white
  static const Color card = Color(0xFFFFFFFF);             // Card white

  // ── Text ───────────────────────────────────────────────
  static const Color textPrimary = Color(0xFF1A1A2E);     // Near-black
  static const Color textSecondary = Color(0xFF64748B);   // Slate gray
  static const Color textHint = Color(0xFF94A3B8);        // Light gray
  static const Color textOnPrimary = Color(0xFFFFFFFF);   // White on teal

  // ── Status ─────────────────────────────────────────────
  static const Color success = Color(0xFF10B981);          // Green
  static const Color warning = Color(0xFFF59E0B);          // Amber
  static const Color error = Color(0xFFEF4444);            // Red
  static const Color info = Color(0xFF3B82F6);             // Blue

  // ── Divider & Border ───────────────────────────────────
  static const Color divider = Color(0xFFE2E8F0);
  static const Color border = Color(0xFFE2E8F0);

  // ── Category Colors (untuk marker peta) ────────────────
  static const Color anjungan = Color(0xFFFF6B35);         // Orange
  static const Color museum = Color(0xFF3B82F6);           // Blue
  static const Color wahana = Color(0xFF10B981);           // Green
  static const Color fasilitas = Color(0xFFEF4444);        // Red

  // ── Gradients ──────────────────────────────────────────
  static const LinearGradient primaryGradient = LinearGradient(
    colors: [primary, primaryDark],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );

  static const LinearGradient accentGradient = LinearGradient(
    colors: [Color(0xFFa855f7), Color(0xFF9333ea)],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );

  static const LinearGradient cardGradient = LinearGradient(
    colors: [Color(0xFF00B4B4), Color(0xFF9333EA)],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );

  // ── Shadows ────────────────────────────────────────────
  static List<BoxShadow> premiumShadow({Color? color}) {
    return [
      BoxShadow(
        color: (color ?? textPrimary).withValues(alpha: 0.06),
        blurRadius: 20,
        offset: const Offset(0, 8),
      ),
      BoxShadow(
        color: (color ?? textPrimary).withValues(alpha: 0.03),
        blurRadius: 8,
        offset: const Offset(0, 2),
      ),
    ];
  }

  static List<BoxShadow> activeShadow() {
    return [
      BoxShadow(
        color: primary.withValues(alpha: 0.25),
        blurRadius: 16,
        offset: const Offset(0, 6),
      ),
    ];
  }
}

