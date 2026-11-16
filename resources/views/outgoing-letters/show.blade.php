
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Keluar - SIRKA</title>

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
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: #1f2937;
            font-size: 26px;
        }

        .description {
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card h3 {
            margin: 0 0 18px;
            color: #1f2937;
            font-size: 18px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-family: Arial, sans-serif;
            margin: 4px 5px 4px 0;
        }

        .primary-button {
            background: #2563eb;
            color: white;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .secondary-button {
            background: #e5e7eb;
            color: #333;
        }

        .secondary-button:hover {
            background: #d1d5db;
        }

        .download-button {
            background: #059669;
            color: white;
        }

        .download-button:hover {
            background: #047857;
        }

        .publish-button {
            background: #174b35;
            color: white;
        }

        .publish-button:hover {
            background: #103d2a;
        }

        .revoke-button {
            background: #dc2626;
            color: white;
        }

        .revoke-button:hover {
            background: #b91c1c;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-heading h3 {
            margin: 0;
            color: #1f2937;
            font-size: 18px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 30px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 145px minmax(0, 1fr);
            gap: 12px;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
            min-width: 0;
        }

        .detail-row.full {
            grid-column: 1 / -1;
        }

        .label {
            font-weight: bold;
            color: #374151;
            font-size: 14px;
        }

        .value {
            color: #4b5563;
            font-size: 14px;
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .status-sent {
            background: #dcfce7;
            color: #166534;
        }

        .status-public {
            background: #e6f5ec;
            color: #187344;
        }

        .status-private {
            background: #fef3c7;
            color: #92400e;
        }

        .status-revoked {
            background: #fee2e2;
            color: #991b1b;
        }

        .attachment {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #fff;
        }

        .attachment:last-child {
            margin-bottom: 0;
        }

        .attachment-title {
            font-size: 15px;
            color: #1f2937;
            font-weight: bold;
            overflow-wrap: anywhere;
            margin-bottom: 8px;
        }

        .help-text {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
            margin: 7px 0 12px;
        }

        .public-info {
            background: #f0f7f3;
            border: 1px solid #d4e8da;
            padding: 16px;
            border-radius: 7px;
            margin: 15px 0;
        }

        .public-info p {
            margin: 7px 0;
            font-size: 13px;
            color: #374151;
        }

        .public-url {
            display: block;
            padding: 11px;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            color: #174b35;
            overflow-wrap: anywhere;
            margin: 8px 0;
            font-size: 13px;
            text-decoration: none;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 14px;
        }

        .empty {
            text-align: center;
            padding: 30px 20px;
            color: #6b7280;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        .attachment-divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }

        .publication-title {
            font-size: 14px;
            color: #1f2937;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .header-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        @media (max-width: 800px) {
            body {
                padding: 15px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-row.full {
                grid-column: auto;
            }
        }

        @media (max-width: 500px) {
            .header {
                align-items: flex-start;
            }

            h1 {
                font-size: 23px;
            }

            .card {
                padding: 17px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .header-actions {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h1>Detail Surat Keluar</h1>
            <p class="description">
                Informasi lengkap dan arsip digital surat keluar koperasi.
            </p>
        </div>

        <div class="header-actions">
            <a href="{{ route('dashboard') }}"
               class="button secondary-button">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- PESAN SUKSES -->
    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- INFORMASI SURAT -->
    <div class="card">

        <div class="section-heading">
            <h3>Informasi Surat</h3>

            @if ($outgoingLetter->status === 'sent')
                <span class="status status-sent">Terkirim</span>
            @else
                <span class="status status-draft">Draft</span>
            @endif
        </div>

        <div class="detail-grid">

            <div class="detail-row">
                <div class="label">Nomor Surat</div>
                <div class="value">
                    {{ $outgoingLetter->letter_number ?? '-' }}
                </div>
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
                <div class="value">
                    {{ $outgoingLetter->recipient ?? '-' }}
                </div>
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

            <div class="detail-row full">
                <div class="label">Perihal</div>
                <div class="value">
                    {{ $outgoingLetter->subject ?? '-' }}
                </div>
            </div>

            <div class="detail-row full">
                <div class="label">Ringkasan</div>
                <div class="value">
                    {{ $outgoingLetter->summary ?: '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Dicatat Oleh</div>
                <div class="value">
                    {{ $outgoingLetter->creator?->name ?? '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Status</div>
                <div class="value">
                    {{ ucfirst($outgoingLetter->status ?? '-') }}
                </div>
            </div>

            <div class="detail-row full">
                <div class="label">Catatan</div>
                <div class="value">
                    {{ $outgoingLetter->notes ?: '-' }}
                </div>
            </div>

        </div>
    </div>

    <!-- ARSIP DIGITAL -->
    <div class="card">

        <div class="section-heading">
            <h3>Arsip Digital Surat</h3>
        </div>

        @if ($outgoingLetter->attachments->isNotEmpty())

            @foreach ($outgoingLetter->attachments as $attachment)

                <div class="attachment">

                    <div class="attachment-title">
                        {{ $attachment->original_name }}
                    </div>

                    <p class="help-text">
                        Ukuran file:
                        {{ number_format(($attachment->file_size ?? 0) / 1024, 2) }} KB
                    </p>

                    <div>
                        <a
                            href="{{ route('outgoing-letters.attachments.view', [
                                'outgoingLetter' => $outgoingLetter->id,
                                'attachment' => $attachment->id
                            ]) }}"
                            target="_blank"
                            class="button primary-button"
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

                    @if (in_array(auth()->user()->role ?? '', ['admin', 'sekretaris']))

                        <hr class="attachment-divider">

                        <div class="publication-title">
                            Publikasi dan Verifikasi Dokumen
                        </div>

                        @if ($attachment->is_public && $attachment->published_at && !$attachment->revoked_at)

                            <span class="status status-public">
                                DITERBITKAN / PUBLIK
                            </span>

                            <div class="public-info">

                                <p><strong>ID Dokumen:</strong></p>
                                <p>{{ $attachment->public_id }}</p>

                                <p><strong>URL Verifikasi:</strong></p>

                                <a
                                    href="{{ route('documents.verify', $attachment->public_token) }}"
                                    target="_blank"
                                    class="public-url"
                                >
                                    {{ route('documents.verify', $attachment->public_token) }}
                                </a>

                                <button
                                    type="button"
                                    class="button publish-button"
                                    onclick="copyVerificationUrl(@js(route('documents.verify', $attachment->public_token)))"
                                >
                                    Salin URL
                                </button>

                                <p>
                                    Diterbitkan pada:
                                    {{ $attachment->published_at->format('d-m-Y H:i') }}
                                </p>

                            </div>

                            <form
                                action="{{ route('outgoing-letters.attachments.revoke', [
                                    'outgoingLetter' => $outgoingLetter->id,
                                    'attachment' => $attachment->id
                                ]) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin mencabut akses publik dokumen ini?')"
                            >
                                @csrf

                                <button type="submit" class="button revoke-button">
                                    Cabut Publikasi
                                </button>
                            </form>

                        @else

                            @if ($attachment->revoked_at)
                                <span class="status status-revoked">
                                    PUBLIKASI DICABUT
                                </span>
                            @else
                                <span class="status status-private">
                                    BELUM DITERBITKAN
                                </span>
                            @endif

                            <p class="help-text">
                                File ini belum dapat diakses oleh pihak luar.
                                Terbitkan dokumen jika PDF sudah final dan siap dibagikan.
                            </p>

                            <form
                                action="{{ route('outgoing-letters.attachments.publish', [
                                    'outgoingLetter' => $outgoingLetter->id,
                                    'attachment' => $attachment->id
                                ]) }}"
                                method="POST"
                                onsubmit="return confirm('Terbitkan PDF ini agar dapat diverifikasi oleh pihak luar?')"
                            >
                                @csrf

                                <button type="submit" class="button publish-button">
                                    Terbitkan Dokumen
                                </button>
                            </form>

                        @endif

                    @endif

                </div>

            @endforeach

        @else

            <div class="empty">
                Belum ada arsip PDF untuk surat ini.
            </div>

        @endif

    </div>

    <!-- TOMBOL KEMBALI -->
    <a
        href="{{ route('dashboard') }}"
        class="button secondary-button"
    >
        ← Kembali ke Daftar Surat Keluar
    </a>

</div>

<script>
    function copyVerificationUrl(url) {
        navigator.clipboard.writeText(url)
            .then(() => {
                alert('URL verifikasi berhasil disalin.');
            })
            .catch(() => {
                alert('Gagal menyalin URL. Silakan salin URL secara manual.');
            });
    }
</script>

</body>
</html>
