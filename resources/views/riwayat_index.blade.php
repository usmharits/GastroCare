@extends('layouts.app')

@section('title', 'Medical History Log | Pakar GERD')

@section('content')
    <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline overflow-hidden mb-8">
        
        <div class="px-6 py-8 md:px-8 border-b border-borderline flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
            <div>
                <h2 class="text-2xl font-bold text-textmain tracking-tight mb-1">Medical History Log</h2>
                <p class="text-[13px] text-textmain/60">Daftar rekam medis dan hasil deteksi sistem pakar sebelumnya.</p>
            </div>
            
            <a href="/proses-diagnosa" class="shrink-0 px-4 py-2.5 bg-primary hover:bg-[#233B60] text-white rounded-xl text-[13px] font-semibold transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.2)] flex items-center gap-2 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Diagnosis
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-bgsoft/50 border-b border-borderline">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-textmain/50 uppercase tracking-widest whitespace-nowrap">Tanggal Periksa</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-textmain/50 uppercase tracking-widest whitespace-nowrap">Diagnosa Sistem</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-textmain/50 uppercase tracking-widest whitespace-nowrap">Kepastian (CF)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-textmain/50 uppercase tracking-widest whitespace-nowrap">Status Triase</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-textmain/50 uppercase tracking-widest text-right whitespace-nowrap">Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borderline/60 bg-white">
                    
                    @forelse($riwayats as $r)
                        <tr class="hover:bg-bgsoft/30 transition-colors group">
                            <td class="px-6 py-5 text-[13px] text-textmain/70 font-medium whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-textmain/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y, H:i') }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="font-bold text-textmain text-[14px]">{{ $r->penyakit->nama_penyakit }}</span>
                            </td>
                            
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3" title="Tingkat akurasi diagnosa berdasarkan perhitungan Certainty Factor">
                                    <div class="w-24 bg-borderline/50 h-2 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $r->cf_percentage }}%"></div>
                                    </div>
                                    <span class="text-[13px] font-bold text-primary">{{ $r->cf_percentage }}%</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php
                                    // Logika perbaikan kelas Tailwind agar tidak ter-purge
                                    $triaseClass = '';
                                    if(strtolower($r->status_triase) == 'gawat' || strtolower($r->status_triase) == 'bahaya') {
                                        $triaseClass = 'bg-status-danger/10 text-status-danger border-status-danger/20';
                                    } elseif(strtolower($r->status_triase) == 'waspada') {
                                        $triaseClass = 'bg-status-warning/10 text-[#B0891A] border-status-warning/20';
                                    } else {
                                        $triaseClass = 'bg-status-success/10 text-status-success border-status-success/20';
                                    }
                                @endphp
                                
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border {{ $triaseClass }}">
                                    {{ $r->status_triase }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                <a href="/riwayat/pdf/{{ $r->id }}" 
                                   onclick="showPdfLoading(event, this.href)"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-[12px] font-semibold text-status-danger bg-status-danger/5 border border-status-danger/10 hover:bg-status-danger hover:text-white transition-all duration-200"
                                   title="Download laporan PDF lengkap">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 bg-bgsoft rounded-full flex items-center justify-center border border-borderline mb-4">
                                        <svg class="w-10 h-10 text-textmain/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-[16px] font-bold text-textmain mb-1">Data Belum Tersedia</h3>
                                    <p class="text-[13px] text-textmain/50 mb-6 max-w-sm">Anda belum pernah melakukan tes diagnosa. Mulai tes sekarang untuk mengetahui kondisi pencernaan Anda.</p>
                                    <a href="/proses-diagnosa" class="px-5 py-2.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl text-[13px] font-semibold transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        Mulai Diagnosa Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
        
        @if(method_exists($riwayats, 'links') && $riwayats->hasPages())
            <div class="px-6 py-4 border-t border-borderline bg-bgsoft/30">
                {{ $riwayats->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
    // --- UX Improvement: Loading State untuk PDF Download ---
    function showPdfLoading(event, url) {
        event.preventDefault(); // Hentikan navigasi langsung
        
        Swal.fire({
            title: 'Generating Document',
            html: '<span class="text-sm text-gray-500">System is preparing your PDF report. Please wait...</span>',
            allowOutsideClick: false,
            showConfirmButton: false,
            width: '320px',
            padding: '1.5em',
            customClass: {
                popup: 'rounded-2xl border border-[#E3E7ED] shadow-xl',
                title: 'text-base font-bold text-[#1F2937] mb-1'
            },
            didOpen: () => {
                Swal.showLoading();
                // Ubah warna spinner SweetAlert ke merah PDF (Danger)
                const loader = Swal.getPopup().querySelector('.swal2-loader');
                if(loader) loader.style.borderColor = '#D9534F transparent #D9534F transparent';
                
                // Lanjutkan ke link download PDF setelah popup muncul
                setTimeout(() => {
                    window.location.href = url;
                }, 500);
            }
        });

        // Menutup loading setelah beberapa detik (asumsi PDF mulai terdownload)
        // Jika server butuh waktu lama, ini bisa diatur lebih lama
        setTimeout(() => {
            Swal.close();
        }, 4000); 
    }
</script>
@endpush