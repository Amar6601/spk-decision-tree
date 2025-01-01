from flask import Flask, jsonify, request

app = Flask(__name__)

def tentukan_kategori(nilai_akhir):
    if nilai_akhir >= 85:
        return "Sangat Baik"
    elif nilai_akhir >= 70:
        return "Baik"
    elif nilai_akhir >= 50:
        return "Cukup"
    else:
        return "Kurang"

@app.route('/classify', methods=['POST'])
def classify():
    data = request.get_json()
    
    if not all(key in data for key in ['absensi', 'pengetahuan', 'disiplin', 'perilaku']):
        return jsonify({'error': 'Data tidak lengkap'}), 400

    # Hitung nilai akhir
    nilai_akhir = calculateFinalScore(data['absensi'], data['pengetahuan'], data['disiplin'], data['perilaku'])
    kategori = tentukan_kategori(nilai_akhir)

    return jsonify({'kategori': kategori})

def calculateFinalScore(absensi, pengetahuan, disiplin, perilaku):
    return (absensi * 0.4) + (pengetahuan * 0.3) + (disiplin * 0.2) + (perilaku * 0.1)

if __name__ == '__main__':
    app.run(port=5000)
