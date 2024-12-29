<?php
if (!file_exists('db_connection.php')) {
    die("File db_connect.php tidak ditemukan.");
	}
include 'db_connection.php'; // Menyertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password sebelum menyimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data pengguna ke database
    $stmt = $conn->prepare("INSERT INTO register (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        // Pendaftaran berhasil, arahkan ke halaman login
        header("Location: login.php");
        exit(); // Pastikan untuk menghentikan eksekusi skrip setelah pengalihan
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>