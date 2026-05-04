<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery - Sistem Pakar Diagnosa Penyakit Lambung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2F4F7F',   
                        secondary: '#5C7FA6', 
                        accent: '#8FAFCC',    
                        bgsoft: '#F4F6F9',    
                        cardbg: '#FFFFFF',    
                        borderline: '#E3E7ED',
                        textmain: '#1F2937',  
                        status: {
                            success: '#7FB77E',
                            warning: '#E6B325',
                            danger: '#D9534F',
                            info: '#5C7FA6'
                        }
                    }
                }
            }
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F6F9; 
            margin: 0;
            overflow: hidden; /* Mencegah scroll global di Desktop */
        }
        
        @media (max-width: 991.98px) {
            body { overflow: auto; } /* Mobile tetap bisa scroll normal */
        }

        /* Fix Autofill Browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #FFFFFF inset !important;
            -webkit-text-fill-color: #1F2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Subtle Pattern Background untuk sisi kiri */
        .bg-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="bg-bgsoft text-textmain antialiased h-screen w-screen overflow-hidden">
    <div class="container-fluid p-0 h-full">
        <div class="row m-0 h-full">
            
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between bg-primary relative p-10 overflow-hidden shadow-[inset_-10px_0_20px_rgba(0,0,0,0.05)]">
                <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#26416A] to-secondary opacity-90 z-0"></div>
                <div class="absolute inset-0 bg-pattern z-0"></div>
                
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/5 rounded-full blur-3xl z-0"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary/20 rounded-full blur-3xl z-0"></div>

                <div class="z-10 mt-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                        <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>
                        <span class="text-white/90 text-xs font-medium tracking-wide uppercase">System is Online</span>
                    </div>
                </div>

                <div class="z-10 max-w-lg mb-8">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-lg mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-white mb-3 tracking-tight leading-tight">
                        Sistem Pakar Triase <br/>
                        <span class="text-accent">Penyakit Lambung</span>
                    </h1>
                    <p class="text-white/80 font-light leading-relaxed text-base mb-6">
                        Membantu analisis kondisi kesehatan pencernaan secara mandiri dan akurat. Based on symptom analysis.
                    </p>

                    <div class="flex flex-wrap gap-2.5">
                        <div class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 backdrop-blur-sm text-white/90 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Certainty Factor Method
                        </div>
                        <div class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 backdrop-blur-sm text-white/90 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Secure Access
                        </div>
                    </div>
                </div>
                
                <div class="z-10 pb-4 flex justify-between items-end">
                    <div class="text-white/50 text-[11px] font-medium tracking-widest uppercase">
                        Expert System v1.0 &copy; {{ date('Y') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12 h-full flex items-center justify-center p-4 sm:p-8 bg-bgsoft relative overflow-hidden">
                
                <div class="w-full max-w-[400px] bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 sm:p-10 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">

                    <div class="w-12 h-12 bg-bgsoft rounded-2xl flex items-center justify-center border border-borderline mb-6 mx-auto lg:mx-0">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>

                    <div class="mb-6 text-center lg:text-left">
                        <h2 class="text-xl font-bold text-textmain mb-1.5 tracking-tight">Password Recovery</h2>
                        <p class="text-[13px] text-textmain/60 leading-relaxed">Masukkan alamat email yang terdaftar pada sistem. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-6 bg-status-success/10 border border-status-success/20 p-3.5 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-status-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[13px] font-medium text-status-success leading-relaxed">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="space-y-5">
                        @csrf

                        <div class="group">
                            <label for="email" class="block text-[12px] font-semibold text-textmain mb-1.5">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-textmain/40 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full py-2.5 pl-9 pr-4 bg-bgsoft border border-borderline rounded-xl text-[13px] text-textmain focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all duration-200 placeholder:text-textmain/30 outline-none"
                                    placeholder="Enter your registered email">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="submitBtn" class="w-full py-2.5 bg-primary hover:bg-[#233B60] text-white rounded-xl font-semibold text-[13px] transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] flex justify-center items-center gap-2 group active:scale-[0.98]">
                                <span>Send Recovery Link</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                        <div class="text-center pt-3 mt-2">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-1.5 text-[12px] font-semibold text-textmain/50 hover:text-primary transition-colors group">
                                <svg class="w-3.5 h-3.5 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Return to Sign In
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- SweetAlert Error Validasi Laravel ---
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Proses Gagal',
                    text: '{{ $errors->first() }}', // Menampilkan error spesifik dari Laravel
                    confirmButtonColor: '#2F4F7F',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-3xl border border-[#E3E7ED] shadow-[0_10px_40px_rgba(0,0,0,0.08)]',
                        title: 'text-lg font-bold text-[#1F2937]',
                        htmlContainer: 'text-sm text-[#1F2937]/70',
                        confirmButton: 'rounded-xl px-8 py-2.5 text-sm font-semibold tracking-wide'
                    }
                });
            @endif

            // --- SweetAlert Sukses Kirim Email ---
            @if(session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Tautan Terkirim',
                    text: 'Silakan periksa kotak masuk email Anda untuk instruksi selanjutnya. Jangan lupa cek folder Spam jika tidak ditemukan.',
                    confirmButtonColor: '#7FB77E',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-3xl border border-[#E3E7ED] shadow-[0_10px_40px_rgba(0,0,0,0.08)]',
                        title: 'text-lg font-bold text-[#1F2937]',
                        htmlContainer: 'text-sm text-[#1F2937]/70',
                        confirmButton: 'rounded-xl px-8 py-2.5 text-sm font-semibold tracking-wide'
                    }
                });
            @endif

            // --- Loading State Saat Submit Form ---
            const form = document.getElementById('resetForm');
            const btn = document.getElementById('submitBtn');

            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.classList.add('opacity-90', 'cursor-not-allowed');
                btn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Processing...</span>
                `;
                
                Swal.fire({
                    title: 'Processing Request',
                    html: '<span class="text-sm text-gray-500">System is preparing your recovery link...</span>',
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
        });
    </script>
</body>
</html>