<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aktivitas User</title>
    <style>
        /* ======== Global ======== */
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        h4 {
            font-size: 13px;
            color: #555;
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        /* ======== Table ======== */
        .table-container {
            width: 95%;
            margin: 0 auto;
            border: 1px solid #999;
            border-radius: 6px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead {
            background-color: #f3f4f6;
        }

        thead th {
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            padding: 8px 6px;
            border-bottom: 1px solid #999;
            text-align: left;
        }

        tbody td {
            padding: 8px 6px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #777;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>Log Aktivitas User</h1>
    <h4>{{ $data['periode'][0] }} – {{ $data['periode'][1] ?? $data['periode'][0] }}</h4>
    <h4>{{ $user->name }} / {{ $user->role }}</h4>


    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:18%;">Waktu</th>
                    <th style="width:15%;">Aksi</th>
                    <th style="width:37%;">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['details'] as $index => $log)
                    <tr>
                        <td class="text-center">
                            {{ $data['details']->firstItem() + $index }}
                        </td>
                        <td>
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada log aktivitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
