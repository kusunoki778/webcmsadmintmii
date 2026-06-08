import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:url_launcher/url_launcher.dart';
import '../core/theme/app_colors.dart';
import '../core/theme/premium_loader.dart';

class CheckoutWebviewScreen extends StatefulWidget {
  final String rawUrl;
  final String title;

  const CheckoutWebviewScreen({
    super.key,
    required this.rawUrl,
    required this.title,
  });

  @override
  State<CheckoutWebviewScreen> createState() => _CheckoutWebviewScreenState();
}

class _CheckoutWebviewScreenState extends State<CheckoutWebviewScreen> {
  late final WebViewController _controller;
  bool _isLoading = true;
  String _targetUrl = '';

  @override
  void initState() {
    super.initState();
    _targetUrl = _extractUrl(widget.rawUrl);
    
    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setBackgroundColor(Colors.white)
      ..setNavigationDelegate(
        NavigationDelegate(
          onProgress: (int progress) {
            // Progress update can be logged if needed
          },
          onPageStarted: (String url) {
            if (mounted) {
              setState(() {
                _isLoading = true;
              });
            }
          },
          onPageFinished: (String url) {
            if (mounted) {
              setState(() {
                _isLoading = false;
              });
            }
          },
          onWebResourceError: (WebResourceError error) {
            // Silently handle web errors
          },
          onNavigationRequest: (NavigationRequest request) async {
            final url = request.url;
            
            // Check for e-wallet or other deep links (non-http/https)
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
              try {
                final uri = Uri.parse(url);
                if (await canLaunchUrl(uri)) {
                  await launchUrl(uri, mode: LaunchMode.externalApplication);
                }
              } catch (e) {
                // Deep link failed to launch
              }
              return NavigationDecision.prevent;
            }
            return NavigationDecision.navigate;
          },
        ),
      )
      ..loadRequest(Uri.parse(_targetUrl));
  }

  String _extractUrl(String code) {
    final cleanCode = code.trim();
    if (cleanCode.startsWith('http')) {
      return cleanCode;
    }
    // If admin pasted a full <iframe> snippet, extract the src URL
    final regExp = RegExp(r"""src=["']([^"']+)["']""");
    final match = regExp.firstMatch(cleanCode);
    if (match != null && match.groupCount >= 1) {
      return match.group(1)!;
    }
    return cleanCode;
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        title: Text(
          widget.title,
          style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 16),
        ),
        backgroundColor: Theme.of(context).appBarTheme.backgroundColor,
        foregroundColor: Theme.of(context).appBarTheme.foregroundColor,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.close_rounded, size: 26),
          onPressed: () => Navigator.pop(context),
        ),
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(1),
          child: Container(
            color: isDark ? const Color(0xFF334155) : AppColors.divider,
            height: 1,
          ),
        ),
      ),
      body: Stack(
        children: [
          WebViewWidget(controller: _controller),
          if (_isLoading)
            Container(
              color: Theme.of(context).scaffoldBackgroundColor.withValues(alpha: 0.8),
              child: const Center(
                child: PremiumLoader(size: 60),
              ),
            ),
        ],
      ),
    );
  }
}
