import 'dart:convert';

import 'package:http/http.dart' as http;
import '../models/artikel.dart';
import '../models/katalog.dart';

class ApiService {
  static String get baseUrl {
    // Menggunakan URL ngrok aktif agar HP/Emulator bisa mengakses backend local via internet
    return 'https://used-luteotropic-alta.ngrok-free.dev/api';
  }

  static String getStorageUrl(String? path, String folder) {
    if (path == null || path.isEmpty) return 'https://via.placeholder.com/400x200?text=No+Image';
    return '$baseUrl/image/$folder/$path';
  }

  Future<List<Artikel>> fetchArtikels() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/beranda/artikel'),
        headers: {'ngrok-skip-browser-warning': 'true'},
      );
      if (response.statusCode == 200) {
        List jsonResponse = json.decode(response.body)['data'];
        return jsonResponse.map((data) => Artikel.fromJson(data)).toList();
      } else {
        throw Exception('Gagal memuat artikel: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Koneksi Gagal: Pastikan Laravel sudah dijalankan');
    }
  }

  Future<List<Katalog>> fetchKatalog(String kategori) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/jelajahi/$kategori'),
        headers: {'ngrok-skip-browser-warning': 'true'},
      );
      if (response.statusCode == 200) {
        List jsonResponse = json.decode(response.body)['data'];
        return jsonResponse.map((data) => Katalog.fromJson(data)).toList();
      } else {
        throw Exception('Gagal memuat data $kategori');
      }
    } catch (e) {
      throw Exception('Koneksi Gagal: Cek jaringan atau server Laravel');
    }
  }

  /// Ambil settings/konfigurasi dari CMS
  Future<Map<String, String>> fetchSettings() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/settings'),
        headers: {'ngrok-skip-browser-warning': 'true'},
      );
      if (response.statusCode == 200) {
        final data = json.decode(response.body)['data'];
        return Map<String, String>.from(data);
      } else {
        throw Exception('Gagal memuat settings');
      }
    } catch (e) {
      throw Exception('Koneksi Gagal: Cek server Laravel');
    }
  }

  /// Ambil daftar tiket dari CMS
  Future<List<Map<String, dynamic>>> fetchTikets() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/tiket'),
        headers: {'ngrok-skip-browser-warning': 'true'},
      );
      if (response.statusCode == 200) {
        List jsonResponse = json.decode(response.body)['data'];
        return jsonResponse.cast<Map<String, dynamic>>();
      } else {
        throw Exception('Gagal memuat data tiket');
      }
    } catch (e) {
      throw Exception('Koneksi Gagal: Cek server Laravel');
    }
  }
}

