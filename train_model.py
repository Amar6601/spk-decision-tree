import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib  # Impor joblib secara langsung

# Contoh data
data = {
    'absensi': [90, 70, 50, 30],
    'pengetahuan': [85, 60, 55, 40],
    'disiplin': [80, 65, 60, 35],
    'perilaku': [75, 70, 50, 20],
    'kategori': ['Sangat Baik', 'Baik', 'Cukup', 'Buruk']
}

# Membuat DataFrame
df = pd.DataFrame(data)

# Mengubah kategori menjadi numerik
df['kategori'] = df['kategori'].astype('category').cat.codes

# Memisahkan fitur dan label
X = df[['absensi', 'pengetahuan', 'disiplin', 'perilaku']]
y = df['kategori']

# Membuat model Decision Tree
model = DecisionTreeClassifier(criterion='entropy')  # 'entropy' untuk C4.5
model.fit(X, y)

# Menyimpan model ke file
joblib.dump(model, 'decision_tree_model.pkl')
