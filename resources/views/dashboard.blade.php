@extends('layouts.app')

@section('title', 'Dashboard Analytics - Sistem Pakar Triase Lambung')

@section('content')

    <div class="relative w-full bg-primary rounded-3xl shadow-[0_10px_40px_rgba(47,79,127,0.15)] mb-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#26416A] to-secondary opacity-95 z-0"></div>
        <div class="absolute inset-0 z-0 opacity-30" style="background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl z-0"></div>
        
        <div class="relative z-10 p-8 md:p-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
            
            <div class="w-full lg:w-1/2">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                    <span class="text-white/90 text-[11px] font-semibold tracking-wide uppercase">System Dashboard</span>
                </div>
                
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white mb-2 leading-tight">
                    @auth 
                        Welcome back,<br/> <span class="text-accent">{{ Auth::user()->name }}</span> 
                    @else 
                        System <span class="text-accent">Overview</span> 
                    @endauth
                </h2>
                
                <p class="text-white/80 text-sm font-light leading-relaxed max-w-md">
                    @auth 
                        Berikut adalah ringkasan kesehatan pencernaan Anda dan analitik dari Sistem Pakar berbasis Certainty Factor. 
                    @else 
                        Authentication is required. Silakan masuk untuk melihat metrik kesehatan dan riwayat diagnosa Anda. 
                    @endauth
                </p>
            </div>

            <div class="w-full lg:w-1/2 flex justify-start lg:justify-end">
                <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 rounded-2xl w-full max-w-md flex items-start gap-4 shadow-lg transition-transform hover:-translate-y-1 duration-300">
                    <div class="p-3 bg-white/20 rounded-xl shrink-0 shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-accent uppercase tracking-widest mb-1.5">Daily Health Insight</p>
                        <p class="text-[13px] text-white/90 font-medium leading-relaxed">
                            {{ $tipHariIni ?? 'Konsistensi adalah kunci. Terapkan pola makan teratur dan hindari konsumsi kafein berlebih untuk menjaga stabilitas asam lambung Anda.' }}
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    @auth
        <div class="row g-5 mb-5">
            
            <div class="col-lg-8 col-12">
                <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 h-full flex flex-col transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="font-bold text-textmain text-lg tracking-tight mb-0.5">Certainty Trend</h3>
                            <p class="text-[12px] font-medium text-textmain/50">Grafik pergerakan nilai CF (Certainty Factor) Anda.</p>
                        </div>
                        <a href="/riwayat" class="text-[12px] font-bold text-primary bg-primary/10 px-4 py-2 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 flex items-center gap-1.5 w-fit">
                            View History
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                    
                    <div class="relative w-full flex-grow" style="min-height: 280px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 h-full flex flex-col transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    
                    <div class="mb-6 text-center lg:text-left border-b border-borderline/60 pb-4">
                        <h3 class="font-bold text-textmain text-lg tracking-tight mb-0.5">Diagnosis Distribution</h3>
                        <p class="text-[12px] font-medium text-textmain/50">Proporsi hasil deteksi sistem pakar.</p>
                    </div>
                    
                    <div class="relative w-full flex-grow flex justify-center items-center" style="min-height: 250px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    
                    <div class="mb-6">
                        <h3 class="font-bold text-textmain text-lg tracking-tight mb-0.5">Activity Overview</h3>
                        <p class="text-[12px] font-medium text-textmain/50">Statistik frekuensi penggunaan sistem dan pengecekan gejala.</p>
                    </div>
                    
                    <div class="relative w-full" style="height: 320px;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    @guest
        <div class="bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-10 md:p-16 mt-8 text-center max-w-3xl mx-auto flex flex-col items-center">
            
            <div class="w-24 h-24 bg-bgsoft rounded-full flex items-center justify-center border border-borderline mb-6 relative">
                <div class="absolute inset-0 bg-primary/5 rounded-full animate-ping opacity-75"></div>
                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            
            <h3 class="text-2xl font-bold text-textmain mb-3 tracking-tight">Authentication Required</h3>
            <p class="text-[14px] text-textmain/60 mb-8 leading-relaxed max-w-lg">
                Fitur analitik terpadu, grafik kepastian diagnosa, dan pelacakan riwayat kesehatan eksklusif tersedia untuk pengguna terdaftar. Silakan otorisasi sesi Anda untuk mengakses fitur penuh.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full sm:w-auto">
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-primary hover:bg-[#233B60] text-white text-[13px] font-semibold px-8 py-3.5 rounded-xl transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] flex justify-center items-center gap-2 active:scale-[0.98]">
                    Sign In to Dashboard
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-transparent hover:bg-bgsoft text-textmain text-[13px] font-semibold px-8 py-3.5 rounded-xl border border-borderline transition-all duration-200 flex justify-center items-center active:scale-[0.98]">
                    Create Account
                </a>
            </div>
        </div>
    @endguest

@endsection

@push('scripts')
    @auth
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // --- GLOBAL CHART.JS CONFIGURATION ---
            Chart.defaults.font.family = "'Inter', 'system-ui', 'sans-serif'";
            Chart.defaults.color = '#6B7280'; // textmain/50
            Chart.defaults.scale.grid.color = '#F3F4F6'; // borderline sangat soft

            // --- PALET WARNA TEMA BARU (Sesuai Konsep Elegant Soft Healthcare UI) ---
            const themePalette = [
                '#2F4F7F', // Primary (Deep Blue)
                '#5C7FA6', // Secondary
                '#8FAFCC', // Accent
                '#7FB77E', // Success
                '#E6B325', // Warning
                '#D9534F'  // Danger
            ];

            // Data dari Backend (Laravel)
            const pieLabels = @json($pieLabels ?? []);
            const pieData = @json($pieData ?? []);
            const lineLabels = @json($lineLabels ?? []);
            const lineData = @json($lineData ?? []);
            const barLabels = @json($barLabels ?? []);
            let barDatasets = @json($barDatasets ?? []);

            // --- PREPARE DATASETS ---
            if(barDatasets.length > 0) {
                barDatasets = barDatasets.map((dataset, index) => {
                    dataset.backgroundColor = themePalette[index % themePalette.length];
                    dataset.borderRadius = 6; // Ujung bar lebih rounded
                    dataset.borderSkipped = false; // Biar rounded atas bawah kalau berdiri sendiri
                    dataset.borderWidth = 0;
                    return dataset;
                });
            } else {
                barDatasets = [{ label: 'No Data', data: [0], backgroundColor: '#E3E7ED', borderRadius: 6 }];
            }

            // --- 1. RENDER PIE CHART (Doughnut) ---
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut', 
                data: {
                    labels: pieLabels.length > 0 ? pieLabels : ['Belum ada data'],
                    datasets: [{
                        data: pieData.length > 0 ? pieData : [1],
                        backgroundColor: pieData.length > 0 ? themePalette : ['#F4F6F9'],
                        borderWidth: 3,
                        borderColor: '#FFFFFF', // Jarak putih antar potongan (Clean look)
                        hoverOffset: 6
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    cutout: '75%', // Cincin tipis dan elegan
                    plugins: { 
                        legend: { 
                            position: 'bottom', 
                            labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: { size: 11, weight: '500' } } 
                        },
                        tooltip: { 
                            backgroundColor: '#1F2937', padding: 12, cornerRadius: 8, titleFont: { size: 13 }, bodyFont: { size: 12 } 
                        }
                    } 
                }
            });

            // --- 2. RENDER LINE CHART (Tren CF) ---
            // Membuat gradien untuk area di bawah garis
            const gradientLine = document.getElementById('lineChart').getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradientLine.addColorStop(0, 'rgba(47, 79, 127, 0.2)'); // Primary color dgn opacity
            gradientLine.addColorStop(1, 'rgba(47, 79, 127, 0)');

            const ctxLine = document.getElementById('lineChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: lineLabels.length > 0 ? lineLabels : ['-'],
                    datasets: [{
                        label: 'Persentase CF (%)',
                        data: lineData.length > 0 ? lineData : [0],
                        borderColor: '#2F4F7F', // Warna Primary Theme
                        backgroundColor: gradientLine,
                        borderWidth: 3, 
                        tension: 0.4, // Smooth curve (Bézier)
                        fill: true, 
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#2F4F7F', 
                        pointBorderWidth: 2, 
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#2F4F7F',
                        pointHoverBorderColor: '#FFFFFF',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    interaction: { mode: 'index', intersect: false },
                    plugins: { 
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1F2937', padding: 12, cornerRadius: 8, titleFont: { size: 13 }, bodyFont: { size: 12 } }
                    }, 
                    scales: { 
                        y: { 
                            beginAtZero: true, max: 100, 
                            border: { display: false },
                            grid: { drawBorder: false, color: '#F4F6F9' },
                            ticks: { font: { size: 11 }, padding: 10 }
                        }, 
                        x: { 
                            border: { display: false },
                            grid: { display: false },
                            ticks: { font: { size: 11 }, padding: 10 }
                        } 
                    } 
                }
            });

            // --- 3. RENDER STACKED BAR CHART (Aktivitas Overview) ---
            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: barLabels.length > 0 ? barLabels : ['Empty'],
                    datasets: barDatasets
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: { 
                        x: { 
                            stacked: true, 
                            grid: { display: false }, 
                            border: { display: false },
                            ticks: { font: { size: 11 } }
                        }, 
                        y: { 
                            stacked: true, 
                            beginAtZero: true, 
                            border: { display: false }, 
                            grid: { color: '#F4F6F9' }, 
                            ticks: { stepSize: 1, font: { size: 11 }, padding: 10 } 
                        } 
                    }, 
                    plugins: { 
                        tooltip: { backgroundColor: '#1F2937', padding: 12, cornerRadius: 8, titleFont: { size: 13 }, bodyFont: { size: 12 } },
                        legend: { 
                            position: 'top', 
                            align: 'end',
                            labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: { size: 11, weight: '500' } } 
                        }
                    } 
                }
            });
        </script>
    @endauth
@endpush