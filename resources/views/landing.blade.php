<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBG Karawang - Selamat Datang</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2Lw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-white">

    <!-- NAVBAR -->
    <nav class="bg-[#064E3B] text-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <!-- LOGO -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <img src="http://127.0.0.1:8000/img/logo.png" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="font-bold leading-none">MBG Karawang</h1>
                    <p class="text-[10px] opacity-80">Monitoring Makanan Bergizi Gratis</p>
                </div>
            </div>

            <!-- DESKTOP MENU -->
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#fitur" class="hover:text-green-300">Fitur</a>
                <a href="#visi-misi" class="hover:text-green-300">Visi & Misi</a>
                <a href="#" class="hover:text-green-300">Tentang Kami</a>
                <a href="{{ route('login') }}"
                    class="bg-white text-[#064E3B] px-8 py-2 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                    Login
                </a>
            </div>

            <!-- HAMBURGER -->
            <button id="btnMenu" class="md:hidden text-2xl">
                ☰
            </button>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobileMenu" class="hidden md:hidden bg-[#064E3B] px-6 pb-6 space-y-4">
            <a href="#fitur" class="block hover:text-green-300">Fitur</a>
            <a href="#visi-misi" class="block hover:text-green-300">Visi & Misi</a>
            <a href="#" class="block hover:text-green-300">Tentang Kami</a>
            <a href="http://127.0.0.1:8000/login"
                class="block bg-white text-[#064E3B] text-center py-2 rounded-full font-bold">
                Login
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <main class="pt-32 max-w-7xl mx-auto px-6 text-center">

        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-white rounded-full border-4 border-[#064E3B] shadow-lg overflow-hidden">
                <img src="http://127.0.0.1:8000/img/karawang.jpg" class="w-full h-full object-contain p-2">
            </div>
        </div>

        <h2 class="text-3xl md:text-4xl font-extrabold text-[#064E3B] mb-10">
            Selamat Datang di
            <span class="border-b-4 border-yellow-400">MBG Karawang</span>
        </h2>

        <!-- GALLERY -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-14">
            <img class="rounded-2xl h-48 object-cover shadow-xl hover:scale-105 transition"
                src="{{ asset('img/anak_anak.jpg') }}">
            <img class="rounded-2xl h-48 object-cover shadow-xl hover:scale-105 transition"
                src="{{ asset('img/embege.jpg') }}">
            <img class="rounded-2xl h-48 object-cover shadow-xl hover:scale-105 transition"
                src="{{ asset('img/dapur.jpg') }}">
            <img class="rounded-2xl h-48 object-cover shadow-xl hover:scale-105 transition"
                src="{{ asset('img/embegesd.jpg')  }}">
        </div>

        <p class="max-w-2xl mx-auto text-[#064E3B] font-semibold text-lg">
            Platform monitoring dan pelaporan Makanan Bergizi Gratis
            untuk Kabupaten Karawang
        </p>
    </main>

    <!-- FITUR -->
    <section id="fitur" class="bg-gradient-to-b from-[#1f4d32] to-[#163826] py-20 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-14">Fitur Unggulan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Card Pemerintah -->
                <div class="bg-white rounded-2xl shadow-xl p-8 text-left">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-yellow-400 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#1f4d32]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 21h18M4 21V7l8-4 8 4v14M9 21V9h6v12" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">
                            Dashboard Pemerintah
                        </h3>
                    </div>
                
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li>• Dashboard Analytics</li>
                        <li>• Monitoring Sekolah</li>
                        <li>• Laporan Terkomputasi</li>
                        <li>• Manajemen Keluhan</li>
                        <li>• Kelola Menu & Sekolah</li>
                    </ul>
                </div>

                <!-- Card Sekolah -->
                <div class="bg-white rounded-2xl shadow-xl p-8 text-left">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-yellow-400 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#1f4d32]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">
                            Dashboard Sekolah
                        </h3>
                    </div>
                
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li>• Input Laporan Harian</li>
                        <li>• Riwayat Laporan</li>
                        <li>• Menu Mingguan</li>
                        <li>• Keluhan & Saran</li>
                        <li>• Profil Sekolah</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- VISI MISI -->
    <section id="visi-misi" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-extrabold text-center text-[#1f4d32] mb-14">
                Visi dan Misi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-[#1f4d32] rounded-2xl p-8 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-4">Visi</h3>
                    <p class="text-green-100 text-sm">
                        Mewujudkan pemerataan dan peningkatan kualitas MBG
                        melalui sistem monitoring yang transparan dan akuntabel.
                    </p>
                </div>

                <div class="bg-[#1f4d32] rounded-2xl p-8 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-4">Misi</h3>
                    <ul class="text-green-100 text-sm space-y-2">
                        <li>• Akses MBG merata</li>
                        <li>• Pelaporan cepat & terdokumentasi</li>
                        <li>• Monitoring akurat</li>
                        <li>• Keluhan responsif</li>
                        <li>• Kolaborasi sekolah & pemerintah</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#1f4d32] text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12">
    
            <!-- GRID FOOTER -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-sm">
    
                <!-- TENTANG MBG -->
                <div>
                    <h3 class="font-bold mb-3">Tentang MBG</h3>
                    <p class="text-green-100 leading-relaxed">
                        Program Makanan Bergizi Gratis untuk meningkatkan
                        kesehatan dan nutrisi anak didik di Kabupaten Karawang.
                    </p>
                </div>
    
                <!-- HUBUNGI KAMI -->
                <div>
                    <h3 class="font-bold mb-3">Hubungi Kami</h3>
                    <ul class="text-green-100 space-y-3">
    
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-yellow-400"></i>
                            <span>mbg@karawang.co.id</span>
                        </li>
    
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-instagram text-pink-400"></i>
                            <span>mbgkarawang_</span>
                        </li>
    
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-tiktok text-gray-200"></i>
                            <span>mbgkarawang_</span>
                        </li>
    
                    </ul>
                </div>
    
                <!-- VERSI -->
                <div>
                    <h3 class="font-bold mb-3">Versi</h3>
                    <ul class="text-green-100 space-y-2">
                        <li>Versi: 2.0 Professional</li>
                        <li>Status:
                            <span class="text-green-300 font-semibold">
                                Production Ready
                            </span>
                        </li>
                        <li>© 2026 Pemerintah Kabupaten Karawang</li>
                    </ul>
                </div>
            </div>
    
            <!-- GARIS BAWAH -->
            <div class="border-t border-green-700 mt-10 pt-6 text-center text-xs text-green-200">
                Dibuat dengan <span class="text-red-400">❤️</span> untuk Program MBG Karawang
            </div>
    
        </div>
    </footer>



    <!-- JS MOBILE MENU -->
    <script>
        const btn = document.getElementById('btnMenu')
        const menu = document.getElementById('mobileMenu')

        btn.onclick = () => {
            menu.classList.toggle('hidden')
        }
    </script>

</body>

</html>