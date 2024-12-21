<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login Rapi</title>
    <!-- Import Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap" rel="stylesheet">
    <style>
    /* Global Styles */
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #F5F2EB;

        font-family: 'Poppins', sans-serif;
        /* Font Poppins */
    }

    /* Container Styles */
    .login-container {
        width: 360px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 24px;
        box-sizing: border-box;
    }

    /* Title Styles */
    h2 {
        font-size: 40px;
        font-weight: 900;
        /* Bold */
        text-align: center;
        color: #000000;
        /* Hitam */
        margin-bottom: 1.5rem;
    }

    /* Form Styles */
    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-group input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: border-color 0.3s ease, background-color 0.3s ease;
        box-sizing: border-box;
    }

    .input-group input:focus {
        border-color: #c3ad8d;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(195, 173, 141, 0.5);
    }

    .input-group span {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #aaa;
    }

    /* Button Styles */
    .login-button {
        width: 100%;
        padding: 12px;
        background-color: #E3CAA5;

        color: #000;
        /* Warna hitam untuk teks */
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-family: 'Poppins', sans-serif;
        /* Tambahkan ini */
    }

    .login-button:hover {
        background-color: #b39979;
    }

    /* Link Styles */
    p {
        margin-top: 1rem;
        text-align: center;
        font-size: 0.875rem;
        color: #555;
    }

    p a {
        color: #000;
        /* Warna hitam */
        font-weight: bold;
        /* Bold */
        text-decoration: none;
        transition: color 0.3s ease;
    }

    p a:hover {
        color: #333;
    }

    /* Checkbox Styles */
    .remember-me {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .remember-me input {
        margin-right: 8px;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Masuk</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            <div class="input-group">
                <span>📧</span>
                <input type="email" name="email" id="email" placeholder="Email" required autofocus />
            </div>
            <!-- Password -->
            <div class="input-group">
                <span>🔒</span>
                <input type="password" name="password" id="password" placeholder="Kata sandi" required />
            </div>
            <!-- Remember Me -->
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" />
                <label for="remember">Ingat saya</label>
            </div>
            <!-- Login Button -->
            <button type="submit" class="login-button">Masuk</button>
        </form>
        <!-- Link Registrasi -->
        <p>
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar, yuk!</a>
        </p>
    </div>
</body>

</html>