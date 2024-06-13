<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

$searchQuery = "";
if (isset($_GET['search'])) {
  $searchQuery = $_GET['search'];
}


$entriesPerPage = 3; 
if (isset($_GET['entries'])) {
  $entriesPerPage = $_GET['entries'];
}

// Pagination
$jumlahData = count(query("SELECT * FROM lapangan8 WHERE nama8 LIKE '%$searchQuery%' OR harga8 LIKE '%$searchQuery%' OR keterangan8 LIKE '%$searchQuery%'"));
$jmlHalaman = ceil($jumlahData / $entriesPerPage);

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

$awalData = ($entriesPerPage * $halamanAktif) - $entriesPerPage;

$lapangan = query("SELECT * FROM lapangan8 WHERE nama8 LIKE '%$searchQuery%' OR harga8 LIKE '%$searchQuery%' OR keterangan8 LIKE '%$searchQuery%' LIMIT $awalData, $entriesPerPage");

if (isset($_POST["simpan"])) {
  if (tambahLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal DiTambahkan');
          window.location.href = 'lapangan.php';
          </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Ubah');
          window.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Di Ubah');
          window.location.href = 'lapangan.php';
          </script>";
  }
}

?>

<?php include 'controller/head.php'; ?>

<!-- Layout container -->
<div class="layout-page">

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Your content here -->
    <div class="col-12 p-5 mb-2 mt-5">
      <!-- Konten -->
      <h3 class="judul">Data Lapangan</h3>
      <hr>
      <button class="btn rounded-pill btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal1">Tambah</button>
      <!-- Modal Tambah -->

      <div class="modal fade" id="tambahModal1" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahModalLabel">Tambah Lapangan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <!-- konten form modal -->
                <div class="row justify-content-center align-items-center">
                  <div class="col">
                    <div class="mb-3">
                      <label for="namaLapangan" class="form-label">Nama Lapangan</label>
                      <input type="text" name="lapangan" class="form-control" id="namaLapangan" required>
                    </div>
                  </div>
                  <div class="col">
                    <div class="mb-3">
                      <label for="harga" class="form-label">Harga</label>
                      <input type="number" name="harga" class="form-control" id="harga" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" id="foto" required>
                  </div>
                  <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" id="keterangan">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="simpan" id="simpan">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End Modal Tambah -->

      <div class="card">
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <div id="testdatatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="dataTables_length" id="testdatatable_length">
                    <label>
                      Show
                      <select name="testdatatable_length" aria-controls="testdatatable" class="form-select form-select-sm" onchange="window.location.href='lapangan.php?entries=' + this.value + '&search=<?= $searchQuery; ?>'">
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
                      <input type="search" class="form-control form-control-sm" placeholder aria-controls="testdatatable" value="<?= $searchQuery; ?>" onkeyup="if(event.keyCode == 13) { window.location.href='lapangan.php?search=' + this.value + '&entries=<?= $entriesPerPage; ?>' }">
                    </label>
                  </div>
                </div>
              </div>
              <div class="row dt-row">
                <div class="col-sm-12">
                  <table id="datatable" class="table table-hover mt-3">
                    <thead class="table-inti">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lapangan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="text">
                      <?php $i = $awalData + 1; ?>
                      <?php foreach ($lapangan as $row) : ?>
                        <tr>
                          <th scope="row"><?= $i++; ?></th>
                          <td><?= $row["nama8"]; ?></td>
                          <td><?= $row["harga8"]; ?></td>
                          <td><?= $row["keterangan8"]; ?></td>
                          <td><img src="../img/<?= $row["foto8"]; ?>" width="100" height="100"></td>
                          <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id_lapangan8"]; ?>">Edit</button>
                            <a href="./controller/hapusLpg.php?id=<?= $row["id_lapangan8"]; ?>" class="btn btn-danger">Hapus</a>
                          </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row["id_lapangan8"]; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row["id_lapangan8"]; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?= $row["id_lapangan8"]; ?>">Edit Lapangan <?= $row["nama8"]; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="idlap" class="form-control" value="<?= $row["id_lapangan8"]; ?>">
                                <input type="hidden" name="fotoLama" class="form-control" value="<?= $row["foto8"]; ?>">
                                <div class="modal-body">
                                  <!-- konten form modal -->
                                  <div class="row justify-content-center align-items-center">
                                    <div class="mb-3">
                                      <img src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                                    </div>
                                    <div class="mb-3">
                                      <label for="foto" class="form-label">Foto</label>
                                      <input type="file" name="foto" class="form-control" id="foto" required>
                                    </div>
                                    <div class="mb-3">
                                      <label for="namaLapangan" class="form-label">Nama Lapangan</label>
                                      <input type="text" name="lapangan" class="form-control" id="namaLapangan" value="<?= $row["nama8"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                      <label for="harga" class="form-label">Harga</label>
                                      <input type="number" name="harga" class="form-control" id="harga" value="<?= $row["harga8"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                      <label for="keterangan" class="form-label">Keterangan</label>
                                      <input type="text" name="ket" class="form-control" id="ket" value="<?= $row["keterangan8"]; ?>" >
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <button type="submit" class="btn btn-primary" name="edit" id="edit">Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- End Edit Modal -->
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
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
      <!-- End Konten -->
    </div>
  </div>
</div>
<!-- / Layout page -->

<?php include 'controller/footer.php'; ?>

<div class="content-backdrop fade"></div>
</div>
<!-- / Layout wrapper -->
