
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIRKA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f5f8;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.07);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand h1 {
            font-size: 30px;
            color: #243b53;
            letter-spacing: 2px;
        }

        .brand p {
            color: #7b8794;
            font-size: 13px;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334e68;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d9e2ec;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #486581;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #52606d;
        }

        .remember input {
            width: auto;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #243b53;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        button:hover {
            background: #334e68;
        }

        .error {
            color: #c0392b;
            font-size: 13px;
            margin-top: 6px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #9aa5b1;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="brand">
            <h1>SIRKA</h1>
            <p>Sistem Informasi Surat Koperasi</p>
            <p>Koperasi Karyawan Swabina Gatra</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    autofocus
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember" value="1">
                <label for="remember" style="margin: 0; font-weight: normal;">
                    Ingat saya
                </label>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="footer">
            &copy; {{ date('Y') }} SIRKA. All rights reserved.
        </div>

    </div>

</body>
</html>
