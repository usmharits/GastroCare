@extends('layouts.app')

@section('title', 'Laporan Diagnosa - Sistem Pakar Triase')

@push('styles')
    <style>
        /* Custom Scrollbar untuk List Obat yang panjang */
        .scroll-obat::-webkit-scrollbar { width: 6px; }
        .scroll-obat::-webkit-scrollbar-track { background: transparent; }
        .scroll-obat::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; border: 2px solid transparent; background-clip: padding-box; }
        .scroll-obat::-webkit-scrollbar-thumb:hover { background: #8FAFCC; border: 0; }
        
        /* Animasi Glow pada Angka CF */
        .cf-glow { text-shadow: 0 0 20px rgba(255, 255, 255, 0.4); }
    </style>
@endpush

@section('content')
    <div class="max-w-[1200px] mx-auto mb-10">
        
        <div class="mb-8 flex justify-between items-center border-b border-borderline/60 pb-5">
            <a href="/proses-diagnosa" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-borderline rounded-xl text-[13px] font-semibold text-textmain/70 hover:text-primary hover:border-primary/40 hover:bg-bgsoft transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)] group active:scale-[0.98]">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Formulir
            </a>
            
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-bgsoft rounded-full border border-borderline/80">
                <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>
                <span class="text-[11px] font-bold text-textmain/60 uppercase tracking-widest">Medical Report</span>
            </div>
        </div>

        <div class="row g-5">
            
            <div class="col-lg-4 col-12">
                <div class="bg-primary rounded-3xl shadow-[0_10px_40px_rgba(47,79,127,0.15)] p-8 text-white h-full relative overflow-hidden flex flex-col justify-center">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#26416A] to-secondary opacity-95 z-0"></div>
                    <div class="absolute inset-0 z-0 opacity-20" style="background-image: radial-gradient(rgba(255, 255, 255, 0.3) 1.5px, transparent 1.5px); background-size: 20px 20px;"></div>
                    <svg class="absolute top-0 right-0 w-64 h-64 text-white opacity-5 transform translate-x-12 -translate-y-12 z-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>

                    <div class="relative z-10 text-center lg:text-left flex flex-col h-full justify-between gap-6">
                        
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 border border-white/20 rounded-md backdrop-blur-sm mb-4 mx-auto lg:mx-0">
                                <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[10px] text-white/90 font-bold uppercase tracking-wider">Kesimpulan Sistem</span>
                            </div>
                            <h2 class="text-3xl md:text-4xl font-black mb-2 leading-tight tracking-tight drop-shadow-md">
                                {{ $diagnosa['nama_penyakit'] }}
                            </h2>
                            <p class="text-[13px] text-white/70 font-medium leading-relaxed mb-6">
                                Terindikasi dari {{ count($diagnosa['gejala_cocok'] ?? []) }} gejala klinis yang Anda cocokkan.
                            </p>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
                            
                            <p class="text-[11px] text-accent font-bold uppercase tracking-widest mb-1">Tingkat Kepastian (CF)</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-6xl font-black leading-none cf-glow">{{ $diagnosa['cf_percentage'] }}</p>
                                <span class="text-2xl font-bold text-white/60">%</span>
                            </div>
                        </div>

                        <div class="bg-[#1C3254]/50 border border-white/5 p-4 rounded-xl">
                            <p class="text-[12px] text-white/80 font-light leading-relaxed text-justify">
                                <span class="font-bold text-white">Metodologi:</span> Berdasarkan kalkulasi <em>Certainty Factor</em> (CF) dari pembobotan pakar medis (MD) dan respon pengguna (MB), sistem menyimpulkan bahwa kondisi Anda memiliki arah diagnosis seperti tertera di atas.
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12">
                <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 h-full flex flex-col">
                    
                    <div class="mb-6">
                        <h3 class="font-bold text-textmain text-xl tracking-tight mb-1">Medical Recommendations</h3>
                        <p class="text-[13px] font-medium text-textmain/50">Daftar intervensi farmakologis yang relevan dengan diagnosa Anda.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow min-h-0">
                        
                        <div class="flex flex-col h-full bg-[#F8FAFC] rounded-2xl border border-borderline/80 overflow-hidden shadow-sm">
                            
                            <div class="px-5 py-4 border-b border-borderline/80 bg-white flex justify-between items-center sticky top-0 z-10 shadow-[0_4px_10px_rgb(0,0,0,0.02)]">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-status-success/10 flex items-center justify-center shrink-0 text-status-success border border-status-success/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-[14px] font-bold text-textmain leading-none mb-1">Swamedikasi</h3>
                                        <p class="text-[10px] text-status-success font-bold uppercase tracking-wider">Aman / Bebas Terbatas</p>
                                    </div>
                                </div>
                                <span class="bg-bgsoft text-textmain/50 text-[11px] font-bold px-2.5 py-1 rounded-md border border-borderline">{{ count($obatAman) }}</span>
                            </div>
                            
                            <div class="p-4 overflow-y-auto scroll-obat flex-grow relative" style="height: 400px;">
                                <div class="space-y-3">
                                    @forelse($obatAman as $obat)
                                        <div class="bg-white border border-borderline/60 p-4 rounded-xl shadow-[0_2px_8px_rgb(0,0,0,0.02)] hover:shadow-[0_4px_12px_rgb(0,0,0,0.06)] hover:border-[#BCF0DA] transition-all duration-300 flex justify-between items-center group relative overflow-hidden">
                                            
                                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-success opacity-70 group-hover:opacity-100 transition-opacity"></div>
                                            
                                            <div class="pl-2 pr-3 min-w-0">
                                                <h4 class="font-bold text-[14px] text-textmain mb-1.5 truncate" title="{{ $obat['nama_obat'] }}">{{ $obat['nama_obat'] }}</h4>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[9px] text-status-success font-bold uppercase tracking-widest bg-status-success/10 border border-status-success/20 px-2 py-0.5 rounded">{{ $obat['golongan'] }}</span>
                                                </div>
                                            </div>
                                            
                                            @if(!empty($obat['link_pembelian']))
                                                <a href="{{ $obat['link_pembelian'] }}" target="_blank" class="shrink-0 text-[11px] font-bold text-primary bg-primary/10 border border-primary/20 hover:bg-primary hover:text-white hover:border-primary px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-1.5 active:scale-[0.95]">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Beli
                                                </a>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="h-full flex flex-col items-center justify-center text-center p-6 opacity-60">
                                            <svg class="w-12 h-12 text-textmain/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="text-[13px] text-textmain/60 font-medium">Tidak ada rekomendasi<br/>obat bebas (swamedikasi).</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col h-full bg-[#FFF5F5]/40 rounded-2xl border border-[#FDE8E8] overflow-hidden shadow-sm">
                            
                            <div class="px-5 py-4 border-b border-[#FDE8E8] bg-white flex justify-between items-center sticky top-0 z-10 shadow-[0_4px_10px_rgb(0,0,0,0.02)]">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-status-danger/10 flex items-center justify-center shrink-0 text-status-danger border border-status-danger/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-[14px] font-bold text-textmain leading-none mb-1">Obat Keras</h3>
                                        <p class="text-[10px] text-status-danger font-bold uppercase tracking-wider">Wajib Resep Dokter</p>
                                    </div>
                                </div>
                                <span class="bg-[#FDE8E8] text-status-danger text-[11px] font-bold px-2.5 py-1 rounded-md">{{ count($obatKeras) }}</span>
                            </div>
                            
                            <div class="p-4 overflow-y-auto scroll-obat flex-grow relative" style="height: 400px;">
                                <div class="space-y-3">
                                    @forelse($obatKeras as $obat)
                                        <div class="bg-white border border-[#FDE8E8] p-4 rounded-xl shadow-sm flex justify-between items-center group relative overflow-hidden opacity-90 hover:opacity-100 hover:border-[#FBD5D5] hover:shadow-md transition-all duration-300">
                                            
                                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-danger opacity-70 group-hover:opacity-100 transition-opacity"></div>
                                            
                                            <div class="pl-2 pr-3 min-w-0">
                                                <h4 class="font-bold text-[14px] text-textmain mb-1.5 truncate" title="{{ $obat['nama_obat'] }}">{{ $obat['nama_obat'] }}</h4>
                                                <span class="inline-block text-[9px] text-status-danger font-bold uppercase tracking-widest bg-status-danger/10 border border-status-danger/20 px-2 py-0.5 rounded">Resep Dokter</span>
                                            </div>
                                            
                                            <div class="shrink-0 w-8 h-8 rounded-full bg-status-danger/5 flex items-center justify-center text-status-danger/40 group-hover:text-status-danger/60 transition-colors" title="Hubungi dokter untuk mendapatkan resep">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="h-full flex flex-col items-center justify-center text-center p-6 opacity-60">
                                            <svg class="w-12 h-12 text-status-danger/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                            <p class="text-[13px] text-textmain/60 font-medium">Tidak ada rekomendasi<br/>obat keras / resep dokter.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="mt-6 bg-status-warning/10 border border-status-warning/30 rounded-2xl p-4 md:p-5 flex items-start gap-4">
            <div class="mt-0.5 shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center text-status-warning shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h4 class="text-[13px] font-bold text-[#B0891A] uppercase tracking-wider mb-1">Medical Disclaimer</h4>
                <p class="text-[13px] text-[#B0891A]/80 leading-relaxed text-justify md:text-left">
                    Hasil di atas merupakan probabilitas komputasi dari mesin inferensi, <strong>bukan vonis medis final</strong>. Gunakan rekomendasi swamedikasi dengan bijak. Jika gejala memburuk, segera konsultasikan dengan dokter atau kunjungi fasilitas kesehatan (Faskes) terdekat.
                </p>
            </div>
        </div>

    </div>
@endsection