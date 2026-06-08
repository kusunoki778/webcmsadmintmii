import 'package:flutter/material.dart';
import 'package:shimmer/shimmer.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:url_launcher/url_launcher.dart';
import '../core/theme/app_colors.dart';
import '../core/theme/app_page_route.dart';
import '../services/api_service.dart';
import '../models/artikel.dart';
import '../models/katalog.dart';
import 'detail_screen.dart';
import 'checkout_webview_screen.dart';

class BerandaScreen extends StatefulWidget {
  const BerandaScreen({super.key});

  @override
  State<BerandaScreen> createState() => _BerandaScreenState();
}

class _BerandaScreenState extends State<BerandaScreen> {
  final ApiService _apiService = ApiService();
  late Future<List<Artikel>> _futureArtikels;
  late Future<List<Katalog>> _futurePopular;
  late Future<Map<String, String>> _futureSettings;

  @override
  void initState() {
    super.initState();
    _futureArtikels = _apiService.fetchArtikels();
    _futurePopular = _apiService.fetchKatalog('anjungan');
    _futureSettings = _apiService.fetchSettings();
  }

  void _refresh() {
    setState(() {
      _futureArtikels = _apiService.fetchArtikels();
      _futurePopular = _apiService.fetchKatalog('anjungan');
      _futureSettings = _apiService.fetchSettings();
    });
  }

  void _openCheckoutWebView(String url) {
    if (url.isEmpty) return;
    Navigator.push(
      context,
      AppPageRoute(
        page: CheckoutWebviewScreen(
          rawUrl: url,
          title: 'Beli Tiket TMII',
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: RefreshIndicator(
          color: AppColors.primary,
          onRefresh: () async => _refresh(),
          child: SingleChildScrollView(
            physics: const AlwaysScrollableScrollPhysics(),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                _buildHeader(),
                _buildHeroBanner(),
                _buildBuyTicketButton(),
                _buildSectionHeader('Tempat Populer', 'Lihat Semua'),
                _buildPopularPlaces(),
                _buildSectionHeader('Berita Terbaru', 'Lihat Semua'),
                _buildLatestNews(),
                _buildMapSection(),
                const SizedBox(height: 100),
              ],
            ),
          ),
        ),
      ),
    );
  }


  // ── HEADER ──────────────────────────────────────────
  Widget _buildHeader() {
    String greeting = 'Selamat Datang';
    final hour = DateTime.now().hour;
    if (hour < 11) {
      greeting = 'Selamat Pagi';
    } else if (hour < 15) {
      greeting = 'Selamat Siang';
    } else if (hour < 18) {
      greeting = 'Selamat Sore';
    } else {
      greeting = 'Selamat Malam';
    }

    return Padding(
      padding: const EdgeInsets.fromLTRB(24, 20, 24, 0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Halo, $greeting!',
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w600,
              color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.6),
            ),
          ),
          const SizedBox(height: 2),
          Text(
            'Jelajahi TMII',
            style: TextStyle(
              fontSize: 25,
              fontWeight: FontWeight.w900,
              color: Theme.of(context).colorScheme.onSurface,
              letterSpacing: -0.5,
            ),
          ),
        ],
      ),
    );
  }

  // ── HERO BANNER ─────────────────────────────────────
  Widget _buildHeroBanner() {
    return Container(
      margin: const EdgeInsets.fromLTRB(24, 20, 24, 0),
      height: 190,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: AppColors.cardGradient,
        boxShadow: AppColors.activeShadow(),
      ),
      child: Stack(
        children: [
          // Decorative circles
          Positioned(
            right: -20,
            top: -20,
            child: Container(
              width: 140,
              height: 140,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: Colors.white.withValues(alpha: 0.08),
              ),
            ),
          ),
          Positioned(
            right: 50,
            bottom: -30,
            child: Container(
              width: 90,
              height: 90,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: Colors.white.withValues(alpha: 0.06),
              ),
            ),
          ),
          // Content
          Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.2),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: const Text(
                    'REKOMENDASI WISATA',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 10,
                      fontWeight: FontWeight.w800,
                      letterSpacing: 1,
                    ),
                  ),
                ),
                const SizedBox(height: 12),
                const Text(
                  'Pesona Budaya\nIndonesia Indah',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 24,
                    fontWeight: FontWeight.w900,
                    height: 1.15,
                    letterSpacing: -0.2,
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  'Rasakan keberagaman tradisi dalam satu tempat',
                  style: TextStyle(
                    color: Colors.white.withValues(alpha: 0.85),
                    fontSize: 12.5,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ── BUY TICKET BUTTON ───────────────────────────────
  Widget _buildBuyTicketButton() {
    return Padding(
      padding: const EdgeInsets.fromLTRB(24, 20, 24, 8),
      child: FutureBuilder<Map<String, String>>(
        future: _futureSettings,
        builder: (context, snapshot) {
          final url = snapshot.data?['booking_url'] ?? '';
          return Container(
            width: double.infinity,
            decoration: BoxDecoration(
              color: Theme.of(context).cardColor,
              borderRadius: BorderRadius.circular(20),
              boxShadow: AppColors.premiumShadow(),
              border: Border.all(color: Theme.of(context).dividerColor),
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(20),
              child: Material(
                color: Colors.transparent,
                child: InkWell(
                  onTap: () => _openCheckoutWebView(url),
                  child: Padding(
                    padding: const EdgeInsets.all(18),
                    child: Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(14),
                          decoration: BoxDecoration(
                            gradient: AppColors.accentGradient,
                            borderRadius: BorderRadius.circular(16),
                          ),
                          child: const Icon(
                            Icons.confirmation_num_rounded,
                            color: Colors.white,
                            size: 26,
                          ),
                        ),
                        const SizedBox(width: 16),
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                'Beli Tiket Masuk TMII',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.w800,
                                  color: Theme.of(context).colorScheme.onSurface,
                                ),
                              ),
                              const SizedBox(height: 3),
                              Text(
                                'Pesan mudah via Online & e-wallet',
                                style: TextStyle(
                                  fontSize: 12.5,
                                  color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.6),
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ],
                          ),
                        ),
                        const Icon(
                          Icons.arrow_forward_ios_rounded,
                          color: AppColors.primary,
                          size: 16,
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
          );
        },
      ),
    );
  }

  // ── SECTION HEADER ──────────────────────────────────
  Widget _buildSectionHeader(String title, String action) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(24, 24, 24, 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            title,
            style: TextStyle(
              fontSize: 19,
              fontWeight: FontWeight.w800,
              color: Theme.of(context).colorScheme.onSurface,
              letterSpacing: -0.2,
            ),
          ),
          Text(
            action,
            style: const TextStyle(
              color: AppColors.primary,
              fontWeight: FontWeight.w700,
              fontSize: 13.5,
            ),
          ),
        ],
      ),
    );
  }

  // ── POPULAR PLACES ──────────────────────────────────
  Widget _buildPopularPlaces() {
    return SizedBox(
      height: 190,
      child: FutureBuilder<List<Katalog>>(
        future: _futurePopular,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return _buildHorizontalShimmer(150, 190);
          }
          if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('Belum ada data', style: TextStyle(color: AppColors.textHint)));
          }

          return ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 4),
            itemCount: snapshot.data!.length > 6 ? 6 : snapshot.data!.length,
            itemBuilder: (context, index) {
              final item = snapshot.data![index];
              final imageUrl = ApiService.getStorageUrl(item.gambar, 'katalogs');

              return GestureDetector(
                onTap: () => Navigator.push(context, AppPageRoute(
                  page: DetailScreen(id: item.id.toString(), title: item.nama, imageUrl: imageUrl, content: item.deskripsi, category: item.kategori),
                )),
                child: Container(
                  width: 145,
                  margin: const EdgeInsets.only(right: 14),
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: AppColors.premiumShadow(),
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(20),
                    child: Stack(
                      fit: StackFit.expand,
                      children: [
                        Image.network(imageUrl, fit: BoxFit.cover, errorBuilder: (c, e, s) => Container(color: Colors.grey[300])),
                        Container(
                          decoration: BoxDecoration(
                            gradient: LinearGradient(
                              begin: Alignment.bottomCenter, end: Alignment.topCenter,
                              colors: [Colors.black.withValues(alpha: 0.8), Colors.transparent],
                              stops: const [0.0, 0.65],
                            ),
                          ),
                        ),
                        Positioned(
                          bottom: 12, left: 12, right: 12,
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                decoration: BoxDecoration(
                                  color: AppColors.primary.withValues(alpha: 0.9),
                                  borderRadius: BorderRadius.circular(6),
                                ),
                                child: Text(
                                  item.kategori.toUpperCase(),
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 8,
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                              ),
                              const SizedBox(height: 4),
                              Text(
                                item.nama,
                                maxLines: 2,
                                overflow: TextOverflow.ellipsis,
                                style: const TextStyle(
                                  color: Colors.white,
                                  fontWeight: FontWeight.w800,
                                  fontSize: 13,
                                  height: 1.25,
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              );
            },
          );
        },
      ),
    );
  }

  // ── LATEST NEWS ─────────────────────────────────────
  Widget _buildLatestNews() {
    return SizedBox(
      height: 235,
      child: FutureBuilder<List<Artikel>>(
        future: _futureArtikels,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return _buildHorizontalShimmer(220, 235);
          }
          if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('Belum ada berita', style: TextStyle(color: AppColors.textHint)));
          }

          return ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 4),
            itemCount: snapshot.data!.length,
            itemBuilder: (context, index) {
              final item = snapshot.data![index];
              final imageUrl = ApiService.getStorageUrl(item.gambar, 'artikels');

              return GestureDetector(
                onTap: () => Navigator.push(context, AppPageRoute(
                  page: DetailScreen(title: item.judul, imageUrl: imageUrl, content: item.konten, category: item.kategori),
                )),
                child: Container(
                  width: 220,
                  margin: const EdgeInsets.only(right: 14),
                  decoration: BoxDecoration(
                    color: Theme.of(context).cardColor,
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: AppColors.premiumShadow(),
                    border: Border.all(color: Theme.of(context).dividerColor),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      ClipRRect(
                        borderRadius: const BorderRadius.vertical(top: Radius.circular(20)),
                        child: Image.network(imageUrl, height: 115, width: double.infinity, fit: BoxFit.cover, errorBuilder: (c, e, s) => Container(height: 115, color: Colors.grey[200])),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(14),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              item.judul,
                              maxLines: 2,
                              overflow: TextOverflow.ellipsis,
                              style: TextStyle(
                                fontWeight: FontWeight.w700,
                                fontSize: 13.5,
                                color: Theme.of(context).colorScheme.onSurface,
                                height: 1.3,
                              ),
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

  // ── MAP SECTION ─────────────────────────────────────
  Widget _buildMapSection() {
    return Padding(
      padding: const EdgeInsets.fromLTRB(24, 28, 24, 0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              const Icon(Icons.map_rounded, color: AppColors.primary, size: 24),
              const SizedBox(width: 8),
              Text('Peta Lokasi TMII', style: TextStyle(fontSize: 19, fontWeight: FontWeight.w800, color: Theme.of(context).colorScheme.onSurface)),
            ],
          ),
          const SizedBox(height: 16),
          FutureBuilder<Map<String, String>>(
            future: _futureSettings,
            builder: (context, snapshot) {
              final lat = double.tryParse(snapshot.data?['map_latitude'] ?? '') ?? -6.30167;
              final lng = double.tryParse(snapshot.data?['map_longitude'] ?? '') ?? 106.89667;
              final gmapsUrl = snapshot.data?['map_gmaps_url'] ?? '';

              return Column(
                children: [
                  Container(
                    height: 200,
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
                          initialZoom: 15.0,
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
                  const SizedBox(height: 14),
                  SizedBox(
                    width: double.infinity,
                    child: OutlinedButton.icon(
                      onPressed: () async {
                        if (gmapsUrl.isNotEmpty) {
                          await launchUrl(Uri.parse(gmapsUrl), mode: LaunchMode.externalApplication);
                        }
                      },
                      style: OutlinedButton.styleFrom(
                        foregroundColor: AppColors.primary,
                        side: const BorderSide(color: AppColors.primary, width: 1.5),
                        padding: const EdgeInsets.symmetric(vertical: 14),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                        textStyle: const TextStyle(fontWeight: FontWeight.w700, fontSize: 14),
                      ),
                      icon: const Icon(Icons.navigation_rounded, size: 18),
                      label: const Text('Buka di Google Maps'),
                    ),
                  ),
                ],
              );
            },
          ),
        ],
      ),
    );
  }

  // ── SHIMMER HELPER ──────────────────────────────────
  Widget _buildHorizontalShimmer(double width, double height) {
    return Shimmer.fromColors(
      baseColor: Colors.grey[200]!,
      highlightColor: Colors.grey[100]!,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 20),
        itemCount: 3,
        itemBuilder: (context, index) => Container(
          width: width,
          margin: const EdgeInsets.only(right: 12),
          decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(20)),
        ),
      ),
    );
  }
}

