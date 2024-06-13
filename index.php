<?php
session_start();
require "functions.php";

$id_user = $_SESSION["id_user"];

$profil = query("SELECT * FROM user8 WHERE id_user8 = '$id_user'")[0];


if (isset($_POST["simpan"])) {
  if (edit($_POST) > 0) {
    echo "<script>
          alert('Berhasil Diubah');
          window.location.href = 'index.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Diubah');
          </script>";
  }
}



?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Goryuk</title>
  <link rel="stylesheet" href="style.css">
  
  
  <!-- Favicon -->   <link rel="icon" type="image/x-icon" href="img/logo.png"/>
  

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="assets/js/config.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  
  <style>
   #home {
    margin-top: 100px; /* Sesuaikan dengan tinggi navbar */
  }
  .text-light {
  color: #ffffff !important;
}
  
  </style>
</head>

<body>
  
<nav class="navbar navbar-example navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/logo.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-2" aria-controls="navbar-ex-2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-ex-2">
      <div class="navbar-nav me-auto">
        <a class="nav-item nav-link active" href="#home">Home</a>
        <a class="nav-item nav-link" href="#about">About</a>
        <a class="nav-item nav-link" href="#bayar">Tata Cara</a>
        <?php
        if (isset($_SESSION['id_user'])) {
          echo '
        <a class="nav-item nav-link" href="user/lapangan.php">Lapangan</a>
        <a class="nav-item nav-link" href="user/bayar.php">Pembayaran</a>
        ';
        }
        ?>
        <a class="nav-item nav-link" href="#contact">Kontak</a>
      </div>
      <button type="button" class="btn">
        <?php
        if (isset($_SESSION['id_user'])) {
          echo '<a href="user/profil.php" data-bs-toggle="modal" data-bs-target="#profilModal" class="nav-link"><i data-feather="user"></i></a>';
        } else {
          echo '<a href="login.php" class="nav-link" type="submit">Login</a>';
        }
        ?>
      </button>
    </div>
  </div>
</nav>


  <!-- Modal Profil -->
  <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="row">
              <div class="col-4 my-5">
                <img src="../img/<?= $profil["foto8"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col-8">
                <h5 class="mb-3"><?= $profil["nama_lengkap8"]; ?></h5>
                <p><?= $profil["jenis_kelamin8"]; ?></p>
                <p><?= $profil["email8"]; ?></p>
                <p><?= $profil["no_handphone8"]; ?></p>
                <p><?= $profil["alamat8"]; ?></p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Edit Profil</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Profil -->

  <!-- Edit profil -->
  <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog edit modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $profil["foto8"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <div class="mb-3">
                <img src="../img/<?= $profil["foto8"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" class="form-control" id="exampleInputPassword1" value="<?= $profil["nama_lengkap8"]; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($profil['jenis_kelamin8'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($profil['jenis_kelamin8'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">No Telp</label>
                  <input type="number" name="hp" class="form-control" id="exampleInputPassword1" value="<?= $profil["no_handphone8"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $profil["email8"]; ?>" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">alamat</label>
                <input type="text" name="alamat" class="form-control" id="exampleInputPassword1" value="<?= $profil["alamat8"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Foto : </label>
                <input type="file" name="foto" class="form-control" id="exampleInputPassword1" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->

  <!-- Jumbotron -->
  <section class="jumbotron" id="home">
    <main class="contain" data-aos="fade-right" data-aos-duration="1000">
      <h1 class="text-light">Olahraga sekarang Yuk!,pesan sekarang di <span>Gor</span>Yuk </h1>
      <p>
      Booking lapangan jadi mudah dan menyenangkan bersama kami! Rasakan kemudahan dan kepuasan dalam setiap langkahnya.
      </p>
      <a href="user/lapangan.php" class="btn btn-inti">Booking Sekarang</a>
    </main>
  </section>
  <!-- End Jumbotron -->

  <!-- About -->
  <section class="about" id="about">
    <h2 data-aos="fade-down" data-aos-duration="1000">
        <span>Tentang</span> Kami
    </h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-img" data-aos="fade-right" data-aos-duration="1000">
                    <img src="img/about.png" alt="" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content" data-aos="fade-left" data-aos-duration="1000">
                    <h4 class="text-center mb-4">Kenapa Harus Memilih Kami?</h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item align-top">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Pilihan Beragam
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body mb-5">
                                    Kami menyediakan berbagai jenis lapangan olahraga untuk memenuhi kebutuhan beragam aktivitas olahraga.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Fitur Lengkap
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body mb-5">
                                    Aplikasi kami dilengkapi dengan fitur pencarian, pemesanan online, pembayaran aman, konfirmasi, manajemen booking, profil pengguna, dan dukungan pelanggan responsif.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Kemudahan Penggunaan
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body mb-5">
                                    Antarmuka sederhana memastikan pengguna dapat dengan mudah menemukan, memesan, dan mengelola lapangan sesuai kebutuhan mereka.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Kualitas Layanan
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body mb-5">
                                    Kami berkomitmen untuk memberikan layanan berkualitas tinggi dan pengalaman yang memuaskan bagi setiap pengguna.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




  <!-- End About -->

 
<!-- Tata Cara Pembayaran -->

<!-- Pembayaran -->
<section class="pembayaran" id="bayar">
   <!-- Announcement Section -->
   <div class="container mt-5 pt-5">
    <div class="row">
      <!-- Pengumuman Admin Section -->
      <div class="col-md-6">
        <div class="announcement">
          <h3 class="judul">Pengumuman</h3>
          <hr>
          <h6 class="text-muted">Pengumuman Penting untuk Pengguna GorYuk</h6>
          <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                  <i class="tf-icons bx bx-home"></i> Kebijakan Baru
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                  <i class="tf-icons bx bx-user"></i>  Jadwal Pemeliharaan
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                  <i class="tf-icons bx bx-message-square"></i> Proyek Mendatang
                </button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <p><strong>Halo Pengguna GorYuk,</strong></p>
                <p>
                Mulai <strong>1 Juni 2024</strong> kami akan menerapkan kebijakan baru terkait penggunaan fasilitas dan penanganan keluhan untuk meningkatkan kualitas layanan. Dokumen lengkap dapat diakses melalui aplikasi atau situs web kami. Jika ada pertanyaan, hubungi layanan pelanggan kami.
                </p>
                <p class="mb-0">
                Terima kasih.
                </p>
              </div>
              <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                <p><strong>Pengguna Setia,</strong></p>
                <p>
                Kami akan melakukan pemeliharaan sistem pada <strong>Selasa, 4 Juni 2024, mulai pukul 00:00 hingga 06:00 WIB.</strong> Selama waktu ini, beberapa layanan mungkin tidak tersedia. Kami mohon maaf atas ketidaknyamanan ini dan berterima kasih atas pengertian Anda.
                </p>
                <p class="mb-0">
                Terima kasih.
                </p>
              </div>
              <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                <p><strong>Kepada Pengguna GorYuk,</strong></p>
                <p>
                Kami akan meluncurkan beberapa proyek baru, termasuk pembaruan sistem reservasi, pengembangan aplikasi mobile, dan kampanye pemasaran. Informasi lebih lanjut akan disampaikan melalui kanal resmi kami.
                </p>
                <p class="mb-0">
                Terima kasih atas dukungan Anda.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tata Cara Pembayaran Section -->
      <div class="col-md-6">
        <div class="tata-cara-pembayaran">
          <h3 class="judul">Tata Cara Pembayaran Lapangan</h3>
          <hr>
          <h6 class="text-muted">Langkah Pembayaran</h6>
          <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#payment-steps" aria-controls="payment-steps" aria-selected="true">
                  <i class="tf-icons bx bx-credit-card"></i> Langkah Pembayaran
                </button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="payment-steps" role="tabpanel">
                <ol>
                  <li>Membuat Akun atau Mendaftar sebagai Anggota</li>
                  <li>Memilih Jenis Lapangan dan Waktu</li>
                  <li>Mengisi Formulir Pemesanan</li>
                  <li>Klik Tombol Pesan</li>
                  <li>Menu Pembayaran</li>
                  <li>Lakukan Pembayaran dan Upload Bukti</li>
                  <li>Menunggu Konfirmasi Admin</li>
                  <li>Datang ke GOR Sesuai Jadwal</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>




<!-- Kontak Kami -->
<?php
$conn = mysqli_connect("localhost", "root", "", "dbgoryuk");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if (insertComplaint($name, $email, $phone, $message) > 0) {
        $successMessage = "Complaint submitted successfully.";
    } else {
        $errorMessage = "Error submitting complaint.";
    }
}

function insertComplaint($name, $email, $phone, $message)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pengaduan_pelanggan8 (name8, email8, phone8, message8) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    $stmt->execute();
    $affectedRows = $stmt->affected_rows;
    $stmt->close();
    return $affectedRows;
}
?>
<section id="contact">
  <div class="col-lg-8 mx-auto">
    <h2 data-aos="fade-down" data-aos-duration="1000" class="text-center">
      <span>Pengaduan </span> Pelanggan
    </h2>
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Formulir Kontak</h5>
      </div>
      <div class="card-body">
        <?php if (isset($successMessage)) { ?>
          <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php } ?>
        <?php if (isset($errorMessage)) { ?>
          <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php } ?>
        <form method="post" action="">
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                <input type="text" class="form-control" id="basic-icon-default-fullname" name="name" placeholder="nama anda" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                <input type="text" id="basic-icon-default-email" class="form-control" name="email" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
              </div>
              <div class="form-text">Anda dapat menggunakan huruf, angka, & titik</div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Nomor Telepon</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                <input type="text" id="basic-icon-default-phone" class="form-control phone-mask" name="phone" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 form-label" for="basic-icon-default-message">Pesan</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                <textarea id="basic-icon-default-message" class="form-control" name="message" placeholder="Hi, Apakah Anda memiliki waktu untuk berbicara?" aria-label="Hi, Apakah Anda memiliki waktu untuk berbicara?" aria-describedby="basic-icon-default-message2"></textarea>
              </div>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>



  <footer class="footer bg-light">
    <div class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3">
      <div class="card bg-light">
        </div>
      </div>
      <div class="card bg-light">
        <div class="card-body">
        <div class="social">
      <a href="https://www.instagram.com/goryuk.tnj/?utm_source=ig_web_button_share_sheet"><i data-feather="instagram"></i></a>
      <p>@goryuk.tnj</p>
    </div>
          <p>Created by <a href="#">Kelompok Delapan</a> &copy; 2024 <br> SMK Negeri 4 Tanjungpinang</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script>
    feather.replace();
  </script>
</body>

</html>