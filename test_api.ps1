# Data yang akan dikirim
$data = @{
    absensi = 70
    pengetahuan = 90
    disiplin = 80
    perilaku = 50
}

# Mengonversi data ke format JSON
$jsonData = $data | ConvertTo-Json

# Mengirim permintaan POST
$response = Invoke-WebRequest -Uri "http://localhost:5000/classify" -Method POST -Body $jsonData -ContentType "application/json"

# Menampilkan respons
$response.Content
