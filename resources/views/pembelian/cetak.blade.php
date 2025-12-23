<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul disesuaikan untuk Pembelian --}}
    <title>Nota Pembelian {{ $pembelian->nopembelian }}</title> 
    <style>
        /* CSS styling dari PHP native Anda dipertahankan */
        h1, h2 { text-align: center; }
        .transaction-details { margin-bottom: 20px; }
        .medicine-list table { width: 100%; border-collapse: collapse; }
        .medicine-list th, .medicine-list td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        .total-amount { text-align: right; margin-top: 20px; }
        p { margin: 0; }
        strong { font-weight: bold; }
        .kanan { margin-left: auto; }
        .kanann { margin-left: 150px; }
        .kanan2 { margin-left: 80px; }
        /* Style untuk Print */
        @media print {
            body { background-color: #fff; }
            .no-print { display: none; }
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f1f1f1;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        
        {{-- Header Bon/Nota (Konten dipertahankan sesuai Penjualan, hanya judul yang disesuaikan) --}}
        <div style=" display: flex; align-items: center;">
            <div>
                <p style="text-align: center; font-size: 0.7rem; width: 310px;">
                    <img src="{{ asset('images/coba1.png') }}" alt="" style="width: 300px; height: auto;"><br>
                    <strong>SERVICE KNALPOT PURBALINGGA, SERVICE, GANTI KNALPOT <br>
                        REPARASI SERVICE KNALPOT MOBIL,MOTOR, DLL <br>
                        JL. H. Naman NO.28, PONDOK KELAPA, JAKARTA-TIMUR <br>
                        HP. 081399135032
                    </strong>
                </p>
                <div style="text-align:start;">
                    <strong style="font-size:large;">
                        {{-- NO. Disesuaikan --}}
                        BILL OF MATERIAL No. {{ $pembelian->nopembelian }} 
                    </strong>
                </div>
            </div>
            <div style="margin-left:auto; text-align: center; font-weight:bold; font-size:medium;">
                <pre>
Jakarta,    {{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d/m/Y') }}

{{-- Relasi disesuaikan ke Supplier --}}
Dari Yth,
{{ $pembelian->supplier->nama ?? 'Supplier Dihapus' }}

Pegawai: {{ $pembelian->pegawai->namapegawai ?? 'Pegawai Dihapus' }}

<hr style="height:1px;background-color: #000;">
                </pre>
            </div>
        </div>

        {{-- Detail Item Pembelian --}}
        <div class="medicine-list">
            <table>
                <thead>
                    <tr>
                        <th>Banyaknya</th>
                        <th>Nama Bahan Baku</th> {{-- Disesuaikan ke Bahan Baku --}}
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rowCount = 0;
                        $grandTotal = 0;
                    @endphp
                    @foreach ($pembelian->detail as $detail) {{-- Menggunakan $pembelian->detail --}}
                        <tr>
                            {{-- Menggunakan 'banyaknya' --}}
                            <td>{{ $detail->banyaknya }}</td> 
                            {{-- Menggunakan relasi bahanBaku dan jenis --}}
                            <td style="text-align: start;">{{ $detail->bahanBaku->jenis ?? 'Bahan Baku Dihapus' }}</td> 
                            {{-- Mengambil harga dari relasi bahanBaku --}}
                            <td>{{ number_format($detail->bahanBaku->harga ?? 0, 0, ',', '.') }}</td> 
                            <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $rowCount++;
                            $grandTotal += $detail->total;
                        @endphp
                    @endforeach

                    {{-- Menambahkan baris kosong jika kurang dari 11 baris --}}
                    @for ($i = $rowCount; $i < 11; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Jumlah Rp.</strong></td>
                        <td>{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        {{-- Tanda Tangan --}}
        <div style="display: flex; justify-content: flex-end;">
            <div style="position: relative; display: inline-block; text-align: center;">
                <pre style="margin: 0;">
            
<strong>Penerima,</strong> {{-- Disesuaikan untuk Pembelian --}}
<img src="{{ asset('images/ttds.png') }}" alt="" style="width: 90px; height: auto;">
<strong>Wanto</strong>
                </pre>
                {{-- Watermark Stempel --}}
                <div style="position: absolute; top: 50px; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); opacity: 0.4;">
                    <img src="{{ asset('images/stempel.png') }}" alt="" style="width: 90px; height: auto;">
                </div>
            </div>
        </div>
    </div>
    <script>
        // Menggunakan JavaScript untuk memicu print saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>