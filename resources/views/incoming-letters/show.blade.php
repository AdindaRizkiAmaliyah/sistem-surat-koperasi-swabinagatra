
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Masuk - SIRKA</title>

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

        h2 {
            margin-top: 0;
            color: #1f2937;
        }

        .description {
            color: #6b7280;
            margin-bottom: 25px;
        }

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

        .attachment,
        .disposition-item {
            padding: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 15px;
        }

        .attachment-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
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

        .disposition-button {
            background: #2563eb;
            color: white;
            margin-top: 10px;
        }

        .empty {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            color: #6b7280;
            margin-top: 15px;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .disposition-item p {
            margin: 8px 0;
            line-height: 1.5;
        }

        .status {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 5px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .attachment-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <h2>Detail Surat Masuk</h2>

        <p class="description">
            Informasi lengkap surat masuk yang tersimpan dalam SIRKA.
        </p>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- INFORMASI SURAT -->
        <h3 class="section-title">Informasi Surat</h3>

        <div class="detail-row">
            <div class="label">Nomor Agenda</div>
            <div class="value">{{ $incomingLetter->agenda_number }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Nomor Surat</div>
            <div class="value">{{ $incomingLetter->letter_number ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Kategori</div>
            <div class="value">
                {{ $incomingLetter->category?->category_name ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="label">Pengirim</div>
            <div class="value">{{ $incomingLetter->sender }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Perihal</div>
            <div class="value">{{ $incomingLetter->subject }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Tanggal Surat</div>
            <div class="value">
                {{ $incomingLetter->letter_date?->format('d-m-Y') ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="label">Tanggal Diterima</div>
            <div class="value">
                {{ $incomingLetter->received_date?->format('d-m-Y') ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="label">Tujuan Surat</div>
            <div class="value">{{ $incomingLetter->destination ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Ringkasan</div>
            <div class="value">{{ $incomingLetter->summary ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Status</div>
            <div class="value">{{ $incomingLetter->status }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Dicatat Oleh</div>
            <div class="value">{{ $incomingLetter->creator?->name ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Catatan</div>
            <div class="value">{{ $incomingLetter->notes ?? '-' }}</div>
        </div>


        <!-- ARSIP DIGITAL SURAT -->
        <h3 class="section-title">Arsip Digital Surat</h3>

        @if ($incomingLetter->attachments->isNotEmpty())

            @foreach ($incomingLetter->attachments as $attachment)

                <div class="attachment">

                    <strong>{{ $attachment->original_name }}</strong>

                    <p>
                        Ukuran:
                        {{ number_format($attachment->file_size / 1024, 2) }} KB
                    </p>

                    <div class="attachment-actions">

                        <a
                            href="{{ route('incoming-letters.attachments.view', [
                                'incomingLetter' => $incomingLetter->id,
                                'attachment' => $attachment->id
                            ]) }}"
                            target="_blank"
                            class="button view-button"
                        >
                            Lihat PDF
                        </a>

                        <a
                            href="{{ route('incoming-letters.attachments.download', [
                                'incomingLetter' => $incomingLetter->id,
                                'attachment' => $attachment->id
                            ]) }}"
                            class="button download-button"
                        >
                            Unduh PDF
                        </a>

                    </div>
                </div>

            @endforeach

        @else

            <div class="empty">
                Belum ada arsip PDF untuk surat ini.
            </div>

        @endif


        <!-- RIWAYAT DISPOSISI -->
        <h3 class="section-title">Riwayat Disposisi</h3>

        <a
            href="{{ route('dispositions.create', $incomingLetter->id) }}"
            class="button disposition-button"
        >
            + Buat Disposisi
        </a>

        @forelse ($incomingLetter->dispositions as $disposition)

            <div class="disposition-item">

                <p>
                    <strong>Tujuan:</strong>

                    @if ($disposition->department)
                        {{ $disposition->department->department_name }}
                    @elseif ($disposition->recipient)
                        {{ $disposition->recipient->name }}
                    @else
                        Tujuan tidak tersedia
                    @endif
                </p>

                <p>
                    <strong>Dari:</strong>
                    {{ $disposition->sender?->name ?? '-' }}
                </p>

                <p>
                    <strong>Instruksi:</strong>
                    {{ $disposition->instruction }}
                </p>

                <p>
                    <strong>Catatan:</strong>
                    {{ $disposition->notes ?? '-' }}
                </p>

                <p>
                    <strong>Batas Waktu:</strong>
                    {{ $disposition->deadline?->format('d-m-Y') ?? '-' }}
                </p>

                <p>
                    <strong>Status:</strong>
                    <span class="status">
                        {{ ucfirst($disposition->status) }}
                    </span>
                </p>

            </div>

        @empty

            <div class="empty">
                Belum ada disposisi untuk surat ini.
            </div>

        @endforelse


        <!-- TOMBOL KEMBALI -->
        <a
            href="{{ route('incoming-letters.index') }}"
            class="button back-button"
        >
            Kembali ke Daftar Surat
        </a>

    </div>
</body>
</html>
