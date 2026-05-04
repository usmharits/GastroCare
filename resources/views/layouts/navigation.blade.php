<nav x-data="{ open: false }" class="bg-white/85 backdrop-blur-lg border-b border-borderline sticky top-0 z-50 transition-all duration-300 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[72px]">
            
            <div class="flex items-center">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group focus:outline-none">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center text-white shadow-[0_4px_10px_rgba(47,79,127,0.2)] group-hover:shadow-[0_6px_15px_rgba(47,79,127,0.3)] group-hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="hidden sm:flex flex-col justify-center">
                            <span class="text-[17px] font-bold tracking-tight text-textmain group-hover:text-primary transition-colors leading-tight">
                                Pakar<span class="text-primary font-black">GERD</span>
                            </span>
                            <span class="text-[10px] font-medium text-textmain/50 uppercase tracking-wider">Expert System</span>
                        </div>
                    </a>
                </div>

                <div class="hidden sm:ms-8 sm:flex sm:items-center sm:space-x-1 border-l border-borderline/80 pl-6 h-8">
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">
                        Dashboard
                    </a>
                    <a href="/proses-diagnosa" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all duration-200 {{ request()->is('proses-diagnosa') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">
                        Diagnosis
                    </a>
                    <a href="/faskes-terdekat" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold transition-all duration-200 {{ request()->is('faskes-terdekat') ? 'bg-primary/10 text-primary' : 'text-textmain/65 hover:bg-bgsoft hover:text-primary' }}">
                        Maps Faskes
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-borderline text-[13px] leading-4 font-semibold rounded-xl text-textmain/80 bg-white hover:text-primary hover:bg-bgsoft hover:border-primary/30 focus:outline-none transition-all duration-300 shadow-[0_2px_10px_rgb(0,0,0,0.02)] group">
                            
                            <div class="w-7 h-7 rounded-lg bg-primary/10 text-primary flex items-center justify-center mr-2.5 text-xs font-bold border border-primary/20 group-hover:bg-primary group-hover:text-white transition-colors">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            
                            <div class="max-w-[120px] truncate">{{ Auth::user()->name }}</div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 text-textmain/40 group-hover:text-primary transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3.5 border-b border-borderline bg-bgsoft/50 rounded-t-md">
                            <p class="text-[10px] text-textmain/50 font-bold uppercase tracking-wider mb-0.5">Active Session</p>
                            <p class="text-[13px] font-bold text-textmain truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="p-1.5 space-y-0.5">
                            <x-dropdown-link :href="route('profile.edit')" class="!text-[13px] !font-semibold !text-textmain/80 hover:!text-primary hover:!bg-bgsoft rounded-lg flex items-center gap-2.5 transition-colors py-2.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ __('Account Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}" id="logoutFormNav">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); confirmLogout('logoutFormNav');" 
                                        class="!text-[13px] !font-semibold !text-status-danger hover:!text-status-danger hover:!bg-status-danger/10 rounded-lg flex items-center gap-2.5 transition-colors py-2.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __('Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-textmain/60 hover:text-primary hover:bg-bgsoft focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden border-t border-borderline bg-white absolute w-full shadow-lg" 
         style="display: none;">
        
        <div class="pt-3 pb-4 space-y-1.5 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl font-semibold text-[14px]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="/proses-diagnosa" :active="request()->is('proses-diagnosa')" class="rounded-xl font-semibold text-[14px]">
                {{ __('Diagnosis System') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="/faskes-terdekat" :active="request()->is('faskes-terdekat')" class="rounded-xl font-semibold text-[14px]">
                {{ __('Maps Faskes') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-5 pb-5 border-t border-borderline bg-bgsoft/30">
            <div class="px-5 flex items-center gap-3.5 mb-4">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-sm font-bold border border-primary/20 shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-[14px] text-textmain">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-[12px] text-textmain/60">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1.5 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl font-semibold text-[14px] text-textmain/80 flex items-center gap-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('Account Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" id="logoutFormNavMobile">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); confirmLogout('logoutFormNavMobile');" 
                            class="rounded-xl font-semibold text-[14px] !text-status-danger hover:!bg-status-danger/10 flex items-center gap-2.5 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('Sign Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>