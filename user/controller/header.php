<nav class="navbar navbar-example navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../img/logo.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-2" aria-controls="navbar-ex-2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-ex-2">
      <div class="navbar-nav me-auto">
        <a class="nav-item nav-link " href="../index.php#home">Home</a>
        <a class="nav-item nav-link" href="../index.php#about">About</a>
        <a class="nav-item nav-link" href="../index.php#bayar">Tata Cara</a>
        <?php
        if (isset($_SESSION['id_user'])) {
          echo '
        <a class="nav-item nav-link " href="lapangan.php">Lapangan</a>
        <a class="nav-item nav-link" href="bayar.php">Pembayaran</a>
        ';
        }
        ?>
        <a class="nav-item nav-link" href="../index.php#contact">Kontak</a>
      </div>
    </div>
  </div>
</nav>