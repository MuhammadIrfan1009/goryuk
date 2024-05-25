<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination
$jmlHalamanPerData = 3;
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



    
<?php include 'controller/head.php';?>

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
                        <input type="text" name="lapangan" class="form-control" id="namaLapangan">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="foto" class="form-label">Foto</label>
                      <input type="file" name="foto" class="form-control" id="foto">
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
      <table class="table table-hover mt-3">
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
          <?php $i = 1; ?>
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
            <div class="modal fade" id="editModal<?= $row["id_lapangan8"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Edit Lapangan <?= $row["nama8"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="idlap" class="form-control" id="exampleInputPassword1" value="<?= $row["id_lapangan8"]; ?>">
                    <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $row["foto8"]; ?>">
                    <div class="modal-body">
                      <!-- konten form modal -->
                      <div class="row justify-content-center align-items-center">
                        <div class="mb-3">
                          <img src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan" class="img-fluid">
                        </div>
                        <div class="col">
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nama Lapangan</label>
                            <input type="text" name="lapangan" class="form-control" id="exampleInputPassword1" value="<?= $row["nama8"]; ?>">
                          </div>
                        </div>
                        <div class="col">
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga8"]; ?>">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Foto : </label>
                          <input type="file" name="foto" class="form-control" id="exampleInputPassword1" value="<?= $row["harga8"]; ?>">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Keterangan : </label>
                          <input type="text" name="ket" class="form-control" id="exampleInputPassword1" value="<?= $row["keterangan8"]; ?>">
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
            <!-- End Modal Tambah -->
          <?php endforeach; ?>
        </tbody>
      
    
    
        <?php include 'controller/pagination.php';?>
</table>
  </div>
</div>
    <!-- / Layout page -->
  </div>
</div>
<?php include 'controller/footer.php';?>