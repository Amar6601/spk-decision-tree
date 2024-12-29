<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama - Karyawan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }
        .menu-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6 text-center">
            <h1 class="text-3xl font-bold text-black">Sistem Manajemen Karyawan</h1>
            <p class="text-black mt-2">Selamat Datang di Aplikasi Penunjang Keputusan</p>
        </div>
		

        <div class="p-8 grid grid-cols-1 gap-6">
            <a href="input_karyawan.php" class="menu-item bg-blue-100 rounded-xl p-6 text-center hover:bg-blue-200 transition duration-300">
                <h3 class="font-semibold text-blue-800">Input Data Karyawan</h3>
            </a>
            
            <a href="daftar_karyawan.php" class="menu-item bg-green-100 rounded-xl p-6 text-center hover:bg-green-200 transition duration-300">
                <h3 class="font-semibold text-green-800">Daftar Data Karyawan</h3>
            </a>
			<!-- Tombol Kembali -->
        <div class="p-6 text-center">
            <a href="index.php" class="bg-gray-300 text-gray-800 rounded-lg px-4 py-2 hover:bg-gray-400 transition duration-300">Kembali</a>
        </div>
    </div>
        </div>
    </div>
	
</body>
</html>
