<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama - Penilaian Karyawan</title>
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
     <script>
        // Memeriksa status login saat halaman ini diakses
        window.onload = function() {
            const isLoggedIn = localStorage.getItem('isLoggedIn'); // Cek status login

            if (isLoggedIn !== 'true') {
                window.location.href = 'login.php'; // Arahkan ke halaman login jika belum login
            }
        };
    </script>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6 text-center">
            <h1 class="text-4xl font-bold text-black">Sistem Penilaian Karyawan</h1>
            <p class="text-black mt-2">Selamat Datang di Aplikasi Penunjang Keputusan</p>
        </div>
        
        <div class="p-8 grid grid-cols-2 md:grid-cols-3 gap-6">
            <a href="penilaian.php" class="menu-item bg-blue-100 rounded-xl p-6 text-center hover:bg-blue-200 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <h3 class="font-semibold text-blue-800">Penilaian Karyawan</h3>
            </a>
            
            <a href="menu_daftar_karyawan.php" class="menu-item bg-green-100 rounded-xl p-6 text-center hover:bg-green-200 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="font-semibold text-green-800">Data Karyawan</h3>
            </a>
            
            <a href="laporan.php" class="menu-item bg-purple-100 rounded-xl p-6 text-center hover:bg-purple-200 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-purple-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="font-semibold text-purple-800">Laporan</h3>
            </a>
            
            <a href="pengaturan.php" class="menu-item bg-red-100 rounded-xl p-6 text-center hover:bg-red-200 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                </svg>
                <h3 class="font-semibold text-red-800">Pengaturan Akun</h3>
            </a>
            
            <a href="login.php" class="menu-item bg-gray-100 rounded-xl p-6 text-center hover:bg-gray-200 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <h3 class="font-semibold text-gray-800">Keluar</h3>
            </a>
        </div>

        
</body>
</html>
