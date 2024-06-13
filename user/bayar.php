<?php
session_start();
require "../functions.php";
require "../session.php";

if ($role !== 'User') {
  header("location:../login.php");
}

$id_user = $_SESSION["id_user"];

// Handle search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

// Handle show entries
$entriesPerPage = isset($_GET['entries']) ? $_GET['entries'] : 5;

// Pagination
$jumlahData = count(query("SELECT * FROM sewa8
                            JOIN user8 ON sewa8.id_user8 = user8.id_user8
                            JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
                            JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
                            WHERE sewa8.id_user8 = '$id_user'
                            AND ( sewa8.tanggal_pesan8 LIKE '%$searchQuery%' 
                            OR sewa8.jam_mulai8 LIKE '%$searchQuery%' 
                            OR lapangan8.nama8 LIKE '%$searchQuery%')"));

$jmlHalaman = ceil($jumlahData / $entriesPerPage);

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

$awalData = ($entriesPerPage * $halamanAktif) - $entriesPerPage;

$sewa8 = query("SELECT sewa8.id_sewa8, sewa8.tanggal_pesan8, sewa8.jam_mulai8, sewa8.jam_habis8, sewa8.harga8, sewa8.lama_sewa8, sewa8.total8, bayar8.bukti8, bayar8.konfirmasi8, lapangan8.nama8
                FROM sewa8
                JOIN user8 ON sewa8.id_user8 = user8.id_user8
                JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
                JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
                WHERE sewa8.id_user8 = '$id_user'
                AND ( sewa8.tanggal_pesan8 LIKE '%$searchQuery%' 
                OR sewa8.jam_mulai8 LIKE '%$searchQuery%'
                OR lapangan8.nama8 LIKE '%$searchQuery%')
                LIMIT $awalData, $entriesPerPage");


  
  
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
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'controller/link.php'; ?>
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
    <?php include 'controller/header.php'; ?>

    <section class="lapangan8 mb-5" id="lapangan8">
        <div class="container-fluid">
            <h2 class="text-head"><span>Pembayaran</span> Lapangan</h2>
            <div class="card">
                <div class="card-header">
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="testdatatable_length">
                                <label>
                                    Show
                                    <select name="testdatatable_length" aria-controls="testdatatable" class="form-select form-select-sm" onchange="window.location.href='bayar.php?entries=' + this.value + '&search=<?= $searchQuery; ?>'">
                                        <option value="5" <?= $entriesPerPage == 5 ? 'selected' : '' ?>>5</option>
                                        <option value="10" <?= $entriesPerPage == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="25" <?= $entriesPerPage == 25 ? 'selected' : '' ?>>25</option>
                                        <option value="50" <?= $entriesPerPage == 50 ? 'selected' : '' ?>>50</option>
                                    </select>
                                    entries
                                </label>
                            </div>
                        </div>
                  
                        <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                            <div id="testdatatable_filter" class="dataTables_filter">
                                <label>
                                    Search:
                                    <input type="search" class="form-control form-control-sm" placeholder aria-controls="testdatatable" value="<?= $searchQuery; ?>" onkeyup="if(event.keyCode == 13) { window.location.href='bayar.php?search=' + this.value + '&entries=<?= $entriesPerPage; ?>' }">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <?php if ($row["konfirmasi8"] == "Sudah Bayar" || $row["konfirmasi8"] == "Terkonfirmasi") : ?>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row["id_sewa8"] ?>">Detail</button>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bayarModal<?= $row["id_sewa8"] ?>">Bayar</button>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row["id_sewa8"] ?>" class="btn btn-danger">Hapus</a>
                                        <?php endif; ?>
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
                                                            <label for="bankInfo" class="form-label">Transfer via Dana 083186867022 a/n Goryuk</label>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="uploadBukti<?= $row["id_sewa8"] ?>" class="form-label">Upload Bukti</label>
                                                            <input type="file" name="foto" class="form-control" id="uploadBukti<?= $row["id_sewa8"] ?>" required>
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
    <div class="modal-dialog modal-dialog-centered"> <!-- Fixed missing 'div' tag here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Added close button -->
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
                            <div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="testdatatable_info" role="status" aria-live="polite">
            Showing <?= $awalData + 1; ?> to <?= $awalData + count($sewa8); ?> of <?= $jumlahData; ?> entries
        </div>
    </div>
    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
        <div class="dataTables_paginate paging_simple_numbers" id="testdatatable_paginate">
            <ul class="pagination">
                <?php if ($halamanAktif > 1): ?>
                    <li class="paginate_button page-item previous">
                        <a href="?halaman=<?= $halamanAktif - 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $jmlHalaman; $i++): ?>
                    <li class="paginate_button page-item <?= $i == $halamanAktif ? 'active' : ''; ?>">
                        <a href="?halaman=<?= $i; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($halamanAktif < $jmlHalaman): ?>
                    <li class="paginate_button page-item next">
                        <a href="?halaman=<?= $halamanAktif + 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include 'controller/footer.php'; ?>
</body>
</html>


                               
                        