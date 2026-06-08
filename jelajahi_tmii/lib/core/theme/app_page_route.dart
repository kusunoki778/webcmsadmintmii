import 'package:flutter/material.dart';

class AppPageRoute extends PageRouteBuilder {
  final Widget page;

  AppPageRoute({required this.page})
      : super(
          pageBuilder: (context, animation, secondaryAnimation) => page,
          transitionsBuilder: (context, animation, secondaryAnimation, child) {
            // Fade-in animation
            final fadeTransition = FadeTransition(
              opacity: animation,
              child: child,
            );

            // Gentle slide transition (from slightly down and right)
            final tween = Tween<Offset>(
              begin: const Offset(0.04, 0.06),
              end: Offset.zero,
            ).chain(CurveTween(curve: Curves.easeOutCubic));

            return SlideTransition(
              position: animation.drive(tween),
              child: fadeTransition,
            );
          },
          transitionDuration: const Duration(milliseconds: 350),
          reverseTransitionDuration: const Duration(milliseconds: 250),
        );
}
