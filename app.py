from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

# Memuat model
model = joblib.load('decision_tree_model.pkl')

@app.route('/classify', methods=['POST'])
def classify():
    data = request.get_json()
    
    # Pastikan semua data yang diperlukan ada
    if not all(key in data for key in ['absensi', 'pengetahuan', 'disiplin', 'perilaku']):
        return jsonify({'error': 'Data tidak lengkap'}), 400

    absensi = data['absensi']
    pengetahuan = data['pengetahuan']
    disiplin = data['disiplin']
    perilaku = data['perilaku']

    # Buat array untuk prediksi
    input_data = np.array([[absensi, pengetahuan, disiplin, perilaku]])
    
    try:
        prediction = model.predict(input_data)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

    # Mengembalikan kategori sebagai respons
    return jsonify({'kategori': prediction[0]})

if __name__ == '__main__':
    app.run(port=5000)
