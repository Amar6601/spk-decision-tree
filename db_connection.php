<?php
$servername = "localhost"; // Nama server
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "pt_lawu"; // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
