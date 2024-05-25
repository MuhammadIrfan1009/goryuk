<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}


$jmlHalamanPerData = 5;
$jumlahData = count(query("SELECT sewa8.id_sewa8,user8.nama_lengkap8,sewa8.tanggal_pesan8,sewa8.jam_mulai8,sewa8.lama_sewa8,sewa8.total8,bayar8.bukti8,bayar8.konfirmasi8
FROM sewa8
JOIN user8 ON sewa8.id_user8 = user8.id_user8
JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8"));
$jmlHalaman = ceil($jumlahData / $jmlHalamanPerData);

if (isset($_GET["halaman"])) {
  $halamanAktif = $_GET["halaman"];
} else {
  $halamanAktif = 1;
}

$awalData = ($jmlHalamanPerData * $halamanAktif) - $jmlHalamanPerData;

$pesan = query("SELECT sewa8.id_sewa8,user8.nama_lengkap8,sewa8.tanggal_pesan8,sewa8.jam_mulai8,sewa8.lama_sewa8,sewa8.total8,bayar8.bukti8,bayar8.konfirmasi8
FROM sewa8
JOIN user8 ON sewa8.id_user8 = user8.id_user8
JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8 LIMIT $awalData, $jmlHalamanPerData");


?>

<?php include 'controller/head.php';?>
    <!-- / Menu -->
    <!-- Layout container -->
    <div class="layout-page">
    
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Your content here -->
        <div class="col-12 p-5 mt-5">
        <!-- Konten -->
        <h3 class="judul">Data Pesanan</h3>
        <hr>
        
        <div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>NamaCust</th>
          <th>TglPesan</th>
          <th>TglMain</th>
          <th>Lama</th>
          <th>Total</th>
          <th>Bukti</th>
          <th>Konfir</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php $i = 1; ?>
        <?php foreach ($pesan as $row) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $row["nama_lengkap8"]; ?></td>
            <td><?= $row["tanggal_pesan8"]; ?></td>
            <td><?= $row["jam_mulai8"]; ?></td>
            <td><?= $row["lama_sewa8"]; ?></td>
            <td><?= $row["total8"]; ?></td>
            <td><img src="../img/<?= $row["bukti8"]; ?>" width="100" height="100"></td>
            <td><span class="badge bg-label-<?= $row["konfirmasi8"] == "Terkonfirmasi" ? 'success' : 'warning'; ?> me-1"><?= $row["konfirmasi8"]; ?></span></td>
            <td>
              <?php
              $id_sewa = $row["id_sewa8"];
              if ($row["konfirmasi8"] != "Terkonfirmasi") {
                echo '
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#konfirmasiModal' . $id_sewa . '">
                        <i class="bx bx-check me-1"></i> Konfirmasi
                      </button>
                      <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#hapusModal' . $id_sewa . '">
                        <i class="bx bx-trash me-1"></i> Hapus
                      </button>
                    </div>
                  </div>
                ';
              }
              ?>
            </td>
          </tr>
          <!-- Modal Konfirmasi -->
          <div class="modal fade" id="konfirmasiModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan <?= $row["nama_lengkap8"]; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Anda yakin ingin mengkonfirmasi pesanan ini?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <a href="./controller/konfirmasiPesan.php?id=<?= $row["id_sewa8"]; ?>" class="btn btn-primary">Konfirmasi</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Konfirmasi -->

          <!-- Modal Hapus -->
          <div class="modal fade" id="hapusModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama_lengkap8"]; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Anda yakin ingin menghapus pesanan ini?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <a href="./controller/hapusPesan.php?id=<?= $row["id_sewa8"]; ?>" class="btn btn-danger">Hapus</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Hapus -->
        <?php endforeach; ?>
      </tbody>
      <ul class="pagination pagination-sm m-3">
    <?php if ($halamanAktif > 1) : ?>
        <li class="page-item prev">
            <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">
                <i class="tf-icon bx bx-chevrons-left"></i>
            </a>
        </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
        <?php if ($i == $halamanAktif) : ?>
            <li class="page-item active">
                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php else : ?>
            <li class="page-item">
                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($halamanAktif < $jmlHalaman) : ?>
        <li class="page-item next">
            <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">
                <i class="tf-icon bx bx-chevrons-right"></i>
            </a>
        </li>
    <?php endif; ?>
</ul>
    </table>
  </div>
</div>

      <!-- / Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>
</div>
<?php include 'controller/footer.php';?>