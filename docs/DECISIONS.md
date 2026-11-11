# 🏛 Catatan Keputusan Arsitektur (Architectural Decision Records)

Dokumen ini mencatat setiap keputusan teknis dan arsitektural proyek **Gedog Tuban** beserta rasionalnya, untuk memudahkan siswa magang RPL dan pengembang berikutnya memahami "mengapa" sebuah pilihan dibuat.

---

## ADR 001: Pilihan Database — SQLite untuk Development Lokal, Siap Skema MySQL untuk Produksi
- **Tanggal:** 2026-11-11 (Fase A)
- **Status:** Diterima & Diimplementasikan
- **Konteks:** Lingkungan Alpine Linux sandboxed ponsel tidak memiliki daemon MariaDB/MySQL bawaan. Menjalankan daemon database berat di sandbox PRoot membebani RAM dan baterai HP.
- **Keputusan:** Menggunakan **SQLite** (`database/database.sqlite`) untuk lingkungan development lokal. Seluruh migrasi ditulis menggunakan tipe data standar Laravel (seperti `unsignedBigInteger`, `string`, `ulid`, `timestamp`) yang 100% kompatibel langsung dengan MySQL di server produksi tanpa perubahan kode migrasi.
- **Dampak:** Setup instan tanpa dependency service latar belakang, zero overhead memory, dan siap switch ke MySQL di server produksi cukup dengan mengubah `DB_CONNECTION=mysql` di `.env`.

---

## ADR 002: Primary Key Berbasis ULID (Universally Unique Lexicographically Sortable Identifier)
- **Tanggal:** 2026-11-11 (Fase A)
- **Status:** Diterima & Diimplementasikan
- **Konteks:** ID auto-increment integer (`1, 2, 3...`) berisiko IDOR (Insecure Direct Object Reference), mudah ditebak di URL publik atau QR code oleh pihak luar, dan menyulitkan integrasi multitenan/ekosistem super-app. UUID murni (v4) tidak urut secara waktu sehingga memperlambat indeks B-tree database.
- **Keputusan:** Seluruh tabel menggunakan **ULID** 26 karakter (`ulid('id')->primary()`) melalui trait bawaan Laravel `HasUlids`.
- **Dampak:** ID aman tak bisa ditebak, tetap urut berdasarkan waktu pembuatan (terindeks cepat), serta cocok dijadikan identifier URL verifikasi publik yang aman.

---

## ADR 003: Pola Adapter untuk Autentikasi Ekosistem Super-App
- **Tanggal:** 2026-11-11 (Fase A / Desain)
- **Status:** Diterima
- **Konteks:** Gedog Tuban adalah sub-app dari Tuban Creative Hub yang autentikasinya terpusat di Main App (SSO OIDC). Namun Main App masih dalam tahap pengembangan sehingga belum ada endpoint OAuth live.
- **Keputusan:** Menerapkan **Adapter Pattern** via interface `AuthAdapterInterface`. Untuk development lokal dibuat `LocalDevAdapter` (memilih role Publik / Kader / Admin dari dropdown session tanpa password), dan `OidcAdapter` disiapkan untuk produksi yang langsung beralih melalui variabel `.env` (`AUTH_ADAPTER=local|oidc`).
- **Dampak:** Sub-app tidak perlu menyimpan tabel password pengguna, kode controller panel admin/kader tetap bersih dari detail protokol auth, dan migrasi ke SSO kelak hanya perlu mengganti 1 baris `.env`.

---

## ADR 004: Frontend Ringan — Blade + Alpine.js + Tailwind CSS
- **Tanggal:** 2026-11-11 (Fase A)
- **Status:** Diterima
- **Konteks:** Dibutuhkan antarmuka yang cepat diakses di ponsel (koneksi 3G, < 3 detik), ramah pembelajaran siswa SMK RPL (mudah dibaca tanpa build step rumit), serta estetik secara editorial craft.
- **Keputusan:** Menggunakan **Blade template** dipadukan dengan **Alpine.js** (interaktivitas reaktif ringan) dan **Tailwind CSS v4** dengan palet hangat (linen, indigo, terracota, lontar).
- **Dampak:** Bundle JavaScript sangat kecil (< 55 KB gzip), rendering server-side cepat dan SEO-friendly, serta sintaks template mudah dipahami.

---

## ADR 005: Token QR Code & Consent Kontak Pengrajin
- **Tanggal:** 2026-11-11 (Fase A)
- **Status:** Diterima
- **Konteks:** Spesifikasi verifikasi keaslian produk dan perlindungan privasi kontak WhatsApp pengrajin lansia.
- **Keputusan:**
  1. Token QR (`token` ULID terpisah di tabel `qr_codes`) **hanya digenerate ketika admin menyetujui produk** (bukan saat draf). Ini menjamin tidak ada QR palsu yang beredar sebelum validasi.
  2. Nomor kontak pengrajin (`wa_number`) hanya ditampilkan jika kolom `consent_at` terisi (persetujuan didapat kader saat input data). Jika tidak ada consent, tombol order WhatsApp mengarah ke kontak resmi sentra binaan atau kader pendamping.
