<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1a4a3b 0%, #2d5a47 25%, #4a7c59 50%, #8fb996 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated forest background elements */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(46, 125, 50, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(129, 199, 132, 0.05) 0%, transparent 50%);
            animation: forestBreeze 20s ease-in-out infinite;
        }

        @keyframes forestBreeze {
            0%, 100% { transform: translateX(0) scale(1); opacity: 0.7; }
            33% { transform: translateX(-10px) scale(1.05); opacity: 0.8; }
            66% { transform: translateX(10px) scale(0.95); opacity: 0.9; }
        }

        /* Floating leaves animation */
        .leaf {
            position: absolute;
            width: 12px;
            height: 12px;
            background: linear-gradient(45deg, #4caf50, #8bc34a);
            border-radius: 0 100% 0 100%;
            animation: floatLeaf 15s infinite linear;
            opacity: 0.3;
        }

        .leaf:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .leaf:nth-child(2) { top: 20%; left: 80%; animation-delay: 3s; }
        .leaf:nth-child(3) { top: 60%; left: 5%; animation-delay: 6s; }
        .leaf:nth-child(4) { top: 80%; left: 90%; animation-delay: 9s; }
        .leaf:nth-child(5) { top: 40%; left: 70%; animation-delay: 12s; }

        @keyframes floatLeaf {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a4a3b;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #1a4a3b, #2e7d32);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-subtitle {
            color: #4a7c59;
            font-size: 16px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d5a47;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e8f5e8;
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            color: #1a4a3b;
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }

        .form-input:hover {
            border-color: #66bb6a;
        }

        .file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
            cursor: pointer;
        }

        .file-input input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px;
            border: 2px dashed #4caf50;
            border-radius: 12px;
            background: rgba(76, 175, 80, 0.05);
            color: #2e7d32;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-label:hover {
            background: rgba(76, 175, 80, 0.1);
            border-color: #388e3c;
            transform: translateY(-2px);
        }

        .file-input-icon {
            margin-right: 8px;
            font-size: 18px;
        }

        .password-group {
            position: relative;
        }

        .btn-primary {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #4caf50, #388e3c);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, #66bb6a, #4caf50);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e8f5e8;
        }

        .form-link {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .form-link:hover {
            color: #388e3c;
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 24px;
                margin: 20px;
            }
            
            .form-title {
                font-size: 28px;
            }
        }

        /* Nature-inspired decorative elements */
        .nature-accent {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4caf50, #8bc34a);
            border-radius: 50%;
            opacity: 0.1;
            animation: pulse 4s ease-in-out infinite;
        }

        .nature-accent:nth-child(2) {
            top: auto;
            bottom: -10px;
            left: -10px;
            animation-delay: 2s;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.1); opacity: 0.2; }
        }
    </style>
</head>
<body>
    <!-- Floating leaves -->
    <div class="leaf"></div>
    <div class="leaf"></div>
    <div class="leaf"></div>
    <div class="leaf"></div>
    <div class="leaf"></div>

    <div class="form-container">
        <!-- Decorative nature accents -->
        <div class="nature-accent"></div>
        <div class="nature-accent"></div>
        
        <div class="form-header">
            <h1 class="form-title">🌲 Bergabunglah dengan kami for-rest</h1>
            <p class="form-subtitle">Buat akun Anda dan jadilah bagian dari komunitas alam</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">🌿 Nama</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama anda" />
                <!-- Error display would go here -->
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">📧 Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email.anda@email.com" />
                <!-- Error display would go here -->
            </div>

            <!-- Avatar Upload -->
            <div class="form-group">
                <label for="avatar" class="form-label">🖼️ Foto Profile (Optional)</label>
                <div class="file-input">
                    <input id="avatar" name="avatar" type="file" accept="image/*" />
                    <label for="avatar" class="file-input-label">
                        <span class="file-input-icon">📷</span>
                        <span>Pilih avatar for-rest Anda</span>
                    </label>
                </div>
                <!-- Error display would go here -->
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">🔒 Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Buat password yang kuat" />
                <!-- Error display would go here -->
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">🔐 Confirm Password</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi password Anda" />
                <!-- Error display would go here -->
            </div>

            <button type="submit" class="btn-primary">
                🌱 Bersama Kita Tumbuh - Register
            </button>

            <div class="form-footer">
                <p style="color: #4a7c59;">
                    Sudah menjadi bagian dari for-rest? 
                    <a href="{{ route('login') }}" class="form-link">Login</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // File input enhancement
            const fileInput = document.getElementById('avatar');
            const fileLabel = document.querySelector('.file-input-label span:last-child');
            const originalText = fileLabel.textContent;

            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileLabel.textContent = `Selected: ${this.files[0].name}`;
                } else {
                    fileLabel.textContent = originalText;
                }
            });

            // Form validation feedback
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() !== '') {
                        this.style.borderColor = '#4caf50';
                    }
                });
            });

            // Password strength indicator (basic)
            const passwordInput = document.getElementById('password');
            passwordInput.addEventListener('input', function() {
                const strength = this.value.length;
                if (strength > 8) {
                    this.style.borderColor = '#4caf50';
                } else if (strength > 4) {
                    this.style.borderColor = '#ff9800';
                } else {
                    this.style.borderColor = '#f44336';
                }
            });
        });
    </script>
</body>
</html>