<?php
include 'db_connection.php'; // Menyertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    session_start(); // Pastikan session dimulai di awal
    $username_email = trim($_POST['username_email']);
    $password = $_POST['password'];

    // Mencari pengguna berdasarkan username atau email
    $stmt = $conn->prepare("SELECT id, password FROM register WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password (pastikan password di-hash saat pendaftaran)
        if (password_verify($password, $row['password'])) {
            // Login berhasil
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['isLoggedIn'] = true; // Tandai sebagai login
            header("Location: index.php"); // Arahkan ke halaman utama
            exit();
        } else {
            $_SESSION['error'] = "Password salah.";
        }
    } else {
        $_SESSION['error'] = "Pengguna tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();

    // Kembali ke login.php dengan error
    header("Location: login.php");
    exit();
}
?>