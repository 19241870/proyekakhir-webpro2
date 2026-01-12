<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Sekolah - MBG Karawang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
        .nav-active { background-color: black !important; color: white !important; transform: scale(1.05); shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .main-content { margin-left: 18rem; width: calc(100% - 18rem); }
    </style>
</head>
<body class="flex">

    <aside class="w-72 bg-[#1a4d2e] h-screen flex flex-col p-6 fixed left-0 top-0 z-50">
        <div class="mb-12 mt-4 px-4 text-center">
            <h1 class="text-xl font-black tracking-tighter text-white uppercase italic">MBG KARAWANG</h1>
            <div class="h-1.5 w-12 bg-green-400 mx-auto mt-2 rounded-full"></div>
        </div>

        <nav class="flex-1 space-y-3">
            @php $menus = [
                ['route' => 'pemerintah.dashboard', 'label' => 'Dashboard'],
                ['route' => 'pemerintah.monitoring', 'label' => 'Monitoring Sekolah'],
                ['route' => 'pemerintah.laporan', 'label' => 'Laporan Harian'],
                ['route' => 'pemerintah.keluhan', 'label' => 'Keluhan'],
                ['route' => 'pemerintah.menu', 'label' => 'Kelola Menu'],
                ['route' => 'pemerintah.sekolah', 'label' => 'Manajemen Sekolah'],
            ]; @endphp

            @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}"
               class="flex items-center px-8 py-3.5 rounded-full font-bold transition-all text-sm {{ Route::is($menu['route']) ? 'nav-active' : 'bg-white text-black hover:bg-gray-100' }}">
               {{ $menu['label'] }}
            </a>
            @endforeach
        </nav>

          <div class="mt-auto border-t border-white/10 pt-6">
            <p class="text-[10px] uppercase font-bold text-gray-400 px-4 mb-1">Pemerintah Kabupaten</p>
            <div class="flex items-center gap-2 px-4 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <p class="text-[10px] text-green-400 font-bold uppercase tracking-widest">SISTEM ONLINE</p>
            </div>
            <a href="{{ url('/') }}" class="block w-full text-center bg-white text-black py-3 rounded-2xl font-black text-xs hover:bg-red-600 hover:text-white transition-all shadow-lg uppercase">
                Keluar
            </a>
        </div>
    </aside>

    <main class="main-content p-8">

        <header class="flex justify-between items-center mb-8 bg-white p-6 rounded-[35px] shadow-sm">
            <div>
                <h1 class="text-2xl font-black text-[#1a4d2e]">Monitoring Sekolah</h1>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Status Laporan Real-Time</p>
            </div>

            <div class="flex gap-3">
                <input type="text" placeholder="Cari nama sekolah..." class="px-6 py-3 rounded-full border border-gray-100 text-xs focus:outline-none focus:ring-2 focus:ring-green-500 w-64 bg-gray-50 font-semibold">
                <button class="bg-[#1a4d2e] text-white px-8 py-3 rounded-full font-bold text-xs shadow-lg hover:bg-black transition uppercase tracking-widest">Filter Data</button>
            </div>
        </header>

        <div class="bg-white rounded-[40px] shadow-sm overflow-hidden border border-gray-50">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50 uppercase text-[10px] font-black text-gray-400 tracking-widest">
                        <th class="px-8 py-6">Nama Sekolah</th>
                        <th class="px-8 py-6">Wilayah/Kecamatan</th>
                        <th class="px-8 py-6">Jam Lapor</th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @php $data_sekolah = [
                        ['nama' => 'SDN Karawang Barat 01', 'kec' => 'Karawang Barat', 'jam' => '08:15', 'status' => 'TERKIRIM'],
                        ['nama' => 'SDN Nagasari 02', 'kec' => 'Karawang Barat', 'jam' => '09:00', 'status' => 'TERKIRIM'],
                        ['nama' => 'SDN Karawang Wetan 04', 'kec' => 'Karawang Timur', 'jam' => '-', 'status' => 'MENUNGGU'],
                        ['nama' => 'SDN Adiarsa Timur 01', 'kec' => 'Karawang Timur', 'jam' => '07:45', 'status' => 'TERKIRIM'],
                        ['nama' => 'SDN Telukjambe 03', 'kec' => 'Telukjambe Timur', 'jam' => '-', 'status' => 'MENUNGGU'],
                    ]; @endphp

                    @foreach($data_sekolah as $s)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-5 font-bold text-gray-800">{{ $s['nama'] }}</td>
                        <td class="px-8 py-5 text-gray-500 font-semibold">{{ $s['kec'] }}</td>
                        <td class="px-8 py-5 text-gray-500">{{ $s['jam'] }}</td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $s['status'] == 'TERKIRIM' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button onclick="bukaEdit('{{ $s['nama'] }}', '{{ $s['status'] }}')" class="text-[#1a4d2e] font-black text-[10px] hover:underline uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-full">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <div id="modalEdit" class="fixed inset-0 bg-black/60 z-[100] hidden items-center justify-center backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-[45px] p-10 shadow-2xl mx-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-xl font-black text-[#1a4d2e]">Edit Data Laporan</h2>
                <button onclick="tutupEdit()" class="text-gray-400 hover:text-black transition">✕</button>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-2">Nama Sekolah</label>
                    <input type="text" id="editNama" class="w-full bg-gray-50 border border-gray-100 px-6 py-4 rounded-2xl font-bold focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-2">Status Laporan</label>
                    <select id="editStatus" class="w-full bg-gray-50 border border-gray-100 px-6 py-4 rounded-2xl font-bold focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="TERKIRIM">TERKIRIM</option>
                        <option value="MENUNGGU">MENUNGGU</option>
                    </select>
                </div>
                <div class="pt-4 flex gap-3">
                    <button onclick="tutupEdit()" class="flex-1 py-4 rounded-2xl font-bold text-xs bg-gray-100 uppercase">Batal</button>
                    <button onclick="alert('Data Tersimpan!')" class="flex-1 py-4 rounded-2xl font-bold text-xs bg-black text-white uppercase tracking-widest shadow-lg">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bukaEdit(nama, status) {
            document.getElementById('modalEdit').classList.replace('hidden', 'flex');
            document.getElementById('editNama').value = nama;
            document.getElementById('editStatus').value = status;
        }
        function tutupEdit() {
            document.getElementById('modalEdit').classList.replace('flex', 'hidden');
        }
    </script>
</body>
</html>
