class Katalog {
  final int id;
  final String nama;
  final String deskripsi;
  final String? gambar;
  final String kategori;
  final String? latitude;
  final String? longitude;

  Katalog({
    required this.id,
    required this.nama,
    required this.deskripsi,
    this.gambar,
    required this.kategori,
    this.latitude,
    this.longitude,
  });

  factory Katalog.fromJson(Map<String, dynamic> json) {
    return Katalog(
      id: json['id'],
      nama: json['nama'] ?? '',
      deskripsi: json['deskripsi'] ?? '',
      gambar: json['gambar'],
      kategori: json['kategori'] ?? '',
      latitude: json['latitude'],
      longitude: json['longitude'],
    );
  }
}
