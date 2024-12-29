<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 w-96">
        <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Input Karyawan</h1>

        <?php
        session_start(); // Memulai session
        if (isset($_SESSION['message'])) {
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong class='font-bold'>Success!</strong>
                    <span class='block sm:inline'>{$_SESSION['message']}</span>
                  </div>";
            unset($_SESSION['message']); // Menghapus pesan setelah ditampilkan
        }
        ?>

        <form action="input_karyawan_process.php" method="POST">
            <input type="hidden" id="id" name="id" value="">
            <label for="nama" class="block text-gray-700 mb-2">Nama:</label>
            <input type="text" id="nama" name="nama" required class="border border-gray-300 rounded-lg p-2 w-full mb-4">

            <label for="alamat" class="block text-gray-700 mb-2">Alamat:</label>
            <input type="text" id="alamat" name="alamat" class="border border-gray-300 rounded-lg p-2 w-full mb-4">

            <label for="telepon" class="block text-gray-700 mb-2">Telepon:</label>
            <input type="tel" id="telepon" name="telepon" class="border border-gray-300 rounded-lg p-2 w-full mb-4">

            <button type="submit" class="bg-green-500 text-white rounded-lg py-2 hover:bg-green-600 w-full">Simpan Karyawan</button>
        </form>
		<!-- Tombol Kembali -->
        <div class="p-6 text-center">
            <a href="menu_daftar_karyawan.php" class="bg-gray-300 text-gray-800 rounded-lg px-4 py-2 hover:bg-gray-400 transition duration-300">Kembali</a>
        </div>
    </div>
    </div>
	

    <script>
        function editKaryawan(id, nama, alamat, telepon) {
            document.getElementById('id').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('alamat').value = alamat;
            document.getElementById('telepon').value = telepon;
        }
    </script>
	
</body>
</html>
