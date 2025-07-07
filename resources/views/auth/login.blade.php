<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 25%, #2c5364 50%, #1a4037 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated forest moonlight background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(ellipse at 70% 20%, rgba(139, 195, 74, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 30% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.03) 0%, transparent 70%);
            animation: moonlight 25s ease-in-out infinite;
        }

        @keyframes moonlight {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        /* Fireflies animation */
        .firefly {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, #ffeb3b, #ffc107);
            border-radius: 50%;
            animation: firefly 12s infinite linear;
            box-shadow: 0 0 8px #ffeb3b, 0 0 16px #ffc107;
        }

        .firefly:nth-child(1) { top: 15%; left: 10%; animation-delay: 0s; animation-duration: 15s; }
        .firefly:nth-child(2) { top: 25%; right: 15%; animation-delay: 3s; animation-duration: 18s; }
        .firefly:nth-child(3) { top: 60%; left: 20%; animation-delay: 6s; animation-duration: 12s; }
        .firefly:nth-child(4) { bottom: 20%; right: 25%; animation-delay: 9s; animation-duration: 20s; }
        .firefly:nth-child(5) { top: 45%; right: 40%; animation-delay: 12s; animation-duration: 14s; }
        .firefly:nth-child(6) { bottom: 40%; left: 30%; animation-delay: 15s; animation-duration: 16s; }

        @keyframes firefly {
            0% { opacity: 0; transform: translateY(0) translateX(0) scale(0); }
            10% { opacity: 1; transform: translateY(-20px) translateX(10px) scale(1); }
            20% { opacity: 0.8; transform: translateY(-40px) translateX(-15px) scale(1.2); }
            30% { opacity: 1; transform: translateY(-20px) translateX(20px) scale(0.8); }
            40% { opacity: 0.6; transform: translateY(-60px) translateX(-10px) scale(1); }
            50% { opacity: 1; transform: translateY(-80px) translateX(15px) scale(1.1); }
            60% { opacity: 0.7; transform: translateY(-60px) translateX(-20px) scale(0.9); }
            70% { opacity: 1; transform: translateY(-40px) translateX(10px) scale(1); }
            80% { opacity: 0.8; transform: translateY(-20px) translateX(-5px) scale(1.2); }
            90% { opacity: 0.5; transform: translateY(-10px) translateX(5px) scale(0.8); }
            100% { opacity: 0; transform: translateY(0) translateX(0) scale(0); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(139, 195, 74, 0.4);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .particle:nth-child(odd) { 
            animation-duration: 25s; 
            background: rgba(76, 175, 80, 0.3);
        }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 32px;
            font-weight: 800;
            color: #1b5e20;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #1b5e20, #2e7d32, #388e3c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .login-subtitle {
            color: #4a7c59;
            font-size: 16px;
            font-weight: 400;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1b5e20;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(76, 175, 80, 0.2);
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1b5e20;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-input:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 
                0 0 0 4px rgba(76, 175, 80, 0.15),
                0 4px 12px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }

        .form-input:hover {
            border-color: rgba(76, 175, 80, 0.4);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #4caf50;
            border-radius: 4px;
            margin-right: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .checkbox:checked {
            background: #4caf50;
            border-color: #4caf50;
        }

        .checkbox-label {
            color: #2e7d32;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #388e3c;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link:hover {
            color: #2e7d32;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #4caf50;
            transition: width 0.3s ease;
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #2e7d32, #388e3c, #4caf50);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 
                0 4px 15px rgba(76, 175, 80, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 6px 20px rgba(76, 175, 80, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            background: linear-gradient(135deg, #388e3c, #4caf50, #66bb6a);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .login-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(76, 175, 80, 0.2);
        }

        .register-link {
            color: #388e3c;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link:hover {
            color: #2e7d32;
        }

        .register-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 50%;
            background: #4caf50;
            transition: all 0.3s ease;
        }

        .register-link:hover::after {
            width: 100%;
            left: 0;
        }

        /* Nature decorative elements */
        .nature-decoration {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(139, 195, 74, 0.1));
            border-radius: 50%;
            animation: breathe 6s ease-in-out infinite;
        }

        .nature-decoration:nth-child(2) {
            top: auto;
            bottom: -15px;
            left: -15px;
            right: auto;
            animation-delay: 3s;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(76, 175, 80, 0.1));
        }

        @keyframes breathe {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.6; }
        }

        /* Status message styling */
        .status-message {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #2e7d32;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-container {
                padding: 28px;
                margin: 20px;
            }
            
            .login-title {
                font-size: 28px;
            }

            .checkbox-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }

        /* Create floating particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particles .particle {
            position: absolute;
        }
    </style>
</head>
<body>
    <!-- Fireflies -->
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>

    <!-- Floating particles -->
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 12s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 14s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 16s;"></div>
    </div>

    <div class="login-container">
        <!-- Nature decorations -->
        <div class="nature-decoration"></div>
        <div class="nature-decoration"></div>
        
        <div class="login-header">
            <h1 class="login-title">🌙 Selamat Datang </h1>
            <p class="login-subtitle">Temukan Kenyamanan Anda di for-rest</p>
        </div>

        <!-- Session Status placeholder -->
        <div class="status-message" style="display: none;">
            Status message will appear here
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">🌿 Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukan email for-rest kamu" />
                <!-- Error display would go here -->
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">🔒 For-rest Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="Masukan password for-rest anda" />
                <!-- Error display would go here -->
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="checkbox-group">
                <label class="checkbox-wrapper">
                    <input id="remember_me" type="checkbox" class="checkbox" name="remember">
                    <span class="checkbox-label">Ingati aku di for-rest ini</span>
                </label>
                
                <a href="{{ route('password.request') }}" class="forgot-link">Butuh bantuan? 🧭</a>
            </div>

            <button type="submit" class="btn-login">
                🌲 Jelajah for-rest
            </button>
        </form>

        <div class="login-footer">
            <p style="color: #4a7c59; margin-bottom: 8px;">Baru di komunitas for-rest ini?</p>
            <a href="{{ route('register') }}" class="register-link">Bersama Kita Tumbuh - Register 🌱</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced checkbox styling
            const checkbox = document.getElementById('remember_me');
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.style.background = '#4caf50';
                        this.style.borderColor = '#4caf50';
                    } else {
                        this.style.background = 'white';
                        this.style.borderColor = '#4caf50';
                    }
                });
            }

            // Form input animations
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                    if (this.value.trim() !== '') {
                        this.style.borderColor = '#4caf50';
                        this.style.background = 'rgba(76, 175, 80, 0.05)';
                    }
                });

                // Email validation styling
                if (input.type === 'email') {
                    input.addEventListener('input', function() {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(this.value)) {
                            this.style.borderColor = '#4caf50';
                        } else if (this.value.length > 0) {
                            this.style.borderColor = '#ff9800';
                        }
                    });
                }
            });

            // Login button hover effect enhancement
            const loginBtn = document.querySelector('.btn-login');
            loginBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.02)';
            });

            loginBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            // Dynamic particles generation
            function createParticle() {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
                document.querySelector('.particles').appendChild(particle);

                // Remove particle after animation
                setTimeout(() => {
                    if (particle.parentNode) {
                        particle.parentNode.removeChild(particle);
                    }
                }, 25000);
            }

            // Create particles periodically
            setInterval(createParticle, 3000);
        });
    </script>
</body>
</html>