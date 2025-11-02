<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIAS Group</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to bottom, #c3d9f7 0%, #ffffff 100%);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 60px; /* jarak antara logo dan form */
        }

        /* Logo */
        .logo-section {
            text-align: center;
        }
        .logo-section img {
            width: 250px;
            margin-bottom: 15px;
        }
        .tagline {
            font-size: 18px;
            font-weight: 500;
        }

        /* Login Card */
        .login-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            width: 280px;
            text-align: center;
        }
        .login-card h2 {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .form-input {
            width: 100%;
            margin: 10px 0;
            padding: 12px 16px;   /* kasih ruang kiri-kanan lebih besar */
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box; /* biar padding tetap rapi */
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover {
            opacity: 0.9;
        }
        .forgot {
            margin-top: 10px;
            font-size: 12px;
        }
        .forgot a {
            color: #4facfe;
            text-decoration: none;
        }
        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo-section">
            <a href="https://trias-group.co.id/" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('images/logotrias.png') }}" alt="TRIAS Logo">
            </a>
            <div class="tagline">Electrical and Automation Specialist</div>
        </div>

        <!-- Form Login -->
        <div class="login-card">
            <h2>Selamat Datang</h2>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <input type="text" name="username" placeholder="Username" class="form-input"
                       value="{{ old('username') }}" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>

                {{-- 🔹 Pesan error login --}}
                @error('login')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-submit">LOGIN</button>
                <div class="forgot"><a href="#">Lupa Password?</a></div>
            </form>
        </div>
    </div>
</body>
</html>
