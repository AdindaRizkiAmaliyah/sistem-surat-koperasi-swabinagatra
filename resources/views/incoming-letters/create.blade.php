<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Masuk - SIRKA</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        .required {
            color: red;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .back-button {
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
        }

        .back-button {
            background: #e5e7eb;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Surat Masuk</h2>
        <p>Masukkan informasi surat masuk ke dalam sistem.</p>

        @if ($errors->any())
            <div style="background: #fee2e2; padding: 12px; margin-bottom: 20px;">
                <strong>Periksa kembali data yang kamu masukkan.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('incoming-letters.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nomor Agenda <span class="required">*</span></label>
                <input
                    type="text"
                    name="agenda_number"
                    value="{{ old('agenda_number') }}"
                    placeholder="Contoh: SM-001/2026"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nomor Surat</label>
                <input
                    type="text"
                    name="letter_number"
                    value="{{ old('letter_number') }}"
                    placeholder="Masukkan nomor surat"
                >
            </div>

            <div class="form-group">
                <label>Kategori Surat</label>
                <select name="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Pengirim <span class="required">*</span></label>
                <input
                    type="text"
                    name="sender"
                    value="{{ old('sender') }}"
                    placeholder="Nama instansi atau pengirim"
                    required
                >
            </div>

            <div class="form-group">
                <label>Perihal <span class="required">*</span></label>
                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Perihal surat"
                    required
                >
            </div>

            <div class="form-group">
                <label>Tanggal Surat</label>
                <input
                    type="date"
                    name="letter_date"
                    value="{{ old('letter_date') }}"
                >
            </div>

            <div class="form-group">
                <label>Tanggal Diterima <span class="required">*</span></label>
                <input
                    type="date"
                    name="received_date"
                    value="{{ old('received_date') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Tujuan Surat</label>
                <input
                    type="text"
                    name="destination"
                    value="{{ old('destination') }}"
                    placeholder="Surat ditujukan kepada siapa atau bagian apa?"
                >
            </div>

            <div class="form-group">
                <label>Ringkasan Surat</label>
                <textarea
                    name="summary"
                    rows="4"
                    placeholder="Tuliskan ringkasan isi surat"
                >{{ old('summary') }}</textarea>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea
                    name="notes"
                    rows="3"
                    placeholder="Catatan tambahan jika ada"
                >{{ old('notes') }}</textarea>
            </div>

            <div class="buttons">
                <button type="submit">Simpan Surat</button>
                <a href="{{ route('incoming-letters.index') }}" class="back-button">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>