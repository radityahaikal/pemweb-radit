<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Barang Jadi {{ $barangJadi->kodejadi }}</title>
    <link href="{{ asset('css/poppins.css') }}" rel="stylesheet">
    
    <style>
        /* CSS Disesuaikan dari PHP Native dan Dioptimalkan untuk Blade */
        body { 
            font-family: Arial, sans-serif; 
            background-color: #fff; /* Diubah menjadi putih untuk cetak */
            margin: 0;
            padding: 0;
            font-size: 10pt; /* Ukuran font umum yang lebih kecil untuk cetak */
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #fff; 
            border: 1px solid #ccc; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        .header-info { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .header-info img { 
            width: 300px; 
            height: auto; 
            margin-bottom: 5px;
        }
        .header-info strong { 
            font-weight: bold; 
            line-height: 1.4; /* Jarak baris yang lebih baik */
            display: block; /* Memastikan setiap baris berada di baris baru */
        }
        .detail-info { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .detail-info strong {
            display: block;
            margin-bottom: 5px;
            font-size: 12pt;
        }
        
        .medicine-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .medicine-list th, .medicine-list td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .total-row td {
            font-weight: bold;
        }
        
        .ttd-section {
            display: flex; 
            justify-content: flex-end; /* Memindahkan TTD ke kanan */
            margin-top: 40px;
        }
        .ttd-box {
            position: relative; 
            display: inline-block; 
            text-align: center;
            /* width: 200px;  */
        }
        .ttd-box pre { margin: 0; white-space: pre-wrap; }
        .ttd-box img.ttd-img { 
            width: 90px; 
            height: auto;
            display: block; /* Memastikan gambar berada di baris baru */
            margin: 5px auto; /* Menengahkan gambar */
        }
        .ttd-box img.stempel-img { 
            position: absolute; 
            top: 55%; /* Geser ke bawah agar menutupi ttd */
            left: 50%; 
            transform: translate(-50%, -50%) rotate(-15deg); 
            opacity: 0.4; 
            width: 90px; 
            height: auto;
        }

        /* Aturan untuk cetak */
        @media print {
            body { background-color: #fff; }
            .container {
                border: none;
                box-shadow: none;
                padding: 0;
            }
            .medicine-list th, .medicine-list td {
                border-color: #000; /* Border hitam untuk cetak */
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        
        <div class="header-info">
            <img src="{{ asset('images/coba1.png') }}" alt="Logo Perusahaan"><br>

            <strong>
                SERVICE KNALPOT PURBALINGGA<br>
                SERVICE, GANTI KNALPOT<br>
                REPARASI SERVICE KNALPOT MOBIL, MOTOR, DLL<br>
                JL. H. NAMAN NO.28, PONDOK KELAPA, JAKARTA-TIMUR<br>
                HP. 081399135032
            </strong>
        </div>

        <div class="detail-info">
            <strong>DETAIL KOMPOSISI BARANG JADI</strong><br>
            Barang Jadi: {{ $barangJadi->barangataulayanan }}<br>
            Kode: {{ $barangJadi->kodejadi }}<br>
            Satuan: {{ $barangJadi->satuan }}
        </div>

        <div class="medicine-list">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bahan Baku</th>
                        <th>Ukuran</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($barangJadi->detailBarang as $detail)
                        <tr>
                            <td>{{ $no++ }}</td>
                            {{-- Mengambil nama bahan baku dari relasi bahanBaku --}}
                            <td>{{ $detail->bahanBaku->jenis ?? 'N/A' }}</td>
                            <td>{{ $detail->ukuran }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Tidak ada komposisi bahan baku yang tercatat.</td>
                        </tr>
                    @endforelse
                    
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;">Total Ukuran</td>
                        <td>{{ $totalUkuran }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="ttd-section">
            <div class="ttd-box">
                <pre>
<strong>Hormat Kami,</strong>
<img src="{{ asset('images/ttds.png') }}" alt="Tanda Tangan" class="ttd-img">
<strong>Wanto</strong>
                </pre>
                
                <img src="{{ asset('images/stempel.png') }}" alt="Stempel" class="stempel-img">
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>