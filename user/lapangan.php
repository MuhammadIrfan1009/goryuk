<?php
session_start();
require "../functions.php";
require "../session.php";

// Cek apakah pengguna sudah login dan memiliki peran sebagai User
if ($role !== 'User') {
    header("location:../login.php");
    exit; // Terminate script execution after redirection
}

// Inisialisasi variabel pencarian
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Query untuk menampilkan data lapangan
// Menggunakan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare("SELECT * FROM lapangan8 WHERE nama8 LIKE ?");
$searchParam = "%{$searchQuery}%"; // Tambahkan wildcard (%) untuk pencarian
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$lapangan = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Pagination
$entriesPerPage = 5; // Jumlah entri per halaman
if (isset($_GET['entries'])) {
    $entriesPerPage = $_GET['entries'];
}

$page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
$start = ($page - 1) * $entriesPerPage; // Indeks awal entri pada halaman

// Hitung total jumlah entri yang sesuai dengan kueri pencarian
$countQuery = "SELECT COUNT(*) AS total FROM lapangan8 WHERE nama8 LIKE '%$searchQuery%'";
$countResult = $conn->query($countQuery);
$totalCount = $countResult->fetch_assoc()["total"];

// Hitung total halaman berdasarkan jumlah entri per halaman
$totalPages = ceil($totalCount / $entriesPerPage);

if (isset($_POST["pesan"])) {
    $result = pesan($_POST);
    if ($result === true) {
      echo "<script>
            alert('Berhasil Dipesan');
            document.location.href = 'bayar.php';
            </script>";
    } else {
      echo "<script>
            alert('$result');
            </script>";
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
    <?php include 'controller/link.php'; ?>

    <style>
        .footer {
            text-align: center;
            padding: 20px 0;
        }

        .nav {
            position: absolute;
        }

        #lapangan {
            margin-top: 135px;
        }
    </style>
</head>

<body>
    <?php include 'controller/header.php'; ?>
    <section class="lapangan" id="lapangan">
        <div class="container">
            <main class="contain" data-aos="fade-right" data-aos-duration="1000">
                <h2 class="text-head">Booking <span>Gor</span>Yuk</h2>
                <!-- Form Pencarian -->
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="testdatatable_length">
                            <label>
                                Show
                                <select name="testdatatable_length" aria-controls="testdatatable" class="form-select form-select-sm" onchange="window.location.href='lapangan.php?entries=' + this.value + '&search=<?= urlencode($searchQuery); ?>'">
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
                                <input type="search" class="form-control form-control-sm" placeholder aria-controls="testdatatable" value="<?= $searchQuery; ?>" onkeyup="if(event.keyCode == 13) { window.location.href='lapangan.php?search=' + this.value + '&entries=<?= $entriesPerPage; ?>' }">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-4">
                    <!-- Cards -->
                    <?php foreach ($lapangan as $row) : ?>
                        <!-- Card -->
                        <div class="col">
                            <div class="card h-100">
                                <img class="card-img-top" src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row["nama8"]; ?></h5>
                                    <p class="card-text"><?= $row["keterangan8"]; ?></p>
                                    <p class="card-price">Harga= Rp.<?= $row["harga8"]; ?></p>
                                    <p class="card-status">Status: <?= cekStatusLapangan($row["id_lapangan8"]); ?></p>
                                    <a href="jadwal.php?id=<?= $row["id_lapangan8"]; ?>" class="btn btn-outline-primary">Jadwal</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal<?= $row["id_lapangan8"]; ?>">Pesan</button>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Pesan -->
                        <div class="modal fade" id="pesanModal<?= $row["id_lapangan8"]; ?>" tabindex="-1" aria-labelledby="pesanModalLabel<?= $row["id_lapangan8"]; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pesanModalLabel<?= $row["id_lapangan8"]; ?>">Pesan Lapangan <?= $row["nama8"]; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
    <div class="modal-body">
        <div class="row justify-content-center align-items-center">
            <div class="mb-3">
                <img src="../img/<?= $row["foto8"]; ?>" alt="gambar lapangan" class="img-fluid">
            </div>
            <div class="text-center">
                <h6 name="harga">Harga : <?= $row["harga8"]; ?></h6>
            </div>
            <div class="col">
                <input type="hidden" name="id_lpg" class="form-control" value="<?= $row["id_lapangan8"]; ?>">
                <div class="mb-3">
                    <label for="tgl_main" class="form-label">Tanggal Main</label>
                    <input type="datetime-local" name="tgl_main" class="form-control" id="tgl_main" required>
                </div>
            </div>
            <div class="col">
                <input type="hidden" name="harga" class="form-control" value="<?= $row["harga8"]; ?>">
                <div class="mb-3">
                    <label for="lama" class="form-label">Lama Main (jam)</label>
                    <input type="number" name="lama" class="form-control" id="lama" min="1" step="1" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-outline-primary" name="pesan" id="pesan">Pesan</button>
    </div>
</form>
</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="testdatatable_info" role="status" aria-live="polite">
                            Showing <?= $start + 1; ?> to <?= min($start + $entriesPerPage, $totalCount); ?> of <?= $totalCount; ?> entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                        <div class="dataTables_paginate paging_simple_numbers" id="testdatatable_paginate">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li class="paginate_button page-item previous">
                                        <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Previous</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="paginate_button page-item <?= $i == $page ? 'active' : ''; ?>">
                                        <a href="?page=<?= $i; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="paginate_button page-item next">
                                        <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
    <?php include 'controller/footer.php'; ?>
</body>

</html>
