<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// Handle search query
$searchQuery = "";
if (isset($_GET['search'])) {
  $searchQuery = $_GET['search'];
}

// Handle show entries
$entriesPerPage = 5; // default value
if (isset($_GET['entries'])) {
  $entriesPerPage = $_GET['entries'];
}

// Pagination
$jumlahData = count(query("SELECT * FROM sewa8
                            JOIN user8 ON sewa8.id_user8 = user8.id_user8
                            JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
                            JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
                            WHERE user8.nama_lengkap8 LIKE '%$searchQuery%' 
                            OR sewa8.tanggal_pesan8 LIKE '%$searchQuery%' 
                            OR sewa8.jam_mulai8 LIKE '%$searchQuery%' 
                            OR lapangan8.nama8 LIKE '%$searchQuery%'"));
$jmlHalaman = ceil($jumlahData / $entriesPerPage);

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

$awalData = ($entriesPerPage * $halamanAktif) - $entriesPerPage;

$rentals = query("SELECT sewa8.id_sewa8, user8.nama_lengkap8, sewa8.tanggal_pesan8, sewa8.jam_mulai8, sewa8.jam_habis8, sewa8.harga8, sewa8.lama_sewa8, sewa8.total8, bayar8.bukti8, bayar8.konfirmasi8, lapangan8.nama8
                    FROM sewa8
                    JOIN user8 ON sewa8.id_user8 = user8.id_user8
                    JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
                    JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
                    WHERE user8.nama_lengkap8 LIKE '%$searchQuery%' 
                    OR sewa8.tanggal_pesan8 LIKE '%$searchQuery%' 
                    OR sewa8.jam_mulai8 LIKE '%$searchQuery%'
                    OR lapangan8.nama8 LIKE '%$searchQuery%'
                    LIMIT $awalData, $entriesPerPage");

?>


<?php include 'controller/head.php'; ?>
<!-- Layout container -->
<div class="layout-page">
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <div class="col-11 p-5 mt-5">
      <!-- Konten -->
      <h3 class="judul">Data Sewa</h3>
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
                    <th scope="col">Nama Penyewa</th>
                    <th scope="col">Tanggal Pesan</th>
                    <th scope="col">Konfirmasi</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody class="text">
                  <?php $i = $awalData + 1; ?>
                  <?php foreach ($rentals as $row) : ?>
                    <tr>
                      <th scope="row"><?= $i; ?></th>
                      <td><?= $row["nama_lengkap8"]; ?></td>
                      <td><?= $row["tanggal_pesan8"]; ?></td>
                      <td><span class="badge bg-label-<?= $row["konfirmasi8"] == "Terkonfirmasi" ? 'success' : 'warning'; ?> me-1"><?= $row["konfirmasi8"]; ?></span></td>
                      <td>
                        <?php if ($row["konfirmasi8"] != "Terkonfirmasi") : ?>
                          <div class="dropdown">
                            <button type="button" class="btn p-3 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#konfirmasiModal<?= $row["id_sewa8"]; ?>">
                                <i class="bx bx-check me-1"></i> Konfirmasi
                              </button>
                              <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row["id_sewa8"]; ?>">
                                <i class="bx bx-trash me-1"></i> Hapus
                              </button>
                            </div>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row["id_sewa8"]; ?>">
                          Detail
                        </button>
                      </td>
                    </tr>
                    
                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row["id_sewa8"]; ?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel<?= $row["id_sewa8"]; ?>">Detail Sewa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row justify-content-center align-items-center">
                              <div class="mb-3">
                                <img src="../img/<?= $row["bukti8"]; ?>" alt="Belum ada bukti pembayaran" class="img-fluid">
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="jamMainDetail<?= $row["id_sewa8"]; ?>" class="form-label">Jam Main</label>
                                  <input type="datetime-local" name="tgl_main" class="form-control" id="jamMainDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["jam_mulai8"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="jamHabisDetail<?= $row["id_sewa8"]; ?>" class="form-label">Jam Habis</label>
                                  <input type="datetime-local" name="jam_habis" class="form-control" id="jamHabisDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["jam_habis8"]; ?>" disabled>
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="lamaMainDetail<?= $row["id_sewa8"]; ?>" class="form-label">Lama Bermain</label>
                                  <input type="text" name="lama_sewa" class="form-control" id="lamaMainDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["lama_sewa8"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="hargaDetail<?= $row["id_sewa8"]; ?>" class="form-label">Harga</label>
                                  <input type="number" name="harga8" class="form-control" id="hargaDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["harga8"]; ?>" disabled>
                                </div>
                              </div>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Total</span>
                                </div>
                                <input type="number" name="total" class="form-control" id="totalDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["total8"]; ?>" disabled>
                              </div>
                            </div>
                            <div class="mb-3">
                              <label for="lapanganDetail<?= $row["id_sewa8"]; ?>" class="form-label">Lapangan</label>
                              <input type="text" name="lapangan" class="form-control" id="lapanganDetail<?= $row["id_sewa8"]; ?>" value="<?= $row["nama8"]; ?>" disabled>
                            </div>
                            <div class="mt-3 mx-3">
                              <h6 class="text-center border border-danger">Status: <?= $row["konfirmasi8"]; ?></h6>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Modal Detail -->

                    <!-- Modal Konfirmasi -->
                    <div class="modal fade" id="konfirmasiModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel<?= $row["id_sewa8"]; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiModalLabel<?= $row["id_sewa8"]; ?>">Konfirmasi Pesanan <?= $row["nama_lengkap8"]; ?></h5>
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
                    <div class="modal fade" id="hapusModal<?= $row["id_sewa8"]; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row["id_sewa8"]; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hapusModalLabel<?= $row["id_sewa8"]; ?>">Hapus Pesanan <?= $row["nama_lengkap8"]; ?></h5>
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
  </div>
  <!-- / Content wrapper -->
</div>
<!-- / Layout container -->
<?php include 'controller/footer.php'; ?>
