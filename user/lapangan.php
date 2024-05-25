<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
  header("location:../login.php");
}

$id = $_SESSION["id_user"];

$lapangan = query("SELECT * FROM lapangan8");
$profil = query("SELECT * FROM user8 WHERE id_user8 = '$id'")[0];



if (isset($_POST["pesan"])) {
  $result = pesan($_POST);
  if ($result === true) {
    echo "<script>
          alert('Berhasil Dipesan');
          document.location.href = 'bayar.php';
          </script>";
  } else {
    echo "<script>
          alert('$result');
          </script>";
  }
}



?>

<!doctype html>
<html lang="en">

<head>
<?php include 'controller/link.php';?>

  <style>
    .footer {
      text-align: center;
      padding: 20px 0;
    }

    .nav {
      position: absolute;
    }
    #lapangan {
      margin-top: 135px;
    }
  </style>
</head>

<body>
<?php include 'controller/header.php';?>
<section class="lapangan" id="lapangan">
    <div class="container">
      <main class="contain" data-aos="fade-right" data-aos-duration="1000">
        <h2 class="text-head">Booking <span>Gor</span>Yuk</h2>
        <div class="row row-cols-1 row-cols-md-4">
          <?php foreach ($lapangan as $row) : ?>
            <div class="col">
              <div class="card h-100">
                <img class="card-img-top" src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan">
                <div class="card-body">
                  <h5 class="card-title"><?= $row["nama8"]; ?></h5>
                  <p class="card-text"><?= $row["keterangan8"]; ?></p>
                  <p class="card-price">Harga= Rp.<?= $row["harga8"]; ?></p>
                  <p class="card-status">Status: <?= cekStatusLapangan($row["id_lapangan8"]); ?></p>
                  <a href="jadwal.php?id=<?= $row["id_lapangan8"]; ?>" class="btn btn-outline-primary">Jadwal</a>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal<?= $row["id_lapangan8"]; ?>">Pesan</button>
                </div>
              </div>
            </div>
            <!-- Modal Pesan -->
            <div class="modal fade" id="pesanModal<?= $row["id_lapangan8"]; ?>" tabindex="-1" aria-labelledby="pesanModalLabel<?= $row["id_lapangan8"]; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel<?= $row["id_lapangan8"]; ?>">Pesan Lapangan <?= $row["nama8"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="" method="post">
                    <div class="modal-body">
                      <div class="row justify-content-center align-items-center">
                        <div class="mb-3">
                          <img src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan" class="img-fluid">
                        </div>
                        <div class="text-center">
                          <h6 name="harga">Harga : <?= $row["harga8"]; ?></h6>
                        </div>
                        <div class="col">
                          <input type="hidden" name="id_lpg" class="form-control" value="<?= $row["id_lapangan8"]; ?>">
                          <div class="mb-3">
                            <label for="tgl_main" class="form-label">Tanggal Main</label>
                            <input type="datetime-local" name="tgl_main" class="form-control" id="tgl_main">
                          </div>
                        </div>
                        <div class="col">
                          <input type="hidden" name="harga" class="form-control" value="<?= $row["harga8"]; ?>">
                          <div class="mb-3">
                            <label for="lama" class="form-label">Lama Main (jam)</label>
                            <input type="number" name="lama" class="form-control" id="lama" min="1" step="1">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-outline-primary" name="pesan" id="pesan">Pesan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal Pesan -->
            <?php endforeach;?>
        </div>
      </main>
    </div>
</section>
<?php include 'controller/footer.php';?>
</html>
