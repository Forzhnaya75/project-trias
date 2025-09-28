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
            text-align: center;
        }

        .header {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .btn-login {
            padding: 8px 18px;
            background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-login:hover {
            opacity: 0.9;
        }
        .logo-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .logo-container img {
            width: 250px;
            margin-bottom: 15px;
        }
        .tagline {
            font-size: 20px;
            font-weight: 500;
        }

        /* ==== MODAL ==== */
        .modal {
            display: none; /* hidden awal */
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
        }
        .modal-content {
            background: #fff;
            border-radius: 10px;
            width: 300px;
            margin: 10% auto;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }
        .modal-content h2 {
            margin: 0 0 15px;
            font-size: 18px;
        }
        .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-input {
            width: 100%;              /* isi penuh modal */
            box-sizing: border-box;   /* biar padding ikut dihitung */
            margin: 10px 0;
            padding: 10px 12px;       /* kasih ruang dalam */
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
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
    </style>
</head>
<body>
    <!-- Tombol login -->
    <div class="header">
        <button class="btn-login" id="openModal">Log in</button>
    </div>

    <!-- Logo + tagline -->
    <div class="logo-container">
        <img src="{{ asset('images/logotrias.png') }}" alt="TRIAS Logo">
        <div class="tagline">Electrical and Automation Specialist</div>
    </div>

    <!-- Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Input Data Login</h2>
            <form method="POST" action="#">
                @csrf
                <input type="text" name="username" placeholder="Username" class="form-input" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>
                <button type="submit" class="btn-submit">LOGIN</button>
                <div class="forgot"><a href="#">Lupa Password?</a></div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById("loginModal");
        const openBtn = document.getElementById("openModal");
        const closeBtn = document.getElementById("closeModal");

        openBtn.onclick = function() {
            modal.style.display = "block";
        }
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
