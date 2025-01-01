<?php
// Menghapus status login dari localStorage
echo "<script>
    localStorage.removeItem('isLoggedIn'); // Menghapus status login
    window.location.href = 'login.php'; // Arahkan ke halaman login
</script>";
?>
