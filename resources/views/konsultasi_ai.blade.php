@extends('layouts.app')

@section('title', 'AI Consult Assistant | Pakar GERD')

@push('styles')
    <style>
        /* === CUSTOM SCROLLBAR UNTUK CHAT === */
        #chatBox::-webkit-scrollbar { width: 5px; }
        #chatBox::-webkit-scrollbar-track { background: transparent; }
        #chatBox::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; }
        #chatBox::-webkit-scrollbar-thumb:hover { background: #8FAFCC; }

        /* === ANIMASI DOT TYPING === */
        .typing-indicator { display: flex; gap: 4px; align-items: center; padding: 4px 2px; }
        .typing-dot {
            width: 6px; height: 6px;
            background-color: #5C7FA6;
            border-radius: 50%;
            animation: typingBounce 1.4s infinite ease-in-out both;
        }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes typingBounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* === PARSER STYLING (Hasil Regex) === */
        .ai-message b, .ai-message strong { color: #1F2937; font-weight: 700; }
        .ai-message br { display: block; content: ""; margin-top: 8px; }
    </style>
@endpush

@section('content')
    <div class="max-w-[1000px] mx-auto h-[calc(100vh-140px)] min-h-[500px] flex flex-col bg-white border border-borderline rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.04)] overflow-hidden relative">
        
        <div class="bg-white/90 backdrop-blur-md border-b border-borderline px-6 py-4 flex items-center justify-between z-10">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl border border-primary/20 shadow-sm">
                        🤖
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-status-success border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h1 class="text-[16px] font-bold text-textmain leading-tight tracking-tight">Gastro AI Assistant</h1>
                    <p class="text-[12px] text-status-success font-semibold flex items-center gap-1 mt-0.5">
                        Online & Ready to help
                    </p>
                </div>
            </div>
            
            <button type="button" onclick="window.location.reload()" class="p-2 text-textmain/40 hover:text-primary hover:bg-bgsoft rounded-xl transition-colors" title="Mulai Obrolan Baru">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
        </div>

        <main id="chatBox" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 bg-[#F8FAFC]">
            
            <div class="flex justify-center my-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-textmain/40 bg-white border border-borderline px-3 py-1 rounded-full shadow-sm">
                    Today
                </span>
            </div>

            <div class="flex items-end gap-3 max-w-[85%] sm:max-w-[75%]">
                <div class="w-8 h-8 bg-primary/10 border border-primary/20 rounded-full flex items-center justify-center text-sm flex-shrink-0 mb-1">🤖</div>
                <div class="bg-white px-5 py-3.5 rounded-[1.2rem] rounded-bl-sm shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-borderline/60">
                    <p class="text-textmain/80 text-[14px] leading-relaxed">
                        Halo! Saya Asisten Kecerdasan Buatan PakarGERD. Ada keluhan pencernaan yang ingin didiskusikan hari ini? Perut terasa begah, mual, atau asam lambung sedang naik? Ceritakan keluhan Anda di bawah.
                    </p>
                </div>
            </div>

        </main>

        <footer class="bg-white p-4 sm:p-5 border-t border-borderline z-10">
            <form id="chatForm" class="relative max-w-4xl mx-auto flex items-end gap-2">
                <div class="relative flex-1 bg-bgsoft border border-borderline focus-within:border-primary/40 focus-within:bg-white focus-within:ring-4 focus-within:ring-primary/10 rounded-[1.5rem] transition-all duration-300">
                    <input type="text" id="userInput" placeholder="Ceritakan keluhan Anda di sini..." class="w-full bg-transparent border-none rounded-[1.5rem] px-5 py-4 focus:ring-0 outline-none text-[14px] text-textmain placeholder-textmain/40" required autocomplete="off">
                </div>
                
                <button type="submit" id="sendBtn" class="shrink-0 bg-primary hover:bg-[#233B60] text-white rounded-[1.2rem] w-14 h-14 flex items-center justify-center transition-all duration-200 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] active:scale-[0.95] disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <p class="text-center text-[10px] text-textmain/40 font-medium mt-3">
                AI dapat membuat kesalahan. Harap verifikasi info penting dengan dokter asli.
            </p>
        </footer>
    </div>
@endsection

@push('scripts')
    <script>
        const chatForm = document.getElementById('chatForm');
        const userInput = document.getElementById('userInput');
        const chatBox = document.getElementById('chatBox');
        const sendBtn = document.getElementById('sendBtn');

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const pesan = userInput.value.trim();
            if(!pesan) return;

            // Nonaktifkan input sementara
            userInput.disabled = true;
            sendBtn.disabled = true;

            tambahChatUser(pesan);
            userInput.value = '';
            
            const loadingId = tambahLoadingAi();

            try {
                const response = await fetch('/chat-ai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ pesan: pesan })
                });

                const data = await response.json();
                document.getElementById(loadingId).remove();
                
                if(response.ok) {
                    tambahChatAi(data.reply);
                } else {
                    tambahChatAi('Mohon maaf, server sedang mengalami gangguan. Silakan coba lagi nanti.');
                }

            } catch (error) {
                document.getElementById(loadingId).remove();
                tambahChatAi('Duh, koneksi terputus. Pastikan internet Anda stabil lalu kirim ulang pesan ya.');
            } finally {
                // Aktifkan kembali input
                userInput.disabled = false;
                sendBtn.disabled = false;
                userInput.focus();
            }
        });

        // Render Bubble Chat User
        function tambahChatUser(text) {
            // Escape HTML untuk keamanan (Mencegah XSS)
            const safeText = text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            
            const html = `
            <div class="flex items-end gap-3 justify-end max-w-[85%] sm:max-w-[75%] ml-auto mt-6 animate-fade-in-up">
                <div class="bg-primary text-white px-5 py-3.5 rounded-[1.2rem] rounded-br-sm shadow-[0_4px_15px_rgba(47,79,127,0.2)]">
                    <p class="text-[14px] leading-relaxed">${safeText}</p>
                </div>
            </div>`;
            chatBox.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        }

        // Render Animasi Loading AI
        function tambahLoadingAi() {
            const id = 'loading-' + Date.now();
            const html = `
            <div id="${id}" class="flex items-end gap-3 max-w-[85%] sm:max-w-[75%] mt-6 animate-fade-in-up">
                <div class="w-8 h-8 bg-primary/10 border border-primary/20 rounded-full flex items-center justify-center text-sm flex-shrink-0 mb-1">🤖</div>
                <div class="bg-white px-5 py-4 rounded-[1.2rem] rounded-bl-sm shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-borderline/60">
                    <div class="typing-indicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            </div>`;
            chatBox.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
            return id;
        }

        // Render Bubble Chat AI (Termasuk Parsing Misi & Link)
        function tambahChatAi(text) {
            // 1. Parsing Bold (Markdown)
            let formattedText = text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
            
            // 2. Parsing Link: [Nama Link](http://link.com)
            formattedText = formattedText.replace(/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/g, '<a href="$2" target="_blank" class="inline-flex items-center gap-1 bg-accent/10 text-primary hover:bg-accent/20 border border-accent/20 font-bold px-2 py-0.5 rounded-md text-[12px] transition-colors my-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg> $1</a>');
            
            // 3. Parsing Misi: [MISI: Makan tepat waktu]
            formattedText = formattedText.replace(/\[MISI:\s*(.+?)\]/g, `<button type="button" onclick="tambahMisi(this, '$1')" class="w-full text-left mt-3 bg-status-success/10 hover:bg-status-success/20 border border-status-success/30 px-4 py-3 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-between group"><div class="flex items-center gap-2.5"><span class="text-xl">🎯</span><span class="text-[13px] font-bold text-[#206A3F] leading-tight">Misi Baru: <br><span class="font-medium">$1</span></span></div><span class="shrink-0 bg-white border border-status-success/20 text-status-success font-bold px-2.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider group-hover:bg-status-success group-hover:text-white transition-colors flex items-center gap-1">+ Tracker</span></button>`);
            
            // 4. Parsing Line Breaks
            formattedText = formattedText.replace(/\n/g, '<br>');
            
            const html = `
            <div class="flex items-end gap-3 max-w-[90%] sm:max-w-[80%] mt-6 animate-fade-in-up">
                <div class="w-8 h-8 bg-primary/10 border border-primary/20 rounded-full flex items-center justify-center text-sm flex-shrink-0 mb-1">🤖</div>
                <div class="bg-white px-5 py-4 rounded-[1.2rem] rounded-bl-sm shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-borderline/60">
                    <p class="ai-message text-textmain/80 text-[14px] leading-relaxed">${formattedText}</p>
                </div>
            </div>`;
            chatBox.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        }

        // Fungsi Tambah Misi ke Tracker
        async function tambahMisi(btnElement, namaMisi) {
            btnElement.innerHTML = `<div class="flex items-center gap-2 text-[13px] font-bold text-status-warning"><svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menambahkan...</div>`;
            btnElement.disabled = true;
            btnElement.classList.add('cursor-not-allowed', 'opacity-80');

            try {
                const response = await fetch('/tracker/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ nama_misi: namaMisi })
                });

                if (response.ok) {
                    btnElement.innerHTML = `<div class="flex items-center gap-2"><svg class="w-5 h-5 text-status-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg><span class="text-[13px] font-bold text-status-success">Berhasil Ditambahkan!</span></div>`;
                    btnElement.className = "w-full text-left mt-3 bg-bgsoft border border-borderline px-4 py-3 rounded-xl flex items-center justify-center opacity-70";
                } else {
                    btnElement.innerHTML = `<div class="flex items-center gap-2 text-status-danger text-[13px] font-bold">❌ Gagal menyimpan. Coba lagi.</div>`;
                    btnElement.disabled = false;
                    btnElement.classList.remove('cursor-not-allowed', 'opacity-80');
                }
            } catch (error) {
                btnElement.innerHTML = `<div class="flex items-center gap-2 text-status-danger text-[13px] font-bold">❌ Koneksi terputus.</div>`;
                btnElement.disabled = false;
                btnElement.classList.remove('cursor-not-allowed', 'opacity-80');
            }
        }

        // Auto Scroll ke Bawah
        function scrollToBottom() {
            chatBox.scrollTo({
                top: chatBox.scrollHeight,
                behavior: 'smooth'
            });
        }
        
        // Animasi kemunculan chat dari bawah
        const style = document.createElement('style');
        style.innerHTML = `
            .animate-fade-in-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        `;
        document.head.appendChild(style);
    </script>
@endpush