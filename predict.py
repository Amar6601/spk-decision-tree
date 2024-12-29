import sys
import joblib
import numpy as np

# Memuat model
model = joblib.load('decision_tree_model.pkl')

# Ambil input dari argumen
absensi = float(sys.argv[1])
pengetahuan = float(sys.argv[2])
disiplin = float(sys.argv[3])
perilaku = float(sys.argv[4])

# Buat array untuk prediksi
input_data = np.array([[absensi, pengetahuan, disiplin, perilaku]])

# Lakukan prediksi
prediction = model.predict(input_data)

# Cetak hasil prediksi
print(prediction[0])
