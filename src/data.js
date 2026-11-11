// DATA CONTOH untuk prototipe. Ganti dengan database (Supabase/Postgres) saat validasi lapangan selesai.
export const SUB = ["Batik & Tenun", "Kuliner Siwalan", "Seni & Budaya", "Kreator Digital"];
export const pelaku = [
  { id: "sri-rahayu", nama: "Sri Rahayu", desa: "Kerek", sub: SUB[0], wa: "6281200000001", kap: "20 kain/bulan", verif: true, bio: "Penenun gedog generasi ketiga. Benang diwarnai indigo dan soga dari kebun sendiri." },
  { id: "sidomulyo", nama: "Sanggar Batik Sidomulyo", desa: "Semanding", sub: SUB[0], wa: "6281200000002", kap: "30 kain/bulan", verif: true, bio: "Kelompok 8 pembatik tulis. Fokus motif gedog klasik dan kemeja siap pakai." },
  { id: "pak-karno", nama: "Pak Karno", desa: "Bancar", sub: SUB[1], wa: "6281200000003", kap: "150 pak gula/bulan", verif: true, bio: "Penyadap siwalan 20 tahun. Mengolah nira menjadi gula cetak." },
  { id: "bu-tini", nama: "Legen Bu Tini", desa: "Palang", sub: SUB[1], wa: "6281200000004", kap: "300 botol/bulan", verif: false, bio: "Olahan legen tahan lama: sirup dan manisan buah siwalan." },
  { id: "sekar", nama: "Sanggar Sekar Tuban", desa: "Tuban kota", sub: SUB[2], wa: "6281200000005", kap: "4 pentas/bulan", verif: false, bio: "Sanggar tari dan karawitan, 25 anggota muda." },
  { id: "dimas", nama: "Dimas Studio", desa: "Tuban kota", sub: SUB[3], wa: "6281200000006", kap: "10 paket foto/bulan", verif: false, bio: "Fotografer produk. Membantu pengrajin membuat foto katalog." },
];
export const produk = [
  { id: "gedog-indigo", nama: "Kain gedog indigo 2 m", harga: 450000, kat: SUB[0], pelaku: "sri-rahayu", cerita: "Ditenun dua minggu di alat tenun gedog, lalu dicelup indigo alami berulang kali." },
  { id: "selendang-soga", nama: "Selendang gedog soga", harga: 180000, kat: SUB[0], pelaku: "sri-rahayu", cerita: "Warna cokelat dari kulit pohon soga. Tiap lembar sedikit berbeda." },
  { id: "panji-krentil", nama: "Batik gedog motif Panji Krentil", harga: 380000, kat: SUB[0], pelaku: "sidomulyo", cerita: "Batik tulis di atas kain gedog dengan motif khas Tuban." },
  { id: "kemeja-gedog", nama: "Kemeja batik gedog", harga: 320000, kat: SUB[0], pelaku: "sidomulyo", cerita: "Kain gedog dijahit modern agar nyaman dipakai harian." },
  { id: "gula-siwalan", nama: "Gula siwalan cetak 500 g", harga: 35000, kat: SUB[1], pelaku: "pak-karno", cerita: "Nira disadap pagi hari, dimasak 6 jam, dicetak dalam tempurung." },
  { id: "sirup-legen", nama: "Sirup legen 330 ml", harga: 40000, kat: SUB[1], pelaku: "bu-tini", cerita: "Legen dimasak jadi sirup supaya tahan berbulan-bulan dan bisa dikirim ke luar pulau." },
  { id: "manisan-siwalan", nama: "Manisan buah siwalan", harga: 28000, kat: SUB[1], pelaku: "bu-tini", cerita: "Buah siwalan muda, dimasak dengan gula siwalan. Cocok untuk oleh-oleh." },
];
export const wisata = [
  { id: "ws-batik", nama: "Workshop batik gedog setengah hari", lokasi: "Kerek", harga: 150000, durasi: "4 jam", pelaku: "sri-rahayu" },
  { id: "tur-siwalan", nama: "Tur kebun siwalan dan cicip legen", lokasi: "Bancar", harga: 75000, durasi: "2 jam", pelaku: "pak-karno" },
  { id: "singgah-ziarah", nama: "Singgah ziarah: belanja kreatif 2 jam", lokasi: "Tuban kota", harga: 50000, durasi: "2 jam", pelaku: "sidomulyo" },
];
export const modul = [
  ["etalase", "Etalase", "Katalog produk dengan cerita pengrajin dan pesan lewat WhatsApp"],
  ["pelaku", "Registri pelaku", "Profil, kapasitas produksi, dan status verifikasi"],
  ["wisata", "Wisata kreatif", "Pesan workshop dan tur desa langsung ke pengrajin"],
  ["pesanan", "Pesanan besar", "Banyak pengrajin mengerjakan satu pesanan instansi"],
  ["toolkit", "Toolkit usaha", "Hitung HPP dan harga jual yang layak"],
  ["dinas", "Dasbor Dinas", "Jumlah pelaku, produk, dan verifikasi secara langsung"],
];
