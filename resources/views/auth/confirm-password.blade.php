<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Confirmation - Sistem Pakar Diagnosa Penyakit Lambung</title>
    
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
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <div class="mb-6 text-center lg:text-left">
                        <h2 class="text-xl font-bold text-textmain mb-1.5 tracking-tight">Security Confirmation</h2>
                        <p class="text-[13px] text-textmain/60 leading-relaxed">Tindakan ini memerlukan tingkat keamanan ekstra. Silakan verifikasi identitas Anda dengan memasukkan kata sandi.</p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm" class="space-y-5">
                        @csrf

                        <div class="group relative">
                            <label for="password" class="block text-[12px] font-semibold text-textmain mb-1.5">Authentication Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-textmain/40 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                                <input type="password" id="password" name="password" required autocomplete="current-password"
                                    class="w-full py-2.5 pl-9 pr-10 bg-bgsoft border border-borderline rounded-xl text-[13px] text-textmain focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all duration-200 placeholder:text-textmain/30 outline-none"
                                    placeholder="Enter your password">
                                
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-textmain/40 hover:text-primary transition-colors focus:outline-none" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeSlashIcon" class="h-4 w-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="flex justify-end pt-1">
                                <a href="{{ route('password.request') }}" class="text-[12px] font-semibold text-primary hover:text-[#233B60] hover:underline transition-colors">
                                    Forgot password?
                                </a>
                            </div>
                        @endif

                        <div class="pt-2">
                            <button type="submit" id="submitBtn" class="w-full py-2.5 bg-primary hover:bg-[#233B60] text-white rounded-xl font-semibold text-[13px] transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] flex justify-center items-center gap-2 group active:scale-[0.98]">
                                <span>Verify Identity</span>
                                <svg class="w-4 h-4 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- Toggle Password Visibility Logic ---
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            togglePasswordBtn.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if(isPassword) {
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });

            // --- SweetAlert Error Validasi Laravel ---
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Authentication Failed',
                    text: 'Kata sandi yang Anda masukkan tidak valid. Please try again.',
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

            // --- Loading State Saat Submit Form ---
            const form = document.getElementById('confirmForm');
            const btn = document.getElementById('submitBtn');

            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.classList.add('opacity-90', 'cursor-not-allowed');
                btn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Verifying...</span>
                `;
                
                Swal.fire({
                    title: 'Verifying Security',
                    html: '<span class="text-sm text-gray-500">System is authenticating your credentials...</span>',
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