<?php

namespace Database\Seeders;

use App\Models\Artisan;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\QRCode;
use App\Models\Verification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $siti  = Artisan::where('name', 'Ibu Siti Rahayu')->first();
        $harto = Artisan::where('name', 'Pak Harto Wiyono')->first();
        $muji  = Artisan::where('name', 'Ibu Mujiati')->first();

        $products = [
            // 1. Batik Tulis Kembang Waluh (Verified)
            [
                'artisan_id'    => $siti->id,
                'name'          => 'Batik Tulis Motif Latar Putih Kembang Waluh',
                'category'      => 'batik_tulis',
                'motif'         => 'Kembang Waluh',
                'material'      => 'Mori Primissima 100% Katun',
                'dye_type'      => 'alami',
                'size'          => '250 cm × 110 cm',
                'price'         => 850000,
                'stock_status'  => 'tersedia',
                'description'   => 'Batik tulis khas Tuban dengan latar putih gading bersih dan motif kembang waluh berwarna biru indigo dari daun tom alami. Dikerjakan manual selama 3 minggu per lembar.',
                'process_story' => 'Lilin malam ditorehkan halus dengan canting tembaga. Pewarna biru difermentasi dari daun tom (Indigofera tinctoria) selama 3 hari tanpa bahan kimia sintetis.',
                'status'        => 'verified',
                'wa_click_count'=> 14,
                'qr_token'      => '01HQJ5K98ABCD1234567890123',
            ],
            // 2. Batik Tulis Sutra ATBM Sekar Jagad (Verified)
            [
                'artisan_id'    => $siti->id,
                'name'          => 'Batik Tulis Sutra ATBM Motif Sekar Jagad',
                'category'      => 'batik_tulis',
                'motif'         => 'Sekar Jagad Tuban',
                'material'      => 'Sutra ATBM Tenun Tangan',
                'dye_type'      => 'campuran',
                'size'          => '240 cm × 115 cm',
                'price'         => 1500000,
                'stock_status'  => 'pre_order',
                'description'   => 'Kain sutra tenun tangan dipadukan dengan motif Sekar Jagad klasik Tuban. Menghadirkan kilau anggun dan kelembutan jatuh yang istimewa untuk acara resmi.',
                'process_story' => 'Kain sutra ditenun di alat ATBM, kemudian dibatik tulis secara cermat dengan 4 tahapan pencelupan warna.',
                'status'        => 'verified',
                'wa_click_count'=> 6,
                'qr_token'      => '01HQJ5K98ABCD1234567890124',
            ],
            // 3. Tenun Gedog Polos Kapas Lokal (Verified)
            [
                'artisan_id'    => $harto->id,
                'name'          => 'Kain Tenun Gedog Polos Serat Kapas Murni',
                'category'      => 'tenun_gedog',
                'motif'         => 'Polos Natural',
                'material'      => 'Serat Kapas Lokal Tuban (Gossypium)',
                'dye_type'      => 'alami',
                'size'          => '200 cm × 90 cm',
                'price'         => 650000,
                'stock_status'  => 'tersedia',
                'description'   => 'Tenun gedog asli dari kapas varietas lokal Tuban yang dipetik dan dipintal tradisional. Tekstur benang tebal, empuk, dan sejuk di kulit.',
                'process_story' => 'Dari bola kapas mentah dipintal dengan roda jantra kayu, kemudian ditenun manual di alat gedog. Denting suara kayu gedog menjadi saksi ketelitian helai demi helai.',
                'status'        => 'verified',
                'wa_click_count'=> 9,
                'qr_token'      => '01HQJ5K98ABCD1234567890125',
            ],
            // 4. Tenun Gedog Motif Kopi Pecah (Pending)
            [
                'artisan_id'    => $harto->id,
                'name'          => 'Tenun Gedog Antik Motif Kopi Pecah',
                'category'      => 'tenun_gedog',
                'motif'         => 'Kopi Pecah Tradisional',
                'material'      => 'Kapas Tuban Pintal Tangan',
                'dye_type'      => 'alami',
                'size'          => '210 cm × 95 cm',
                'price'         => 950000,
                'stock_status'  => 'tersedia',
                'description'   => 'Motif geometris Kopi Pecah yang melambangkan kerendahan hati dan kemakmuran. Pewarnaan cokelat hangat dari ekstrak kulit biji kopi dan daun jambu mete.',
                'process_story' => 'Pola lungsi dan pakan dihitung manual baris per baris. Ketebalan benang yang khas memberikan ketahanan kain puluhan tahun.',
                'status'        => 'pending',
                'wa_click_count'=> 0,
                'qr_token'      => null,
            ],
            // 5. Tas Jinjing Batik Cap Gedog (Draft)
            [
                'artisan_id'    => $muji->id,
                'name'          => 'Tas Jinjing Kombinasi Batik Cap & Tenun Gedog',
                'category'      => 'produk_jadi',
                'motif'         => 'Parang Rusak Pesisir',
                'material'      => 'Kain Tenun Gedog & Katun Mori Cap',
                'dye_type'      => 'sintetis',
                'size'          => '35 cm × 30 cm × 12 cm',
                'price'         => 185000,
                'stock_status'  => 'tersedia',
                'description'   => 'Tas jinjing praktis untuk aktivitas harian, memadukan aksen tenun gedog kokoh pada bagian tali dan dasar tas, dengan motif batik cap pesisiran.',
                'process_story' => 'Dijahit rapi oleh kelompok kriya wanita Sumurgeneng, memadukan sisa potongan kain tenun berkualitas tinggi agar nihil limbah (zero waste).',
                'status'        => 'draft',
                'wa_click_count'=> 0,
                'qr_token'      => null,
            ],
        ];

        foreach ($products as $data) {
            $qrToken = $data['qr_token'] ?? null;
            unset($data['qr_token']);

            $product = Product::create($data);

            // Buat foto utama produk (placeholder lokal)
            ProductImage::create([
                'product_id' => $product->id,
                'path'       => 'images/samples/product-' . Str::slug($product->category) . '.svg',
                'sort_order' => 1,
                'is_primary' => true,
            ]);

            // Alur verifikasi & QR Code sesuai status
            if ($product->status === 'verified') {
                Verification::create([
                    'verifiable_type'  => 'product',
                    'verifiable_id'    => $product->id,
                    'reviewer_user_id' => 'admin-001',
                    'action'           => 'approved',
                    'reason'           => 'Uji keaslian bahan serat kapas dan motif lokal lolos standar kurasi dinas.',
                    'created_at'       => now()->subDays(5),
                ]);

                // QR Code dibuat saat disetujui
                QRCode::create([
                    'product_id' => $product->id,
                    'token'      => $qrToken ?? (string) Str::ulid(),
                    'created_at' => now()->subDays(5),
                ]);
            } elseif ($product->status === 'pending') {
                Verification::create([
                    'verifiable_type'  => 'product',
                    'verifiable_id'    => $product->id,
                    'reviewer_user_id' => null,
                    'action'           => 'submitted',
                    'reason'           => 'Diajukan kader untuk verifikasi keaslian tenun gedog.',
                    'created_at'       => now()->subDays(1),
                ]);
            }
        }
    }
}
