<?php

$conn = mysqli_connect("localhost", "root", "", "dbgoryuk");

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function hapusMember($id) {
  global $conn;

  // Pertama, hapus baris terkait di tabel bayar8
  $queryHapusBayar = "DELETE bayar8 FROM bayar8 
                      INNER JOIN sewa8 ON bayar8.id_sewa8 = sewa8.id_sewa8 
                      WHERE sewa8.id_user8 = ?";
  $stmt = $conn->prepare($queryHapusBayar);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $rowsAffectedBayar = $stmt->affected_rows;
  $stmt->close();

  // Kedua, hapus baris terkait di tabel sewa8
  $queryHapusSewa = "DELETE FROM sewa8 WHERE id_user8 = ?";
  $stmt = $conn->prepare($queryHapusSewa);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $rowsAffectedSewa = $stmt->affected_rows;
  $stmt->close();

  // Ketiga, hapus pengguna dari tabel user8
  $queryHapusUser = "DELETE FROM user8 WHERE id_user8 = ?";
  $stmt = $conn->prepare($queryHapusUser);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $rowsAffectedUser = $stmt->affected_rows;
  $stmt->close();

  // Mengembalikan jumlah total baris yang dihapus
  return $rowsAffectedBayar + $rowsAffectedSewa + $rowsAffectedUser;
}





function hapusLpg($id)
{
    global $conn;

    // Hapus terlebih dahulu data yang berkaitan dari tabel bayar8 dan sewa8
    $queryHapusBayar = "DELETE FROM bayar8 
                        WHERE id_sewa8 IN (SELECT id_sewa8 FROM sewa8 WHERE id_lapangan8 = ?)";
    $stmtBayar = $conn->prepare($queryHapusBayar);
    $stmtBayar->bind_param("i", $id);
    $stmtBayar->execute();
    $stmtBayar->close();

    $queryHapusSewa = "DELETE FROM sewa8 WHERE id_lapangan8 = ?";
    $stmtSewa = $conn->prepare($queryHapusSewa);
    $stmtSewa->bind_param("i", $id);
    $stmtSewa->execute();
    $stmtSewa->close();

    // Akhirnya, hapus data lapangan8 itu sendiri
    $queryHapusLapangan = "DELETE FROM lapangan8 WHERE id_lapangan8 = ?";
    $stmt = $conn->prepare($queryHapusLapangan);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    return true; // Atau Anda bisa menggunakan mysqli_affected_rows($conn) jika perlu
}


function hapusAdmin($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM admin8 WHERE id_user8 = $id");

  return mysqli_affected_rows($conn);
}

function hapusPesan($id)
{
    global $conn;

    // Enable MySQLi error reporting for detailed errors
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Start a transaction
        $conn->begin_transaction();

        // Delete related records in bayar8
        $stmt = $conn->prepare("DELETE FROM bayar8 WHERE id_sewa8 = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete the record in sewa8
        $stmt = $conn->prepare("DELETE FROM sewa8 WHERE id_sewa8 = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        return $affected_rows;
    } catch (mysqli_sql_exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        return -2; // Indicate that an error occurred
    }
}


function daftar($data)
{
  global $conn;

  // Ambil data dari form
  $username = strtolower(stripslashes($data["email"]));
  $password = $data["password"];
  $nama = $data["nama"];
  
  // Periksa apakah username sudah terdaftar
  $result = mysqli_query($conn, "SELECT email8 FROM user8 WHERE email8 = '$username'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>
            alert('Username sudah terdaftar!');
          </script>";
    return false;
  }

  // Masukkan data ke dalam database
  $query = "INSERT INTO user8 (email8, password8, no_handphone8, jenis_kelamin8, nama_lengkap8, alamat8, foto8) VALUES ('$username', '$password', NULL, NULL, '$nama', NULL, NULL)";
  mysqli_query($conn, $query);
  
  // Kembalikan jumlah baris yang terpengaruh
  return mysqli_affected_rows($conn);
}


function edit($data)
{
  global $conn;

  $userid = $_SESSION["id_user"];
  $username = strtolower(stripslashes($data["email"]));
  $nama = $data["nama_lengkap"];
  $no_handphone = $data["hp"];
  $gender = $data["jenis_kelamin"];
  $gambar = $data["foto"];
  $gambarLama = $data["fotoLama"];
 
  // Cek apakah User pilih gambar baru
  if ($_FILES["foto"]["error"] === 1) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }

  $query = "UPDATE user8 SET email8 = '$username', 
  nama_lengkap8 = '$nama',
  no_handphone8 = '$no_handphone',
  jenis_kelamin8 = '$gender',
  foto8 = '$gambar'
  WHERE id_user8 = '$userid'
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function pesan($data)
{
    global $conn;

    $userid = $_SESSION["id_user"];
    $idlpg = $data["id_lpg"];
    $lama = $data["lama"]; // Durasi dalam jam
    $mulai = $data["tgl_main"];

    // Mengubah waktu mulai ke format UNIX timestamp
    $mulai_waktu = strtotime($mulai);
    // Menghitung waktu selesai berdasarkan waktu mulai dan durasi
    $habis_waktu = $mulai_waktu + ($lama * 3600);
    // Mengubah waktu selesai kembali ke format datetime-local
    $habis = date('Y-m-d\TH:i:s', $habis_waktu);

    $harga = $data["harga"];
    $total = $lama * $harga;

    // Memeriksa apakah slot waktu sudah dipesan atau sudah dipesan dan dikonfirmasi
    $query = "SELECT * FROM sewa8 WHERE id_lapangan8 = '$idlpg' AND (
        ('$mulai' BETWEEN jam_mulai8 AND jam_habis8) OR 
        ('$habis' BETWEEN jam_mulai8 AND jam_habis8) OR 
        (jam_mulai8 BETWEEN '$mulai' AND '$habis') OR 
        (jam_habis8 BETWEEN '$mulai' AND '$habis')
    ) AND EXISTS (
        SELECT * FROM bayar8 WHERE id_sewa8 = sewa8.id_sewa8 AND konfirmasi8 = 'Terkonfirmasi'
    )";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        return "Maaf, lapangan tidak tersedia pada waktu tersebut.";
    } else {
        // Memanggil prosedur tersimpan untuk memasukkan data pemesanan
        $stmt = mysqli_prepare($conn, "CALL insert_sewa8(?, ?, ?, ?, ?, ?, ?, @last_id)");
        if ($stmt === false) {
            return "Error saat mempersiapkan statement: " . mysqli_error($conn);
        }
        mysqli_stmt_bind_param($stmt, 'iiissii', $userid, $idlpg, $lama, $mulai, $habis, $harga, $total);
        if (mysqli_stmt_execute($stmt) === false) {
            return "Error saat mengeksekusi statement: " . mysqli_stmt_error($stmt);
        }

        // Mengambil ID terakhir yang dimasukkan
        $result = mysqli_query($conn, "SELECT @last_id AS last_id");
        if ($result === false) {
            return "Error saat mengambil ID terakhir: " . mysqli_error($conn);
        }
        $row = mysqli_fetch_assoc($result);
        $last_id = $row['last_id'];

        if ($last_id) {
            return true;
        } else {
            return "Error saat menyimpan data.";
        } 
    }
}



function bayar($data)
{
    global $conn;
    $id_sewa = $data["id_sewa8"];

    // Upload Gambar
    $bukti_file = upload(); // Pastikan ini mengembalikan nama file yang diunggah
    if (!$bukti_file) {
        return false;
    }

    // Update status konfirmasi menjadi Sudah Bayar dan masukkan bukti pembayaran
    $query = "CALL set_status_bayar($id_sewa, '$bukti_file')";
    $result = mysqli_query($conn, $query);

    // Mengembalikan jumlah baris yang terpengaruh oleh query UPDATE
    $affected_rows = mysqli_affected_rows($conn);

    // Jika ada baris yang terpengaruh, berarti pembayaran berhasil
    if ($affected_rows > 0) {
        return $affected_rows;
    } else {
        return false;
    }
}




function tambahLpg($data)
{
    global $conn;

    $lapangan8 = mysqli_real_escape_string($conn, $data["lapangan"]);
    $harga = mysqli_real_escape_string($conn, $data["harga"]);
    $keterangan = mysqli_real_escape_string($conn, $data["keterangan"]);

    // Upload Gambar
    $upload = upload();
    if (!$upload) {
        return false;
    }

    // Prepare and bind parameterized query
    $query = "INSERT INTO lapangan8 (nama8, harga8, keterangan8, foto8) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $lapangan8, $harga, $keterangan, $upload);

    // Execute statement
    $stmt->execute();

    // Check affected rows
    $affectedRows = $stmt->affected_rows;

    // Close statement
    $stmt->close();

    return $affectedRows;
}



function upload()
{
    // Check if the 'foto' key exists in the $_FILES array
    if (!isset($_FILES['foto'])) {
        echo "<script>
        alert('No file uploaded.');
        </script>";
        return false;
    }

    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Check if no file was uploaded
    if ($error === 4) {
        echo "<script>
        alert('Pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    // Check if the uploaded file is an image
    $extensiValid = ['jpg', 'png', 'jpeg'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));

    if (!in_array($extensiGambar, $extensiValid)) {
        echo "<script>
        alert('Yang anda upload bukan gambar!');
        </script>";
        return false;
    }

    // Check if the file size is too large
    if ($ukuranFile > 20000000) {
        echo "<script>
        alert('Ukuran Gambar Terlalu Besar!');
        </script>";
        return false;
    }

    // Generate a new unique name for the file
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensiGambar;

    // Move the file to the designated folder
    if (move_uploaded_file($tmpName, '../img/' . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        echo "<script>
        alert('Failed to upload the file.');
        </script>";
        return false;
    }
}



function editLpg($data)
{
  global $conn;

  $id = $data["idlap"];
  $lapangan8 = $data["lapangan"];
  $ket = $data["ket"];
  $harga = $data["harga"];
  $gambarLama = $data["fotoLama"];

  // Check if the user uploaded a new image
  if ($_FILES["foto"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
    if (!$gambar) {
      return false;
    }
  }

  $query = "UPDATE lapangan8 SET 
  nama8 = '$lapangan8',
  keterangan8 = '$ket',
  harga8 = '$harga',
  foto8 = '$gambar' WHERE id_lapangan8 = '$id'
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tambahAdmin($data)
{
  global $conn;

  $username = $data["username"];
  $password = $data["password"];
  $nama = $data["nama"];
  $no_handphone= $data["hp"];
  $email = $data["email"];

  $query = "INSERT INTO admin8 (username8,password8,nama8,no_handphone8,email8) VALUES ('$username','$password','$nama','$no_handphone','$email')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function editAdmin($data)
{
  global $conn;

  $id = $data["id"];
  $username = $data["username"];
  $password = $data["password"];
  $nama = $data["nama"];
  $no_handphone= $data["hp"];
  $email = $data["email"];

  $query = "UPDATE admin8 SET 
  username8 = '$username',
  password8 = '$password',
  nama8 = '$nama',
  no_handphone8 = '$no_handphone',
  email8  = '$email' WHERE id_user8 = '$id'
  
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function konfirmasi($id_sewa)
{
    global $conn;

    $id = $id_sewa;

    mysqli_query($conn, "UPDATE bayar8 SET konfirmasi8 = 'Terkonfirmasi' WHERE id_sewa8 = '$id'");
    return mysqli_affected_rows($conn);
}



function cekStatusLapangan($id_lapangan) {
  global $conn;
  date_default_timezone_set('Asia/Jakarta'); 
  $now = date('Y-m-d H:i:s'); // Waktu sekarang dalam format yang sesuai

  // Query untuk mengecek apakah ada sewa yang aktif dan sudah dikonfirmasi untuk lapangan ini
  // Dengan melakukan join antara tabel sewa8 dan bayar8
  $query = "SELECT * FROM sewa8 s 
            JOIN bayar8 b ON s.id_sewa8 = b.id_sewa8
            WHERE s.id_lapangan8 = $id_lapangan 
            AND ('$now' BETWEEN s.jam_mulai8 AND s.jam_habis8)
            AND b.konfirmasi8 = 'Terkonfirmasi'";
  
  $result = mysqli_query($conn, $query);

  if (!$result) {
      die('Error: ' . mysqli_error($conn)); // Tambahkan debugging jika ada error pada query
  }

  return (mysqli_num_rows($result) > 0) ? 'Dipakai' : 'Kosong';
}
