import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../services/collection_service.dart';
import '../models/katalog.dart';
import 'detail_screen.dart';

class KatalogListScreen extends StatefulWidget {
  final String title;
  final String categoryKey;

  const KatalogListScreen({
    super.key,
    required this.title,
    required this.categoryKey,
  });

  @override
  State<KatalogListScreen> createState() => _KatalogListScreenState();
}

class _KatalogListScreenState extends State<KatalogListScreen> {
  final ApiService _apiService = ApiService();
  final CollectionService _collectionService = CollectionService();
  late Future<List<Katalog>> _futureKatalog;
  Set<String> _bookmarkedIds = {};

  @override
  void initState() {
    super.initState();
    _futureKatalog = _apiService.fetchKatalog(widget.categoryKey);
    _loadBookmarks();
  }

  Future<void> _loadBookmarks() async {
    final collection = await _collectionService.getCollection();
    setState(() {
      _bookmarkedIds = collection
          .where((item) => item.kategori.toLowerCase() == widget.categoryKey.toLowerCase())
          .map((item) => item.id.toString())
          .toSet();
    });
  }

  Future<void> _toggleBookmark(Katalog item) async {
    final key = item.id.toString();
    if (_bookmarkedIds.contains(key)) {
      await _collectionService.removeFromCollection(item.id, item.kategori);
      setState(() { _bookmarkedIds.remove(key); });
    } else {
      await _collectionService.addToCollection(item);
      setState(() { _bookmarkedIds.add(key); });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[50],
      appBar: AppBar(
        title: Text(widget.title, style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.white)),
        backgroundColor: const Color(0xFF00B4B4),
        iconTheme: const IconThemeData(color: Colors.white),
        elevation: 0,
      ),
      body: FutureBuilder<List<Katalog>>(
        future: _futureKatalog,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(
              child: Padding(
                padding: const EdgeInsets.all(20.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Icon(Icons.wifi_off_rounded, size: 60, color: Colors.grey),
                    const SizedBox(height: 20),
                    Text(snapshot.error.toString(), textAlign: TextAlign.center, style: const TextStyle(color: Colors.grey)),
                  ],
                ),
              ),
            );
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('Data tidak tersedia.'));
          }

          return ListView.builder(
            padding: const EdgeInsets.all(20),
            itemCount: snapshot.data!.length,
            itemBuilder: (context, index) {
              final item = snapshot.data![index];
              final imageUrl = ApiService.getStorageUrl(item.gambar, 'katalogs');
              final isFav = _bookmarkedIds.contains(item.id.toString());

              return Container(
                margin: const EdgeInsets.only(bottom: 20),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(25),
                  boxShadow: [
                    BoxShadow(color: Colors.black.withValues(alpha: 0.05), blurRadius: 15, offset: const Offset(0, 8)),
                  ],
                ),
                child: InkWell(
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => DetailScreen(
                          title: item.nama,
                          imageUrl: imageUrl,
                          content: item.deskripsi,
                          category: item.kategori,
                        ),
                      ),
                    );
                  },
                  borderRadius: BorderRadius.circular(25),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Hero(
                        tag: 'katalog_${item.id}',
                        child: ClipRRect(
                          borderRadius: const BorderRadius.vertical(top: Radius.circular(25)),
                          child: Image.network(
                            imageUrl,
                            height: 200,
                            width: double.infinity,
                            fit: BoxFit.cover,
                            errorBuilder: (context, e, s) => Container(color: Colors.grey[200], height: 200, child: const Icon(Icons.broken_image)),
                          ),
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(20.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Expanded(
                                  child: Text(
                                    item.nama,
                                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                                  ),
                                ),
                                Container(
                                  decoration: const BoxDecoration(color: Color(0xFFE0F2FE), shape: BoxShape.circle),
                                  child: IconButton(
                                    icon: Icon(isFav ? Icons.favorite : Icons.favorite_border, color: const Color(0xFF00B4B4)),
                                    onPressed: () => _toggleBookmark(item),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(height: 8),
                            Text(
                              item.deskripsi,
                              maxLines: 2,
                              overflow: TextOverflow.ellipsis,
                              style: TextStyle(color: Colors.grey[600], height: 1.4, fontSize: 14),
                            ),
                            const SizedBox(height: 15),
                            Row(
                              children: [
                                Text('Baca Selengkapnya', style: const TextStyle(color: Color(0xFF00B4B4), fontWeight: FontWeight.bold, fontSize: 13)),
                                const SizedBox(width: 5),
                                const Icon(Icons.arrow_right_alt, color: Color(0xFF00B4B4), size: 18),
                              ],
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
              );
            },
          );
        },
      ),
    );
  }
}
