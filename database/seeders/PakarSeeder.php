<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;

class PakarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. INPUT DATA GEJALA
        $dataGejala = [
            ['kode' => 'G01', 'nama_gejala' => 'Mual (Nausea)', 'is_kritis' => false],
            ['kode' => 'G02', 'nama_gejala' => 'Muntah (Emesis)', 'is_kritis' => false],
            ['kode' => 'G03', 'nama_gejala' => 'Nyeri di perut / Nyeri ulu hati', 'is_kritis' => false],
            ['kode' => 'G04', 'nama_gejala' => 'Perut terasa penuh / Kembung', 'is_kritis' => false],
            ['kode' => 'G05', 'nama_gejala' => 'Nafsu makan berkurang', 'is_kritis' => false],
            ['kode' => 'G06', 'nama_gejala' => 'Panas di dada (Heartburn)', 'is_kritis' => false],
            ['kode' => 'G07', 'nama_gejala' => 'Nyeri di dada', 'is_kritis' => false],
            ['kode' => 'G08', 'nama_gejala' => 'Sering bersendawa / Regurgitasi asam', 'is_kritis' => false],
            ['kode' => 'G09', 'nama_gejala' => 'Penurunan berat badan tanpa sebab', 'is_kritis' => false],
            ['kode' => 'G10', 'nama_gejala' => 'Suara serak / Sakit tenggorokan konstan', 'is_kritis' => false],
            ['kode' => 'G11', 'nama_gejala' => 'Sulit menelan (Disfagia)', 'is_kritis' => false],
            ['kode' => 'G12', 'nama_gejala' => 'Bau mulut (Halitosis)', 'is_kritis' => false],
            ['kode' => 'G13', 'nama_gejala' => 'Cepat kenyang (Early satiety)', 'is_kritis' => false],
            ['kode' => 'G14', 'nama_gejala' => 'Susah tidur akibat naiknya asam lambung', 'is_kritis' => false],
            ['kode' => 'G15', 'nama_gejala' => 'Muntah darah (berwarna seperti bubuk kopi)', 'is_kritis' => true], // KONDISI KRITIS
            ['kode' => 'G16', 'nama_gejala' => 'Diare/Mencret', 'is_kritis' => false],
            ['kode' => 'G17', 'nama_gejala' => 'Batuk kronis terus-menerus', 'is_kritis' => false],
            ['kode' => 'G18', 'nama_gejala' => 'Kram perut hebat / Kolik saluran cerna', 'is_kritis' => false],
            ['kode' => 'G19', 'nama_gejala' => 'Air liur muncul berlebihan secara mendadak', 'is_kritis' => false],
            ['kode' => 'G20', 'nama_gejala' => 'Tinja berwarna gelap / hitam', 'is_kritis' => true], // KONDISI KRITIS
        ];

        foreach ($dataGejala as $gejala) {
            Gejala::create($gejala);
        }

        // Ambil data penyakit buat mapping Rule
        $idGERD = Penyakit::where('kode', 'P01')->first()->id;
        $idGastritis = Penyakit::where('kode', 'P02')->first()->id;
        $idTukak = Penyakit::where('kode', 'P03')->first()->id;
        $idDispepsia = Penyakit::where('kode', 'P04')->first()->id;
        $idGastroparesis = Penyakit::where('kode', 'P05')->first()->id;
        $idHernia = Penyakit::where('kode', 'P06')->first()->id;
        $idBarrett = Penyakit::where('kode', 'P07')->first()->id;
        $idGastroenteritis = Penyakit::where('kode', 'P08')->first()->id;

        // 2. INPUT DATA RULES (RELASI PENYAKIT & GEJALA BESERTA BOBOT PAKAR)
        // Nilai MB diisi sesuai bobot PDF, Nilai MD di-set 0 (standar awal CF)
        $rules = [
            // G01: Mual
            ['penyakit_id' => $idGastritis, 'gejala_kode' => 'G01', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G01', 'mb' => 0.70, 'md' => 0.0],
            ['penyakit_id' => $idGastroparesis, 'gejala_kode' => 'G01', 'mb' => 1.00, 'md' => 0.0],
            
            // G02: Muntah
            ['penyakit_id' => $idGastritis, 'gejala_kode' => 'G02', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G02', 'mb' => 0.70, 'md' => 0.0],
            ['penyakit_id' => $idGastroparesis, 'gejala_kode' => 'G02', 'mb' => 0.90, 'md' => 0.0],

            // G03: Nyeri Ulu Hati (Spesifik sesuai tabel)
            ['penyakit_id' => $idGastritis, 'gejala_kode' => 'G03', 'mb' => 0.90, 'md' => 0.0],
            ['penyakit_id' => $idTukak, 'gejala_kode' => 'G03', 'mb' => 0.60, 'md' => 0.0],
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G03', 'mb' => 0.30, 'md' => 0.0],

            // G04: Perut Kembung
            ['penyakit_id' => $idGastritis, 'gejala_kode' => 'G04', 'mb' => 0.60, 'md' => 0.0],
            ['penyakit_id' => $idDispepsia, 'gejala_kode' => 'G04', 'mb' => 0.90, 'md' => 0.0],

            // G05: Nafsu makan berkurang
            ['penyakit_id' => $idGastritis, 'gejala_kode' => 'G05', 'mb' => 0.60, 'md' => 0.0],
            ['penyakit_id' => $idTukak, 'gejala_kode' => 'G05', 'mb' => 0.60, 'md' => 0.0],

            // G06: Panas di dada
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G06', 'mb' => 1.00, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G06', 'mb' => 1.00, 'md' => 0.0],

            // G07: Nyeri dada
            ['penyakit_id' => $idHernia, 'gejala_kode' => 'G07', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G07', 'mb' => 0.80, 'md' => 0.0],

            // G08: Sering bersendawa
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G08', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idHernia, 'gejala_kode' => 'G08', 'mb' => 0.80, 'md' => 0.0],

            // G09: Penurunan BB
            ['penyakit_id' => $idTukak, 'gejala_kode' => 'G09', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G09', 'mb' => 0.80, 'md' => 0.0],

            // G10: Suara serak
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G10', 'mb' => 0.70, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G10', 'mb' => 0.60, 'md' => 0.0],

            // G11: Sulit menelan
            ['penyakit_id' => $idHernia, 'gejala_kode' => 'G11', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G11', 'mb' => 0.90, 'md' => 0.0],

            // G12: Bau mulut
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G12', 'mb' => 0.40, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G12', 'mb' => 0.20, 'md' => 0.0],

            // G13: Cepat kenyang
            ['penyakit_id' => $idDispepsia, 'gejala_kode' => 'G13', 'mb' => 0.80, 'md' => 0.0],
            ['penyakit_id' => $idGastroparesis, 'gejala_kode' => 'G13', 'mb' => 0.80, 'md' => 0.0],

            // G14: Susah tidur
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G14', 'mb' => 0.40, 'md' => 0.0],

            // G15: Muntah darah (KRITIS)
            ['penyakit_id' => $idTukak, 'gejala_kode' => 'G15', 'mb' => 0.95, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G15', 'mb' => 0.95, 'md' => 0.0],

            // G16: Diare
            ['penyakit_id' => $idGastroenteritis, 'gejala_kode' => 'G16', 'mb' => 0.90, 'md' => 0.0],

            // G17: Batuk kronis
            ['penyakit_id' => $idHernia, 'gejala_kode' => 'G17', 'mb' => 0.50, 'md' => 0.0],
            ['penyakit_id' => $idGERD, 'gejala_kode' => 'G17', 'mb' => 0.70, 'md' => 0.0],

            // G18: Kram perut
            ['penyakit_id' => $idGastroenteritis, 'gejala_kode' => 'G18', 'mb' => 0.80, 'md' => 0.0],

            // G19: Air liur berlebih
            ['penyakit_id' => $idHernia, 'gejala_kode' => 'G19', 'mb' => 0.60, 'md' => 0.0],

            // G20: Tinja gelap (KRITIS)
            ['penyakit_id' => $idTukak, 'gejala_kode' => 'G20', 'mb' => 0.90, 'md' => 0.0],
            ['penyakit_id' => $idBarrett, 'gejala_kode' => 'G20', 'mb' => 0.90, 'md' => 0.0],
        ];

        foreach ($rules as $r) {
            // Kita cari ID gejala berdasarkan kodenya
            $gejalaId = Gejala::where('kode', $r['gejala_kode'])->first()->id;
            
            Rule::create([
                'penyakit_id' => $r['penyakit_id'],
                'gejala_id' => $gejalaId,
                'mb' => $r['mb'],
                'md' => $r['md']
            ]);
        }
    }
}