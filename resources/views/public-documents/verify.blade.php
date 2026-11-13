
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen - SIRKA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f5f8;
            color: #263445;
            min-height: 100vh;
        }

        .header {
            background: #ffffff;
            padding: 22px 8%;
            border-bottom: 1px solid #e5e9ef;
        }

        .header h2 {
            color: #174b35;
            font-size: 22px;
        }

        .header p {
            color: #687585;
            font-size: 13px;
            margin-top: 5px;
        }

        .container {
            width: 90%;
            max-width: 760px;
            margin: 55px auto;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 5px 22px rgba(0, 0, 0, 0.05);
        }

        .status {
            display: inline-block;
            background: #e6f5ec;
            color: #187344;
            padding: 9px 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 22px;
        }

        .status span {
            margin-right: 6px;
        }

        h1 {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .description {
            color: #687585;
            line-height: 1.6;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .document-id {
            background: #f4f7f5;
            padding: 17px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .document-id small {
            display: block;
            color: #687585;
            margin-bottom: 7px;
        }

        .document-id strong {
            color: #174b35;
            letter-spacing: 1px;
            overflow-wrap: anywhere;
        }

        .details {
            border-top: 1px solid #e8ecf0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #e8ecf0;
            font-size: 14px;
        }

        .detail-row span:first-child {
            color: #687585;
        }

        .detail-row strong {
            text-align: right;
            overflow-wrap: anywhere;
        }

        .button {
            display: block;
            text-align: center;
            background: #174b35;
            color: white;
            padding: 14px;
            text-decoration: none;
            border-radius: 7px;
            margin-top: 28px;
            font-weight: bold;
        }

        .button:hover {
            background: #103b29;
        }

        .footer {
            text-align: center;
            color: #8993a0;
            font-size: 12px;
            padding: 25px;
        }

        @media (max-width: 600px) {
            .card {
                padding: 23px;
            }

            .container {
                margin: 30px auto;
            }

            .detail-row {
                flex-direction: column;
                gap: 6px;
            }

            .detail-row strong {
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <h2>SIRKA</h2>
        <p>Sistem Informasi Surat Koperasi</p>
    </header>

    <main class="container">
        <section class="card">

            <div class="status">
                <span>✓</span> DOKUMEN TERVERIFIKASI
            </div>

            <h1>Dokumen Resmi Koperasi</h1>

            <p class="description">
                Dokumen ini terdaftar dalam sistem arsip digital
                Koperasi Karyawan Swabina Gatra dan telah diterbitkan
                melalui sistem SIRKA.
            </p>

            <div class="document-id">
                <small>ID Dokumen</small>
                <strong>{{ $attachment->public_id }}</strong>
            </div>

            @php
                $letter = $attachment->letter;
            @endphp

            <div class="details">

                <div class="detail-row">
                    <span>Nomor Surat</span>
                    <strong>{{ $letter->letter_number }}</strong>
                </div>

                <div class="detail-row">
                    <span>Perihal</span>
                    <strong>{{ $letter->subject }}</strong>
                </div>

                <div class="detail-row">
                    <span>Penerima</span>
                    <strong>{{ $letter->recipient }}</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Surat</span>
                    <strong>
                        {{ $letter->letter_date
                            ? $letter->letter_date->format('d-m-Y')
                            : '-' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Diterbitkan</span>
                    <strong>
                        {{ $attachment->published_at->format('d-m-Y H:i') }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Nama File</span>
                    <strong>{{ $attachment->original_name }}</strong>
                </div>

            </div>

            <a href="{{ route('documents.verify.pdf', $attachment->public_token) }}"
               class="button"
               target="_blank">
                Lihat Dokumen PDF
            </a>

        </section>
    </main>

    <footer class="footer">
        © {{ date('Y') }} Koperasi Karyawan Swabina Gatra.
        Seluruh hak cipta dilindungi.
    </footer>

</body>
</html>
