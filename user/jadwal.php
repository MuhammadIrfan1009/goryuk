<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
    header("location:../login.php");
    exit;
}

$id_user = $_SESSION["id_user"];
$id_lpg = $_GET["id"];

$now = date('Y-m-d H:i:s'); 

$query = "
    SELECT sewa8.*, lapangan8.nama8, user8.nama_lengkap8
    FROM sewa8
    JOIN lapangan8 ON sewa8.id_lapangan8 = lapangan8.id_lapangan8
    LEFT JOIN user8 ON sewa8.id_user8 = user8.id_user8
    JOIN bayar8 ON sewa8.id_sewa8 = bayar8.id_sewa8
    WHERE lapangan8.id_lapangan8 = '$id_lpg'
    AND bayar8.konfirmasi8 = 'Terkonfirmasi'
    AND '$now' < sewa8.jam_mulai8
    AND '$now' < sewa8.jam_habis8
";

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
                            <?php $i = 1; ?>
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
            </div>
        </div>
    </section>
    <?php include 'controller/footer.php'; ?>
</body>

</html>
