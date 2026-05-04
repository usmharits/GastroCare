@extends('layouts.app')

@section('title', 'Daily Tracker & Jurnal Harian | Pakar GERD')

@push('styles')
    <style>
        /* Animasi Transisi Halus */
        .animate-fade-in { animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Progress Bar Glow */
        .progress-glow {
            box-shadow: 0 0 15px rgba(127, 183, 126, 0.6);
        }
        
        /* Custom Strikethrough untuk Misi Selesai */
        .strike-smooth {
            text-decoration: line-through;
            text-decoration-color: #9CA3AF;
            text-decoration-thickness: 2px;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-[800px] mx-auto mb-12 animate-fade-in">
        
        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-borderline shadow-sm mb-4">
                <span class="text-xl leading-none">🔥</span>
                <span class="text-textmain/70 text-[11px] font-bold tracking-wide uppercase">Daily Habit Tracker</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-textmain tracking-tight mb-3">Kedisiplinan Hari Ini</h2>
            <p class="text-[14px] text-textmain/60 leading-relaxed max-w-xl">
                Konsistensi adalah kunci penyembuhan GERD. Selesaikan misi harian Anda untuk menjaga stabilitas asam lambung dan kesehatan pencernaan.
            </p>
        </div>

        <div class="bg-cardbg rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 mb-8 transition-all duration-300">
            <div class="flex justify-between items-end mb-4">
                <div>
                    <h3 class="text-[15px] font-bold text-textmain mb-1">Progress Penyelesaian</h3>
                    <p class="text-[12px] font-medium text-textmain/50">
                        @if($progress == 100)
                            <span class="text-status-success font-bold">Luar biasa! Semua misi hari ini tuntas. 🎉</span>
                        @elseif($progress > 50)
                            Sedikit lagi! Tetap semangat selesaikan misimu.
                        @else
                            Ayo mulai kerjakan misi pertamamu hari ini.
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black {{ $progress == 100 ? 'text-status-success' : 'text-primary' }} transition-colors duration-500">{{ $progress }}%</span>
                </div>
            </div>
            
            <div class="w-full bg-bgsoft rounded-full h-3.5 border border-borderline/60 overflow-hidden relative">
                <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $progress == 100 ? 'bg-status-success progress-glow' : 'bg-primary' }}" 
                     style="width: {{ $progress }}%">
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-[14px] font-bold text-textmain/60 uppercase tracking-wider mb-2 px-2">Daftar Misi Anda</h3>
            
            @forelse($trackers as $misi)
                <div class="bg-white border {{ $misi->is_done ? 'border-status-success/30 bg-[#F6FCF8]' : 'border-borderline hover:border-primary/30 hover:shadow-[0_4px_15px_rgba(0,0,0,0.03)]' }} p-4 md:p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-300 group">
                    
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="shrink-0 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-colors duration-300 {{ $misi->is_done ? 'bg-status-success border-status-success text-white shadow-[0_2px_10px_rgba(127,183,126,0.4)]' : 'bg-bgsoft border-borderline text-textmain/30 group-hover:text-primary group-hover:border-primary/30' }}">
                            @if($misi->is_done)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-[15px] leading-snug transition-all duration-300 {{ $misi->is_done ? 'strike-smooth text-textmain/40' : 'font-bold text-textmain group-hover:text-primary' }}">
                                {{ $misi->nama_misi }}
                            </p>
                            <p class="text-[11px] font-medium mt-1 {{ $misi->is_done ? 'text-status-success' : 'text-textmain/40' }}">
                                {{ $misi->is_done ? 'Telah diselesaikan' : 'Belum diselesaikan' }}
                            </p>
                        </div>
                    </div>

                    <form action="/tracker/toggle/{{ $misi->id }}" method="POST" class="shrink-0 sm:w-auto w-full" onsubmit="this.querySelector('button').innerHTML = 'Memproses...'; this.querySelector('button').classList.add('opacity-70', 'cursor-not-allowed');">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-[13px] font-bold transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.97] {{ $misi->is_done ? 'bg-white border border-borderline text-textmain/60 hover:bg-bgsoft hover:text-textmain' : 'bg-primary text-white shadow-[0_4px_12px_rgba(47,79,127,0.25)] hover:bg-[#233B60] hover:shadow-[0_6px_16px_rgba(47,79,127,0.35)]' }}">
                            @if($misi->is_done)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Batalkan
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Tandai Selesai
                            @endif
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-16 px-6 bg-white rounded-[2rem] border-2 border-dashed border-borderline shadow-sm">
                    <div class="w-20 h-20 bg-bgsoft rounded-full flex items-center justify-center border border-borderline mx-auto mb-5">
                        <span class="text-3xl">🎯</span>
                    </div>
                    <h3 class="text-[18px] font-bold text-textmain mb-2">Belum Ada Misi Hari Ini</h3>
                    <p class="text-[13px] text-textmain/50 max-w-md mx-auto mb-6 leading-relaxed">
                        Anda belum memiliki jadwal pantauan atau misi untuk dikerjakan hari ini. Konsultasikan kondisi Anda dengan Asisten AI untuk mendapatkan rekomendasi misi harian.
                    </p>
                    <a href="/konsultasi-ai" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-[#233B60] text-white font-bold text-[13px] px-8 py-3.5 rounded-xl transition-all shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Minta Rekomendasi AI
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection