
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
            max-width: 1350px;
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

        .button-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 17px;
            margin-bottom: 18px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
            color: #475569;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 13px;
            background: white;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 18px;
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

        .card-table {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
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

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
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

        @media (max-width: 900px) {
            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .filter-grid {
                grid-template-columns: 1fr;
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

        @if ($errors->any())
            <div class="alert" style="background:#fee2e2;color:#991b1b;">
                Periksa kembali filter yang kamu masukkan.
            </div>
        @endif

        <!-- Form pencarian dan filter -->
        <div class="card">
            <h2 class="filter-title">Pencarian dan Filter Surat</h2>

            <form action="{{ route('incoming-letters.index') }}" method="GET">

                <div class="filter-grid">
                    <div class="form-group">
                        <label for="search">Kata Kunci</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            placeholder="No. agenda, pengirim, perihal..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="category_id">Kategori Surat</label>
                        <select id="category_id" name="category_id">
                            <option value="">Semua Kategori</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Awal Diterima</label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir Diterima</label>
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                        >
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="button button-primary">
                        Cari
                    </button>

                    <a href="{{ route('incoming-letters.index') }}"
                       class="button button-secondary">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <!-- Tabel surat masuk -->
        <div class="card card-table">
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
                            <td>{{ $letter->category?->category_name ?? '-' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}
                            </td>
                            <td>
                                <span class="badge">
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
                                Tidak ada surat masuk yang sesuai dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $letters->links() }}
            </div>
        </div>

        <div>
            <a href="{{ route('dashboard') }}"
               class="button button-secondary">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</body>
</html>
