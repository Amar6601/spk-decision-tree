<?php
include 'db_connection.php'; // Menyertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username_email = $_POST['username_email'];
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
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php"); // Arahkan ke halaman dashboard
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Pengguna tidak ditemukan.";
    }

    $stmt->close();
}
$conn->close();
?>
