<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gedog Tuban — Kriya Batik & Tenun Tradisional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F5EFE0] text-[#1A1A1A] antialiased">
    <!-- Top Bar -->
    <header class="border-b border-[#E8E0D0] bg-[#FAF6ED]/80 backdrop-blur sticky top-0 z-40">
        <div class="max-w-md mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-[#2D3B6B] text-[#F5EFE0] flex items-center justify-center font-bold text-sm">GT</span>
                <div>
                    <h1 class="font-bold text-base text-[#2D3B6B] leading-tight font-serif">Gedog Tuban</h1>
                    <p class="text-[11px] text-[#C4622D] font-medium tracking-wide uppercase">Tuban Creative Hub</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#7A9E6F]/20 text-[#5B7A51]">
                    Fase A Aktif
                </span>
            </div>
        </div>
    </header>

    <!-- Hero / Status Banner -->
    <main class="max-w-md mx-auto px-4 py-5 space-y-5">
        <div class="bg-[#FAF6ED] p-4 rounded-xl border border-[#E8E0D0] shadow-sm space-y-2">
            <div class="flex items-center gap-2 text-xs font-semibold text-[#2D3B6B]">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Dev Server Aktif (Port 8000)</span>
            </div>
            <h2 class="font-bold text-lg text-[#2D3B6B] font-serif leading-snug">
                Sub-App Kriya Batik Tulis &amp; Tenun Gedog Asli Tuban
            </h2>
            <p class="text-xs text-[#555] leading-relaxed">
                Pondasi database SQLite, 8 tabel migrasi ULID, seeder desa, dan palet editorial craft telah terpasang.
            </p>
        </div>

        <!-- Database Metrics Pill -->
        <div class="grid grid-cols-3 gap-2 text-center">
            <div class="bg-[#FAF6ED] p-3 rounded-lg border border-[#E8E0D0]">
                <div class="text-xl font-bold text-[#2D3B6B] font-serif">{{ \App\Models\Village::count() }}</div>
                <div class="text-[11px] text-[#666]">Desa Sentra</div>
            </div>
            <div class="bg-[#FAF6ED] p-3 rounded-lg border border-[#E8E0D0]">
                <div class="text-xl font-bold text-[#C4622D] font-serif">{{ \App\Models\Artisan::count() }}</div>
                <div class="text-[11px] text-[#666]">Pengrajin</div>
            </div>
            <div class="bg-[#FAF6ED] p-3 rounded-lg border border-[#E8E0D0]">
                <div class="text-xl font-bold text-[#7A9E6F] font-serif">{{ \App\Models\Product::count() }}</div>
                <div class="text-[11px] text-[#666]">Produk Terdaftar</div>
            </div>
        </div>

        <!-- Sample Products from DB -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-sm text-[#2D3B6B]">Koleksi Sampel (Database Seeder)</h3>
                <span class="text-[11px] text-[#777]">Pratinjau Data</span>
            </div>

            <div class="space-y-3">
                @foreach(\App\Models\Product::with('artisan.village', 'primaryImage', 'qrCode')->get() as $item)
                    <article class="bg-[#FAF6ED] rounded-xl border border-[#E8E0D0] p-3.5 flex gap-3 shadow-xs">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-[#E8E0D0] shrink-0 border border-[#E0D8C8]">
                            @if($item->primaryImage)
                                <img src="{{ asset($item->primaryImage->path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 mb-1">
                                @if($item->status === 'verified')
                                    <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold bg-[#7A9E6F]/20 text-[#5B7A51]">
                                        ✓ Asli &amp; Terverifikasi
                                    </span>
                                @elseif($item->status === 'pending')
                                    <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold bg-amber-500/20 text-amber-800">
                                        ⏳ Menunggu Kurasi
                                    </span>
                                @else
                                    <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold bg-gray-500/20 text-gray-700">
                                        Draf
                                    </span>
                                @endif
                                <span class="text-[10px] text-[#888] truncate">{{ $item->artisan->village->name }}</span>
                            </div>
                            <h4 class="font-semibold text-xs text-[#1A1A1A] line-clamp-1 leading-snug">
                                {{ $item->name }}
                            </h4>
                            <p class="text-[11px] text-[#666] line-clamp-1 mt-0.5">
                                Oleh {{ $item->artisan->name }}
                            </p>
                            <div class="flex items-center justify-between mt-2 pt-1 border-t border-[#E8E0D0]/60">
                                <span class="font-bold text-xs text-[#2D3B6B] font-serif">
                                    {{ $item->formatted_price }}
                                </span>
                                @if($item->qrCode)
                                    <span class="text-[10px] text-[#C4622D] font-mono">
                                        QR: {{ substr($item->qrCode->token, -6) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Next Step Notice -->
        <div class="p-3.5 rounded-lg bg-[#2D3B6B]/10 border border-[#2D3B6B]/20 text-xs text-[#2D3B6B] space-y-1">
            <p class="font-semibold">Siap Melanjutkan ke Fase B</p>
            <p class="text-[11px] text-[#444] leading-relaxed">
                Auth Adapter (LocalDev + OIDC), middleware peran (publik/kader/admin), dan panel input kader akan dibangun di fase selanjutnya.
            </p>
        </div>
    </main>
</body>
</html>
