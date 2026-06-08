import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import '../core/theme/app_colors.dart';
import '../services/collection_service.dart';
import '../models/katalog.dart';

class DetailScreen extends StatefulWidget {
  final String? id;
  final String title;
  final String? imageUrl;
  final String content;
  final String category;
  final String? latitude;
  final String? longitude;

  const DetailScreen({
    super.key,
    this.id,
    required this.title,
    this.imageUrl,
    required this.content,
    required this.category,
    this.latitude,
    this.longitude,
  });

  @override
  State<DetailScreen> createState() => _DetailScreenState();
}

class _DetailScreenState extends State<DetailScreen> {
  final CollectionService _collectionService = CollectionService();
  bool _isSaved = false;

  @override
  void initState() {
    super.initState();
    _checkIfSaved();
  }

  Future<void> _checkIfSaved() async {
    if (widget.id == null) return;
    final collection = await _collectionService.getCollection();
    final isSaved = collection.any((item) => item.id.toString() == widget.id);
    setState(() => _isSaved = isSaved);
  }

  Future<void> _toggleSave() async {
    if (widget.id == null) return;

    final item = Katalog(
      id: int.parse(widget.id!),
      kategori: widget.category.toLowerCase(),
      nama: widget.title,
      deskripsi: widget.content,
      gambar: widget.imageUrl?.split('/').last ?? '',
    );

    if (_isSaved) {
      await _collectionService.removeFromCollection(item.id, item.kategori);
    } else {
      await _collectionService.addToCollection(item);
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Row(children: [
              const Icon(Icons.check_circle_rounded, color: Colors.white),
              const SizedBox(width: 8),
              Flexible(child: Text('${widget.title} ditambahkan ke koleksi')),
            ]),
            backgroundColor: AppColors.primary,
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          ),
        );
      }
    }
    setState(() => _isSaved = !_isSaved);
  }

  @override
  Widget build(BuildContext context) {
    final lat = double.tryParse(widget.latitude ?? '');
    final lng = double.tryParse(widget.longitude ?? '');
    final hasCoordinates = lat != null && lng != null;

    // Peta hanya ditampilkan untuk kategori destinasi (bukan berita/artikel)
    final mapCategories = ['anjungan', 'museum', 'wahana', 'rekreasi'];
    final showMap = mapCategories.contains(widget.category.toLowerCase()) && hasCoordinates;

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: CustomScrollView(
        slivers: [
          SliverAppBar(
            expandedHeight: 280.0,
            floating: false,
            pinned: true,
            iconTheme: const IconThemeData(color: Colors.white),
            backgroundColor: AppColors.primary,
            leading: Container(
              margin: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: Colors.black.withValues(alpha: 0.3),
                shape: BoxShape.circle,
              ),
              child: IconButton(
                icon: const Icon(Icons.arrow_back_rounded, color: Colors.white, size: 20),
                onPressed: () => Navigator.pop(context),
              ),
            ),
            flexibleSpace: FlexibleSpaceBar(
              collapseMode: CollapseMode.parallax,
              background: Stack(
                fit: StackFit.expand,
                children: [
                  Image.network(
                    widget.imageUrl ?? 'https://via.placeholder.com/600x400',
                    fit: BoxFit.cover,
                    errorBuilder: (c, e, s) => Container(color: Colors.grey[200], child: const Icon(Icons.image_not_supported, size: 80, color: Colors.grey)),
                  ),
                  Container(
                    decoration: BoxDecoration(
                      gradient: LinearGradient(
                        begin: Alignment.bottomCenter, end: Alignment.topCenter,
                        colors: [Colors.black.withValues(alpha: 0.75), Colors.transparent],
                        stops: const [0.0, 0.5],
                      ),
                    ),
                  ),
                  Positioned(
                    bottom: 20, left: 20, right: 20,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                          decoration: BoxDecoration(
                            gradient: AppColors.primaryGradient,
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Text(
                            widget.category.toUpperCase(),
                            style: const TextStyle(color: Colors.white, fontSize: 9, fontWeight: FontWeight.w800, letterSpacing: 0.5),
                          ),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          widget.title,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 24,
                            fontWeight: FontWeight.w900,
                            height: 1.2,
                            letterSpacing: -0.2,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),

          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.all(24.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Info Chips
                  SingleChildScrollView(
                    scrollDirection: Axis.horizontal,
                    child: Row(
                      children: [
                        _buildInfoChip(Icons.access_time_rounded, '08.00 - 17.00 WIB'),
                        const SizedBox(width: 10),
                        _buildInfoChip(Icons.location_on_rounded, 'TMII Area'),
                      ],
                    ),
                  ),
                  const SizedBox(height: 28),

                  // About Section
                  Text(
                    'Tentang Destinasi',
                    style: TextStyle(
                      fontSize: 19,
                      fontWeight: FontWeight.w800,
                      color: Theme.of(context).colorScheme.onSurface,
                      letterSpacing: -0.2,
                    ),
                  ),
                  const SizedBox(height: 10),
                  Text(
                    widget.content,
                    style: TextStyle(
                      fontSize: 14.5,
                      height: 1.65,
                      color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.75),
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  const SizedBox(height: 28),

                  // Map — hanya untuk anjungan/museum/wahana/rekreasi
                  if (showMap) ...[
                    Row(
                      children: [
                        const Icon(Icons.map_rounded, color: AppColors.primary, size: 22),
                        const SizedBox(width: 8),
                        Text(
                          'Lokasi di Peta',
                          style: TextStyle(
                            fontSize: 19,
                            fontWeight: FontWeight.w800,
                            color: Theme.of(context).colorScheme.onSurface,
                            letterSpacing: -0.2,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 14),
                    Container(
                      height: 180,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(20),
                        boxShadow: AppColors.premiumShadow(),
                        border: Border.all(color: Theme.of(context).dividerColor),
                      ),
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(20),
                        child: FlutterMap(
                          options: MapOptions(
                            initialCenter: LatLng(lat, lng),
                            initialZoom: 17.0,
                            interactionOptions: const InteractionOptions(
                              flags: InteractiveFlag.pinchZoom | InteractiveFlag.drag,
                            ),
                          ),
                          children: [
                            TileLayer(
                              urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                              userAgentPackageName: 'com.example.jelajahi_tmii',
                            ),
                            MarkerLayer(
                              markers: [
                                Marker(
                                  point: LatLng(lat, lng),
                                  width: 50,
                                  height: 50,
                                  child: Container(
                                    padding: const EdgeInsets.all(4),
                                    decoration: BoxDecoration(
                                      color: Colors.white,
                                      shape: BoxShape.circle,
                                      boxShadow: AppColors.premiumShadow(),
                                    ),
                                    child: const Icon(Icons.location_on, color: AppColors.primary, size: 36),
                                  ),
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                    ),
                  ],

                  const SizedBox(height: 80),
                ],
              ),
            ),
          ),
        ],
      ),

      // Sticky Save Button
      bottomNavigationBar: widget.id != null ? Container(
        padding: const EdgeInsets.fromLTRB(24, 16, 24, 30),
        decoration: BoxDecoration(
          color: Theme.of(context).cardColor,
          borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withValues(alpha: 0.05),
              blurRadius: 16,
              offset: const Offset(0, -4),
            )
          ],
          border: Border(top: BorderSide(color: Theme.of(context).dividerColor)),
        ),
        child: SizedBox(
          width: double.infinity,
          height: 54,
          child: ElevatedButton.icon(
            onPressed: _toggleSave,
            style: ElevatedButton.styleFrom(
              backgroundColor: _isSaved ? Theme.of(context).colorScheme.primary.withValues(alpha: 0.15) : AppColors.primary,
              foregroundColor: _isSaved ? AppColors.primary : Colors.white,
              elevation: _isSaved ? 0 : 2,
              shadowColor: _isSaved ? null : AppColors.primary.withValues(alpha: 0.2),
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
            ),
            icon: Icon(_isSaved ? Icons.bookmark_rounded : Icons.bookmark_border_rounded, size: 20),
            label: Text(
              _isSaved ? 'Tersimpan di Koleksi' : 'Simpan Ke Koleksi',
              style: const TextStyle(fontWeight: FontWeight.w800, fontSize: 15),
            ),
          ),
        ),
      ) : null,
    );
  }

  Widget _buildInfoChip(IconData icon, String label) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.primary.withValues(alpha: 0.12),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Theme.of(context).colorScheme.primary.withValues(alpha: 0.2)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 16, color: AppColors.primary),
          const SizedBox(width: 6),
          Text(
            label,
            style: const TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w700,
              color: AppColors.primary,
            ),
          ),
        ],
      ),
    );
  }
}
