<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PakarGERD') }} - Public Access</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F6F9; 
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #8FAFCC; }
    </style>
</head>
<body class="font-sans text-textmain antialiased bg-bgsoft selection:bg-primary/20 selection:text-primary flex flex-col min-h-screen relative overflow-x-hidden">
    
    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-primary/5 rounded-full blur-3xl z-0 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-secondary/10 rounded-full blur-3xl z-0 pointer-events-none"></div>
    
    <div class="fixed inset-0 z-0 opacity-40 pointer-events-none" style="background-image: radial-gradient(rgba(47, 79, 127, 0.08) 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>

    <div class="flex-grow flex flex-col justify-center items-center py-10 px-4 relative z-10">
        
        <div class="mb-8 text-center">
            <a href="/" class="flex flex-col items-center gap-3.5 group transition-all duration-300 hover:-translate-y-1 focus:outline-none">
                <div class="w-14 h-14 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-white shadow-[0_4px_14px_rgba(47,79,127,0.25)] group-hover:shadow-[0_8px_20px_rgba(47,79,127,0.35)] transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                
                <div class="flex flex-col items-center">
                    <h1 class="text-2xl font-bold tracking-tight text-textmain group-hover:text-primary transition-colors leading-tight">
                        Pakar<span class="text-primary font-black">GERD</span>
                    </h1>
                    <p class="text-[11px] font-medium text-textmain/50 uppercase tracking-widest mt-0.5">Public Service Area</p>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-[460px] bg-cardbg shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-borderline sm:rounded-3xl overflow-hidden relative transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-[#416B9E] to-secondary"></div>
            
            <div class="px-6 py-8 sm:p-10">
                {{ $slot }}
            </div>
        </div>

        <div class="mt-12 text-center flex flex-col items-center gap-2">
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/60 border border-borderline/60 backdrop-blur-sm shadow-sm">
                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[11px] font-semibold text-textmain/70">Secured System</span>
            </div>
            <p class="text-[12px] font-medium text-textmain/40 mt-1">
                &copy; {{ date('Y') }} Expert System. All rights reserved.
            </p>
        </div>

    </div>

</body>
</html>