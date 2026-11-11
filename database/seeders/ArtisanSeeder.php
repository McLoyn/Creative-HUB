<?php

namespace Database\Seeders;

use App\Models\Artisan;
use App\Models\Village;
use App\Models\Verification;
use Illuminate\Database\Seeder;

class ArtisanSeeder extends Seeder
{
    public function run(): void
    {
        $margorejo   = Village::where('name', 'Margorejo')->first();
        $gaji        = Village::where('name', 'Gaji')->first();
        $sumurgeneng = Village::where('name', 'Sumurgeneng')->first();

        $artisans = [
            [
                'village_id'    => $margorejo->id,
                'kader_user_id' => 'kader-001',
                'name'          => 'Ibu Siti Rahayu',
                'craft_type'    => 'batik_tulis',
                'story'         => 'Ibu Siti telah membatik selama lebih dari 30 tahun di Desa Margorejo, Kerek. Motif gedog yang ia torehkan terinspirasi dari flora lokal dan ukiran kayu jati kuno. Setiap helai kain adalah warisan rasa.',
                'wa_number'     => '6281234567890',
                'consent_at'    => now()->subDays(20),
                'status'        => 'verified',
            ],
            [
                'village_id'    => $gaji->id,
                'kader_user_id' => 'kader-001',
                'name'          => 'Pak Harto Wiyono',
                'craft_type'    => 'tenun_gedog',
                'story'         => 'Pak Harto mewarisi alat tenun gedog tradisional dari kakeknya di Desa Gaji. Dari memintal kapas sendiri hingga menenun helai demi helai di bawah denting kayu gedog yang khas.',
                'wa_number'     => '6289876543210',
                'consent_at'    => now()->subDays(15),
                'status'        => 'verified',
            ],
            [
                'village_id'    => $sumurgeneng->id,
                'kader_user_id' => 'kader-002',
                'name'          => 'Ibu Mujiati',
                'craft_type'    => 'campuran',
                'story'         => 'Ibu Mujiati merintis kelompok kriya perempuan di Sumurgeneng, menggabungkan batik cap motif pesisir Tuban dengan produk siap pakai seperti pouch dan tote bag.',
                'wa_number'     => null, // Belum memberikan persetujuan tampil kontak
                'consent_at'    => null,
                'status'        => 'pending',
            ],
        ];

        foreach ($artisans as $data) {
            $artisan = Artisan::create($data);

            if ($artisan->status === 'verified') {
                Verification::create([
                    'verifiable_type'  => 'artisan',
                    'verifiable_id'    => $artisan->id,
                    'reviewer_user_id' => 'admin-001',
                    'action'           => 'approved',
                    'reason'           => 'Profil lengkap dan identitas pengrajin valid.',
                    'created_at'       => now()->subDays(10),
                ]);
            } elseif ($artisan->status === 'pending') {
                Verification::create([
                    'verifiable_type'  => 'artisan',
                    'verifiable_id'    => $artisan->id,
                    'reviewer_user_id' => null,
                    'action'           => 'submitted',
                    'reason'           => 'Diajukan oleh kader pendamping kader-002.',
                    'created_at'       => now()->subDays(1),
                ]);
            }
        }
    }
}
