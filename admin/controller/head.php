<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../img/logo.png"/>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/css/dataTables.bootstrap5.min.css">

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>

  <!-- Template customizer & Theme config files -->
  <script src="../assets/js/config.js"></script>
 
  <style>
    .layout-menu {
      position: fixed;
      top: 0;
      height: 100%;
      width: 250px; /* Adjust the width as per your design */
    }
    /* Adjust the layout to accommodate fixed menu */
    .layout-page {
      margin-left: 250px; /* Same as the width of the menu */
    }
    .footer {
      position: fixed;
      bottom: 0;
      left: 250px; /* Same as the width of the menu */
      width: calc(100% - 250px); /* Adjust width to not overlap with menu */
      background-color: #f8f9fa;
      padding: 10px;
      text-align: center;
    }
  </style>

  <title>Admin Goryuk</title>
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="../users/dashboard.php" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase"><?= $_SESSION["username"]; ?></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>
      <div class="menu-inner-shadow"></div>
      <ul class="menu-inner py-1">
        <!-- Home -->
        <li class="menu-item">
          <a href="home.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Home">Home</div>
          </a>
        </li>
        <!-- Data Member -->
        <li class="menu-item">
          <a href="member.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Data Member">Data Member</div>
          </a>
        </li>
        <!-- Data Lapangan -->
        <li class="menu-item">
          <a href="lapangan.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-map"></i>
            <div data-i18n="Data Lapangan">Data Lapangan</div>
          </a>
        </li>
        <!-- Data Pesanan -->
        <li class="menu-item">
          <a href="pesan.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-message"></i>
            <div data-i18n="Data Pesanan">Data Pesanan</div>
          </a>
        </li>
        <!-- Data Admin -->
        <li class="menu-item">
          <a href="admin.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Data Admin">Data Admin</div>
          </a>
        </li>
  
        <li class="menu-item">
          <a href="backstore.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-save"></i>
            <div data-i18n="Data Pesanan">Backup/Restore</div>
          </a>
        </li>

        <li class="menu-item">
          <a  href="../logout.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-exit"></i>
            <div data-i18n="Data Admin">Logout</div>
          </a>
        </li>
      </ul>
     
    </aside>