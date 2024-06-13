<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// search query
$searchQuery = "";
if (isset($_GET['search'])) {
  $searchQuery = $_GET['search'];
}

//show entries
$entriesPerPage = 5; 
if (isset($_GET['entries'])) {
  $entriesPerPage = $_GET['entries'];
}

// Pagination
$jumlahData = count(query("SELECT * FROM user8 WHERE nama_lengkap8 LIKE '%$searchQuery%' OR email8 LIKE '%$searchQuery%' OR no_handphone8 LIKE '%$searchQuery%'"));
$jmlHalaman = ceil($jumlahData / $entriesPerPage);

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

$awalData = ($entriesPerPage * $halamanAktif) - $entriesPerPage;

$member = query("SELECT * FROM user8 WHERE nama_lengkap8 LIKE '%$searchQuery%' OR email8 LIKE '%$searchQuery%' OR no_handphone8 LIKE '%$searchQuery%' LIMIT $awalData, $entriesPerPage");
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
              <div id="testdatatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="testdatatable_length">
                      <label>
                        Show
                        <select name="entries" aria-controls="testdatatable" class="form-select form-select-sm" onchange="window.location.href='?entries=' + this.value + '&search=<?= $searchQuery; ?>'">
                          <option value="3" <?= $entriesPerPage == 3 ? 'selected' : '' ?>>3</option>
                          <option value="5" <?= $entriesPerPage == 5 ? 'selected' : '' ?>>5</option>
                          <option value="10" <?= $entriesPerPage == 10 ? 'selected' : '' ?>>10</option>
                        </select>
                        entries
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div id="testdatatable_filter" class="dataTables_filter">
                      <label>
                        Search:
                        <input type="search" class="form-control form-control-sm" placeholder aria-controls="testdatatable" value="<?= $searchQuery; ?>" onkeyup="if(event.keyCode == 13) { window.location.href='?search=' + this.value + '&entries=<?= $entriesPerPage; ?>' }">
                      </label>
                    </div>
                  </div>
                </div>
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
                    <?php $i = $awalData + 1; ?>
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
                </table>
                <div class="row">
                  <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="testdatatable_info" role="status" aria-live="polite">
                      Showing <?= $awalData + 1; ?> to <?= min($awalData + $entriesPerPage, $jumlahData); ?> of <?= $jumlahData; ?> entries
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="testdatatable_paginate">
                      <ul class="pagination">
                        <?php if ($halamanAktif > 1) : ?>
                          <li class="paginate_button page-item previous"><a href="?halaman=<?= $halamanAktif - 1; ?>&entries=<?= $entriesPerPage; ?>&search=<?= $searchQuery; ?>" aria-controls="testdatatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
                          <?php if ($i == $halamanAktif) : ?>
                            <li class="paginate_button page-item active"><a href="?halaman=<?= $i; ?>&entries=<?= $entriesPerPage; ?>&search=<?= $searchQuery; ?>" aria-controls="testdatatable" data-dt-idx="<?= $i; ?>" tabindex="0" class="page-link"><?= $i; ?></a></li>
                          <?php else : ?>
                            <li class="paginate_button page-item"><a href="?halaman=<?= $i; ?>&entries=<?= $entriesPerPage; ?>&search=<?= $searchQuery; ?>" aria-controls="testdatatable" data-dt-idx="<?= $i; ?>" tabindex="0" class="page-link"><?= $i; ?></a></li>
                          <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($halamanAktif < $jmlHalaman) : ?>
                          <li class="paginate_button page-item next"><a href="?halaman=<?= $halamanAktif + 1; ?>&entries=<?= $entriesPerPage; ?>&search=<?= $searchQuery; ?>" aria-controls="testdatatable" data-dt-idx="<?= $i; ?>" tabindex="0" class="page-link">Next</a></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
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
