
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar - SIRKA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0 0 8px;
            color: #1f2937;
            font-size: 26px;
        }

        .description {
            color: #6b7280;
            margin: 0;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .primary-button {
            background: #2563eb;
            color: white;
        }

        .secondary-button {
            background: #e5e7eb;
            color: #333;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            align-items: end;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 7px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            color: #374151;
        }

        td {
            color: #4b5563;
        }

        .detail-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
        }

        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .status-sent {
            background: #dcfce7;
            color: #166534;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #6b7280;
        }

        .success-message {
            padding: 13px 15px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 800px) {
            body {
                padding: 15px;
            }

            .filter-form {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .filter-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h1>Surat Keluar</h1>
            <p class="description">
                Daftar dan pengelolaan arsip surat keluar koperasi.
            </p>
        </div>

        <a href="{{ route('outgoing-letters.create') }}"
           class="button primary-button">
            + Tambah Surat Keluar
        </a>
    </div>

    <!-- PESAN SUKSES -->
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTER DAN PENCARIAN -->
    <div class="card">
        <form action="{{ route('outgoing-letters.index') }}"
              method="GET"
              class="filter-form">

            <div class="form-group">
                <label for="search">Cari Surat</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    placeholder="Nomor, penerima, atau perihal"
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id">
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
                <label for="department_id">Departemen</label>
                <select name="department_id" id="department_id">
                    <option value="">Semua Departemen</option>

                    @foreach ($departments as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ request('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai</label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    value="{{ request('start_date') }}"
                >
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai</label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    value="{{ request('end_date') }}"
                >
            </div>

            <div class="filter-actions">
                <button type="submit" class="button primary-button">
                    Cari
                </button>

                <a href="{{ route('outgoing-letters.index') }}"
                   class="button secondary-button">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- TABEL SURAT KELUAR -->
    <div class="card">
        <h3>Daftar Surat Keluar</h3>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Surat</th>
                        <th>Penerima</th>
                        <th>Perihal</th>
                        <th>Departemen</th>
                        <th>Tanggal Dikirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($outgoingLetters as $letter)
                        <tr>
                            <td>
                                {{ $outgoingLetters->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $letter->letter_number }}</td>

                            <td>{{ $letter->recipient }}</td>

                            <td>{{ $letter->subject }}</td>

                            <td>
                                {{ $letter->department?->department_name ?? '-' }}
                            </td>

                            <td>
                                {{ $letter->sent_date?->format('d-m-Y') ?? '-' }}
                            </td>

                            <td>
                                @if ($letter->status === 'sent')
                                    <span class="status status-sent">
                                        Terkirim
                                    </span>
                                @else
                                    <span class="status status-draft">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('outgoing-letters.show', $letter->id) }}"
                                    class="detail-link"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada data surat keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $outgoingLetters->links() }}
        </div>
    </div>

    <a href="{{ route('dashboard') }}"
       class="button secondary-button">
        Kembali ke Dashboard
    </a>

</div>
</body>
</html>
