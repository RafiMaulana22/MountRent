<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: ../index.php?page=dashboard');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Login Admin - MountRent
    </title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {

            min-height: 100vh;

            background:
                linear-gradient(rgba(0, 0, 0, 0.65),
                    rgba(0, 0, 0, 0.65)),
                url('../uploads/hero.jpg');

            background-size: cover;
            background-position: center;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .login-card {

            width: 100%;
            max-width: 450px;

            background: rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, 0.12);

            border-radius: 30px;

            padding: 45px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.25);

            color: white;
        }

        .brand-icon {

            width: 90px;
            height: 90px;

            background: rgba(255, 255, 255, 0.12);

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 24px;

            margin: auto;
            margin-bottom: 25px;

            font-size: 42px;
        }

        .login-title {

            font-size: 34px;
            font-weight: 700;
        }

        .login-subtitle {

            color: #d1d5db;
            font-size: 15px;
        }

        .form-label {

            font-weight: 500;
            margin-bottom: 10px;
        }

        .input-group {

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.12);

            border-radius: 16px;

            overflow: hidden;
        }

        .input-group-text {

            background: transparent;
            border: none;

            color: #d1d5db;

            padding-left: 18px;
        }

        .form-control {

            background: transparent;
            border: none;

            color: white;

            padding: 14px;
        }

        .form-control:focus {

            background: transparent;

            color: white;

            box-shadow: none;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-login {

            background: #16a34a;
            border: none;

            padding: 14px;

            border-radius: 16px;

            font-weight: 600;

            transition: 0.3s;
        }

        .btn-login:hover {

            background: #15803d;

            transform: translateY(-2px);
        }

        .alert {

            border-radius: 16px;

            border: none;
        }

        .back-link {

            color: #d1d5db;

            text-decoration: none;

            transition: 0.3s;
        }

        .back-link:hover {
            color: white;
        }
    </style>

</head>

<body>

    <div class="login-card">

        <!-- BRAND -->

        <div class="text-center mb-4">

            <div class="brand-icon">

                <i class="bi bi-backpack2-fill"></i>

            </div>

            <h1 class="login-title mb-2">

                MountRent

            </h1>

            <p class="login-subtitle mb-0">

                Login admin untuk mengelola
                rental perlengkapan mendaki.

            </p>

        </div>

        <!-- ALERT -->

        <?php if (isset($_GET['pesan'])) : ?>

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle-fill"></i>
            Username atau password salah.

        </div>

        <?php endif; ?>

        <!-- FORM -->

        <form action="proses_login.php" method="POST">

            <!-- USERNAME -->

            <div class="mb-4">

                <label class="form-label">

                    Username

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-fill"></i>

                    </span>

                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="mb-4">

                <label class="form-label">

                    Password

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Masukkan password" required>

                    <!-- TOGGLE -->

                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                        <i class="bi bi-eye-fill" id="toggleIcon"></i>
                    </span>

                </div>

            </div>

            <!-- BUTTON -->

            <button type="submit" class="btn btn-login text-white w-100 mb-4">
                <i class="bi bi-box-arrow-in-right"></i>
                Login Admin
            </button>

        </form>

        <!-- BACK -->

        <div class="text-center">

            <a href="../landing/index.php" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Landing Page
            </a>

        </div>

    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');

        const password = document.getElementById('password');

        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {

            const type =
                password.getAttribute('type') === 'password' ?
                'text' :
                'password';

            password.setAttribute('type', type);

            // GANTI ICON

            if (type === 'text') {

                toggleIcon.classList.remove('bi-eye-fill');

                toggleIcon.classList.add('bi-eye-slash-fill');

            } else {

                toggleIcon.classList.remove('bi-eye-slash-fill');

                toggleIcon.classList.add('bi-eye-fill');
            }

        });
    </script>
</body>

</html>
