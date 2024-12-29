<?php
include 'db_connection.php'; // Menyertakan file koneksi

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus data karyawan dari database
    $stmt = $conn->prepare("DELETE FROM karyawan WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Memperbarui ID karyawan setelah penghapusan
        $conn->query("SET @count = 0;");
        $conn->query("UPDATE karyawan SET id = (@count := @count + 1) ORDER BY id;");

        // Redirect ke halaman daftar karyawan setelah berhasil
        header("Location: daftar_karyawan.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
