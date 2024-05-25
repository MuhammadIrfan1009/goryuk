<?php
session_start();
require "functions.php";

$loginError = false;

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $cariadmin = query("SELECT * FROM admin8 WHERE email8 = '$username' AND password8 = '$password'");
  $cariuser = query("SELECT * FROM user8 WHERE email8 = '$username' AND password8 = '$password'");

  if ($cariadmin) {
    // set session
    $_SESSION['username'] = $cariadmin[0]['nama8'];
    $_SESSION['role'] = "Admin";
    header("Location: admin/admin.php");
    exit;
  } else if ($cariuser) {
    // set session
    $_SESSION['email'] = $cariuser[0]['email8'];
    $_SESSION['id_user'] = $cariuser[0]['id_user8'];
    $_SESSION['role'] = "User";
    header("Location: index.php");
    exit;
  } else {
    $loginError = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; IdeKreatif</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css"/>
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="assets/css/styles.css"/>
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css"/>
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
</head>
<body>
    <?php if ($loginError): ?>
    <div class="toast-container position-absolute p-3" style="top: 0; right: 0;">
        <div id="loginErrorToast" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Username atau Password salah
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-uppercase fw-bolder">Login</span>
                            </a>
                        </div>
                        <h4 class="mb-2">Selamat datang di Goryuk!</h4>
                        <form class="mb-3" action="login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="username" placeholder="Enter your email" autofocus required/>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" name="password" placeholder="••••••••" aria-describedby="password" required/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" name="login">Masuk</button>
                            </div>
                        </form>
                        <p class="text-center">
                            <span>Belum punya akun?</span>
                            <a href="user/daftar.php"><span>Daftar</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    
</body>
</html>
