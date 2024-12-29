<?php
session_start(); // Memulai session
include 'db_connection.php'; // Menyertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if (empty($id)) {
        // Menyimpan data karyawan baru
        $stmt = $conn->prepare("INSERT INTO karyawan (nama, alamat, telepon) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $alamat, $telepon);
    } else {
        // Mengupdate data karyawan yang sudah ada
        $stmt = $conn->prepare("UPDATE karyawan SET nama=?, alamat=?, telepon=? WHERE id=?");
        $stmt->bind_param("sssi", $nama, $alamat, $telepon, $id);
    }

    if ($stmt->execute()) {
        // Menyimpan pesan notifikasi ke session
        $_SESSION['message'] = "Data karyawan berhasil disimpan!";

        // Memperbarui ID karyawan agar berurutan
        $conn->query("SET @count = 0;");
        $conn->query("UPDATE karyawan SET id = (@count := @count + 1) ORDER BY id;");

        // Redirect ke halaman input karyawan setelah berhasil
        header("Location: input_karyawan.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
