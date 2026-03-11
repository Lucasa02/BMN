<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja Perbaikan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #2c3e50; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 12px; }

        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px; font-weight: bold; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #bdc3c7; padding: 8px; text-align: left; vertical-align: top; }
        .data-table th { background-color: #ecf0f1; font-weight: bold; text-align: center; }
        .data-table td:nth-child(1) { text-align: center; width: 30px; }
        .data-table td:nth-child(5) { text-align: right; white-space: nowrap; }

        .footer { width: 100%; margin-top: 50px; }
        .signature-box { float: right; width: 300px; text-align: center; }
        .signature-line { margin-top: 70px; border-bottom: 1px solid #000; font-weight: bold; }

        .status-badge { color: white; padding: 4px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Kinerja Perbaikan Inventaris</h2>
        <p>Logbook Resmi Tim Perbaikan</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="120">Nama Tim Perbaikan</td>
            <td width="10">:</td>
            <td>{{ Auth::user()->nama_lengkap }}</td>
            <td width="120">Tanggal Cetak</td>
            <td width="10">:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>NIP / ID</td>
            <td>:</td>
            <td>{{ Auth::user()->nip ?? '-' }}</td>
            <td>Total Tercatat</td>
            <td>:</td>
            <td>{{ $logbook->count() }} Unit Barang</td>
        </tr>
        <tr>
            <td>Periode Laporan</td>
            <td>:</td>
            <td colspan="4" style="color: #c0392b;">{{ $periodeText }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Selesai</th>
                <th>Nama Barang</th>
                <th>Deskripsi Tindakan & Detail Pengerjaan</th>
                <th>Biaya Perbaikan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbook as $index => $l)
            @php
                // Logika Pewarnaan Background Status untuk PDF
                $bgColor = '#95a5a6'; // Abu-abu default (Proses/dll)
                if($l->status == 'selesai') {
                    $bgColor = '#27ae60'; // Hijau
                } elseif($l->status == 'diperbaiki') {
                    $bgColor = '#2980b9'; // Biru
                } elseif($l->status == 'tidak_dapat_diperbaiki') {
                    $bgColor = '#e74c3c'; // Merah
                } elseif($l->status == 'proses') {
                    $bgColor = '#f39c12'; // Oranye
                }
                $statusLabel = str_replace('_', ' ', $l->status);
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $l->updated_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $l->barang->nama_barang ?? 'Barang Dihapus' }}</strong><br><small>{{ $l->barang->kode_barang ?? '' }}</small></td>
                <td>{!! nl2br(e($l->deskripsi)) !!}</td>
                <td>Rp {{ number_format($l->biaya, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusLabel }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada riwayat perbaikan yang dilakukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui / Melaporkan,</p>
            <br>
            <div class="signature-line">{{ Auth::user()->nama_lengkap }}</div>
            <p style="margin-top: 5px;">Perbaikan</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
