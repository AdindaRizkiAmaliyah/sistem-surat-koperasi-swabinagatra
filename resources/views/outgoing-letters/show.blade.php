
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
            max-width: 850px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
        }

        h2 {
            color: #1f2937;
            margin-top: 0;
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

        .attachment {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 15px;
        }

        .attachment-title {
            font-size: 16px;
            color: #1f2937;
            overflow-wrap: anywhere;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
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

        .publish-button {
            background: #174b35;
            color: white;
        }

        .revoke-button {
            background: #dc2626;
            color: white;
        }

        .back-button {
            background: #e5e7eb;
            color: #333;
            margin-top: 25px;
        }

        .status {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            margin: 12px 0;
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

        .public-info {
            background: #f0f7f3;
            border: 1px solid #d4e8da;
            padding: 15px;
            border-radius: 7px;
            margin-top: 15px;
        }

        .public-info p {
            margin: 7px 0;
            font-size: 13px;
            color: #374151;
        }

        .public-url {
            display: block;
            padding: 10px;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            color: #174b35;
            overflow-wrap: anywhere;
            margin-top: 8px;
            font-size: 13px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            background: #e6f5ec;
            color: #187344;
        }

        .empty {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            color: #6b7280;
        }

        .help-text {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
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
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Detail Surat Keluar</h2>

    <p style="color: #6b7280;">
        Informasi lengkap surat keluar yang tersimpan dalam SIRKA.
    </p>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

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

                <div class="attachment-title">
                    <strong>{{ $attachment->original_name }}</strong>
                </div>

                <p class="help-text">
                    Ukuran:
                    {{ number_format(($attachment->file_size ?? 0) / 1024, 2) }} KB
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

                @if (in_array(auth()->user()->role ?? '', ['admin', 'sekretaris']))

                    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

                    <strong>Publikasi dan Verifikasi Dokumen</strong>

                    @if ($attachment->is_public && $attachment->published_at && !$attachment->revoked_at)

                        <div>
                            <span class="status status-public">
                                DITERBITKAN / PUBLIK
                            </span>
                        </div>

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
                                onclick="copyVerificationUrl('{{ route('documents.verify', $attachment->public_token) }}')"
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
                            <div>
                                <span class="status status-revoked">
                                    PUBLIKASI DICABUT
                                </span>
                            </div>
                        @else
                            <div>
                                <span class="status status-private">
                                    BELUM DITERBITKAN
                                </span>
                            </div>
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

    <a
        href="{{ route('outgoing-letters.index') }}"
        class="button back-button"
    >
        Kembali ke Daftar Surat
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
