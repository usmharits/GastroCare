@extends('layouts.app')

@section('title', 'AI Food Scanner | Pakar GERD')

@push('styles')
    <style>
        /* Animasi Area Drop */
        .drag-active {
            border-color: #2F4F7F !important;
            background-color: rgba(47, 79, 127, 0.05) !important;
        }
        
        /* Efek Laser Pemindai AI (Sangat Keren untuk Presentasi) */
        .scanner-container { position: relative; overflow: hidden; }
        .scan-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: #8FAFCC; /* Accent color */
            box-shadow: 0 0 20px 5px rgba(143, 175, 204, 0.6);
            animation: scanning 2.5s infinite linear;
            z-index: 20;
            display: none;
        }
        .is-scanning .scan-line { display: block; }
        .is-scanning .scan-overlay { display: block; }
        
        .scan-overlay {
            position: absolute; inset: 0;
            background: rgba(31, 41, 55, 0.4);
            backdrop-filter: blur(2px);
            z-index: 10;
            display: none;
        }

        @keyframes scanning {
            0% { top: 0; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Styling Hasil AI Markdown */
        .ai-response b, .ai-response strong { color: #1F2937; font-weight: 700; }
        .ai-response ul { margin-top: 0.5rem; margin-bottom: 1rem; padding-left: 1.25rem; list-style-type: disc; }
        .ai-response li { margin-bottom: 0.25rem; }
        .ai-response p { margin-bottom: 0.75rem; }
    </style>
@endpush

@section('content')
    <div class="max-w-[800px] mx-auto mb-10">

        <div class="mb-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-borderline shadow-sm mb-4">
                <span class="w-2 h-2 rounded-full bg-status-info animate-pulse"></span>
                <span class="text-textmain/70 text-[11px] font-bold tracking-wide uppercase">Computer Vision Feature</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-textmain tracking-tight mb-3">AI Food Scanner</h2>
            <p class="text-[14px] text-textmain/60 leading-relaxed max-w-xl mx-auto">
                Unggah foto makanan atau minuman Anda. Kecerdasan Buatan (AI) kami akan menganalisis komposisinya dan memverifikasi tingkat keamanannya bagi penderita asam lambung (GERD).
            </p>
        </div>

        <div class="bg-cardbg rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 mb-8 transition-all duration-300">
            
            <form id="scannerForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-6 relative">
                    <input type="file" id="foto_makanan" name="foto_makanan" accept="image/jpeg, image/png, image/jpg, image/webp" class="hidden">
                    
                    <label for="foto_makanan" id="drop-area" class="border-2 border-dashed border-primary/30 rounded-3xl bg-bgsoft hover:bg-primary/5 cursor-pointer flex flex-col items-center justify-center p-12 text-center transition-all duration-300 group">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center border border-borderline mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h4 class="text-[16px] font-bold text-textmain mb-1">Upload Food Image</h4>
                        <p class="text-[12px] text-textmain/50 mb-3">Klik untuk memilih file, atau drag & drop gambar ke area ini.</p>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-textmain/40 bg-white px-3 py-1 rounded-md border border-borderline">JPG, PNG, WEBP (Max 4MB)</span>
                    </label>
                    
                    <div id="preview-container" class="hidden relative rounded-3xl overflow-hidden shadow-sm border border-borderline scanner-container group bg-[#000]">
                        <img id="imagePreview" class="w-full h-[300px] md:h-[400px] object-cover transition-opacity duration-300" alt="Food Preview">
                        
                        <div class="scan-overlay"></div>
                        <div class="scan-line"></div>

                        <div id="changePhotoOverlay" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-30">
                            <button type="button" id="btnRetake" class="bg-white/20 backdrop-blur-md border border-white/40 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-white hover:text-textmain transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Change Photo
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" id="scanBtn" class="w-full bg-primary hover:bg-[#233B60] text-white text-[14px] font-bold py-3.5 rounded-2xl shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] transition-all duration-200 flex justify-center items-center gap-2 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                    <span>Analyze Content</span>
                </button>
            </form>
        </div>

        <div id="resultArea" class="hidden bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-borderline overflow-hidden transition-all duration-500 opacity-0 translate-y-4">
            
            <div class="px-6 py-5 border-b border-borderline/60 bg-bgsoft flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center border border-primary/20">
                        <span class="text-xl">🤖</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-textmain text-[16px] leading-tight">AI Assessment Result</h3>
                        <p class="text-[11px] text-textmain/50 font-bold uppercase tracking-wider">Dietary Recommendation</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 md:p-8">
                <div id="scanResult" class="ai-response text-[14px] text-textmain/80 leading-relaxed"></div>
            </div>

            <div class="px-6 py-4 bg-status-warning/10 border-t border-status-warning/20">
                <p class="text-[11px] text-[#B0891A] font-medium leading-relaxed">
                    <strong class="uppercase">Disclaimer:</strong> Analisis ini dihasilkan oleh AI berdasarkan identifikasi visual gambar. Toleransi asam lambung tiap individu dapat berbeda. Selalu utamakan panduan gizi dari dokter Anda.
                </p>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scannerForm');
            const fileInput = document.getElementById('foto_makanan');
            const dropArea = document.getElementById('drop-area');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('imagePreview');
            const btnRetake = document.getElementById('btnRetake');
            const changePhotoOverlay = document.getElementById('changePhotoOverlay');
            
            const scanBtn = document.getElementById('scanBtn');
            const resultArea = document.getElementById('resultArea');
            const scanResult = document.getElementById('scanResult');

            // --- 1. DRAG AND DROP LOGIC ---
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-active'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-active'), false);
            });

            dropArea.addEventListener('drop', (e) => {
                let dt = e.dataTransfer;
                let files = dt.files;
                if(files.length) {
                    fileInput.files = files; // Assign dropped file to input
                    handleFile(files[0]);
                }
            });

            // --- 2. FILE SELECTION & PREVIEW ---
            fileInput.addEventListener('change', function() {
                if (this.files[0]) handleFile(this.files[0]);
            });

            function handleFile(file) {
                // Validasi Ukuran (Max 4MB)
                const maxSize = 4 * 1024 * 1024;
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran foto maksimal adalah 4MB. Silakan kompres atau pilih foto lain.',
                        confirmButtonColor: '#2F4F7F',
                        customClass: { popup: 'rounded-3xl' }
                    });
                    fileInput.value = ""; // Reset
                    return;
                }

                // Validasi Tipe
                if (!file.type.match('image.*')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Format Tidak Sesuai',
                        text: 'Silakan unggah file berformat JPG, JPEG, PNG, atau WEBP.',
                        confirmButtonColor: '#2F4F7F',
                        customClass: { popup: 'rounded-3xl' }
                    });
                    fileInput.value = "";
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    dropArea.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                    resultArea.classList.add('hidden'); // Hide old results
                    resultArea.classList.remove('opacity-100', 'translate-y-0');
                    resultArea.classList.add('opacity-0', 'translate-y-4');
                }
                reader.readAsDataURL(file);
            }

            // --- 3. RETAKE PHOTO BUTTON ---
            btnRetake.addEventListener('click', function() {
                fileInput.value = ""; // Reset
                previewContainer.classList.add('hidden');
                dropArea.classList.remove('hidden');
                resultArea.classList.add('hidden');
            });

            // --- 4. FORM SUBMISSION & AI SCANNING ---
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if(!fileInput.files[0]) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Foto Belum Dipilih',
                        text: 'Silakan unggah foto makanan terlebih dahulu sebelum melakukan pemindaian.',
                        confirmButtonColor: '#2F4F7F',
                        customClass: { popup: 'rounded-3xl' }
                    });
                    return;
                }

                // UI Loading State (Laser Animation)
                scanBtn.disabled = true;
                scanBtn.innerHTML = `<span class="animate-pulse">System is scanning...</span>`;
                previewContainer.classList.add('is-scanning'); // Trigger Laser CSS
                changePhotoOverlay.classList.add('hidden'); // Sembunyikan tombol ganti foto saat scan
                
                // Hide old result if scanning again
                resultArea.classList.add('hidden');
                resultArea.classList.remove('opacity-100', 'translate-y-0');
                resultArea.classList.add('opacity-0', 'translate-y-4');
                scanResult.innerHTML = '';

                const formData = new FormData(this);

                try {
                    const response = await fetch('/scan-food', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });

                    const data = await response.json();
                    
                    // Stop Loading UI
                    scanBtn.disabled = false;
                    scanBtn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        <span>Analyze Content</span>
                    `;
                    previewContainer.classList.remove('is-scanning');
                    changePhotoOverlay.classList.remove('hidden');

                    // Tampilkan Area Hasil
                    resultArea.classList.remove('hidden');
                    
                    // Efek Transisi Smooth untuk Hasil
                    setTimeout(() => {
                        resultArea.classList.remove('opacity-0', 'translate-y-4');
                        resultArea.classList.add('opacity-100', 'translate-y-0');
                    }, 50);

                    if(response.ok) {
                        // SMART MARKDOWN PARSER (Bold, Lists, and Linebreaks)
                        let text = data.reply;
                        // Bold
                        text = text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
                        // Bullet points (convert '* ' or '- ' to <li>)
                        text = text.replace(/^(?:-|\*)\s+(.*)/gm, '<li>$1</li>');
                        // Wrap consecutive <li> into <ul>
                        text = text.replace(/(<li>.*<\/li>\n?)+/g, '<ul class="list-disc pl-5 mb-3">$&</ul>');
                        // Line breaks
                        text = text.replace(/\n/g, '<br>');
                        // Clean up stray empty br tags inside ul
                        text = text.replace(/<br>\s*<ul/g, '<ul').replace(/<\/ul>\s*<br>/g, '</ul>');
                        
                        scanResult.innerHTML = text;
                    } else {
                        scanResult.innerHTML = `<div class="text-status-danger font-bold flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Error: ${data.reply}</div>`;
                    }

                } catch (error) {
                    // Reset UI on Error
                    scanBtn.disabled = false;
                    scanBtn.innerHTML = `<span>Analyze Content</span>`;
                    previewContainer.classList.remove('is-scanning');
                    changePhotoOverlay.classList.remove('hidden');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Terputus',
                        text: 'Aduh, gagal menyambung ke server AI. Coba periksa koneksi internet Anda.',
                        confirmButtonColor: '#2F4F7F',
                        customClass: { popup: 'rounded-3xl' }
                    });
                }
            });
        });
    </script>
@endpush