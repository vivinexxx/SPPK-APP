import joblib

# Memuat model
model = joblib.load('model.pkl')

# Prediksi menggunakan model
# Pastikan input sesuai dengan fitur yang digunakan saat pelatihan
input_data = [[20.36, 8776, 8.36]]  # Pisahkan dengan koma, gunakan float untuk angka desimal

# Pastikan fitur kategorikal telah diencode, contoh dengan label encoding atau one-hot encoding
# Jika model Anda memerlukan preprocessing, pastikan Anda melakukannya sebelum prediksi

prediction = model.predict(input_data)

print(f"Hasil prediksi: {prediction}")
