<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Tracker; 
use Carbon\Carbon;

class KirimReminderWa extends Command
{
    /**
     * Nama command untuk dieksekusi via terminal (php artisan pakar:reminder-wa)
     */
    protected $signature = 'pakar:reminder-wa';

    /**
     * Deskripsi command
     */
    protected $description = 'Kirim notifikasi WhatsApp via Fonnte untuk pengguna yang belum menyelesaikan misi harian.';

    public function handle()
    {
        $this->info('🔍 Memulai pemindaian misi harian yang belum tuntas...');

        // Mengambil user yang memiliki relasi trackers dengan is_done = false
        $users = User::whereHas('trackers', function ($query) {
            $query->where('is_done', false);
        })->with(['trackers' => function ($query) {
            $query->where('is_done', false);
        }])->get();

        if ($users->isEmpty()) {
            $this->info('✨ Luar biasa! Seluruh pengguna telah menyelesaikan misi kesehatannya hari ini.');
            return;
        }

        $tokenFonnte = env('FONNTE_TOKEN');

        foreach ($users as $user) {
            // Skip jika user tidak mencantumkan nomor HP
            if (!$user->no_hp) continue;

            // Merapikan daftar misi menjadi format bullet points WhatsApp
            $daftarMisi = "";
            foreach ($user->trackers as $misi) {
                $daftarMisi .= "▪️ {$misi->nama_misi}\n";
            }

            // Menyusun copywriting pesan WhatsApp yang empatik dan suportif
            $pesanWa  = "Halo, *{$user->name}*! 👋✨\n\n";
            $pesanWa .= "Semoga harimu menyenangkan. Asisten PakarGERD melihat masih ada beberapa misi kesehatan lambung yang belum sempat kamu selesaikan hari ini:\n\n";
            $pesanWa .= "{$daftarMisi}\n";
            $pesanWa .= "Yuk, luangkan waktu sebentar untuk menyelesaikannya. Konsistensi adalah kunci untuk pencernaan yang lebih sehat! 💪🌿\n\n";
            $pesanWa .= "_Pesan ini dikirim otomatis oleh Sistem PakarGERD._";

            try {
                $response = Http::withHeaders([
                    'Authorization' => $tokenFonnte,
                ])->post('https://api.fonnte.com/send', [
                    'target'  => $user->no_hp,
                    'message' => $pesanWa,
                    'delay'   => '2' // Jeda 2 detik untuk menghindari rate-limit/spam detection Fonnte
                ]);

                $body = $response->json();

                // Fonnte mengembalikan status: true jika berhasil masuk antrean
                if ($response->successful() && isset($body['status']) && $body['status'] == true) {
                    $this->info("[✅ SUCCESS] Pengingat terkirim ke: {$user->name} ({$user->no_hp})");
                } else {
                    // Menangkap dan menampilkan alasan detail jika gagal
                    $alasan = $body['detail'] ?? $body['reason'] ?? $response->body();
                    $this->error("[❌ FAILED] Gagal mengirim ke {$user->name} | Detail: " . $alasan);
                }
                
            } catch (\Exception $e) {
                $this->error("[🚨 ERROR] Koneksi API Fonnte terputus: " . $e->getMessage());
            }
        }
        
        $this->newLine();
        $this->info('🏁 Proses pengiriman pengingat WhatsApp selesai.');
    }
}