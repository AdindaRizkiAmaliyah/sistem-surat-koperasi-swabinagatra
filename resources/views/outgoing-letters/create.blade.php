
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Keluar - SIRKA</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        h1 { color: #1f2937; margin-top: 0; }

        .description {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .required { color: #dc2626; }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
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

        .help-text {
            color: #6b7280;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .card { padding: 20px; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="card">
        <h1>Tambah Surat Keluar</h1>

        <p class="description">
            Masukkan informasi surat keluar yang akan dicatat ke dalam SIRKA.
        </p>

        <form action="{{ route('outgoing-letters.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="letter_number">
                    Nomor Surat <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="letter_number"
                    id="letter_number"
                    value="{{ old('letter_number') }}"
                    required
                >

                @error('letter_number')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Kategori Surat</label>

                <select name="category_id" id="category_id">
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

                @error('category_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="department_id">Departemen</label>

                <select name="department_id" id="department_id">
                    <option value="">-- Pilih Departemen --</option>

                    @foreach ($departments as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>

                @error('department_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="recipient">
                    Penerima Surat <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="recipient"
                    id="recipient"
                    value="{{ old('recipient') }}"
                    placeholder="Nama instansi atau penerima"
                    required
                >

                @error('recipient')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">
                    Perihal <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="subject"
                    id="subject"
                    value="{{ old('subject') }}"
                    required
                >

                @error('subject')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="letter_date">Tanggal Surat</label>

                <input
                    type="date"
                    name="letter_date"
                    id="letter_date"
                    value="{{ old('letter_date') }}"
                >

                @error('letter_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sent_date">Tanggal Dikirim</label>

                <input
                    type="date"
                    name="sent_date"
                    id="sent_date"
                    value="{{ old('sent_date') }}"
                >

                @error('sent_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="summary">Ringkasan Surat</label>

                <textarea
                    name="summary"
                    id="summary"
                    placeholder="Masukkan ringkasan isi surat..."
                >{{ old('summary') }}</textarea>

                @error('summary')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">
                    Status <span class="required">*</span>
                </label>

                <select name="status" id="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                    <option value="sent" {{ old('status') === 'sent' ? 'selected' : '' }}>
                        Terkirim
                    </option>
                </select>

                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Catatan</label>

                <textarea
                    name="notes"
                    id="notes"
                    placeholder="Catatan tambahan (opsional)"
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="attachment">Arsip Digital (PDF)</label>

                <input
                    type="file"
                    name="attachment"
                    id="attachment"
                    accept=".pdf,application/pdf"
                >

                <p class="help-text">
                    Format PDF, maksimal ukuran file 5 MB. Pengunggahan bersifat opsional.
                </p>

                @error('attachment')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="button primary-button">
                    Simpan Surat
                </button>

                <a
                    href="{{ route('outgoing-letters.index') }}"
                    class="button secondary-button"
                >
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
</body>
</html>
