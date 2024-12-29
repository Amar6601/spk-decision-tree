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

// Ambil data akun
$result_akun = $conn->query("SELECT * FROM karyawan"); // Ganti 'akun' dengan nama tabel yang sesuai

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css" rel="stylesheet">
    <style>
        .notification {
            display: none; /* Sembunyikan notifikasi secara default */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="title has-text-centered">Daftar Karyawan</h2>
        
        <!-- Notifikasi -->
        <div id="notification" class="notification is-success">
            <button class="delete" onclick="closeNotification()"></button>
            Data karyawan berhasil disimpan!
        </div>

        <table class="table is-striped is-bordered is-fullwidth">
            <thead>
                <tr>
                    <th class="has-text-centered">ID</th>
                    <th class="has-text-centered">Nama</th>
                    <th class="has-text-centered">Alamat</th>
                    <th class="has-text-centered">Telepon</th>
                    <th class="has-text-centered">Aksi</th>
                </tr>
            </thead>
            <tbody id="karyawanTable">
                <?php
                if ($result_akun->num_rows > 0) {
                    while ($row = $result_akun->fetch_assoc()) {
                        echo "<tr id='row-{$row['id']}'>
                                <td class='has-text-centered'>{$row['id']}</td>
                                <td class='has-text-centered'>{$row['nama']}</td>
                                <td class='has-text-centered'>{$row['alamat']}</td>
                                <td class='has-text-centered'>{$row['telepon']}</td>
                                <td class='has-text-centered'>
                                    <button class='button is-info' onclick='openEditModal({$row['id']}, \"{$row['nama']}\", \"{$row['alamat']}\", \"{$row['telepon']}\")'>Edit</button>
                                    <a href='delete_karyawan.php?id={$row['id']}' class='button is-danger'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='has-text-centered'>Tidak ada data karyawan.</td></tr>";
                }

                $conn->close(); // Menutup koneksi
                ?>
            </tbody>
        </table>

        <!-- Tombol Kembali -->
        <div class="p-6 text-center">
            <a href="menu_daftar_karyawan.php" class="button is-light">Kembali</a>
        </div>
    </div>

    <!-- Modal untuk Edit Karyawan -->
    <div id="editModal" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <h2 class="title">Edit Karyawan</h2>
                <form id="editForm" onsubmit="return saveData(event)">
                    <input type="hidden" id="editId" name="id">
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input" type="text" id="editNama" name="nama" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Alamat</label>
                        <div class="control">
                            <input class="input" type="text" id="editAlamat" name="alamat">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Telepon</label>
                        <div class="control">
                            <input class="input" type="tel" id="editTelepon" name="telepon">
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-centered">
                        <div class="control">
                            <button type="submit" class="button is-success">Simpan</button>
                        </div>
                        <div class="control">
                            <button type="button" class="button" onclick="closeEditModal()">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" onclick="closeEditModal()"></button>
    </div>

    <script>
        function openEditModal(id, nama, alamat, telepon) {
            document.getElementById('editId').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editTelepon').value = telepon;
            document.getElementById('editModal').classList.add('is-active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('is-active');
        }

        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }

        function saveData(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            const id = document.getElementById('editId').value;
            const nama = document.getElementById('editNama').value;
            const alamat = document.getElementById('editAlamat').value;
            const telepon = document.getElementById('editTelepon').value;

            // Menggunakan Fetch API untuk mengirim data ke server
            fetch('input_karyawan_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&nama=${encodeURIComponent(nama)}&alamat=${encodeURIComponent(alamat)}&telepon=${encodeURIComponent(telepon)}`
            })
            .then(response => response.text())
            .then(data => {
                // Update tampilan tabel
                document.getElementById(`row-${id}`).innerHTML = `
                    <td class='has-text-centered'>${id}</td>
                    <td class='has-text-centered'>${nama}</td>
                    <td class='has-text-centered'>${alamat}</td>
                    <td class='has-text-centered'>${telepon}</td>
                    <td class='has-text-centered'>
                        <button class='button is-info' onclick='openEditModal(${id}, "${nama}", "${alamat}", "${telepon}")'>Edit</button>
                        <a href='delete_karyawan.php?id=${id}' class='button is-danger'>Hapus</a>
                    </td>
                `;
                // Tampilkan notifikasi
                document.getElementById('notification').style.display = 'block';
                closeEditModal(); // Tutup modal setelah menyimpan
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
