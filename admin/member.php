<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:/login.php");
}

// Pagination
$jmlHalamanPerData = 5;
$jumlahData = count(query("SELECT * FROM user8"));
$jmlHalaman = ceil($jumlahData / $jmlHalamanPerData);

if (isset($_GET["halaman"])) {
  $halamanAktif = $_GET["halaman"];
} else {
  $halamanAktif = 1;
}

$awalData = ($jmlHalamanPerData * $halamanAktif) - $jmlHalamanPerData;

$member = query("SELECT * FROM user8 LIMIT $awalData, $jmlHalamanPerData");
?>

<?php include 'controller/head.php';?>
    <!-- Layout container -->
    <div class="layout-page">
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Your content here -->
        <div class="col-11 p-5 mt-5">
          <!-- Konten -->
          <h3 class="judul">Data Member</h3>
          <hr>
          <div class="card">
            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-hover mt-5">
                  <thead class="table-inti">
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Jenis Kelamin</th>
                      <th scope="col">Email</th>
                      <th scope="col">No hp </th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="text">
                    <?php $i = 1; ?>
                    <?php foreach ($member as $row) : ?>
                      <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $row["nama_lengkap8"]; ?></td>
                        <td><?= $row["jenis_kelamin8"]; ?></td>
                        <td><?= $row["email8"]; ?></td>
                        <td><?= $row["no_handphone8"]; ?></td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id_user8']; ?>">Hapus</button>
                        </td>
                      </tr>
                      <!-- Modal Hapus -->
                      <div class="modal fade" id="hapusModal<?= $row['id_user8']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_user8']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="hapusModalLabel<?= $row['id_user8']; ?>">Konfirmasi Hapus Data</h5>
                            </div>
                            <div class="modal-body">
                              <p>Anda yakin ingin menghapus data ini?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <a href="./controller/hapusMember.php?id=<?= $row['id_user8']; ?>" class="btn btn-danger">Hapus</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Hapus -->
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  </tbody>
                  <?php include 'controller/pagination.php';?>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>
</div>
<?php include 'controller/footer.php';?>
