<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(Gambar/background.jpg); /* Ganti dengan nama file gambar Anda */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .container {
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang sedikit transparan */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: 1s ease-out 0s 1 slideIn;
        }

        .container.fadeOut {
            animation: 1s ease-in 0s 1 slideOut;
        }

        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form label {
            color: #555;
            margin-bottom: 5px;
        }

        .container form input[type="text"], 
        .container form input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .container form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .container form button[type="submit"]:hover {
            background-color: #45a049;
        }

        .register-link, .forgot-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a, .forgot-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .register-link a:hover, .forgot-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container animate__animated">
        <h1>Login</h1>
        <form action="authenticate.php" method="POST" onsubmit="return handleFormSubmit(event)">
            <input type="hidden" name="action" value="login">
            <label for="username_email">Username atau Email:</label>
            <input type="text" id="username_email" name="username_email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <div class="forgot-link">
            <a href="forgot_account.php">Lupa akun?</a>
        </div>
        <div class="register-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form

            // Simulasi login (ganti dengan logika autentikasi yang sesuai)
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Cek username dan password (ganti dengan logika yang sesuai)
            if (username === 'admin' && password === 'password') {
                localStorage.setItem('isLoggedIn', 'true'); // Set status login
                window.location.href = 'index.php'; // Arahkan ke halaman utama
            } else {
                alert('Username atau password salah!');
            }
        });

        function handleFormSubmit(event) {
            if (validateForm()) {
                event.preventDefault();
                var container = document.querySelector('.container');
                container.classList.add('fadeOut');
                setTimeout(() => {
                    event.target.submit();
                }, 1000); // Durasi animasi sesuai dengan slideOut
            } else {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
