
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - SIRKA</title>

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
            max-width: 1200px;
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

        .header h1 {
            font-size: 26px;
            margin-bottom: 6px;
        }

        .header p {
            color: #718096;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
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

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
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
            background: #e2e8f0;
            color: #334155;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .button-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .button-status {
            background: #f1f5f9;
            color: #334155;
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
                <h1>Manajemen Pengguna</h1>
                <p>Kelola akun pengguna Sistem Informasi Surat Koperasi (SIRKA).</p>
            </div>

            <a href="{{ route('users.create') }}" class="button button-primary">
                + Tambah Pengguna
            </a>
        </div>

        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Departemen</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->department?->department_name ?? '-' }}</td>
                            <td>
                                <span class="badge">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if ($user->is_active)
                                    <span class="badge active">Aktif</span>
                                @else
                                    <span class="badge inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="button button-edit">
                                        Edit
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.toggle-status', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin mengubah status pengguna ini?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="button button-status">
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('dashboard') }}" class="button button-secondary">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</body>
</html>
