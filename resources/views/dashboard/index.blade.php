
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SIRKA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f5f8;
            color: #243b53;
        }

        .navbar {
            background: #243b53;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .logout button {
            background: #ffffff;
            color: #243b53;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            max-width: 1150px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #627d98;
            line-height: 1.6;
        }

        .role {
            display: inline-block;
            margin-top: 12px;
            background: #d9e2ec;
            color: #243b53;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: capitalize;
        }

        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.04);
        }

        .content h2 {
            font-size: 19px;
            margin-bottom: 12px;
        }

        .content p {
            color: #627d98;
            line-height: 1.7;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #829ab1;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="brand">SIRKA</div>

        <form class="logout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <main class="container">

        <section class="welcome">
            <h1>Selamat Datang, {{ $user->name }}!</h1>

            <p>
                Selamat datang di Sistem Informasi Surat Koperasi
                Karyawan Swabina Gatra.
            </p>

            <span class="role">
                {{ $user->role }}
            </span>
        </section>

        <section class="content">
            <h2>Dashboard</h2>

            <p>
                Kamu berhasil masuk ke sistem SIRKA.
                Silakan gunakan menu yang tersedia sesuai dengan
                hak akses akun kamu.
            </p>
        </section>

        <div class="footer">
            &copy; {{ date('Y') }} SIRKA - Koperasi Karyawan Swabina Gatra
        </div>

    </main>

</body>
</html>
