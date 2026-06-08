import 'package:flutter/material.dart';
import '../core/theme/app_colors.dart';
import '../services/collection_service.dart';
import '../services/api_service.dart';
import '../models/katalog.dart';
import 'detail_screen.dart';
import '../core/theme/premium_loader.dart';
import '../core/theme/app_page_route.dart';

class KoleksiScreen extends StatefulWidget {
  const KoleksiScreen({super.key});

  @override
  State<KoleksiScreen> createState() => _KoleksiScreenState();
}

class _KoleksiScreenState extends State<KoleksiScreen> {
  final CollectionService _collectionService = CollectionService();
  List<Katalog> _koleksiItems = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadAll();
  }

  Future<void> _loadAll() async {
    setState(() => _isLoading = true);
    final items = await _collectionService.getCollection();
    setState(() {
      _koleksiItems = items;
      _isLoading = false;
    });
  }

  Future<void> _removeItem(Katalog item) async {
    await _collectionService.removeFromCollection(item.id, item.kategori);
    _loadAll();
    if (mounted) {
      ScaffoldMessenger.of(context).hideCurrentSnackBar();
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('${item.nama} dihapus dari koleksi'),
          backgroundColor: AppColors.textPrimary,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          action: SnackBarAction(
            label: 'BATALKAN',
            textColor: AppColors.primaryLight,
            onPressed: () async {
              await _collectionService.addToCollection(item);
              _loadAll();
            },
          ),
        ),
      );
    }
  }



  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: _isLoading
            ? const Center(child: PremiumLoader())
            : RefreshIndicator(
                color: AppColors.primary,
                onRefresh: () async => _loadAll(),
                child: SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Padding(
                        padding: const EdgeInsets.fromLTRB(24, 24, 24, 4),
                        child: Text(
                          'Koleksi Favorit',
                          style: TextStyle(
                            fontSize: 26,
                            fontWeight: FontWeight.w900,
                            color: Theme.of(context).textTheme.bodyLarge?.color ?? AppColors.textPrimary,
                            letterSpacing: -0.5,
                          ),
                        ),
                      ),

                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 4),
                        child: Text(
                          '${_koleksiItems.length} destinasi disimpan',
                          style: const TextStyle(fontSize: 13.5, color: AppColors.textSecondary, fontWeight: FontWeight.w600),
                        ),
                      ),
                      const SizedBox(height: 16),

                      if (_koleksiItems.isEmpty)
                        _buildEmptyKoleksi()
                      else
                        _buildKoleksiList(),

                      const SizedBox(height: 32),
                      const Center(child: Text('Jelajahi TMII v1.0.0', style: TextStyle(fontSize: 12, color: AppColors.textHint, fontWeight: FontWeight.w500))),
                      const SizedBox(height: 100),
                    ],
                  ),
                ),
              ),
      ),
    );
  }

  Widget _buildEmptyKoleksi() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 24, vertical: 8),
      padding: const EdgeInsets.all(32),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Theme.of(context).dividerColor),
        boxShadow: AppColors.premiumShadow(),
      ),
      child: Column(
        children: [
          const Icon(Icons.bookmark_border_rounded, size: 44, color: AppColors.primary),
          const SizedBox(height: 14),
          Text(
            'Belum ada koleksi',
            style: TextStyle(fontSize: 16, fontWeight: FontWeight.w800, color: Theme.of(context).textTheme.bodyLarge?.color ?? AppColors.textPrimary),
          ),
          const SizedBox(height: 4),
          const Text(
            'Simpan tempat favoritmu dari halaman Jelajahi untuk akses cepat di sini.',
            textAlign: TextAlign.center,
            style: TextStyle(fontSize: 12.5, color: AppColors.textSecondary, height: 1.4),
          ),
        ],
      ),

    );
  }

  Widget _buildKoleksiList() {
    return ListView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 4),
      itemCount: _koleksiItems.length,
      itemBuilder: (context, index) {
        final item = _koleksiItems[index];
        final imageUrl = ApiService.getStorageUrl(item.gambar, 'katalogs');

        return TweenAnimationBuilder<double>(
          tween: Tween(begin: 0.0, end: 1.0),
          duration: Duration(milliseconds: 300 + (index * 80)),
          curve: Curves.easeOutCubic,
          builder: (context, value, child) {
            return Opacity(
              opacity: value,
              child: Transform.translate(
                offset: Offset(0, 20 * (1 - value)),
                child: child,
              ),
            );
          },
          child: Dismissible(
            key: Key('${item.id}_${item.kategori}'),
            direction: DismissDirection.endToStart,
            background: Container(
              alignment: Alignment.centerRight,
              padding: const EdgeInsets.only(right: 24),
              margin: const EdgeInsets.only(bottom: 12),
              decoration: BoxDecoration(
                color: AppColors.error.withValues(alpha: 0.08),
                borderRadius: BorderRadius.circular(20),
              ),
              child: const Icon(Icons.delete_rounded, color: AppColors.error, size: 26),
            ),
            onDismissed: (_) => _removeItem(item),
            child: GestureDetector(
              onTap: () => Navigator.push(context, AppPageRoute(
                page: DetailScreen(
                  id: item.id.toString(),
                  title: item.nama,
                  imageUrl: imageUrl,
                  content: item.deskripsi,
                  category: item.kategori,
                ),
              )),
              child: Container(
                margin: const EdgeInsets.only(bottom: 12),
                decoration: BoxDecoration(
                  color: Theme.of(context).cardColor,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: AppColors.premiumShadow(color: Theme.of(context).shadowColor),
                  border: Border.all(color: Theme.of(context).dividerColor),
                ),
                child: Row(
                  children: [
                    ClipRRect(
                      borderRadius: const BorderRadius.only(topLeft: Radius.circular(20), bottomLeft: Radius.circular(20)),
                      child: Image.network(imageUrl, width: 85, height: 85, fit: BoxFit.cover,
                        errorBuilder: (c, e, s) => Container(width: 85, height: 85, color: Colors.grey[200], child: const Icon(Icons.image, color: Colors.grey)),
                      ),
                    ),
                    Expanded(
                      child: Padding(
                        padding: const EdgeInsets.all(14),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 7, vertical: 2),
                              decoration: BoxDecoration(color: AppColors.primary.withValues(alpha: 0.1), borderRadius: BorderRadius.circular(6)),
                              child: Text(
                                item.kategori.toUpperCase(),
                                style: const TextStyle(color: AppColors.primary, fontSize: 8.5, fontWeight: FontWeight.w800, letterSpacing: 0.3),
                              ),
                            ),
                            const SizedBox(height: 6),
                            Text(
                              item.nama,
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                              style: TextStyle(fontWeight: FontWeight.w800, fontSize: 14.5, color: Theme.of(context).textTheme.bodyLarge?.color ?? AppColors.textPrimary),
                            ),
                          ],
                        ),
                      ),
                    ),
                    IconButton(
                      padding: const EdgeInsets.all(12),
                      icon: const Icon(Icons.delete_outline_rounded, color: AppColors.error, size: 20),
                      onPressed: () => _removeItem(item),
                    ),
                  ],
                ),
              ),
            ),
          ),
        );
      },
    );
  }
}
