
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Disposisi - SIRKA</title>

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
            max-width: 850px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
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

        .letter-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 25px;
            font-size: 14px;
            line-height: 1.8;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .required {
            color: #dc2626;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .help {
            display: block;
            color: #718096;
            font-size: 12px;
            margin-top: 6px;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 6px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .primary {
            background: #176b50;
            color: white;
        }

        .secondary {
            background: #e2e8f0;
            color: #334155;
        }

        @media (max-width: 600px) {
            .actions {
                flex-direction: column;
            }

            .button {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">

            <h1>Buat Disposisi Surat</h1>
            <p class="subtitle">
                Isi arahan dan tentukan tujuan tindak lanjut surat masuk.
            </p>

            <div class="letter-info">
                <strong>Informasi Surat Masuk</strong><br>
                Nomor Agenda: {{ $incomingLetter->agenda_number }}<br>
                Nomor Surat: {{ $incomingLetter->letter_number ?? '-' }}<br>
                Pengirim: {{ $incomingLetter->sender }}<br>
                Perihal: {{ $incomingLetter->subject }}
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('dispositions.store', $incomingLetter->id) }}"
                method="POST"
            >
                @csrf

                <div class="form-group">
                    <label for="to_department_id">Tujuan Departemen</label>

                    <select name="to_department_id" id="to_department_id">
                        <option value="">Pilih Departemen</option>

                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                {{ old('to_department_id') == $department->id ? 'selected' : '' }}
                            >
                                {{ $department->department_code }} -
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>

                    <small class="help">
                        Pilih departemen jika surat ditujukan kepada satu bagian.
                    </small>
                </div>

                <div class="form-group">
                    <label for="to_user_id">Atau Tujuan Pengguna</label>

                    <select name="to_user_id" id="to_user_id">
                        <option value="">Pilih Pengguna</option>

                        @foreach ($users as $user)
                            <option
                                value="{{ $user->id }}"
                                {{ old('to_user_id') == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->name }}
                                ({{ ucfirst($user->role) }})
                            </option>
                        @endforeach
                    </select>

                    <small class="help">
                        Pilih pengguna jika surat ditujukan kepada orang tertentu.
                        Pilih salah satu tujuan saja.
                    </small>
                </div>

                <div class="form-group">
                    <label for="instruction">
                        Instruksi Disposisi <span class="required">*</span>
                    </label>

                    <textarea
                        name="instruction"
                        id="instruction"
                        required
                        placeholder="Tuliskan arahan atau instruksi tindak lanjut surat..."
                    >{{ old('instruction') }}</textarea>

                    @error('instruction')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Tambahan</label>

                    <textarea
                        name="notes"
                        id="notes"
                        placeholder="Catatan tambahan jika diperlukan..."
                    >{{ old('notes') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="deadline">Batas Waktu Tindak Lanjut</label>

                    <input
                        type="date"
                        name="deadline"
                        id="deadline"
                        value="{{ old('deadline') }}"
                    >

                    <small class="help">
                        Boleh dikosongkan jika tidak ada batas waktu.
                    </small>
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">
                        Simpan Disposisi
                    </button>

                    <a
                        href="{{ route('incoming-letters.show', $incomingLetter->id) }}"
                        class="button secondary"
                    >
                        Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
