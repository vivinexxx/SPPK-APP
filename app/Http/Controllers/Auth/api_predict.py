from flask import Flask, request, jsonify
import joblib
import os

app = Flask(__name__)

# Load model

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(BASE_DIR, '..', '..', '..', 'Models', 'model.pkl')
model = joblib.load(model_path)


@app.route('/')
def home():
    return "API is running. Use POST /predict for predictions."

@app.route('/predict', methods=['POST'])
def predict():
    # Ambil data dari request
    data = request.get_json()
    presentase_pm = float(data['presentase_pm'])
    pengeluaran = float(data['pengeluaran_perkapita'])
    pengangguran = float(data['tingkat_pengangguran'])


    # Prediksi klasifikasi (sesuai input model)
    prediction = model.predict([[presentase_pm, pengeluaran, pengangguran]])
    result = 'Tidak Miskin' if prediction[0] == 1 else 'Miskin'

    return jsonify({'klasifikasi_kemiskinan': result})

if __name__ == '__main__':
    app.run(debug=True)