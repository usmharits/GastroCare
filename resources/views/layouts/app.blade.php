<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pakar Triase Penyakit Lambung')</title>
    
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F6F9; 
        }
        
        /* Custom Scrollbar yang Elegan */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #8FAFCC; }

        /* Mencegah highlight biru saat klik di mobile */
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="text-textmain antialiased min-h-screen flex flex-col relative selection:bg-primary/20 selection:text-primary">

    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-lg border-b border-borderline shadow-[0_4px_20px_rgb(0,0,0,0.02)] transition-all duration-300">
        <div class="container-fluid px-4 md:px-8 max-w-[1400px] mx-auto">
            <div class="h-[72px] flex items-center justify-between">
                
                <a href="/" class="flex items-center gap-3 group outline-none">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center text-white shadow-[0_4px_10px_rgba(47,79,127,0.2)] group-hover:shadow-[0_6px_15px_rgba(47,79,127,0.3)] group-hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[17px] font-bold tracking-tight text-textmain group-hover:text-primary transition-colors leading-tight">
                            Pakar<span class="text-primary font-black">GERD</span>
                        </span>
                        <span class="text-[10px] font-medium text-textmain/50 uppercase tracking-wider">Expert System</span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-1.5">
                    
                    <div class="flex items-center gap-1 mr-4 border-r border-borderline/80 pr-5">
                        <a href="/" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('/') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">Dashboard</a>
                        
                        <a href="/proses-diagnosa" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('proses-diagnosa') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">Diagnosis</a>
                        
                        <a href="/faskes-terdekat" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('faskes-terdekat') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">Maps Faskes</a>
                        
                        <a href="/food-scanner" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('food-scanner') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">Food Scanner</a>

                        @auth
                            <a href="/konsultasi-ai" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('konsultasi-ai') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">AI Chat</a>
                            
                            <a href="/tracker" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all {{ request()->is('tracker') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">Daily Tracker</a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-2">
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="m-0" id="logoutFormDesktop">
                                @csrf
                                <button type="button" onclick="confirmLogout('logoutFormDesktop')" class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-[13px] font-semibold text-status-danger/80 hover:bg-status-danger/10 hover:text-status-danger transition-colors group">
                                    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-lg text-[13px] font-semibold text-textmain/70 hover:text-primary hover:bg-bgsoft transition-colors">Sign In</a>
                            <a href="{{ route('register') }}" class="px-4 py-2.5 rounded-xl text-[13px] font-semibold bg-primary text-white hover:bg-[#233B60] transition-all shadow-[0_4px_14px_rgba(47,79,127,0.2)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.3)] active:scale-[0.98]">Create Account</a>
                        @endguest
                    </div>
                </nav>

                <button id="mobileMenuBtn" class="md:hidden p-2 text-textmain/70 hover:text-primary rounded-xl hover:bg-bgsoft transition-colors focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <svg id="iconOpen" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="iconClose" class="w-6 h-6 hidden transition-transform duration-300 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobileMenu" class="md:hidden absolute top-[72px] left-0 w-full bg-white border-b border-borderline shadow-lg transition-all duration-300 origin-top transform scale-y-0 opacity-0 invisible">
            <div class="px-4 py-5 space-y-2 flex flex-col h-[calc(100vh-72px)] overflow-y-auto pb-10">
                <p class="text-[11px] font-bold text-textmain/40 uppercase tracking-wider mb-2 px-2">Menu Navigasi</p>
                
                <a href="/" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('/') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">Dashboard</a>
                <a href="/proses-diagnosa" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('proses-diagnosa') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">Diagnosis System</a>
                <a href="/faskes-terdekat" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('faskes-terdekat') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">Maps Faskes</a>
                <a href="/food-scanner" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('food-scanner') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">Food Scanner</a>

                @auth
                    <a href="/konsultasi-ai" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('konsultasi-ai') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">AI Chat Assistant</a>
                    <a href="/tracker" class="block px-4 py-3 rounded-xl text-[14px] font-semibold {{ request()->is('tracker') ? 'bg-primary/10 text-primary' : 'text-textmain/70 hover:bg-bgsoft hover:text-primary' }}">Daily Tracker</a>
                    
                    <div class="mt-4 pt-4 border-t border-borderline">
                        <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                            @csrf
                            <button type="button" onclick="confirmLogout('logoutFormMobile')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-[14px] font-semibold text-status-danger bg-status-danger/5 hover:bg-status-danger/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="mt-4 pt-4 border-t border-borderline flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 rounded-xl text-[14px] font-semibold text-textmain border border-borderline hover:bg-bgsoft transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-3 rounded-xl text-[14px] font-semibold bg-primary text-white shadow-sm hover:bg-[#233B60] transition-colors">Create Account</a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="flex-grow container-fluid px-4 md:px-8 max-w-[1400px] mx-auto py-8 lg:py-10">
        @yield('content')
        {{ $slot ?? '' }} 
    </main>

    <footer class="mt-auto py-8 border-t border-borderline bg-white text-center">
        <div class="container-fluid max-w-[1400px] mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-textmain/50">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[12px] font-medium">Certainty Factor Method</p>
            </div>
            <p class="text-[12px] text-textmain/50 font-medium">
                &copy; {{ date('Y') }} Expert System v1.0. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- 1. Mobile Menu Toggle Logic ---
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenu');
            const iconOpen = document.getElementById('iconOpen');
            const iconClose = document.getElementById('iconClose');
            let isMenuOpen = false;

            btn.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                if (isMenuOpen) {
                    menu.classList.remove('scale-y-0', 'opacity-0', 'invisible');
                    menu.classList.add('scale-y-100', 'opacity-100', 'visible');
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                    iconClose.classList.remove('rotate-90');
                    document.body.style.overflow = 'hidden'; // Cegah scroll body saat menu terbuka
                } else {
                    menu.classList.remove('scale-y-100', 'opacity-100', 'visible');
                    menu.classList.add('scale-y-0', 'opacity-0', 'invisible');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                    iconClose.classList.add('rotate-90');
                    document.body.style.overflow = '';
                }
            });

            // --- 2. Global Toast Notification (Tangkap session dari Controller) ---
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-xl border border-[#E3E7ED] shadow-lg mt-16 mr-4',
                    title: 'text-sm font-semibold text-[#1F2937]'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif
        });

        // --- 3. Smart Logout Confirmation ---
        function confirmLogout(formId) {
            Swal.fire({
                title: 'Sign Out?',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D9534F',
                cancelButtonColor: '#F4F6F9',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: '<span style="color:#1F2937">Batal</span>',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl border border-[#E3E7ED] shadow-xl',
                    title: 'text-lg font-bold text-[#1F2937]',
                    confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold',
                    cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold border border-[#E3E7ED]'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Signing Out...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl border border-[#E3E7ED] w-64' },
                        didOpen: () => { Swal.showLoading(); }
                    });
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</body>
</html>