<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SimulasiBpom;
use Carbon\Carbon;

class AiController extends Controller
{
    public function index()
    {
        return view('konsultasi_ai');
    }

    public function chat(Request $request)
    {
        $pesanUser = $request->input('pesan');

        // 1. Ambil nama obat SEKALIGUS link pembeliannya
        $obatAman = SimulasiBpom::whereIn('golongan', ['Bebas', 'Bebas Terbatas'])
                                ->get(['nama_obat', 'link_pembelian']);
        
        // Bikin daftar panjang berisi: "Nama Obat (URL)"
        $daftarObatLokal = "";
        foreach ($obatAman as $obat) {
            $link = $obat->link_pembelian ? $obat->link_pembelian : '#';
            $daftarObatLokal .= "- " . $obat->nama_obat . " (URL: " . $link . ")\n";
        }
        
        $waktu = now()->timezone('Asia/Jakarta');
        $hariTanggal = $waktu->translatedFormat('l, d F Y');
        $jam = $waktu->format('H:i');
        $tahunSekarang = $waktu->year;

        // 2. System Prompt Update (Bilingual, Empatik, dan Profesional)
        $systemPrompt = "Anda adalah 'Gastro AI Assistant', asisten kecerdasan buatan spesialis kesehatan lambung dan GERD yang berempati, informatif, dan profesional. 
        [SYSTEM CONTEXT: Anda beroperasi di Indonesia. Waktu saat ini: " . $hariTanggal . ", pukul " . $jam . " WIB. Gunakan konteks ini untuk memberikan sapaan yang relevan. Presiden RI saat ini: Prabowo Subianto].

        Tugas Anda terbagi menjadi dua skenario utama:

        SKENARIO A: JIKA PENGGUNA BERTANYA SEPUTAR KESEHATAN PENCERNAAN
        1. Dengarkan keluhan pengguna dengan empati dan berikan validasi atas ketidaknyamanan yang dirasakan.
        2. Berikan saran swamedikasi non-farmakologis (contoh: manajemen stres, posisi tidur, pola makan).
        3. JIKA merekomendasikan intervensi medis/obat, ANDA HANYA DIIZINKAN memilih dari daftar inventaris berikut:\n" . $daftarObatLokal . "
        4. PENTING: Saat merujuk nama obat dari daftar di atas, WAJIB sertakan tautan pembelian menggunakan format Markdown Link.
        5. Sisipkan Medical Disclaimer bahwa saran ini bersifat triase awal dan bukan pengganti diagnosis dokter.
        6. JIKA memberikan saran perubahan kebiasaan, berikan misi harian kepada pengguna. Gunakan format persis seperti ini di akhir respons: [MISI: nama misi]. Contoh: [MISI: Hindari konsumsi kafein hari ini] atau [MISI: Minum air putih 2 liter]. Anda boleh memberikan lebih dari satu misi.
        7. JIKA pengguna menanyakan obat di luar daftar inventaris, JANGAN menyebutkan ulang nama obat tersebut. Berikan edukasi mengapa kandungan tertentu mungkin berisiko bagi lambung, dan sarankan untuk berkonsultasi dengan dokter spesialis.
        
        SKENARIO B: JIKA PENGGUNA BERTANYA DI LUAR TOPIK KESEHATAN
        1. Jangan menolak secara kaku. Awali dengan: '*Fokus utama saya adalah kesehatan pencernaan Anda, namun saya akan mencoba membantu menjawab hal tersebut!*'
        2. Berikan jawaban umum yang akurat, ringkas, dan sopan.
        3. DILARANG KERAS memberikan format [MISI: ...] pada skenario non-medis ini.

        ATURAN KOMUNIKASI:
        1. Gunakan bahasa semi-formal (Indonesia yang baik dengan sedikit istilah medis yang dijelaskan secara sederhana).
        2. Jangan pernah mendeskripsikan diri Anda sebagai LLM, bot, atau program bahasa. Bersikaplah seperti asisten virtual kesehatan yang ahli.";
        
        $apiKey = env('GROQ_API_KEY');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $pesanUser]
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $balasanAi = $response->json()['choices'][0]['message']['content'];
                return response()->json(['reply' => $balasanAi]);
            } else {
                // Auto-fetch error models Groq dengan UI HTML yang elegan
                $modelResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])->get('https://api.groq.com/openai/v1/models');

                // Menggunakan Inline SVG Error Icon
                $errorMsg = "<div class='text-[#D9534F] font-bold flex items-center gap-2 mb-2'>
                                <svg class='w-5 h-5 shrink-0' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path></svg>
                                Layanan AI Sedang Mengalami Kendala (Error: " . $response->status() . ")
                             </div>
                             <p class='text-sm mb-3'>Model AI yang digunakan saat ini tidak merespons. Berikut adalah daftar model yang tersedia di server GroqCloud Anda:</p>";

                if ($modelResponse->successful()) {
                    $models = $modelResponse->json()['data'];
                    $errorMsg .= "<div class='bg-gray-50 border border-gray-200 rounded-lg p-3 max-h-40 overflow-y-auto text-xs font-mono text-gray-600'>";
                    foreach ($models as $m) {
                        $errorMsg .= "<div>&bull; " . $m['id'] . "</div>";
                    }
                    $errorMsg .= "</div>";
                }
                return response()->json(['reply' => $errorMsg]);
            }
        } catch (\Exception $e) {
            return response()->json(['reply' => "<div class='text-[#D9534F] font-bold flex items-center gap-2'><svg class='w-5 h-5 shrink-0' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'></path></svg> Koneksi terputus. Sistem gagal menghubungi server AI: " . $e->getMessage() . "</div>"]);
        }
    }


    // --- FITUR BARU: AI FOOD SCANNER ---

    public function foodScannerIndex()
    {
        return view('food_scanner');
    }

    public function scanFood(Request $request)
    {
        $request->validate([
            'foto_makanan' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $image = $request->file('foto_makanan');
        $base64Image = base64_encode(file_get_contents($image->getRealPath()));
        $mimeType = $image->getClientMimeType();

        $systemPrompt = "Anda adalah Ahli Gizi Klinis AI spesialis penyakit lambung dan GERD.
        Tugas Anda adalah melakukan analisis visual terhadap foto makanan/minuman yang dikirimkan oleh pengguna. 
        Berikan penilaian akademis namun mudah dipahami dengan format berikut:
        
        [STATUS]: (Pilih satu secara presisi: 🟢 AMAN / 🟡 KONSUMSI TERBATAS / 🔴 HINDARI)
        [IDENTIFIKASI OBJEK]: (Sebutkan tebakan rasional nama makanan/minuman tersebut)
        [ANALISIS KLINIS]: (Berikan penjelasan medis singkat mengapa komposisi visual makanan ini (seperti tingkat minyak, rempah pedas, keasaman, atau tekstur) memengaruhi produksi asam lambung).";

        $apiKey = env('GROQ_API_KEY');
        
        // PENTING: Llama-4-scout belum mendukung vision di Groq. Gunakan model vision Llama 3.2.
        $modelDipakai = 'meta-llama/llama-4-scout-17b-16e-instruct'; // <-- Aku ubah ke model Vision resmi yang jalan di Groq

        try {
            $response = Http::timeout(30)->withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $modelDipakai,
                'messages' => [
                    [
                        'role' => 'user', 
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $systemPrompt
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => "data:{$mimeType};base64,{$base64Image}"
                                ]
                            ]
                        ]
                    ]
                ],
                'temperature' => 0.4,
            ]);

            if ($response->successful()) {
                $hasilScan = $response->json()['choices'][0]['message']['content'];
                return response()->json(['reply' => $hasilScan]);
            } else {
                // =========================================================
                // DEBUGGING ERROR MODEL GROQCLOUD (UI PREMIUM)
                // =========================================================
                $modelResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])->get('https://api.groq.com/openai/v1/models');
                
                $errorBody = $response->json();
                $pesanError = $errorBody['error']['message'] ?? $response->body();
                
                $pesanBalasan = "<div class='text-[#D9534F] font-bold flex items-start gap-2 mb-3'>
                                    <svg class='w-5 h-5 shrink-0 mt-0.5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path></svg>
                                    <div>
                                        <p class='mb-1'>Gagal Memproses Gambar</p>
                                        <p class='text-xs font-normal opacity-80'>" . htmlspecialchars($pesanError) . "</p>
                                    </div>
                                 </div>";

                if ($modelResponse->successful()) {
                    $models = $modelResponse->json()['data'];
                    $pesanBalasan .= "<p class='text-sm mb-2 font-medium'>Daftar Model GroqCloud yang Aktif:</p>
                                      <div class='bg-[#F8FAFC] border border-[#E3E7ED] rounded-lg p-3 max-h-40 overflow-y-auto text-[11px] font-mono text-[#4A6FA5]'>";
                    
                    foreach ($models as $m) {
                        $pesanBalasan .= "<div class='py-0.5 border-b border-gray-100 last:border-0'>&bull; " . $m['id'] . "</div>";
                    }
                    $pesanBalasan .= "</div>
                                      <p class='text-[11px] text-gray-500 mt-2 italic'>*Pastikan Anda menggunakan model dengan akhiran 'vision' (misal: llama-3.2-11b-vision-preview) pada kode Controller.</p>";
                }

                return response()->json(['reply' => $pesanBalasan], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['reply' => "<div class='text-[#D9534F] font-bold flex items-center gap-2'><svg class='w-5 h-5 shrink-0' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'></path></svg> Koneksi terputus: " . htmlspecialchars($e->getMessage()) . "</div>"], 500);
        }
    }
}