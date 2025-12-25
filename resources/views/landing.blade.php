<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIAS Group</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #7ad1eaff 0%, #7faaf0ff 100%); /* Bright Blue Gradient */
            font-family: 'Segoe UI', Arial, sans-serif; /* Modern font */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Prevent scrollbars */
            position: relative;
        }

        #bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 60px; /* jarak antara logo dan form */
            position: relative;
            z-index: 1; /* Ensure content is above canvas */
        }

        /* Logo */
        .logo-section {
            text-align: center;
            animation: fadeIn 1s ease-out; /* Intro animation */
        }
        .logo-section img {
            width: 250px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        .logo-section img:hover {
            transform: scale(1.05); /* Micro-interaction */
        }
        .tagline {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95); /* Glass-ish feel */
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15); /* Softer shadow */
            width: 280px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideIn 0.8s ease-out;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }

        .login-card h2 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #444;
        }
        .form-input {
            width: 100%;
            margin: 10px 0;
            padding: 12px 16px;   /* kasih ruang kiri-kanan lebih besar */
            border: 1px solid #ddd;
            border-radius: 8px; /* Softer corners */
            font-size: 14px;
            box-sizing: border-box; /* biar padding tetap rapi */
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-input:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.2);
            outline: none;
        }

        /* Premium Button Style (Inspired by Uiverse) */
        .btn-submit {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            background: transparent;
            border: none;
            cursor: pointer;
            position: relative;
            z-index: 1;
            overflow: hidden;
            transition: all 0.5s ease;
            border-radius: 50px; /* Pill shape */
            background-size: 300% 100%;
            background-image: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed);
            box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75);
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            background-position: 100% 0;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 6px 20px rgba(0, 198, 255, 0.7);
            transform: translateY(-2px);
        }

        .btn-submit:focus {
            outline: none;
        }

        /* Loading Spinner - Adapted for new button */
        .btn-submit.loading {
            color: transparent;
            pointer-events: none;
        }
        .btn-submit.loading::after {
            content: "";
            position: absolute;
            width: 24px;
            height: 24px;
            top: 50%;
            left: 50%;
            margin-top: -12px;
            margin-left: -12px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 0.8s linear infinite;
        }

        .forgot {
            margin-top: 15px;
            font-size: 12px;
        }
        .forgot a {
            color: #4facfe;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot a:hover {
            color: #00f2fe;
            text-decoration: underline;
        }
        .error-message {
            color: #ff4d4d;
            font-size: 13px;
            margin-top: 5px;
            text-align: left;
            background: rgba(255, 77, 77, 0.1);
            padding: 8px;
            border-radius: 5px;
            animation: fadeIn 0.3s ease;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            border: 1px solid #ff4d4d; /* Highlight border on error */
        }
    </style>
</head>
<body>
    <canvas id="bg-animation"></canvas>
    <div class="container">
        <!-- Logo -->
        <div class="logo-section">
            <a href="https://trias-group.co.id/" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('images/logotrias.png') }}" alt="TRIAS Logo">
            </a>
            <div class="tagline">Electrical and Automation Specialist</div>
        </div>

        <!-- Form Login -->
        <div class="login-card @error('login') shake @enderror">
            <h2>Selamat Datang</h2>
            <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
                @csrf
                <input type="text" name="username" placeholder="Username" class="form-input"
                       value="{{ old('username') }}" required>
                <input type="password" name="password" placeholder="Password" class="form-input" required>

                {{-- 🔹 Pesan error login --}}
                @error('login')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <button type="submit" class="btn-submit" id="btnSubmit">LOGIN</button>
                <div class="forgot"><a href="#">Lupa Password?</a></div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Existing Form Logic
            const form = document.getElementById('loginForm');
            const btn = document.getElementById('btnSubmit');

            if(form && btn) {
                form.addEventListener('submit', function() {
                    // Start loading animation
                    btn.classList.add('loading');
                });
            }

            // Canvas Animation Logic
            const canvas = document.getElementById('bg-animation');
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            let particlesArray;

            // Mouse position
            let mouse = {
                x: null,
                y: null,
                radius: (canvas.height / 80) * (canvas.width / 80)
            }

            window.addEventListener('mousemove', 
                function(event) {
                    mouse.x = event.x;
                    mouse.y = event.y;
                }
            );

            // Handle resize
            window.addEventListener('resize', function(){
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                mouse.radius = (canvas.height / 80) * (canvas.width / 80);
                init();
            });

            // Create particles
            class Particle {
                constructor(x, y, directionX, directionY, size, color) {
                    this.x = x;
                    this.y = y;
                    this.directionX = directionX;
                    this.directionY = directionY;
                    this.size = size;
                    this.color = color;
                }
                // Draw individual particle
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                    ctx.fill();
                }
                // Update particle position
                update() {
                    if (this.x > canvas.width || this.x < 0) {
                        this.directionX = -this.directionX;
                    }
                    if (this.y > canvas.height || this.y < 0) {
                        this.directionY = -this.directionY;
                    }

                    // Collision detection with mouse
                    let dx = mouse.x - this.x;
                    let dy = mouse.y - this.y;
                    let distance = Math.sqrt(dx*dx + dy*dy);
                    if (distance < mouse.radius + this.size){
                         if (mouse.x < this.x && this.x < canvas.width - this.size * 10) {
                             this.x += 3;
                         }
                         if (mouse.x > this.x && this.x > this.size * 10) {
                             this.x -= 3;
                         }
                         if (mouse.y < this.y && this.y < canvas.height - this.size * 10) {
                             this.y += 3;
                         }
                         if (mouse.y > this.y && this.y > this.size * 10) {
                             this.y -= 3;
                         }
                    }

                    this.x += this.directionX;
                    this.y += this.directionY;
                    this.draw();
                }
            }

            function init() {
                particlesArray = [];
                let numberOfParticles = (canvas.height * canvas.width) / 9000;
                for (let i = 0; i < numberOfParticles; i++) {
                    let size = (Math.random() * 3) + 1;
                    let x = (Math.random() * ((innerWidth - size * 2) - (size * 2)) + size * 2);
                    let y = (Math.random() * ((innerHeight - size * 2) - (size * 2)) + size * 2);
                    let directionX = (Math.random() * 2) - 1; // Speed
                    let directionY = (Math.random() * 2) - 1;
                    let color = '#ffffff';

                    particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
                }
            }

            // Connect particles
            function connect(){
                let opacityValue = 1;
                for (let a = 0; a < particlesArray.length; a++) {
                    for (let b = a; b < particlesArray.length; b++) {
                        let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x)) + 
                                       ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                        
                        // Distance to connect
                        if (distance < (canvas.width/7) * (canvas.height/7)) {
                             opacityValue = 1 - (distance/20000);
                             ctx.strokeStyle = 'rgba(255, 255, 255,' + opacityValue + ')'; // White line color
                             ctx.lineWidth = 1;
                             ctx.beginPath();
                             ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                             ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                             ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                requestAnimationFrame(animate);
                ctx.clearRect(0,0,innerWidth, innerHeight);
                
                for (let i = 0; i < particlesArray.length; i++) {
                    particlesArray[i].update();
                }
                connect();
            }

            // Start
            init();
            animate();
            
            // Mouse out event
            window.addEventListener('mouseout', function(){
                mouse.x = undefined; 
                mouse.y = undefined;
            });
        });
    </script>
</body>
</html>
