<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Diagnosa - {{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</title>
    <style>
        /* === RESET & BASE STYLES === */
        @page {
            margin: 40px 50px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1F2937; /* Text Main */
            line-height: 1.5;
            font-size: 14px;
            background-color: #FFFFFF;
        }
        
        /* === KOP SURAT / HEADER === */
        .header-container {
            width: 100%;
            border-bottom: 3px solid #2F4F7F; /* Primary Color */
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header-title {
            color: #2F4F7F;
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }
        .header-subtitle {
            color: #5C7FA6; /* Secondary Color */
            font-size: 14px;
            margin: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-date {
            text-align: right;
            font-size: 12px;
            color: #6B7280;
            margin-top: -20px;
        }

        /* === BOX INFORMASI === */
        .section-title {
            font-size: 16px;
            color: #2F4F7F;
            border-bottom: 1px solid #E3E7ED;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 30px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .info-box {
            background-color: #F4F6F9; /* Background Soft */
            border: 1px solid #E3E7ED;
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        .info-table {
            width: 100%;
            border: none;
        }
        .info-table td {
            padding: 6px 0;
            vertical-align: top;
            border: none;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #4B5563;
            font-size: 13px;
        }

        /* === TABEL DATA HASIL === */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th {
            background-color: #2F4F7F;
            color: #FFFFFF;
            text-align: left;
            padding: 12px 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #2F4F7F;
        }
        .data-table td {
            padding: 15px;
            border: 1px solid #E3E7ED;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        /* Elemen Spesifik Tabel */
        .disease-name {
            font-size: 18px;
            font-weight: bold;
            color: #1F2937;
            margin: 0;
        }
        .cf-value {
            font-size: 20px;
            font-weight: bold;
            color: #2F4F7F;
        }
        
        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            text-transform: uppercase;
        }
        .badge-aman { background-color: #DEF7EC; color: #16A34A; border: 1px solid #BCF0DA; }
        .badge-waspada { background-color: #FEF3C7; color: #CA8A04; border: 1px solid #FDE047; }
        .badge-gawat { background-color: #FDE8E8; color: #DC2626; border: 1px solid #FBD5D5; }

        /* === DISCLAIMER BOX === */
        .warning-box {
            background-color: #FFFBEB;
            border: 1px solid #FEF3C7;
            border-left: 5px solid #F59E0B;
            padding: 15px 20px;
            margin-top: 40px;
            border-radius: 4px;
        }
        .warning-title {
            color: #B45309;
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .warning-text {
            color: #92400E;
            font-size: 12px;
            margin: 0;
            text-align: justify;
        }

        /* === FOOTER === */
        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
            border-top: 1px solid #E3E7ED;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <h1 class="header-title">PakarGERD</h1>
        <p class="header-subtitle">Sistem Pakar Triase Penyakit Lambung</p>
        <div class="header-date">
            Ref: {{ strtoupper(substr(md5($data->id . $data->tanggal), 0, 8)) }}
        </div>
    </div>

    <h2 class="section-title">Data Identitas Pengguna</h2>
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Lengkap</td>
                <td>: <strong>{{ $data->user->name ?? 'Pengguna Tidak Terdaftar (Guest)' }}</strong></td>
            </tr>
            <tr>
                <td class="info-label">Email Kontak</td>
                <td>: {{ $data->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Waktu Pemeriksaan</td>
                <td>: {{ \Carbon\Carbon::parse($data->tanggal)->format('l, d F Y - H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="info-label">Metode Kalkulasi</td>
                <td>: Certainty Factor (CF)</td>
            </tr>
        </table>
    </div>

    <h2 class="section-title">Kesimpulan Analisis Sistem</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th width="45%">Diagnosa Terindikasi</th>
                <th width="25%" style="text-align: center;">Tingkat CF</th>
                <th width="30%" style="text-align: center;">Status Triase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p class="disease-name">{{ $data->penyakit->nama_penyakit }}</p>
                </td>
                <td style="text-align: center;">
                    <span class="cf-value">{{ $data->cf_percentage }}%</span>
                </td>
                <td style="text-align: center;">
                    @php
                        $statusText = strtoupper($data->status_triase);
                        $badgeClass = 'badge-aman';
                        
                        if (strtolower($data->status_triase) == 'waspada') {
                            $badgeClass = 'badge-waspada';
                        } elseif (in_array(strtolower($data->status_triase), ['gawat', 'bahaya'])) {
                            $badgeClass = 'badge-gawat';
                        }
                    @endphp
                    <div class="badge {{ $badgeClass }}">{{ $statusText }}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <p class="warning-title">⚠️ PERHATIAN MEDIS (MEDICAL DISCLAIMER)</p>
        <p class="warning-text">
            Dokumen ini merupakan hasil perhitungan dari algoritma sistem pakar kecerdasan buatan berdasarkan gejala yang dimasukkan oleh pengguna, dan <strong>bukan merupakan vonis atau rekam medis resmi dari dokter</strong>. Hasil ini ditujukan sebagai langkah skrining awal (triase). Jika Anda mengalami gejala parah seperti muntah darah, kesulitan bernapas, atau nyeri dada yang hebat, <strong>segera hubungi layanan gawat darurat atau fasilitas kesehatan terdekat.</strong>
        </p>
    </div>

    <div class="footer">
        Dicetak secara elektronik dari Sistem Pakar GERD pada {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB. <br>
        Dokumen ini sah dan tidak memerlukan tanda tangan basah.
    </div>

</body>
</html>