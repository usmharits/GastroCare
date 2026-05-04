@extends('layouts.app')

@section('title', 'Diagnostic Assessment - Sistem Pakar Triase')

@push('styles')
    <style>
        /* === ANIMASI & STYLING CARD GEJALA === */
        .gejala-card { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            cursor: pointer; 
        }
        .gejala-card:hover { 
            border-color: #5C7FA6; /* Secondary Color */
            background-color: #F4F6F9; 
            box-shadow: 0 6px 15px rgba(47, 79, 127, 0.06);
            transform: translateY(-2px);
        }
        
        /* State Aktif (Selected) */
        .gejala-card.selected { 
            border-color: #2F4F7F; /* Primary Color */
            background-color: rgba(47, 79, 127, 0.04); 
            box-shadow: 0 4px 12px rgba(47, 79, 127, 0.08);
        }
        .gejala-card.selected .check-circle { 
            background-color: #2F4F7F; 
            border-color: #2F4F7F; 
        }
        .gejala-card.selected .check-icon { 
            opacity: 1; 
            transform: scale(1); 
        }
        .gejala-card.selected .gejala-text {
            color: #2F4F7F;
        }
        
        /* Modifikasi Checkbox Indicator */
        .check-circle { 
            transition: all 0.3s ease; 
        }
        .check-icon { 
            opacity: 0; 
            transform: scale(0.2); 
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
        }
        
        /* Sembunyikan Checkbox Asli (Native) */
        input[type="checkbox"].gejala-checkbox { 
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        /* Custom Scrollbar untuk Container Gejala */
        .scroll-gejala::-webkit-scrollbar { width: 8px; }
        .scroll-gejala::-webkit-scrollbar-track { background: transparent; }
        .scroll-gejala::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; border: 2px solid #FFFFFF; }
        .scroll-gejala::-webkit-scrollbar-thumb:hover { background: #8FAFCC; }
    </style>
@endpush

@section('content')
    <div class="max-w-[1200px] mx-auto mb-10">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-borderline shadow-sm mb-4">
                    <span class="w-2 h-2 rounded-full bg-status-info animate-pulse"></span>
                    <span class="text-textmain/70 text-[11px] font-bold tracking-wide uppercase">Tahap Pemeriksaan</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-textmain tracking-tight mb-2">Diagnostic Assessment</h2>
                <p class="text-[14px] text-textmain/60 leading-relaxed max-w-2xl">
                    Silakan tandai gejala-gejala spesifik yang sedang Anda alami. Sistem pakar kami akan mengkalkulasi bobot indikasi menggunakan metode <strong>Certainty Factor</strong> untuk memberikan analisis yang terukur.
                </p>
            </div>
            
            <div class="shrink-0 bg-white border border-borderline shadow-sm px-5 py-3 rounded-2xl flex items-center justify-between gap-4 md:min-w-[180px]">
                <span class="text-[12px] font-bold text-textmain/60 uppercase tracking-wider">Gejala Terpilih</span>
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span id="counter" class="text-xl font-black transition-transform duration-300">0</span>
                </div>
            </div>
        </div>

        <form id="diagnosaForm" action="{{ route('diagnosa.proses') }}" method="POST">
            @csrf 
            
            <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline overflow-hidden flex flex-col relative transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)]">
                
                <div class="p-5 md:p-8 max-h-[65vh] overflow-y-auto scroll-gejala bg-cardbg relative">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        
                        @forelse($gejalas as $gejala)
                            <label class="gejala-card border border-borderline rounded-2xl p-4 flex items-start gap-3.5 relative overflow-hidden group select-none">
                                
                                <input type="checkbox" name="gejala_id[]" value="{{ $gejala->id }}" class="gejala-checkbox">
                                
                                <div class="check-circle mt-0.5 w-5 h-5 rounded-full border-2 border-[#D1D5DB] flex items-center justify-center shrink-0 bg-white shadow-sm">
                                    <svg class="check-icon w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0 pr-2">
                                    <p class="gejala-text text-[13.5px] font-semibold text-textmain leading-relaxed transition-colors">
                                        {{ $gejala->nama_gejala }}
                                    </p>
                                    <span class="inline-block mt-1.5 text-[10px] font-bold text-textmain/30 group-hover:text-primary/50 transition-colors uppercase tracking-wider">
                                        Kode: {{ $gejala->kode }}
                                    </span>
                                </div>
                            </label>
                        @empty
                            <div class="col-span-full py-12 text-center">
                                <p class="text-textmain/50 font-medium">Data gejala belum tersedia di dalam basis pengetahuan (Knowledge Base).</p>
                            </div>
                        @endforelse

                    </div>
                </div>

                <div class="border-t border-borderline bg-white/90 backdrop-blur-md p-5 md:px-8 md:py-6 flex flex-col sm:flex-row justify-between items-center gap-4 z-10 sticky bottom-0 shadow-[0_-10px_30px_rgba(0,0,0,0.02)]">
                    
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-status-warning/10 text-status-warning flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-[12px] text-textmain/60 font-medium leading-relaxed max-w-sm hidden sm:block">
                            Pastikan Anda memilih gejala sesuai dengan kondisi aktual untuk memastikan tingkat akurasi (CF) yang tinggi.
                        </p>
                    </div>
                    
                    <button type="submit" id="btnSubmit" class="w-full sm:w-auto bg-primary hover:bg-[#233B60] text-white text-[13px] font-semibold py-3.5 px-8 rounded-xl shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] transition-all duration-200 flex items-center justify-center gap-2 group active:scale-[0.98]">
                        <span>Analyze Symptoms</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
                
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.gejala-checkbox');
            const counterDisplay = document.getElementById('counter');
            
            // Fungsi Bulletproof untuk menghitung dan mengupdate counter
            function updateCounter() {
                const count = document.querySelectorAll('.gejala-checkbox:checked').length;
                
                // Animasi scale pada angka
                if (counterDisplay.textContent != count) {
                    counterDisplay.style.transform = 'scale(1.3)';
                    counterDisplay.textContent = count;
                    
                    // Efek warna jika ada yang dipilih
                    if(count > 0) {
                        counterDisplay.parentElement.classList.add('bg-primary', 'text-white');
                        counterDisplay.parentElement.classList.remove('bg-primary/10', 'text-primary');
                        counterDisplay.classList.add('text-white');
                    } else {
                        counterDisplay.parentElement.classList.remove('bg-primary', 'text-white');
                        counterDisplay.parentElement.classList.add('bg-primary/10', 'text-primary');
                        counterDisplay.classList.remove('text-white');
                    }

                    setTimeout(() => counterDisplay.style.transform = 'scale(1)', 200);
                }
            }

            // 1. Inisialisasi awal (jika ada old input dari Laravel validation)
            checkboxes.forEach(checkbox => {
                const card = checkbox.closest('.gejala-card');
                if (checkbox.checked) {
                    card.classList.add('selected');
                }
            });
            updateCounter(); // Hitung awal

            // 2. Event Listener yang disempurnakan
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.gejala-card');
                    
                    if (this.checked) {
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }
                    
                    // Hitung ulang setiap kali ada perubahan
                    updateCounter();
                });
            });

            // 3. Loading State & Validasi saat Submit
            const form = document.getElementById('diagnosaForm');
            const btnSubmit = document.getElementById('btnSubmit');

            form.addEventListener('submit', function(e) {
                const currentCount = document.querySelectorAll('.gejala-checkbox:checked').length;
                
                if(currentCount === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Tidak Lengkap',
                        text: 'Sistem membutuhkan minimal satu gejala untuk memproses algoritma Certainty Factor. Silakan pilih gejala Anda.',
                        confirmButtonColor: '#2F4F7F',
                        confirmButtonText: 'Pilih Gejala',
                        customClass: { 
                            popup: 'rounded-3xl border border-[#E3E7ED] shadow-xl', 
                            title: 'text-lg font-bold text-[#1F2937]',
                            confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold' 
                        }
                    });
                    return;
                }

                // Ubah tombol jadi loading
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-90', 'cursor-not-allowed');
                btnSubmit.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Calculating CF...</span>
                `;
                
                Swal.fire({
                    title: 'System Processing',
                    html: '<span class="text-sm text-gray-500">Mengkalkulasi bobot gejala menggunakan Certainty Factor...</span>',
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
                        const loader = Swal.getPopup().querySelector('.swal2-loader');
                        if(loader) loader.style.borderColor = '#2F4F7F transparent #2F4F7F transparent';
                    }
                });
            });

            // 4. Alert Peringatan Sistem (Jika ada dari Session Controller)
            @if(session('error_darurat'))
                Swal.fire({
                    icon: 'error',
                    title: 'Indikasi Medis Kritis',
                    text: '{{ session('error_darurat') }}',
                    confirmButtonColor: '#D9534F',
                    confirmButtonText: 'Mengerti',
                    customClass: { 
                        popup: 'rounded-3xl border border-[#E3E7ED] shadow-xl', 
                        title: 'text-lg font-bold text-[#1F2937]',
                        confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold' 
                    }
                });
            @endif
            
            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi Sistem',
                    text: '{{ session('info') }}',
                    confirmButtonColor: '#2F4F7F',
                    customClass: { 
                        popup: 'rounded-3xl border border-[#E3E7ED] shadow-xl',
                        title: 'text-lg font-bold text-[#1F2937]', 
                        confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold' 
                    }
                });
            @endif
        });
    </script>
@endpush