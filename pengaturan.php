<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan server Anda
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "pt_lawu"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel register
$result_register = $conn->query("SELECT * FROM register"); // Ganti 'register' dengan nama tabel yang sesuai

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-blue-600 p-6 text-center">
                <h1 class="text-3xl font-bold text-white">Pengaturan Akun</h1>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Username</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_register->num_rows > 0) {
                                $no = 1; // Inisialisasi nomor urut
                                while ($row = $result_register->fetch_assoc()) {
                                    echo "<tr class='border-b'>
                                            <td class='px-4 py-3'>{$no}</td>
                                            <td class='px-4 py-3'>{$row['username']}</td>
                                            <td class='px-4 py-3'>{$row['email']}</td>
                                            <td class='px-4 py-3'>{$row['password']}</td>
                                        </tr>";
                                    $no++; // Increment nomor urut
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center border-b'>Tidak ada data akun.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Tombol Kembali -->
    <div class="p-7">
        <a href="index.php" class="bg-gray-300 text-gray-800 rounded-lg px-4 py-2 hover:bg-gray-400 transition duration-300">Kembali</a>
    </div>
</body>
</html>
