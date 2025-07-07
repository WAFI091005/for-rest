@extends('layouts.app')

@section('title', 'Buat Memori')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .forest-section {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #0d4f2f 0%, #1a6b42 20%, #2e8b57 40%, #3cb371 60%, #90ee90 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
        padding: 64px 0;
    }

    /* Animated forest background layers */
    .forest-section::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(ellipse at 20% 70%, rgba(34, 139, 34, 0.1) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 30%, rgba(46, 125, 50, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(76, 175, 80, 0.05) 0%, transparent 60%);
        animation: forestFlow 30s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes forestFlow {
        0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
        33% { opacity: 0.5; transform: scale(1.1) rotate(1deg); }
        66% { opacity: 0.4; transform: scale(0.9) rotate(-1deg); }
    }

    /* Floating forest elements */
    .forest-element {
        position: fixed;
        pointer-events: none;
        opacity: 0.1;
    }

    .tree-silhouette {
        font-size: 40px;
        color: #2d5a3d;
        animation: sway 8s ease-in-out infinite;
    }

    .tree-silhouette:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
    .tree-silhouette:nth-child(2) { top: 20%; right: 8%; animation-delay: 2s; }
    .tree-silhouette:nth-child(3) { bottom: 15%; left: 10%; animation-delay: 4s; }
    .tree-silhouette:nth-child(4) { bottom: 25%; right: 12%; animation-delay: 6s; }

    @keyframes sway {
        0%, 100% { transform: rotate(-2deg) scale(1); }
        50% { transform: rotate(2deg) scale(1.1); }
    }

    /* Floating leaves */
    .leaf-float {
        position: fixed;
        width: 8px;
        height: 8px;
        background: linear-gradient(45deg, #228b22, #32cd32);
        border-radius: 0 100% 0 100%;
        animation: leafDrift 20s infinite linear;
        opacity: 0.2;
        pointer-events: none;
    }

    @keyframes leafDrift {
        0% { transform: translateY(100vh) translateX(0) rotate(0deg); opacity: 0; }
        10% { opacity: 0.3; }
        90% { opacity: 0.3; }
        100% { transform: translateY(-10vh) translateX(50px) rotate(360deg); opacity: 0; }
    }

    /* Light rays through forest */
    .sun-ray {
        position: fixed;
        width: 2px;
        height: 100vh;
        background: linear-gradient(to bottom, transparent, rgba(255, 255, 0, 0.1), transparent);
        animation: sunRay 15s ease-in-out infinite;
        pointer-events: none;
    }

    .sun-ray:nth-child(1) { left: 20%; animation-delay: 0s; }
    .sun-ray:nth-child(2) { left: 40%; animation-delay: 5s; }
    .sun-ray:nth-child(3) { left: 60%; animation-delay: 10s; }
    .sun-ray:nth-child(4) { left: 80%; animation-delay: 7s; }

    @keyframes sunRay {
        0%, 100% { opacity: 0; transform: translateX(0); }
        50% { opacity: 0.4; transform: translateX(10px); }
    }

    .container {
        max-width: 1024px;
        margin: 0 auto;
        padding: 0 16px;
        position: relative;
        z-index: 10;
    }

    .header-section {
        text-align: center;
        margin-bottom: 48px;
        animation: slideDown 1s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        background: linear-gradient(135deg, #228b22, #32cd32);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        box-shadow: 0 8px 25px rgba(34, 139, 34, 0.3);
        animation: logoGlow 3s ease-in-out infinite;
    }

    @keyframes logoGlow {
        0%, 100% { box-shadow: 0 8px 25px rgba(34, 139, 34, 0.3); }
        50% { box-shadow: 0 12px 35px rgba(34, 139, 34, 0.5); }
    }

    .main-title {
        font-size: 48px;
        font-weight: 800;
        color: #0d4f2f;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #0d4f2f, #1a6b42, #2e8b57);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

.main-subtitle {
    font-size: 20px;
    color: #ffffff; /* hitam pekat */
    font-weight: 600;
    opacity: 1;
}


    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 48px;
        border-radius: 32px;
        box-shadow: 
            0 25px 50px rgba(0, 0, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border: 2px solid rgba(46, 139, 87, 0.1);
        position: relative;
        animation: formSlideUp 1.2s ease-out;
    }

    @keyframes formSlideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, rgba(34, 139, 34, 0.3), rgba(46, 139, 87, 0.2), rgba(50, 205, 50, 0.1));
        border-radius: 32px;
        z-index: -1;
        animation: borderGlow 4s ease-in-out infinite;
    }

    @keyframes borderGlow {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }

    .form-group {
        margin-bottom: 32px;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 12px;
        font-weight: 700;
        color: #0d4f2f;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .form-label::before {
        content: '🌲';
        margin-right: 8px;
        font-size: 14px;
    }

    .form-input {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid rgba(46, 139, 87, 0.2);
        border-radius: 16px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #0d4f2f;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-input:focus {
        outline: none;
        border-color: #2e8b57;
        box-shadow: 
            0 0 0 4px rgba(46, 139, 87, 0.15),
            0 8px 25px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
    }

    .form-input:hover {
        border-color: rgba(46, 139, 87, 0.4);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }

    .form-select {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232e8b57' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 48px;
        cursor: pointer;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .image-upload-box {
        position: relative;
        border: 2px dashed #2e8b57;
        border-radius: 16px;
        padding: 24px;
        background: rgba(46, 139, 87, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .image-upload-box:hover {
        background: rgba(46, 139, 87, 0.1);
        border-color: #228b22;
        transform: translateY(-2px);
    }

    .image-upload-box input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .upload-content {
        text-align: center;
        pointer-events: none;
    }

    .upload-icon {
        font-size: 32px;
        margin-bottom: 8px;
        display: block;
    }

    .upload-text {
        color: #2e8b57;
        font-weight: 600;
        font-size: 14px;
    }

    .upload-subtext {
        color: #6b7280;
        font-size: 12px;
        margin-top: 4px;
    }

    .submit-section {
        text-align: center;
        margin-top: 40px;
    }

    .submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #228b22, #2e8b57, #32cd32);
        color: white;
        padding: 18px 36px;
        border: none;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 
            0 8px 25px rgba(34, 139, 34, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 
            0 12px 35px rgba(34, 139, 34, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        background: linear-gradient(135deg, #32cd32, #3cb371, #90ee90);
    }

    .submit-btn:active {
        transform: translateY(-2px) scale(1.02);
    }

    .btn-icon {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
    }

    .error-message {
        color: #dc2626;
        font-size: 14px;
        margin-top: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .error-message::before {
        content: '⚠';
        font-size: 12px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .form-container {
            padding: 32px;
            margin: 20px;
            border-radius: 24px;
        }
        
        .main-title {
            font-size: 36px;
        }

        .main-subtitle {
            font-size: 18px;
        }

        .image-grid {
            grid-template-columns: 1fr;
        }

        .submit-btn {
            padding: 16px 28px;
            font-size: 16px;
        }
    }

    /* Loading animation */
    .loading {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(46, 139, 87, 0.3);
        border-top: 4px solid #2e8b57;
        border-radius: 50%;
        animation: leafSpin 1s linear infinite;
    }

    @keyframes leafSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<section class="forest-section">
    <!-- Floating forest elements -->
    <div class="tree-silhouette forest-element">🌲</div>
    <div class="tree-silhouette forest-element">🌳</div>
    <div class="tree-silhouette forest-element">🌲</div>
    <div class="tree-silhouette forest-element">🌳</div>

    <!-- Sun rays -->
    <div class="sun-ray"></div>
    <div class="sun-ray"></div>
    <div class="sun-ray"></div>
    <div class="sun-ray"></div>

    <!-- Floating leaves -->
    <div class="leaf-float" style="left: 10%; animation-delay: 0s;"></div>
    <div class="leaf-float" style="left: 25%; animation-delay: 3s;"></div>
    <div class="leaf-float" style="left: 40%; animation-delay: 6s;"></div>
    <div class="leaf-float" style="left: 55%; animation-delay: 9s;"></div>
    <div class="leaf-float" style="left: 70%; animation-delay: 12s;"></div>
    <div class="leaf-float" style="left: 85%; animation-delay: 15s;"></div>

    <div class="container">
        <div class="header-section">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Forest Icon" class="logo" onerror="this.innerHTML='🌿'; this.style.background='linear-gradient(135deg, #228b22, #32cd32)'; this.style.color='white'; this.style.display='flex'; this.style.alignItems='center'; this.style.justifyContent='center';">
            <h2 class="main-title">Bagikan Petualanganmu 🌿</h2>
            <p class="main-subtitle">Isi form berikut untuk menciptakan kenangan baru dalam For-Rest.</p>
        </div>

        <form action="{{ route('memori.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf {{-- ✅ Ini WAJIB untuk mencegah error 419 --}}

            {{-- Judul --}}
            <div class="form-group">
                <label for="title" class="form-label">Judul Memori</label>
                <input type="text" id="title" name="title" required value="{{ old('title') }}" 
                       class="form-input" placeholder="Berikan nama untuk petualangan Anda...">
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Perjalanan --}}
            <div class="form-group">
                <label for="trip_date" class="form-label">Tanggal Perjalanan</label>
                <input type="date" id="trip_date" name="trip_date" required value="{{ old('trip_date') }}" 
                       class="form-input">
                @error('trip_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="form-group">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" id="location" name="location" required value="{{ old('location') }}" 
                       class="form-input" placeholder="Tempat magis mana yang Anda kunjungi?">
                @error('location')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="form-group">
                <label class="form-label">Gambar Petualangan</label>
                <div class="image-grid">
                    @foreach ([1, 2, 3] as $index)
                        <div class="image-upload-box">
                            <input type="file" id="image{{ $index == 1 ? '' : $index }}" name="image{{ $index == 1 ? '' : $index }}" accept="image/*">
                            <div class="upload-content">
                                @if($index == 1)
                                    <span class="upload-icon">📸</span>
                                    <div class="upload-text">Gambar Utama</div>
                                    <div class="upload-subtext">Wajib diisi</div>
                                @elseif($index == 2)
                                    <span class="upload-icon">🖼</span>
                                    <div class="upload-text">Gambar Kedua</div>
                                    <div class="upload-subtext">Opsional</div>
                                @else
                                    <span class="upload-icon">🌅</span>
                                    <div class="upload-text">Gambar Ketiga</div>
                                    <div class="upload-subtext">Opsional</div>
                                @endif
                            </div>
                        </div>
                        @error('image' . ($index == 1 ? '' : $index))
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    @endforeach
                </div>
            </div>

            {{-- Kategori --}}
            <div class="form-group">
                <label for="category_id" class="form-label">Kategori</label>
                <select id="category_id" name="category_id" required class="form-input form-select">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih jenis petualangan Anda</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="description" class="form-label">Ceritakan Petualangan Anda</label>
                <textarea id="description" name="description" class="form-input form-textarea" 
                          placeholder="Bagikan pengalaman, perasaan, dan momen berkesan dari petualangan Anda di alam...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="submit-section">
                <button type="submit" class="submit-btn">
                    <svg class="btn-icon" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Memori Hutan
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Loading overlay -->
<div class="loading" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced file upload interactions
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        const uploadBox = input.closest('.image-upload-box');
        const uploadText = uploadBox.querySelector('.upload-text');
        const originalText = uploadText.textContent;
        
        input.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                uploadText.textContent = `✅ ${this.files[0].name}`;
                uploadBox.style.background = 'rgba(34, 139, 34, 0.1)';
                uploadBox.style.borderColor = '#228b22';
            } else {
                uploadText.textContent = originalText;
                uploadBox.style.background = 'rgba(46, 139, 87, 0.05)';
                uploadBox.style.borderColor = '#2e8b57';
            }
        });

        // Drag and drop functionality
        uploadBox.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.background = 'rgba(34, 139, 34, 0.15)';
            this.style.borderColor = '#228b22';
            this.style.transform = 'translateY(-4px)';
        });

        uploadBox.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.background = 'rgba(46, 139, 87, 0.05)';
            this.style.borderColor = '#2e8b57';
            this.style.transform = 'translateY(0)';
        });

        uploadBox.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                input.dispatchEvent(new Event('change'));
            }
            this.style.background = 'rgba(46, 139, 87, 0.05)';
            this.style.borderColor = '#2e8b57';
            this.style.transform = 'translateY(0)';
        });
    });

    // Form validation and enhancement
    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('.form-input');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
            if (this.value.trim() !== '') {
                this.style.borderColor = '#228b22';
                this.style.background = 'rgba(34, 139, 34, 0.05)';
            }
        });

        // Real-time validation
        input.addEventListener('input', function() {
            if (this.hasAttribute('required') && this.value.trim() === '') {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#2e8b57';
            }
        });
    });

    // Form submission with loading
    form.addEventListener('submit', function(e) {
        const loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.style.display = 'flex';
        
        // Disable submit button to prevent double submission
        const submitBtn = this.querySelector('.submit-btn');
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
    });

    // Dynamic leaf generation
    function createLeaf() {
        const leaf = document.createElement('div');
        leaf.className = 'leaf-float';
        leaf.style.left = Math.random() * 100 + '%';
        leaf.style.animationDelay = Math.random() * 5 + 's';
        leaf.style.animationDuration = (Math.random() * 10 + 15) + 's';
        document.body.appendChild(leaf);

        setTimeout(() => {
            if (leaf.parentNode) {
                leaf.parentNode.removeChild(leaf);
            }
        }, 25000);
    }

    // Create leaves periodically
    setInterval(createLeaf, 4000);

    // Character counter for description
    const textarea = document.getElementById('description');
    if (textarea) {
        const counter = document.createElement('div');
        counter.style.cssText = 'text-align: right; font-size: 12px; color: #6b7280; margin-top: 4px;';
        textarea.parentNode.appendChild(counter);

        textarea.addEventListener('input', function() {
            counter.textContent = `${this.value.length} karakter`;
            if (this.value.length > 500) {
                counter.style.color = '#ef4444';
            } else {
                counter.style.color = '#6b7280';
            }
        });
    }
});
</script>
@endsection