<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        /* Reset body margin dan padding */
        body {
            margin: 0;
            padding: 0;
            background-color: #0000;
            /* Warna cokelat tua untuk latar belakang */
            background-image: url('./image/bg.png');
            /* Pastikan file gambar tersedia di folder */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            /* Pusatkan konten secara vertikal */
            justify-content: center;
            /* Pusatkan konten secara horizontal */
            font-family: 'Georgia', serif;
            /* Font elegan */
            color: #F5F5DC;
            /* Warna beige untuk teks */
        }


        /* Style untuk container */
        .container {
            background: rgba(255, 245, 220, 0.9);
            /* Warna latar beige semi transparan */
            padding: 30px 50px;
            border-radius: 15px;
            max-width: 700px;
            text-align: justify;
            /* Rata kanan-kiri */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            /* Bayangan */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #8B4513;
            /* Warna cokelat tua untuk judul */
        }

        h3 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.7em;
            color: #8B4513;
        }

        p {
            line-height: 1.8;
            /* Jarak antar baris lebih nyaman dibaca */
            margin-bottom: 20px;
            color: #4E3629;
            /* Warna teks cokelat gelap */
        }

        a {
            color: #8B4513;
            /* Warna cokelat tua untuk link */
            text-decoration: none;
            font-weight: bold;
            border: 2px solid #8B4513;
            /* Tambahkan border */
            padding: 5px 15px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        a:hover {
            background-color: #8B4513;
            /* Warna cokelat tua saat hover */
            color: #F5F5DC;
            /* Warna beige untuk teks */
            text-decoration: none;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .welcome {
            text-align: center;
            font-style: italic;
            color: #4E3629;
        }
    </style>
</head>

<body>
    <div class="overlay"></div> <!-- Overlay gelap untuk latar -->
    <div class="container">
        <h1>Selamat Datang</h1>
        <h3>Di Sistem Pengambilan Keputusan untuk Kebijakan Bantuan Daerah Berdasarkan Status Kemiskinan</h3>
        <p>
            SPPK Kemiskinan adalah platform web yang menyediakan data dan analisis kemiskinan di Indonesia.
            Platform ini dirancang untuk membantu kebijakan tepat sasaran dengan visualisasi dan laporan wilayah
            termiskin,
            mendukung pengambilan keputusan yang lebih baik.
        </p>
        <div class="links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register')}}">Register</a>
        </div>
    </div>
</body>

</html>