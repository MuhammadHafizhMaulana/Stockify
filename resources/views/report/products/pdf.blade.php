<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keluar-Masuk Produk</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <h1>Laporan Keluar-Masuk Produk</h1>
    <p>Periode: {{ $data['periode'][0] }} s/d {{ $data['periode'][1] }}</p>

    {{-- Ringkasan --}}
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Total Masuk</th>
                <th>Total Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['summary'] as $row)
                <tr>
                    <td>{{ $row->product->name }}</td>
                    <td align="center">{{ $row->total_masuk }}</td>
                    <td align="center">{{ $row->total_keluar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Detail transaksi --}}
    <h3>Detail Transaksi</h3>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Qty</th>
                <th>Status</th>
                <th>User Inputor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['details'] as $trx)
                <tr>
                    <td>{{ $trx->updated_at }}</td>
                    <td>{{ ucwords($trx->product->name) }}</td>
                    <td>{{ ucfirst($trx->type) }}</td>
                    <td align="center">{{ $trx->quantity }}</td>
                    <td align="center">{{ ucfirst($trx->status) }}</td>
                    <td>{{ ucwords($trx->user->name) }}/{{ $trx->user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
