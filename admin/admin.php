<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination
$jmlHalamanPerData = 5;
$jumlahData = count(query("SELECT * FROM lapangan8"));
$jmlHalaman = ceil($jumlahData / $jmlHalamanPerData);

if (isset($_GET["halaman"])) {
  $halamanAktif = $_GET["halaman"];
} else {
  $halamanAktif = 1;
}

$awalData = ($jmlHalamanPerData * $halamanAktif) - $jmlHalamanPerData;

$lapangan = query("SELECT * FROM lapangan8 LIMIT $awalData, $jmlHalamanPerData");

if (isset($_POST["simpan"])) {
  if (tambahAdmin($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'admin.php';
          </script>";
          
  } else {
    echo "<script>
          alert('Gagal DiTambahkan');
          window.location.href = 'admin.php';
          </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editAdmin($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Ubah');
          window.location.href = 'admin.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Di Ubah');
          window.location.href = 'admin.php';
          </script>";
  }
}
$admin = query("SELECT * FROM admin8");

?>

<?php include 'controller/head.php';?>

<div class="layout-page">
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Your content here -->
    <div class="col-12 p-5 mb-2 mt-5">
      <!-- Konten -->
      <h3 class="judul">Data Admin</h3>
      <hr>
      <button class="btn rounded-pill btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal1">Tambah</button>
      <!-- Modal Tambah -->
      <div class="modal fade" id="tambahModal1" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahModalLabel">Tambah Admin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <!-- konten form modal -->
                <div class="row justify-content-center align-items-center">
                  <div class="col">
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                  </div>
                  <div class="col">
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                      <input type="text" name="nama" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">No Hp</label>
                      <input type="number" name="hp" class="form-control" id="exampleInputPassword1">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputPassword1">
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
            <table class="table table-hover mt-3">
              <thead class="table-inti">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Username</th>
                  <th scope="col">Nama Lengkap</th>
                  <th scope="col">Email</th>
                  <th scope="col">No Hp</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody class="text">
                <?php $i = 1; ?>
                <?php foreach ($admin as $row) : ?>
                  <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $row["username8"]; ?></td>
                    <td><?= $row["nama8"]; ?></td>
                    <td><?= $row["email8"]; ?></td>
                    <td><?= $row["no_handphone8"]; ?> </td>
                    <td>
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id_user8"]; ?>">Edit</button>
                      <a href="./controller/hapusAdmin.php?id=<?= $row["id_user8"]; ?>" class="btn btn-danger">Hapus</a>
                    </td>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $row["id_user8"]; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row["id_user8"]; ?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?= $row["id_user8"]; ?>">Edit Admin <?= $row["nama8"]; ?></h5>
                          </div>
                          <form action="" method="post">
                            <input type="hidden" name="id" class="form-control" value="<?= $row["id_user8"]; ?>">
                            <div class="modal-body">
                              <!-- konten form modal -->
                              <div class="row justify-content-center align-items-center">
                                <div class="mb-3">
                                  <img src="../img/futsal.jpg" alt="gambar lapangan" class="img-fluid">
                                </div>
                                <div class="col">
                                  <div class="mb-3">
                                    <label for="edit_username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="edit_username" value="<?= $row["username8"]; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="edit_password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="edit_password" value="<?= $row["password8"]; ?>">
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="edit_nama" value="<?= $row["nama8"]; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="edit_email" value="<?= $row["email8"]; ?>">
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="edit_hp" class="form-label">No Hp</label>
                                  <input type="number" name="hp" class="form-control" id="edit_hp" value="<?= $row["no_handphone8"]; ?>">
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
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <?php include 'controller/pagination.php';?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- / Layout page -->
  </div>
</div>
<?php include 'controller/footer.php';?>
