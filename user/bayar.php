<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
  header("location:../login.php");
};

$id_user = $_SESSION["id_user"];

// Pagination
$jmlHalamanPerData = 5;
$jumlahData = count(query("SELECT sewa8.*, lapangan8.nama8, bayar8.bukti8, bayar8.konfirmasi8
FROM sewa8
JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
left JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
WHERE sewa8.id_user8 = '$id_user'"));
$jmlHalaman = ceil($jumlahData / $jmlHalamanPerData);

if (isset($_GET["halaman"])) {
  $halamanAktif = $_GET["halaman"];
} else {
  $halamanAktif = 1;
}

$awalData = ($jmlHalamanPerData * $halamanAktif) - $jmlHalamanPerData;

$sewa8 = query("SELECT sewa8.*, lapangan8.nama8, bayar8.bukti8, bayar8.konfirmasi8
FROM sewa8
JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
left JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
WHERE sewa8.id_user8 = '$id_user' LIMIT $awalData, $jmlHalamanPerData");
// Pagination



$profil = query("SELECT * FROM user8 WHERE id_user8 = '$id_user'")[0];


if (isset($_POST["simpan"])) {
  if (edit($_POST) > 1) {
    echo "<script>
          alert('Berhasil Diubah');
          </script>";
  } else {
    echo "<script>
          alert('Gagal Diubah');
          </script>";
  }
}


if (isset($_POST["bayar8"])) {
  if (bayar($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Bayar!');
          document.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Bayar!');
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

    #lapangan8 {
    margin-top: 135px; /* Sesuaikan dengan tinggi navbar */
  }
  </style>
</head>

<body>
<?php include 'controller/header.php';?>

<section class="lapangan8 mb-5" id="lapangan8">
    <div class="container-fluid ">
        <h2 class="text-head"><span>Pembayaran</span> Lapangan</h2>
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data" class="px-4">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped my-4">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Nama Lapangan</th>
                                <th scope="col">Jam Main</th>
                                <th scope="col">Lama Sewa</th>
                                <th scope="col">Jam Habis</th>
                                <th scope="col">Total</th>
                                <th scope="col">Konfirmasi</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($sewa8 as $row) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $row["tanggal_pesan8"] ?></td>
                                    <td><?= $row["nama8"] ?></td>
                                    <td><?= $row["jam_mulai8"] ?></td>
                                    <td><?= $row["lama_sewa8"] ?></td>
                                    <td><?= $row["jam_habis8"] ?></td>
                                    <td><?= $row["total8"] ?></td>
                                    <td><?= $row["konfirmasi8"] ?></td>
                                    <td>
                                        <?php
                                        $id_sewa = $row["id_sewa8"];
                                        if ($row["konfirmasi8"] == "Sudah Bayar" || $row["konfirmasi8"] == "Terkonfirmasi") {
                                            echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal' . $row["id_sewa8"] . '">Detail</button>';
                                        } else {
                                            echo '<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bayarModal' . $row["id_sewa8"] . '">Bayar</button>
                                                  <a href="" data-bs-toggle="modal" data-bs-target="#hapusModal' . $row["id_sewa8"] . '" class="btn btn-danger">Hapus</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- Modal Bayar -->
                                <div class="modal fade" id="bayarModal<?= $row["id_sewa8"] ?>" data-bs-backdrop="static" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Bayar Lapangan <?= $row["nama8"]; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id_sewa8" value="<?= $row["id_sewa8"]; ?>">
                                                <div class="modal-body">
                                                    <div class="row justify-content-center align-items-center">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="jamMain<?= $row["id_sewa8"] ?>" class="form-label">Jam Main</label>
                                                                <input type="datetime-local" name="tgl_main" class="form-control" id="jamMain<?= $row["id_sewa8"] ?>" value="<?= $row["jam_mulai8"]; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jamHabis<?= $row["id_sewa8"] ?>" class="form-label">Jam Habis</label>
                                                                <input type="datetime-local" name="jam_habis" class="form-control" id="jamHabis<?= $row["id_sewa8"] ?>" value="<?= $row["jam_habis8"]; ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="lamaMain<?= $row["id_sewa8"] ?>" class="form-label">Lama Main</label>
                                                                <input type="text" name="lama_sewa" class="form-control" id="lamaMain<?= $row["id_sewa8"] ?>" value="<?= $row["lama_sewa8"]; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="harga<?= $row["id_sewa8"] ?>" class="form-label">Harga</label>
                                                                <input type="number" name="harga8" class="form-control" id="harga<?= $row["id_sewa8"] ?>" value="<?= $row["harga8"]; ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend border border-danger">
                                                                <span class="input-group-text">Total</span>
                                                            </div>
                                                            <input type="number" name="total" class="form-control border border-danger" id="total<?= $row["id_sewa8"] ?>" value="<?= $row["total8"]; ?>" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="bankInfo" class="form-label">Transfer ke : BRI 0892322132 a/n Goryuk</label>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="uploadBukti<?= $row["id_sewa8"] ?>" class="form-label">Upload Bukti</label>
                                                            <input type="file" name="foto" class="form-control" id="uploadBukti<?= $row["id_sewa8"] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mx-3">
                                                    <h6 class="text-center border border-danger">Status : Belum Bayar</h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary" name="bayar8" id="bayar8">Bayar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Bayar -->

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModal<?= $row["id_sewa8"] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Pembayaran Lapangan <?= $row["nama8"]; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row justify-content-center align-items-center">
                                                    <div class="mb-3">
                                                        <img src="../img/<?= $row["bukti8"]; ?>" alt="gambar lapangan8" class="img-fluid">
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label for="jamMainDetail<?= $row["id_sewa8"] ?>" class="form-label">Jam Main</label>
                                                            <input type="datetime-local" name="tgl_main" class="form-control" id="jamMainDetail<?= $row["id_sewa8"] ?>" value="<?= $row["jam_mulai8"]; ?>" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jamHabisDetail<?= $row["id_sewa8"] ?>" class="form-label">Jam Habis</label>
                                                            <input type="datetime-local" name="jam_habis" class="form-control" id="jamHabisDetail<?= $row["id_sewa8"] ?>" value="<?= $row["jam_habis8"]; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label for="lamaMainDetail<?= $row["id_sewa8"] ?>" class="form-label">Jam lama bermain</label>
                                                            <input type="text" name="lama_sewa" class="form-control" id="lamaMainDetail<?= $row["id_sewa8"] ?>" value="<?= $row["lama_sewa8"]; ?>" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="hargaDetail<?= $row["id_sewa8"] ?>" class="form-label">Harga</label>
                                                            <input type="number" name="harga8" class="form-control" id="hargaDetail<?= $row["id_sewa8"] ?>" value="<?= $row["harga8"]; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Total</span>
                                                        </div>
                                                        <input type="number" name="total" class="form-control" id="totalDetail<?= $row["id_sewa8"] ?>" value="<?= $row["total8"]; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mx-3">
                                                    <h6 class="text-center border border-danger">Status : <?= $row["konfirmasi8"]; ?></h6>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Detail -->

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="hapusModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus Data</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menghapus data ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="./controller/hapus.php?id=<?= $row["id_sewa8"] ?>" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Hapus -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php include 'controller/pagination.php';?>
            </form>
        </div>
    </div>
</section>

<?php include 'controller/footer.php';?>


</html>