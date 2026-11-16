
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Disposisi - SIRKA</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 850px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
        }

        h2 { margin-top: 0; color: #1f2937; }

        .description { color: #6b7280; margin-bottom: 25px; }

        .section-title {
            margin-top: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 15px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .label { font-weight: bold; color: #374151; }

        .value { color: #4b5563; overflow-wrap: anywhere; }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .status-form {
            margin-top: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }

        select {
            width: 100%;
            padding: 11px;
            margin: 10px 0 15px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .save-button {
            background: #2563eb;
            color: white;
        }

        .back-button {
            background: #e5e7eb;
            color: #333;
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .container { padding: 20px; }
            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Detail Disposisi</h2>

    <p class="description">
        Informasi lengkap disposisi surat yang tersimpan dalam SIRKA.
    </p>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="section-title">Informasi Surat</h3>

    <div class="detail-row">
        <div class="label">Nomor Agenda</div>
        <div class="value">
            {{ $disposition->incomingLetter?->agenda_number ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Nomor Surat</div>
        <div class="value">
            {{ $disposition->incomingLetter?->letter_number ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Perihal</div>
        <div class="value">
            {{ $disposition->incomingLetter?->subject ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Pengirim Surat</div>
        <div class="value">
            {{ $disposition->incomingLetter?->sender ?? '-' }}
        </div>
    </div>

    <h3 class="section-title">Informasi Disposisi</h3>

    <div class="detail-row">
        <div class="label">Dari</div>
        <div class="value">
            {{ $disposition->sender?->name ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Tujuan</div>
        <div class="value">
            {{ $disposition->recipient?->name
                ?? $disposition->department?->department_name
                ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Instruksi</div>
        <div class="value">
            {{ $disposition->instruction ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Catatan</div>
        <div class="value">
            {{ $disposition->notes ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Batas Waktu</div>
        <div class="value">
            {{ $disposition->deadline?->format('d-m-Y') ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Status Saat Ini</div>
        <div class="value">
            {{ ucfirst($disposition->status) }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Tanggal Selesai</div>
        <div class="value">
            {{ $disposition->completed_at?->format('d-m-Y H:i') ?? '-' }}
        </div>
    </div>

    <h3 class="section-title">Perbarui Status Disposisi</h3>

    <form
        action="{{ route('dispositions.update-status', $disposition->id) }}"
        method="POST"
        class="status-form"
    >
        @csrf
        @method('PATCH')

        <label for="status"><strong>Status Disposisi</strong></label>

        <select name="status" id="status" required>
            <option value="pending"
                {{ $disposition->status === 'pending' ? 'selected' : '' }}>
                Menunggu
            </option>

            <option value="processing"
                {{ $disposition->status === 'processing' ? 'selected' : '' }}>
                Diproses
            </option>

            <option value="completed"
                {{ $disposition->status === 'completed' ? 'selected' : '' }}>
                Selesai
            </option>
        </select>

        @error('status')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <button type="submit" class="button save-button">
            Simpan Perubahan Status
        </button>
    </form>

    <a
        href="{{ route('incoming-letters.show', $disposition->incoming_letter_id) }}"
        class="button back-button"
    >
        Kembali ke Detail Surat
    </a>

</div>
</body>
</html>
