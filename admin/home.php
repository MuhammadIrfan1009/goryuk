<?php
session_start();
require "../functions.php";
require "../session.php";

if ($role !== 'Admin') {
  header("location:../login.php");
  exit;
}

$lapangan = query("SELECT COUNT(id_lapangan8) AS jml_lapangan FROM lapangan8")[0];
$pesanan = query("SELECT COUNT(id_bayar8) AS jml_sewa FROM bayar8")[0];
$user = query("SELECT COUNT(id_user8) AS jml_user FROM user8")[0];


// Database connection
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dbgoryuk"; // Ganti dengan nama database Anda

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the last 3 complaints
$sql = "SELECT name8, email8, phone8, message8, created_at FROM pengaduan_pelanggan8 ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);

$complaints = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
} else {
    echo "No complaints found";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'controller/head.php';?>

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Your content here -->
          <div class="col-10 p-5 mt-5">
            <!-- Home Content -->
            <h3 class="judul">Home</h3>
            <hr>
            <div class="row row-cols-1 row-cols-md-4 g-3 justify-content-center my-5 gap-3">
              <div class="col">
                <div class="card align-items-center">
                  <img src="../img/bg2.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Jumlah Lapangan</h5>
                    <h2 class="card-text text-center"><?= $lapangan["jml_lapangan"]; ?></h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card align-items-center">
                  <img src="../img/bad.png" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Jumlah Pesanan</h5>
                    <h2 class="card-text text-center"><?= $pesanan["jml_sewa"]; ?></h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card align-items-center">
                  <img src="../img/yeyy.png" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Jumlah Member</h5>
                    <h2 class="card-text text-center"><?= $user["jml_user"]; ?></h2>
                  </div>
                </div>
              </div>
            </div>

            <!-- Announcement Section -->
            <div class="announcement">
            <h3 class="judul">Pengumuman</h3>
            <hr>
            <div class="text p-2 mb-2">
                <div class="row">
                    <div class="col-xl-6">
                        <h6 class="text-muted">Pengumuman Admin</h6>
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                                        <i class="tf-icons bx bx-home"></i> Kebijakan Baru
                                        
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                                        <i class="tf-icons bx bx-user"></i> Jadwal Rapat
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
                                    <p>
                                        <strong>Kepada Seluruh Admin GorYuk,</strong>
                                    </p>
                                    <p>
                                        Kami ingin memberitahukan bahwa telah diberlakukan kebijakan baru mengenai penggunaan fasilitas dan penanganan keluhan pelanggan. Kebijakan ini bertujuan untuk meningkatkan kualitas layanan dan efisiensi operasional.
                                    </p>
                                    <p class="mb-0">
                                        Mohon untuk membaca dokumen kebijakan terbaru yang telah dikirimkan ke email Anda masing-masing. Jika ada pertanyaan atau membutuhkan klarifikasi lebih lanjut, jangan ragu untuk menghubungi manajemen.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                    <p>
                                        <strong>Perhatian Semua Admin,</strong>
                                    </p>
                                    <p>
                                        Kami akan mengadakan rapat bulanan pada <strong>Senin, 3 Juni 2024, pukul 10:00 WIB</strong> di ruang konferensi utama. Kehadiran Anda sangat diharapkan untuk membahas perkembangan terbaru dan rencana strategis ke depan.
                                    </p>
                                    <p class="mb-0">
                                        Agenda rapat akan mencakup evaluasi kinerja bulan lalu, diskusi tentang kebijakan baru, dan penyusunan rencana untuk proyek mendatang. Silakan siapkan laporan dan ide-ide Anda untuk rapat tersebut.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                    <p>
                                        <strong>Halo Tim Admin,</strong>
                                    </p>
                                    <p>
                                        Kami dengan senang hati mengumumkan beberapa proyek mendatang yang akan segera diluncurkan. Proyek ini termasuk pembaruan sistem reservasi, pengembangan aplikasi mobile, dan kampanye pemasaran baru untuk menarik lebih banyak pelanggan.
                                    </p>
                                    <p class="mb-0">
                                        Setiap admin akan diberikan tanggung jawab khusus terkait proyek-proyek ini. Detail lebih lanjut akan disampaikan dalam rapat bulanan kita. Kami mengharapkan partisipasi aktif dan kontribusi ide-ide kreatif dari semua anggota tim.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
    <h6 class="text-muted">Pengaduan Pelanggan</h6>
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-complaints" aria-controls="navs-justified-complaints" aria-selected="true">
                    <i class="tf-icons bx bx-error"></i> Keluhan
                    
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-justified-complaints" role="tabpanel">
                <?php if (!empty($complaints)): ?>
                    <?php foreach ($complaints as $complaint): ?>
                        <p>
                            <strong>Nama:</strong> <?= htmlspecialchars($complaint['name8']) ?><br>
                            <strong>Email:</strong> <?= htmlspecialchars($complaint['email8']) ?><br>
                            <strong>Phone:</strong> <?= htmlspecialchars($complaint['phone8']) ?><br>
                            <strong>Pesan:</strong><br>
                            <?= nl2br(htmlspecialchars($complaint['message8'])) ?>
                        </p>
                        <p class="mb-0">
                            <strong>Created At:</strong> <?= htmlspecialchars($complaint['created_at']) ?>
                        </p>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No complaints found</p>
                <?php endif; ?>
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
  </div>
  <!-- Footer -->
  <?php include 'controller/footer.php';?>