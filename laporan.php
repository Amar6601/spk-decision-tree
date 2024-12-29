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

// Ambil data karyawan
$result_karyawan = $conn->query("SELECT * FROM karyawan");
$result_penilaian = $conn->query("SELECT * FROM penilaian_karyawan");

// Ambil karyawan terbaik
$best_employee_result = $conn->query("SELECT * FROM penilaian_karyawan ORDER BY nilai_akhir DESC LIMIT 1");
$best_employee = $best_employee_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Laporan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script>
        function printReport(reportId) {
            const printContent = document.getElementById(reportId).innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // Reload the page to restore original content
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-blue-600 p-6 text-center">
                <h1 class="text-3xl font-bold text-white">Menu Laporan</h1>
            </div>

            <div class="p-6">
                <ul class="space-y-4">
                    <li>
                        <a href="#daftar-karyawan" class="block p-4 bg-blue-100 rounded-lg hover:bg-blue-200">Laporan Daftar Karyawan</a>
                    </li>
                    <li>
                        <a href="#penilaian-karyawan" class="block p-4 bg-blue-100 rounded-lg hover:bg-blue-200">Laporan Penilaian Karyawan</a>
                    </li>
                    <li>
                        <a href="#karyawan-terbaik" class="block p-4 bg-blue-100 rounded-lg hover:bg-blue-200">Laporan Karyawan Terbaik</a>
                    </li>
                    <li>
                        <a href="#bobot-kriteria" class="block p-4 bg-blue-100 rounded-lg hover:bg-blue-200">Laporan Bobot Kriteria</a>
                    </li>
                </ul>

                <div id="daftar-karyawan" class="mt-8">
                    <h2 class="text-xl font-bold">Laporan Daftar Karyawan</h2>
                    <button onclick="printReport('daftar-karyawan')" class="mt-2 bg-green-500 text-white rounded-lg px-4 py-2">Cetak</button>
                    <table class="w-full mt-4">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Alamat</th>
                                <th class="px-4 py-3 text-left">Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_karyawan->num_rows > 0) {
                                $no = 1; // Inisialisasi nomor urut
                                while ($row = $result_karyawan->fetch_assoc()) {
                                    echo "<tr class='border-b'>
                                            <td class='px-4 py-3'>{$no}</td>
                                            <td class='px-4 py-3'>{$row['nama']}</td>
                                            <td class='px-4 py-3'>{$row['alamat']}</td>
                                            <td class='px-4 py-3'>{$row['telepon']}</td>
                                        </tr>";
                                    $no++; // Increment nomor urut
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center border-b'>Tidak ada data karyawan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="penilaian-karyawan" class="mt-8">
                    <h2 class="text-xl font-bold">Laporan Penilaian Karyawan</h2>
                    <button onclick="printReport('penilaian-karyawan')" class="mt-2 bg-green-500 text-white rounded-lg px-4 py-2">Cetak</button>
                    <table class="w-full mt-4">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-center">Absensi (%)</th>
                                <th class="px-4 py-3 text-center">Pengetahuan (%)</th>
                                <th class="px-4 py-3 text-center">Disiplin (%)</th>
                                <th class="px-4 py-3 text-center">Perilaku (%)</th>
                                <th class="px-4 py-3 text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_penilaian->num_rows > 0) {
                                $no = 1; // Inisialisasi nomor urut
                                while ($row = $result_penilaian->fetch_assoc()) {
                                    echo "<tr class='border-b'>
                                            <td class='px-4 py-3'>{$no}</td>
                                            <td class='px-4 py-3'>{$row['nama']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['absensi']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['pengetahuan']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['disiplin']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['perilaku']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['nilai_akhir']}</td>
                                        </tr>";
                                    $no++; // Increment nomor urut
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center border-b'>Tidak ada data penilaian karyawan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="karyawan-terbaik" class="mt-8">
                    <h2 class="text-xl font-bold">Laporan Karyawan Terbaik</h2>
                    <button onclick="printReport('karyawan-terbaik')" class="mt-2 bg-green-500 text-white rounded-lg px-4 py-2">Cetak</button>
                    <?php if ($best_employee): ?>
                        <p>Nama: <?php echo $best_employee['nama']; ?></p>
                        <p>Nilai Akhir: <?php echo number_format($best_employee['nilai_akhir'], 2); ?></p>
                    <?php else: ?>
                        <p>Tidak ada data karyawan terbaik.</p>
                    <?php endif; ?>
                </div>

                <div id="bobot-kriteria" class="mt-8">
                    <h2 class="text-xl font-bold">Laporan Bobot Kriteria</h2>
                    <button onclick="printReport('bobot-kriteria')" class="mt-2 bg-green-500 text-white rounded-lg px-4 py-2">Cetak</button>
                    <ul>
                        <li>Absensi: 40%</li>
                        <li>Pengetahuan: 30%</li>
                        <li>Disiplin: 20%</li>
                        <li>Perilaku: 10%</li>
                    </ul>
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
