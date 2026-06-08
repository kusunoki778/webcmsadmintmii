import 'package:flutter_test/flutter_test.dart';
import 'package:jelajahi_tmii/main.dart';

void main() {
  testWidgets('App smoke test', (WidgetTester tester) async {
    await tester.pumpWidget(const JelajahiTMIIApp());
    expect(find.text('Beranda'), findsWidgets);
  });
}
