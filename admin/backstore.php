<?php
session_start();
require "../session.php";
require "../functions.php";


if ($role !== 'Admin') {
    header("location:../login.php");
    exit;
  }

// Database configuration
$host = 'localhost'; // host
$username = 'root'; // username
$password = ''; // password
$database_name = 'dbgoryuk'; // nama db
?>

<?php include 'controller/head.php'; ?>


<!-- Layout container -->
<div class="layout-page">
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Your content here -->
        <div class="col-11 p-5 mt-5">
            <!-- Content -->
            <div id="notification"></div>
            <div id="notification1"></div>
            <h3 class="judul">Backup and Restore</h3>

            <!-- Backup Card -->
        <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Backup Database</h5>
                    <form method="post" action="">
                        <button type="submit" name="backup" class="btn btn-primary">Backup Data</button>
                    </form>
                </div>
        </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Restore Database</h5>
                            <form method="post" enctype="multipart/form-data" action="">
                                <div class="row mb-3">
                                    <label for="backup_file" class="form-label">Pilih File Backup</label>
                                    <input type="file" class="form-control" id="backup_file" name="backup_file" accept=".sql" required>
                                </div>
                                <button type="submit" name="restore" class="btn btn-primary">Restore Data</button>
                            </form>
                        </div>
                    </div>

            <?php
           if (isset($_POST['backup'])) {
            // Nama file backup
            $backup_name = 'dbgoryuk';
        
            // Direktori untuk menyimpan file backup
            $backup_dir = 'C:/xampp/htdocs/goryuk/backup_files/data';
            if (!file_exists($backup_dir)) {
                mkdir($backup_dir, 0777, true);
            }
        
            $backup_file = $backup_dir . '/' . $backup_name . '_' . date('Y-m-d_H-i-s') . '.sql';
        
            
            $mysqldump_path = 'C:/xampp/mysql/bin/mysqldump.exe';
        
            // Perintah untuk melakukan backup database
            $command = "\"{$mysqldump_path}\" --user={$username} --password={$password} --host={$host} --routines --triggers {$database_name} > \"{$backup_file}\"";
        
            // Eksekusi perintah dan tangkap output serta status
            exec($command . ' 2>&1', $output, $status);
        
            // Log output
            $log_file = $backup_dir . '/backup_log.txt';
            $log_message = date('Y-m-d H:i:s') . " - Perintah backup: {$command}\nStatus: {$status}\nOutput: " . implode("\n", $output) . "\n\n";
            file_put_contents($log_file, $log_message, FILE_APPEND);
        
            // Cek apakah backup berhasil
            if ($status === 0) {
                $notification1 = "<div class='alert alert-success' role='alert'>Backup database berhasil.</div>";
            } else {
                $notification1 = "<div class='alert alert-danger' role='alert'>Backup database gagal.</div>";
            }
        }
        
        if (isset($_POST['restore'])) {
            // Mendapatkan file yang di-upload
            $backup_file = $_FILES['backup_file']['tmp_name'];
        
            // Path ke executable MySQL
            $mysql_path = "C:/xampp/mysql/bin/mysql";
        
            // Perintah untuk menghapus dan membuat ulang database RESTORE=
            $drop_command = "\"$mysql_path\" --user={$username} --password={$password} --host={$host} --execute=\"DROP DATABASE IF EXISTS {$database_name}; CREATE DATABASE {$database_name};\" 2>&1";
        
            // Eksekusi perintah drop database
            exec($drop_command, $output_drop, $status_drop);
        
            if ($status_drop === 0) {
                // Perintah untuk mengembalikan database dari file backup
                $restore_command = "\"$mysql_path\" --user={$username} --password={$password} --host={$host} {$database_name} < \"{$backup_file}\" 2>&1";
        
                // Eksekusi perintah restore database
                exec($restore_command, $output_restore, $status_restore);
        
                // Cek apakah restore berhasil
                if ($status_restore === 0) {
                    $notification = "<div class='alert alert-success' role='alert'>Restore database berhasil.</div>";
                } else {
                    $notification = "<div class='alert alert-danger' role='alert'>Error: Tidak dapat mengembalikan database. " . implode("\n", $output_restore) . "</div>";
                }
            }
        }
        ?>
        
        </div>
    </div>
    <!-- / Content wrapper -->
</div>
<!-- / Layout page -->

<script>
    // Tampilkan notifikasi setelah halaman dimuat sepenuhnya
    window.onload = function() {
        var notificationDiv = document.getElementById("notification");
        notificationDiv.innerHTML = "<?php echo $notification; ?>";
    };
</script>
<script>
    // Tampilkan notifikasi setelah halaman dimuat sepenuhnya
    window.onload = function() {
        var notificationDiv = document.getElementById("notification1");
        notificationDiv.innerHTML = "<?php echo $notification1; ?>";
    };
</script>

<?php include 'controller/footer.php'; ?>
