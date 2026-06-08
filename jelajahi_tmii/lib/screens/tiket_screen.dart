import 'package:flutter/material.dart';
import '../core/theme/app_colors.dart';
import '../core/theme/premium_loader.dart';
import '../core/theme/app_page_route.dart';
import '../services/api_service.dart';
import 'checkout_webview_screen.dart';

class TiketScreen extends StatefulWidget {
  const TiketScreen({super.key});

  @override
  State<TiketScreen> createState() => _TiketScreenState();
}

class _TiketScreenState extends State<TiketScreen> {
  final ApiService _apiService = ApiService();
  late Future<List<Map<String, dynamic>>> _futureTikets;
  late Future<Map<String, String>> _futureSettings;

  @override
  void initState() {
    super.initState();
    _futureTikets = _apiService.fetchTikets();
    _futureSettings = _apiService.fetchSettings();
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: Column(
          children: [
            // Header
            Container(
              width: double.infinity,
              padding: const EdgeInsets.fromLTRB(24, 28, 24, 24),
              decoration: const BoxDecoration(
                gradient: AppColors.primaryGradient,
              ),
              child: const Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text('Informasi Tiket', style: TextStyle(fontSize: 26, fontWeight: FontWeight.w900, color: Colors.white, letterSpacing: -0.5)),
                  SizedBox(height: 4),
                  Text('Harga resmi & jam operasional TMII', style: TextStyle(fontSize: 13.5, color: Colors.white70, fontWeight: FontWeight.w500)),
                ],
              ),
            ),

            // Content
            Expanded(
              child: RefreshIndicator(
                color: AppColors.primary,
                onRefresh: () async {
                  setState(() {
                    _futureTikets = _apiService.fetchTikets();
                    _futureSettings = _apiService.fetchSettings();
                  });
                },
                child: SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  padding: const EdgeInsets.all(24),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Jam Operasional
                      FutureBuilder<Map<String, String>>(
                        future: _futureSettings,
                        builder: (context, snapshot) {
                          if (snapshot.connectionState == ConnectionState.waiting) {
                            return const Center(child: Padding(
                              padding: EdgeInsets.symmetric(vertical: 20),
                              child: PremiumLoader(size: 36),
                            ));
                          }
                          final settings = snapshot.data ?? {};
                          return Container(
                            width: double.infinity,
                            padding: const EdgeInsets.all(18),
                            decoration: BoxDecoration(
                              color: Theme.of(context).cardColor,
                              borderRadius: BorderRadius.circular(20),
                              border: Border.all(color: Theme.of(context).dividerColor),
                              boxShadow: AppColors.premiumShadow(),
                            ),
                            child: Row(
                              children: [
                                Container(
                                  padding: const EdgeInsets.all(12),
                                  decoration: BoxDecoration(
                                    color: AppColors.surfaceTint,
                                    borderRadius: BorderRadius.circular(12),
                                  ),
                                  child: const Icon(Icons.access_time_rounded, color: AppColors.primary, size: 26),
                                ),
                                const SizedBox(width: 14),
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text('Jam Operasional Utama', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 15, color: Theme.of(context).colorScheme.onSurface)),
                                    const SizedBox(height: 3),
                                    Text(
                                      settings['opening_gate_1'] ?? '06:00 - 17:00 WIB',
                                      style: TextStyle(fontSize: 13.5, color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.6), fontWeight: FontWeight.w600),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          );
                        },
                      ),
                      const SizedBox(height: 28),

                      // Daftar Harga
                      Text('Daftar Tiket Masuk', style: TextStyle(fontSize: 19, fontWeight: FontWeight.w800, color: Theme.of(context).colorScheme.onSurface, letterSpacing: -0.2)),
                      const SizedBox(height: 14),

                      FutureBuilder<List<Map<String, dynamic>>>(
                        future: _futureTikets,
                        builder: (context, snapshot) {
                          if (snapshot.connectionState == ConnectionState.waiting) {
                            return const Center(child: Padding(
                              padding: EdgeInsets.symmetric(vertical: 60),
                              child: PremiumLoader(size: 44),
                            ));
                          } else if (snapshot.hasError || !snapshot.hasData || snapshot.data!.isEmpty) {
                            return _buildInfoCard();
                          }

                          return Column(
                            children: snapshot.data!.map((tiket) {
                              final imageUrl = ApiService.getStorageUrl(tiket['gambar'], 'tikets');
                              final deskripsi = tiket['deskripsi'] ?? '';

                              return Container(
                                margin: const EdgeInsets.only(bottom: 16),
                                child: Material(
                                  color: Theme.of(context).cardColor,
                                  shape: const TicketBorder(),
                                  clipBehavior: Clip.antiAlias,
                                  elevation: 2,
                                  shadowColor: Colors.black.withValues(alpha: 0.05),
                                  child: Container(
                                    height: 105,
                                    padding: const EdgeInsets.symmetric(horizontal: 16),
                                    child: Row(
                                      children: [
                                        // Left: Image and Name/Description
                                        Expanded(
                                          child: Row(
                                            children: [
                                              ClipRRect(
                                                borderRadius: BorderRadius.circular(12),
                                                child: Image.network(
                                                  imageUrl,
                                                  width: 60,
                                                  height: 60,
                                                  fit: BoxFit.cover,
                                                  errorBuilder: (c, e, s) => Container(
                                                    width: 60,
                                                    height: 60,
                                                    color: Theme.of(context).colorScheme.primary.withValues(alpha: 0.1),
                                                    child: const Icon(
                                                      Icons.confirmation_num_rounded,
                                                      color: AppColors.primary,
                                                      size: 24,
                                                    ),
                                                  ),
                                                ),
                                              ),
                                              const SizedBox(width: 14),
                                              Expanded(
                                                child: Column(
                                                  mainAxisAlignment: MainAxisAlignment.center,
                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                  children: [
                                                    Text(
                                                      tiket['nama_tiket'] ?? 'Tiket',
                                                      maxLines: 1,
                                                      overflow: TextOverflow.ellipsis,
                                                      style: TextStyle(
                                                        fontWeight: FontWeight.w800,
                                                        fontSize: 15,
                                                        color: Theme.of(context).colorScheme.onSurface,
                                                      ),
                                                    ),
                                                    if (deskripsi.toString().isNotEmpty)
                                                      Padding(
                                                        padding: const EdgeInsets.only(top: 2),
                                                        child: Text(
                                                          deskripsi,
                                                          maxLines: 2,
                                                          overflow: TextOverflow.ellipsis,
                                                          style: TextStyle(
                                                            fontSize: 11,
                                                            color: Theme.of(context).colorScheme.onSurface.withValues(alpha: 0.5),
                                                            fontWeight: FontWeight.w500,
                                                          ),
                                                        ),
                                                      ),
                                                  ],
                                                ),
                                              ),
                                            ],
                                          ),
                                        ),

                                        // Middle: Punch line separator
                                        Container(
                                          margin: const EdgeInsets.symmetric(horizontal: 10),
                                          width: 1.5,
                                          height: double.infinity,
                                          child: LayoutBuilder(
                                            builder: (context, constraints) {
                                              final boxHeight = constraints.constrainHeight();
                                              const dashHeight = 4.0;
                                              const dashGap = 3.0;
                                              final dashCount = (boxHeight / (dashHeight + dashGap)).floor();
                                              return Flex(
                                                direction: Axis.vertical,
                                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                                children: List.generate(dashCount, (_) {
                                                  return SizedBox(
                                                    width: 1.5,
                                                    height: dashHeight,
                                                    child: DecoratedBox(
                                                      decoration: BoxDecoration(color: Theme.of(context).dividerColor),
                                                    ),
                                                  );
                                                }),
                                              );
                                            },
                                          ),
                                        ),

                                        // Right: Buy Button
                                        Container(
                                          width: 75,
                                          alignment: Alignment.centerRight,
                                          child: _buildBuyButton(tiket),
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                              );
                            }).toList(),
                          );
                        },
                      ),

                      const SizedBox(height: 100),
                    ],
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildInfoCard() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Theme.of(context).dividerColor),
      ),
      child: const Column(
        children: [
          Icon(Icons.info_outline_rounded, color: AppColors.textHint, size: 40),
          SizedBox(height: 12),
          Text('Data tiket belum tersedia', style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.textSecondary)),
          SizedBox(height: 4),
          Text('Silakan hubungi admin untuk informasi lebih lanjut', textAlign: TextAlign.center, style: TextStyle(fontSize: 13, color: AppColors.textHint)),
        ],
      ),
    );
  }

  Widget _buildBuyButton(Map<String, dynamic> tiket) {
    final widgetCode = tiket['widget_code']?.toString() ?? '';
    final hasWidget = widgetCode.isNotEmpty;

    return SizedBox(
      height: 26,
      width: 70,
      child: ElevatedButton(
        onPressed: hasWidget
            ? () {
                Navigator.push(
                  context,
                  AppPageRoute(
                    page: CheckoutWebviewScreen(
                      rawUrl: widgetCode,
                      title: tiket['nama_tiket'] ?? 'Beli Tiket',
                    ),
                  ),
                );
              }
            : null,
        style: ElevatedButton.styleFrom(
          backgroundColor: AppColors.primary,
          foregroundColor: Colors.white,
          disabledBackgroundColor: Theme.of(context).disabledColor.withValues(alpha: 0.1),
          disabledForegroundColor: Theme.of(context).disabledColor.withValues(alpha: 0.4),
          padding: EdgeInsets.zero,
          elevation: hasWidget ? 2 : 0,
          shadowColor: AppColors.primary.withValues(alpha: 0.2),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        ),
        child: Text(
          hasWidget ? 'Beli' : 'N/A',
          style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
        ),
      ),
    );
  }
}

// ── CUSTOM SHAPE BORDER UNTUK TIKET FISIK ───────────────
class TicketBorder extends ShapeBorder {
  const TicketBorder();

  @override
  EdgeInsetsGeometry get dimensions => EdgeInsets.zero;

  @override
  Path getInnerPath(Rect rect, {TextDirection? textDirection}) => Path();

  @override
  Path getOuterPath(Rect rect, {TextDirection? textDirection}) {
    final path = Path();
    path.lineTo(0, rect.top);
    
    // Left notch
    double cutRadius = 10.0;
    double cutHeight = rect.height * 0.5;
    
    path.lineTo(0, cutHeight - cutRadius);
    path.arcToPoint(
      Offset(0, cutHeight + cutRadius),
      radius: Radius.circular(cutRadius),
      clockwise: true,
    );
    path.lineTo(0, rect.bottom);
    path.lineTo(rect.width, rect.bottom);
    
    // Right notch
    path.lineTo(rect.width, cutHeight + cutRadius);
    path.arcToPoint(
      Offset(rect.width, cutHeight - cutRadius),
      radius: Radius.circular(cutRadius),
      clockwise: true,
    );
    path.lineTo(rect.width, rect.top);
    path.close();
    
    return path;
  }

  @override
  void paint(Canvas canvas, Rect rect, {TextDirection? textDirection}) {}

  @override
  ShapeBorder scale(double t) => this;
}

