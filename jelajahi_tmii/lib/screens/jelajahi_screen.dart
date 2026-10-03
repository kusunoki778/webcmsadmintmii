import 'package:flutter/material.dart';
import '../core/theme/app_colors.dart';
import '../core/theme/premium_loader.dart';
import '../core/theme/app_page_route.dart';
import '../services/api_service.dart';
import '../models/katalog.dart';
import 'detail_screen.dart';

class JelajahiScreen extends StatefulWidget {
  const JelajahiScreen({super.key});

  @override
  State<JelajahiScreen> createState() => _JelajahiScreenState();
}

class _JelajahiScreenState extends State<JelajahiScreen> {
  final ApiService _apiService = ApiService();
  final TextEditingController _searchController = TextEditingController();
  String _activeTab = 'anjungan';
  late Future<List<Katalog>> _futureKatalog;
  String _searchQuery = '';

  final List<Map<String, String>> _tabs = [
    {'key': 'anjungan', 'label': 'Anjungan'},
    {'key': 'wahana', 'label': 'Wahana'},
    {'key': 'museum', 'label': 'Museum'},
  ];

  @override
  void initState() {
    super.initState();
    _fetchData();
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  void _fetchData() {
    setState(() {
      _futureKatalog = _apiService.fetchKatalog(_activeTab);
    });
  }

  List<Katalog> _filterResults(List<Katalog> items) {
    if (_searchQuery.isEmpty) return items;
    return items.where((item) => item.nama.toLowerCase().contains(_searchQuery.toLowerCase())).toList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Header & Search
            Padding(
              padding: const EdgeInsets.fromLTRB(24, 24, 24, 16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Jelajahi TMII',
                    style: TextStyle(
                      fontSize: 26,
                      fontWeight: FontWeight.w900,
                      color: Theme.of(context).colorScheme.onSurface,
                      letterSpacing: -0.5,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Container(
                    decoration: BoxDecoration(
                      color: Theme.of(context).cardColor,
                      borderRadius: BorderRadius.circular(16),
                      boxShadow: AppColors.premiumShadow(),
                      border: Border.all(color: Theme.of(context).dividerColor),
                    ),
                    child: TextField(
                      controller: _searchController,
                      onChanged: (val) => setState(() => _searchQuery = val),
                      style: TextStyle(fontSize: 15, color: Theme.of(context).colorScheme.onSurface, fontWeight: FontWeight.w600),
                      decoration: InputDecoration(
                        prefixIcon: const Icon(Icons.search_rounded, color: AppColors.primary, size: 22),
                        hintText: 'Cari anjungan, museum, atau wahana...',
                        border: InputBorder.none,
                        hintStyle: const TextStyle(color: AppColors.textHint, fontSize: 14, fontWeight: FontWeight.normal),
                        contentPadding: const EdgeInsets.symmetric(vertical: 14),
                        suffixIcon: _searchQuery.isNotEmpty
                            ? IconButton(
                                icon: const Icon(Icons.clear_rounded, color: AppColors.textHint, size: 20),
                                onPressed: () {
                                  _searchController.clear();
                                  setState(() {
                                    _searchQuery = '';
                                  });
                                },
                              )
                            : null,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // Pill Tabs
            SizedBox(
              height: 46,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 20),
                itemCount: _tabs.length,
                itemBuilder: (context, index) {
                  final tab = _tabs[index];
                  final isActive = _activeTab == tab['key'];
                  return GestureDetector(
                    onTap: () {
                      if (_activeTab != tab['key']) {
                        _activeTab = tab['key']!;
                        _searchController.clear();
                        _searchQuery = '';
                        _fetchData();
                      }
                    },
                    child: AnimatedContainer(
                      duration: const Duration(milliseconds: 250),
                      curve: Curves.easeInOut,
                      margin: const EdgeInsets.symmetric(horizontal: 4),
                      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 8),
                      decoration: BoxDecoration(
                        gradient: isActive ? AppColors.primaryGradient : null,
                        color: isActive ? null : Theme.of(context).cardColor,
                        borderRadius: BorderRadius.circular(20),
                        boxShadow: isActive ? AppColors.activeShadow() : AppColors.premiumShadow(),
                        border: isActive ? null : Border.all(color: Theme.of(context).dividerColor),
                      ),
                      child: Center(
                        child: Text(
                          tab['label']!,
                          style: TextStyle(
                            color: isActive ? Colors.white : AppColors.textSecondary,
                            fontWeight: isActive ? FontWeight.w800 : FontWeight.w600,
                            fontSize: 14,
                          ),
                        ),
                      ),
                    ),
                  );
                },
              ),
            ),
            const SizedBox(height: 14),

            // Grid Content
            Expanded(
              child: FutureBuilder<List<Katalog>>(
                future: _futureKatalog,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return _buildSkeletonLoading();
                  } else if (snapshot.hasError) {
                    return _buildErrorState();
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return _buildEmptyState();
                  }

                  final filtered = _filterResults(snapshot.data!);
                  if (filtered.isEmpty) {
                    return _buildEmptyState(message: 'Tidak ditemukan untuk "$_searchQuery"');
                  }

                  return GridView.builder(
                    padding: const EdgeInsets.fromLTRB(24, 8, 24, 100),
                    gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: 2,
                      crossAxisSpacing: 16,
                      mainAxisSpacing: 16,
                      childAspectRatio: 0.68,
                    ),
                    itemCount: filtered.length,
                    itemBuilder: (context, index) {
                      final item = filtered[index];
                      final imageUrl = ApiService.getStorageUrl(item.gambar, 'katalogs');

                      return GestureDetector(
                        onTap: () => Navigator.push(context, AppPageRoute(
                          page: DetailScreen(
                            id: item.id.toString(),
                            title: item.nama,
                            imageUrl: imageUrl,
                            content: item.deskripsi,
                            category: item.kategori,
                            latitude: item.latitude,
                            longitude: item.longitude,
                          ),
                        )),
                        child: Container(
                          decoration: BoxDecoration(
                            color: Theme.of(context).cardColor,
                            borderRadius: BorderRadius.circular(20),
                            boxShadow: AppColors.premiumShadow(),
                            border: Border.all(color: Theme.of(context).dividerColor),
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Hero(
                                tag: 'katalog_${item.id}',
                                child: ClipRRect(
                                  borderRadius: const BorderRadius.vertical(top: Radius.circular(20)),
                                  child: Image.network(
                                    imageUrl, height: 105, width: double.infinity, fit: BoxFit.cover,
                                    errorBuilder: (c, e, s) => Container(height: 105, color: Colors.grey[200], child: const Icon(Icons.image, color: Colors.grey)),
                                  ),
                                ),
                              ),
                              Expanded(
                                child: Padding(
                                  padding: const EdgeInsets.all(12),
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            item.nama,
                                            maxLines: 2,
                                            overflow: TextOverflow.ellipsis,
                                            style: TextStyle(
                                              fontWeight: FontWeight.w800,
                                              fontSize: 13.5,
                                              color: Theme.of(context).colorScheme.onSurface,
                                              height: 1.25,
                                            ),
                                          ),
                                          const SizedBox(height: 4),
                                          Text(
                                            item.deskripsi,
                                            maxLines: 2,
                                            overflow: TextOverflow.ellipsis,
                                            style: const TextStyle(
                                              color: AppColors.textSecondary,
                                              fontSize: 11,
                                              height: 1.3,
                                            ),
                                          ),
                                        ],
                                      ),
                                      Row(
                                        children: [
                                          const Icon(Icons.location_on_rounded, color: AppColors.primary, size: 10),
                                          const SizedBox(width: 2),
                                          Expanded(
                                            child: Text(
                                              'TMII Area',
                                              style: TextStyle(
                                                fontSize: 10,
                                                fontWeight: FontWeight.w600,
                                                color: AppColors.primary,
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
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
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSkeletonLoading() {
    return const Center(
      child: PremiumLoader(size: 48),
    );
  }

  Widget _buildErrorState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Icon(Icons.error_outline_rounded, color: AppColors.error, size: 48),
          const SizedBox(height: 16),
          const Text('Terjadi kesalahan', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w700)),
          const SizedBox(height: 8),
          TextButton(onPressed: _fetchData, child: const Text('Coba Lagi', style: TextStyle(color: AppColors.primary, fontWeight: FontWeight.w600))),
        ],
      ),
    );
  }

  Widget _buildEmptyState({String? message}) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Icon(Icons.search_off_rounded, color: AppColors.textHint, size: 48),
          const SizedBox(height: 16),
          Text(message ?? 'Tidak ditemukan', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: AppColors.textSecondary)),
          const SizedBox(height: 4),
          const Text('Coba kata kunci lain', style: TextStyle(color: AppColors.textHint)),
        ],
      ),
    );
  }
}
