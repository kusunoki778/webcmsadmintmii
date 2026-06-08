import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import '../models/katalog.dart';

class CollectionService {
  static const String _key = 'user_koleksi';

  Future<void> addToCollection(Katalog item) async {
    final prefs = await SharedPreferences.getInstance();
    List<String> koleksi = prefs.getStringList(_key) ?? [];
    
    // Cek apakah sudah ada (berdasarkan ID)
    bool exists = koleksi.any((element) {
      final json = jsonDecode(element);
      return json['id'] == item.id && json['kategori'] == item.kategori;
    });

    if (!exists) {
      // Simpan objek utuh sebagai JSON string
      Map<String, dynamic> itemMap = {
        'id': item.id,
        'nama': item.nama,
        'deskripsi': item.deskripsi,
        'gambar': item.gambar,
        'kategori': item.kategori,
      };
      koleksi.add(jsonEncode(itemMap));
      await prefs.setStringList(_key, koleksi);
    }
  }

  Future<void> removeFromCollection(int id, String kategori) async {
    final prefs = await SharedPreferences.getInstance();
    List<String> koleksi = prefs.getStringList(_key) ?? [];
    
    koleksi.removeWhere((element) {
      final json = jsonDecode(element);
      return json['id'] == id && json['kategori'] == kategori;
    });

    await prefs.setStringList(_key, koleksi);
  }

  Future<List<Katalog>> getCollection() async {
    final prefs = await SharedPreferences.getInstance();
    List<String> koleksi = prefs.getStringList(_key) ?? [];
    
    return koleksi.map((item) {
      return Katalog.fromJson(jsonDecode(item));
    }).toList();
  }

  Future<bool> isBookmarked(int id, String kategori) async {
    final prefs = await SharedPreferences.getInstance();
    List<String> koleksi = prefs.getStringList(_key) ?? [];
    
    return koleksi.any((element) {
      final json = jsonDecode(element);
      return json['id'] == id && json['kategori'] == kategori;
    });
  }
}
