class Artikel {
  final int id;
  final String judul;
  final String konten;
  final String? gambar;
  final String kategori;
  final String slug;

  Artikel({
    required this.id,
    required this.judul,
    required this.konten,
    this.gambar,
    required this.kategori,
    required this.slug,
  });

  factory Artikel.fromJson(Map<String, dynamic> json) {
    return Artikel(
      id: json['id'],
      judul: json['judul'] ?? '',
      konten: json['konten'] ?? '',
      gambar: json['gambar'],
      kategori: json['kategori'] ?? '',
      slug: json['slug'] ?? '',
    );
  }
}
