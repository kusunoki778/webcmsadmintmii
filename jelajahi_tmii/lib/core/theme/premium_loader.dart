import 'dart:math' as math;
import 'package:flutter/material.dart';
import 'app_colors.dart';

class PremiumLoader extends StatefulWidget {
  final double size;
  final double strokeWidth;

  const PremiumLoader({
    super.key,
    this.size = 50.0,
    this.strokeWidth = 4.0,
  });

  @override
  State<PremiumLoader> createState() => _PremiumLoaderState();
}

class _PremiumLoaderState extends State<PremiumLoader> with SingleTickerProviderStateMixin {
  late AnimationController _controller;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1500),
    )..repeat();
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Center(
      child: SizedBox(
        width: widget.size,
        height: widget.size,
        child: AnimatedBuilder(
          animation: _controller,
          builder: (context, child) {
            return Stack(
              alignment: Alignment.center,
              children: [
                // Outer spinning ring (clockwise)
                Transform.rotate(
                  angle: _controller.value * 2 * math.pi,
                  child: CustomPaint(
                    size: Size(widget.size, widget.size),
                    painter: _GradientArcPainter(
                      colors: [AppColors.primary, AppColors.accent],
                      strokeWidth: widget.strokeWidth,
                    ),
                  ),
                ),
                // Inner spinning ring (counter-clockwise)
                Transform.rotate(
                  angle: -_controller.value * 2 * math.pi,
                  child: CustomPaint(
                    size: Size(widget.size * 0.7, widget.size * 0.7),
                    painter: _GradientArcPainter(
                      colors: [AppColors.accentLight, AppColors.primaryLight],
                      strokeWidth: widget.strokeWidth * 0.8,
                    ),
                  ),
                ),
                // Center glowing point or icon
                Container(
                  width: widget.size * 0.22,
                  height: widget.size * 0.22,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    color: AppColors.primary.withValues(alpha: 0.8),
                    boxShadow: [
                      BoxShadow(
                        color: AppColors.primary.withValues(alpha: 0.6),
                        blurRadius: 10,
                        spreadRadius: 2,
                      ),
                    ],
                  ),
                ),
              ],
            );
          },
        ),
      ),
    );
  }
}

class _GradientArcPainter extends CustomPainter {
  final List<Color> colors;
  final double strokeWidth;

  _GradientArcPainter({
    required this.colors,
    required this.strokeWidth,
  });

  @override
  void paint(Canvas canvas, Size size) {
    final rect = Rect.fromLTWH(
      strokeWidth / 2,
      strokeWidth / 2,
      size.width - strokeWidth,
      size.height - strokeWidth,
    );

    final paint = Paint()
      ..strokeWidth = strokeWidth
      ..style = PaintingStyle.stroke
      ..strokeCap = StrokeCap.round
      ..shader = SweepGradient(
        colors: colors,
        startAngle: 0.0,
        endAngle: 2 * math.pi,
      ).createShader(rect);

    canvas.drawArc(rect, 0.0, 1.75 * math.pi, false, paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
