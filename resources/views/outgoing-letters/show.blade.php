
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Keluar - SIRKA</title>

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

        h2 { color: #1f2937; margin-top: 0; }

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

        .label {
            font-weight: bold;
            color: #374151;
        }

        .value {
            color: #4b5563;
            overflow-wrap: anywhere;
        }

        .attachment {
            padding: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 15px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            margin: 5px 5px 5px 0;
        }

        .view-button {
            background: #2563eb;
            color: white;
        }

        .download-button {
            background: #059669;
            color: white;
        }

        .back-button {
            background: #e5e7eb;
            color: #333;
            margin-top: 25px;
        }

        .empty {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            color: #6b7280;
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

    <h2>Detail Surat Keluar</h2>

    <p style="color: #6b7280;">
        Informasi lengkap surat keluar yang tersimpan dalam SIRKA.
    </p>

    <h3 class="section-title">Informasi Surat</h3>

    <div class="detail-row">
        <div class="label">Nomor Surat</div>
        <div class="value">{{ $outgoingLetter->letter_number }}</div>
    </div>

    <div class="detail-row">
        <div class="label">Kategori</div>
        <div class="value">
            {{ $outgoingLetter->category?->category_name ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Departemen</div>
        <div class="value">
            {{ $outgoingLetter->department?->department_name ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Penerima</div>
        <div class="value">{{ $outgoingLetter->recipient }}</div>
    </div>

    <div class="detail-row">
        <div class="label">Perihal</div>
        <div class="value">{{ $outgoingLetter->subject }}</div>
    </div>

    <div class="detail-row">
        <div class="label">Tanggal Surat</div>
        <div class="value">
            {{ $outgoingLetter->letter_date?->format('d-m-Y') ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Tanggal Dikirim</div>
        <div class="value">
            {{ $outgoingLetter->sent_date?->format('d-m-Y') ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Ringkasan</div>
        <div class="value">{{ $outgoingLetter->summary ?? '-' }}</div>
    </div>

    <div class="detail-row">
        <div class="label">Status</div>
        <div class="value">{{ ucfirst($outgoingLetter->status) }}</div>
    </div>

    <div class="detail-row">
        <div class="label">Dicatat Oleh</div>
        <div class="value">
            {{ $outgoingLetter->creator?->name ?? '-' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="label">Catatan</div>
        <div class="value">{{ $outgoingLetter->notes ?? '-' }}</div>
    </div>


    <h3 class="section-title">Arsip Digital Surat</h3>

    @if ($outgoingLetter->attachments->isNotEmpty())

        @foreach ($outgoingLetter->attachments as $attachment)

            <div class="attachment">

                <strong>{{ $attachment->original_name }}</strong>

                <p>
                    Ukuran:
                    {{ number_format($attachment->file_size / 1024, 2) }} KB
                </p>

                <a
                    href="{{ route('outgoing-letters.attachments.view', [
                        'outgoingLetter' => $outgoingLetter->id,
                        'attachment' => $attachment->id
                    ]) }}"
                    target="_blank"
                    class="button view-button"
                >
                    Lihat PDF
                </a>

                <a
                    href="{{ route('outgoing-letters.attachments.download', [
                        'outgoingLetter' => $outgoingLetter->id,
                        'attachment' => $attachment->id
                    ]) }}"
                    class="button download-button"
                >
                    Unduh PDF
                </a>

            </div>

        @endforeach

    @else

        <div class="empty">
            Belum ada arsip PDF untuk surat ini.
        </div>

    @endif

    <a
        href="{{ route('outgoing-letters.index') }}"
        class="button back-button"
    >
        Kembali ke Daftar Surat
    </a>

</div>
</body>
</html>
