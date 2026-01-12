<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal MBG Karawang</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #064E3B 0%, #043125 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 40px; /* Sesuai spesifikasi rounded-[40px] */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: #064E3B;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
        }

        .login-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #064E3B;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .login-title p {
            color: #6b7280;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Tab Buttons Pill Style */
        .tab-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            background: #f3f4f6;
            padding: 0.4rem;
            border-radius: 9999px; /* Pill style */
            margin-bottom: 2rem;
        }

        .tab-btn {
            padding: 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            color: #6b7280;
            background: transparent;
        }

        .tab-btn.active {
            background: #064E3B;
            color: white;
            shadow: 0 4px 10px rgba(6, 78, 59, 0.3);
        }

        /* Input Field Style */
        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;
            text-transform: uppercase;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #f3f4f6;
            border-radius: 20px;
            background: #f9fafb;
            transition: all 0.3s;
            outline: none;
            margin-bottom: 1rem;
        }

        .form-group input:focus {
            border-color: #064E3B;
            background: white;
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: #064E3B;
            color: white;
            border: none;
            border-radius: 9999px; /* Pill style */
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: #043125;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.2);
        }

        .hidden { display: none; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-icon">
            <i class="fas fa-utensils"></i>
        </div>

        <div class="login-title">
            <h1>Portal MBG</h1>
            <p>Makanan Bergizi Gratis Karawang</p>
        </div>

        <div class="tab-buttons">
            <button class="tab-btn active" id="btn-sekolah" onclick="switchTab('sekolah')">
                <i class="fas fa-school mr-1"></i> Sekolah
            </button>
            <button class="tab-btn" id="btn-pemerintah" onclick="switchTab('pemerintah')">
                <i class="fas fa-landmark mr-1"></i> Pemerintah
            </button>
        </div>

        <form id="form-sekolah" action="{{ route('login.process') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="sekolah">
            <div class="form-group">
                <label>Username Sekolah</label>
                <input type="text" name="email" placeholder="Masukkan NPSN / Email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login uppercase tracking-widest text-xs">Masuk Sebagai Sekolah</button>
        </form>

        <form id="form-pemerintah" class="hidden" action="{{ route('login.process') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="admin">
            <div class="form-group">
                <label>Username Admin</label>
                <input type="text" name="email" placeholder="Masukkan NIP / Email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login uppercase tracking-widest text-xs">Masuk Sebagai Pemerintah</button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="#" style="color: #064E3B; font-size: 0.75rem; font-weight: 600; text-decoration: none; opacity: 0.7;">Lupa Password?</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session('swal.icon') }}',
            title: '{{ session('swal.title') }}',
            text: '{{ session('swal.text') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif

    <script>
        function switchTab(type) {
            const formSekolah = document.getElementById('form-sekolah');
            const formPemerintah = document.getElementById('form-pemerintah');
            const btnSekolah = document.getElementById('btn-sekolah');
            const btnPemerintah = document.getElementById('btn-pemerintah');

            if (type === 'sekolah') {
                formSekolah.classList.remove('hidden');
                formPemerintah.classList.add('hidden');
                btnSekolah.classList.add('active');
                btnPemerintah.classList.remove('active');
            } else {
                formSekolah.classList.add('hidden');
                formPemerintah.classList.remove('hidden');
                btnSekolah.classList.remove('active');
                btnPemerintah.classList.add('active');
            }
        }
    </script>

</body>
</html>