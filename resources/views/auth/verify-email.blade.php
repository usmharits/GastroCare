<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Sistem Pakar Diagnosa Penyakit Lambung</title>
    
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
                        <span class="w-2 h-2 rounded-full bg-status-warning animate-pulse"></span>
                        <span class="text-white/90 text-xs font-medium tracking-wide uppercase">Pending Verification</span>
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
                
                <div class="w-full max-w-[440px] bg-cardbg rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 sm:p-10 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">

                    <div class="w-12 h-12 bg-bgsoft rounded-2xl flex items-center justify-center border border-borderline mb-6 mx-auto sm:mx-0">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>

                    <div class="mb-6 text-center sm:text-left">
                        <h2 class="text-xl font-bold text-textmain mb-2 tracking-tight">System Verification</h2>
                        <p class="text-[13px] text-textmain/70 leading-relaxed">
                            Terima kasih telah melakukan pendaftaran. Sebagai langkah keamanan, sistem kami telah mengirimkan tautan verifikasi ke kotak masuk Anda. <br class="hidden sm:block mt-2">
                            <span class="font-medium text-textmain">Please verify your email address to unlock full system access.</span>
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-6 bg-status-success/10 border border-status-success/20 p-3.5 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-status-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[13px] font-medium text-status-success leading-relaxed">A new verification link has been sent to your registered email address.</p>
                        </div>
                    @endif

                    <div class="space-y-3.5 pt-2 border-t border-borderline/60">
                        
                        <p class="text-[12px] text-textmain/50 text-center sm:text-left mb-3">Tidak menerima email? Periksa folder Spam atau kirim ulang tautan.</p>

                        <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                            @csrf
                            <button type="submit" id="resendBtn" class="w-full py-2.5 bg-primary hover:bg-[#233B60] text-white rounded-xl font-semibold text-[13px] transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] flex justify-center items-center gap-2 group active:scale-[0.98]">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span>Resend Verification Link</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="submit" id="logoutBtn" class="w-full py-2.5 bg-transparent border border-borderline hover:bg-[#F8FAFC] hover:border-[#D1D5DB] text-textmain/70 hover:text-textmain rounded-xl font-semibold text-[13px] transition-all duration-200 flex justify-center items-center gap-2 group active:scale-[0.98]">
                                <svg class="w-4 h-4 text-textmain/50 group-hover:text-status-danger transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Sign Out of System</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- SweetAlert jika email sukses dikirim ulang ---
            @if(session('status') == 'verification-link-sent')
                Swal.fire({
                    icon: 'success',
                    title: 'Tautan Terkirim',
                    text: 'Silakan periksa kotak masuk atau folder spam pada email Anda.',
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

            // --- Loading state untuk tombol Kirim Ulang ---
            const resendForm = document.getElementById('resendForm');
            const resendBtn = document.getElementById('resendBtn');

            resendForm.addEventListener('submit', function() {
                resendBtn.disabled = true;
                resendBtn.classList.add('opacity-90', 'cursor-not-allowed');
                resendBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Sending...</span>
                `;
                
                Swal.fire({
                    title: 'Processing Request',
                    html: '<span class="text-sm text-gray-500">System is sending a new verification link...</span>',
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

            // --- Loading state tipis untuk tombol Sign Out ---
            const logoutForm = document.getElementById('logoutForm');
            const logoutBtn = document.getElementById('logoutBtn');

            logoutForm.addEventListener('submit', function() {
                logoutBtn.disabled = true;
                logoutBtn.classList.add('opacity-70', 'cursor-not-allowed');
                logoutBtn.innerHTML = `<span>Signing out...</span>`;
            });
        });
    </script>
</body>
</html>