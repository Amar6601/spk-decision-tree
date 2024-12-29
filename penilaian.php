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

// Fungsi untuk mengklasifikasikan karyawan berdasarkan nilai akhir menggunakan API Decision Tree
function classifyEmployee($absensi, $pengetahuan, $disiplin, $perilaku) {
    $data = [
        'absensi' => $absensi,
        'pengetahuan' => $pengetahuan,
        'disiplin' => $disiplin,
        'perilaku' => $perilaku
    ];

    $ch = curl_init('http://localhost:5000/classify'); // Ganti dengan URL API Anda
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    // Cek apakah ada kesalahan dalam permintaan curl
    if ($response === false) {
        die('Curl error: ' . curl_error($ch));
    }

    // Debugging: Tampilkan respons API
    echo "<pre>Respons API: " . htmlspecialchars($response) . "</pre>"; // Menampilkan respons API

    $responseData = json_decode($response, true);
    
    // Debugging: Tampilkan data yang diterima
    if (isset($responseData['kategori'])) {
        return $responseData['kategori'];
    } else {
        // Jika kategori tidak ada, Anda bisa mengembalikan nilai default
        echo "<pre>Respons API tidak mengandung kategori: " . json_encode($responseData) . "</pre>";
        return 'Belum Ditetapkan'; // Atau nilai lain yang sesuai
    }
}

// Fungsi untuk menghitung nilai akhir
function calculateFinalScore($absensi, $pengetahuan, $disiplin, $perilaku) {
    return ($absensi * 0.4) + ($pengetahuan * 0.3) + ($disiplin * 0.2) + ($perilaku * 0.1);
}

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $absensi = $_POST['absensi'] ?? 0;
    $pengetahuan = $_POST['pengetahuan'] ?? 0;
    $disiplin = $_POST['disiplin'] ?? 0;
    $perilaku = $_POST['perilaku'] ?? 0;

    // Sanitasi input
    $nama = $conn->real_escape_string($nama);
    $absensi = (float)$absensi;
    $pengetahuan = (float)$pengetahuan;
    $disiplin = (float)$disiplin;
    $perilaku = (float)$perilaku;

    // Hitung nilai akhir
    $nilai_akhir = calculateFinalScore($absensi, $pengetahuan, $disiplin, $perilaku);

    // Klasifikasi menggunakan Decision Tree
    $kategori = classifyEmployee($absensi, $pengetahuan, $disiplin, $perilaku);

    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Proses edit
        $id = (int)$_POST['id'];

        $sql = "UPDATE penilaian_karyawan SET nama=?, absensi=?, pengetahuan=?, disiplin=?, perilaku=?, nilai_akhir=?, kategori=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddddssi", $nama, $absensi, $pengetahuan, $disiplin, $perilaku, $nilai_akhir, $kategori, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Data karyawan berhasil diperbarui!');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // Proses simpan
        $sql = "INSERT INTO penilaian_karyawan (nama, absensi, pengetahuan, disiplin, perilaku, nilai_akhir, kategori) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddddss", $nama, $absensi, $pengetahuan, $disiplin, $perilaku, $nilai_akhir, $kategori);

        if ($stmt->execute()) {
            echo "<script>alert('Data karyawan berhasil disimpan!');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Proses hapus
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM penilaian_karyawan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data karyawan berhasil dihapus!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Ambil data karyawan
$result_karyawan = $conn->query("SELECT * FROM karyawan");
$result_penilaian = $conn->query("SELECT * FROM penilaian_karyawan");

// Ambil karyawan terbaik
$best_employee_result = $conn->query("SELECT * FROM penilaian_karyawan ORDER BY nilai_akhir DESC LIMIT 1");
$best_employee = $best_employee_result->fetch_assoc();

// Fetch employee data for editing
$edit_employee = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM penilaian_karyawan WHERE id='$edit_id'");
    $edit_employee = $edit_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Karyawan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-blue-600 p-6 text-center">
                <h1 class="text-3xl font-bold text-white">Penilaian Karyawan</h1>
            </div>

            <div class="p-6">
                <?php if ($best_employee): ?>
                    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500">
                        <p class="font-bold">Karyawan Terbaik:</p>
                        <p>Nama: <?php echo htmlspecialchars($best_employee['nama']); ?></p>
                        <p>Nilai Akhir: <?php echo number_format($best_employee['nilai_akhir'], 2); ?></p>
                        <p>Kategori: <?php echo isset($best_employee['kategori']) ? htmlspecialchars($best_employee['kategori']) : 'Belum Ditetapkan'; ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" class="mb-6">
                    <input type="hidden" name="id" value="<?php echo $edit_employee['id'] ?? ''; ?>">
                    <input type="hidden" name="action" value="<?php echo $edit_employee ? 'edit' : 'save'; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Nama Karyawan</label>
                            <select name="nama" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                <option value="">Pilih Karyawan</option>
                                <?php
                                if ($result_karyawan->num_rows > 0) {
                                    while ($row = $result_karyawan->fetch_assoc()) {
                                        $selected = ($edit_employee && $edit_employee['nama'] == $row['nama']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['nama']) . "' $selected>" . htmlspecialchars($row['nama']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada karyawan</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700">Absensi (%)</label>
                            <input type="number" name="absensi" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo $edit_employee['absensi'] ?? ''; ?>" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Pengetahuan (%)</label>
                            <input type="number" name="pengetahuan" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo $edit_employee['pengetahuan'] ?? ''; ?>" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Disiplin (%)</label>
                            <input type="number" name="disiplin" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo $edit_employee['disiplin'] ?? ''; ?>" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Perilaku (%)</label>
                            <input type="number" name="perilaku" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo $edit_employee['perilaku'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-500 text-white rounded-lg px-4 py-2">Simpan</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-center">Absensi (%)</th>
                                <th class="px-4 py-3 text-center">Pengetahuan (%)</th>
                                <th class="px-4 py-3 text-center">Disiplin (%)</th>
                                <th class="px-4 py-3 text-center">Perilaku (%)</th>
                                <th class="px-4 py-3 text-center">Nilai Akhir</th>
                                <th class="px-4 py-3 text-center">Kategori</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_penilaian->num_rows > 0) {
                                $no = 1; // Inisialisasi nomor urut
                                while ($row = $result_penilaian->fetch_assoc()) {
                                    echo "<tr class='border-b'>
                                            <td class='px-4 py-3'>{$no}</td>
                                            <td class='px-4 py-3'>" . htmlspecialchars($row['nama']) . "</td>
                                            <td class='px-4 py-3 text-center'>{$row['absensi']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['pengetahuan']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['disiplin']}</td>
                                            <td class='px-4 py-3 text-center'>{$row['perilaku']}</td>
                                            <td class='px-4 py-3 text-center'>" . number_format($row['nilai_akhir'], 2) . "</td>
                                            <td class='px-4 py-3 text-center'>" . (isset($row['kategori']) ? htmlspecialchars($row['kategori']) : 'Belum Ditetapkan') . "</td>
                                            <td class='px-4 py-3 text-center'>
                                                <a href='?edit={$row['id']}' class='text-blue-500'>Edit</a> | 
                                                <a href='?delete={$row['id']}' class='text-red-500' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Delete</a>
                                            </td>
                                        </tr>";
                                    $no++; // Increment nomor urut
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center border-b'>Tidak ada data karyawan.</td></tr>";
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
