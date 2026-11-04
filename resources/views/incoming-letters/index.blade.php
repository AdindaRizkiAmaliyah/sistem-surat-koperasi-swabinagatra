
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk - SIRKA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #263238;
        }

        .container {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #718096;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .button-primary {
            background: #176b50;
            color: white;
        }

        .button-primary:hover {
            background: #10543e;
        }

        .button-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .button-secondary:hover {
            background: #cbd5e1;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            overflow-x: auto;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
        }

        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #edf0f2;
            font-size: 14px;
        }

        th {
            color: #64748b;
            background: #f8fafc;
            font-weight: 600;
        }

        td {
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            background: #e2e8f0;
            color: #334155;
        }

        .status-registered {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .empty {
            text-align: center;
            color: #718096;
            padding: 30px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 650px) {
            .header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="header">
            <div>
                <h1>Surat Masuk</h1>
                <p class="subtitle">
                    Daftar surat yang diterima Koperasi Karyawan Swabina Gatra.
                </p>
            </div>

            <a href="{{ route('incoming-letters.create') }}"
               class="button button-primary">
                + Tambah Surat Masuk
            </a>
        </div>

        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Agenda</th>
                        <th>No. Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Tanggal Diterima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($letters as $letter)
                        <tr>
                            <td>{{ $letters->firstItem() + $loop->index }}</td>

                            <td>{{ $letter->agenda_number }}</td>

                            <td>{{ $letter->letter_number ?? '-' }}</td>

                            <td>{{ $letter->sender }}</td>

                            <td>{{ $letter->subject }}</td>

                            <td>
                                {{ $letter->category?->category_name ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="badge status-registered">
                                    {{ ucfirst($letter->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('incoming-letters.show', $letter->id) }}"
                                   class="button button-secondary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty">
                                Belum ada surat masuk yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $letters->links() }}
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('dashboard') }}"
               class="button button-secondary">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</body>
</html>
