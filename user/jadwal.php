<?php
session_start();
require "../functions.php";
require "../session.php";

if ($role !== 'User') {
    header("location:../login.php");
    exit;
}

$id_user = $_SESSION["id_user"];
$id_lpg = isset($_GET["id"]) ? $_GET["id"] : 1; // Default to 1 if not provided

$now = date('Y-m-d H:i:s'); 

// Handle search query
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Handle pagination
$entriesPerPage = 5;
if (isset($_GET['entries'])) {
    $entriesPerPage = $_GET['entries'];
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $entriesPerPage;

$query = "
    SELECT sewa8.*, lapangan8.nama8, user8.nama_lengkap8
    FROM sewa8
    JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
    LEFT JOIN user8 ON sewa8.id_user8 = user8.id_user8
    JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8 
    WHERE lapangan8.id_lapangan8 = '$id_lpg'
    AND bayar8.konfirmasi8 = 'Terkonfirmasi'
    AND ('$now' < sewa8.jam_mulai8 AND '$now' < sewa8.jam_habis8)
    AND (sewa8.tanggal_pesan8 LIKE '%$searchQuery%' OR user8.nama_lengkap8 LIKE '%$searchQuery%' OR lapangan8.nama8 LIKE '%$searchQuery%' OR sewa8.jam_mulai8 LIKE '%$searchQuery%')
    LIMIT $start, $entriesPerPage
";
$countQuery = "
SELECT COUNT(*) AS total
FROM sewa8
JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
LEFT JOIN user8 ON sewa8.id_user8 = user8.id_user8
JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8 
WHERE lapangan8.id_lapangan8 = '$id_lpg'
AND bayar8.konfirmasi8 = 'Terkonfirmasi'
AND ('$now' < sewa8.jam_mulai8 AND '$now' < sewa8.jam_habis8)
AND (sewa8.tanggal_pesan8 LIKE '%$searchQuery%' OR user8.nama_lengkap8 LIKE '%$searchQuery%' OR lapangan8.nama8 LIKE '%$searchQuery%' OR sewa8.jam_mulai8 LIKE '%$searchQuery%')
";
$countResult = $conn->query($countQuery);
$totalCount = $countResult->fetch_assoc()["total"];
$totalPages = ceil($totalCount / $entriesPerPage);


// Menjalankan query
$result = $conn->query($query);

if (!$result) {
    die("Query error: " . $conn->error);
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
        #lapangan {
            margin-top: 135px; 
        }    
    </style>
</head>

<body>
<?php include 'controller/header.php'; ?>
    <section class="lapangan mb-5" id="lapangan">
        <div class="container-fluid">
            <h2 class="text-head"><span>Jadwal</span> Lapangan </h2>
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive text-nowrap">
                        <div id="testdatatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="testdatatable_length">
                                        <label>
                                            Show
                                            <select name="testdatatable_length" aria-controls="testdatatable" class="form-select form-select-sm" onchange="window.location.href='jadwal.php?id=<?= $id_lpg; ?>&entries=' + this.value + '&search=<?= $searchQuery; ?>'">
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
                                            <input type="search" class="form-control form-control-sm" placeholder aria-controls="testdatatable" value="<?= $searchQuery; ?>" onkeyup="if(event.keyCode == 13) { window.location.href='jadwal.php?id=<?= $id_lpg; ?>&search=' + this.value + '&entries=<?= $entriesPerPage; ?>' }">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="post" class="px-4">
                                <table class="table table-striped my-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal Pesan</th>
                                            <th scope="col">Nama Pemesan</th>
                                            <th scope="col">Nama Lapangan</th>
                                            <th scope="col">Jam Main</th>
                                            <th scope="col">Lama Sewa</th>
                                            <th scope="col">Jam Habis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = $start + 1; ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <th scope="row"><?= $i++; ?></th>
                                                <td><?= $row["tanggal_pesan8"] ?></td>
                                                <td><?= $row["nama_lengkap8"] ?></td>
                                                <td><?= $row["nama8"] ?></td>
                                                <td><?= $row["jam_mulai8"] ?></td>
                                                <td><?= $row["lama_sewa8"] ?></td>
                                                <td><?= $row["jam_habis8"] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </form>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="testdatatable_info" role="status" aria-live="polite">
                                        Showing <?= $start +
                                        1; ?> to <?= $start + $result->num_rows; ?> of <?= $totalCount; ?> entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                                        <div class="dataTables_paginate paging_simple_numbers" id="testdatatable_paginate">
                                            <ul class="pagination">
                                                <?php if ($page > 1): ?>
                                                    <li class="paginate_button page-item previous">
                                                        <a href="?id=<?= $id_lpg; ?>&page=<?= $page - 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Previous</a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li class="paginate_button page-item <?= $i == $page ? 'active' : ''; ?>">
                                                        <a href="?id=<?= $id_lpg; ?>&page=<?= $i; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link"><?= $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <?php if ($page < $totalPages): ?>
                                                    <li class="paginate_button page-item next">
                                                        <a href="?id=<?= $id_lpg; ?>&page=<?= $page + 1; ?>&search=<?= urlencode($searchQuery); ?>&entries=<?= $entriesPerPage; ?>" class="page-link">Next</a>
                                                    </li>
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
        </section>
        <?php include 'controller/footer.php'; ?>
    </body>
    </html>
    