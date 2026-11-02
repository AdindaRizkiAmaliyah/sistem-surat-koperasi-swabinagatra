
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - SIRKA</title>

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
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        h1 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #718096;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #176b50;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .button {
            padding: 12px 18px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
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

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">

            <h1>Tambah Pengguna</h1>
            <p class="subtitle">
                Masukkan informasi pengguna baru untuk sistem SIRKA.
            </p>

            @if ($errors->any())
                <div class="alert">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul style="margin-left: 20px; margin-top: 8px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        required
                    >
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Jabatan / Role</label>
                    <select id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>

                        <option value="admin" @selected(old('role') == 'admin')>
                            Admin
                        </option>

                        <option value="sekretaris" @selected(old('role') == 'sekretaris')>
                            Sekretaris
                        </option>

                        <option value="ketua" @selected(old('role') == 'ketua')>
                            Ketua
                        </option>

                        <option value="bendahara" @selected(old('role') == 'bendahara')>
                            Bendahara
                        </option>

                        <option value="staff" @selected(old('role') == 'staff')>
                            Staff
                        </option>
                    </select>
                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department_id">Departemen</label>
                    <select id="department_id" name="department_id">
                        <option value="">-- Tidak ada departemen --</option>

                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                @selected(old('department_id') == $department->id)
                            >
                                {{ $department->department_code }} - {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="button-primary">
                        Simpan Pengguna
                    </button>

                    <a href="{{ route('users.index') }}" class="button-secondary">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
