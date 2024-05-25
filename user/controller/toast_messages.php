<div id="toastAdd" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert"
aria-live="assertive" aria-atomic="true">
<div class="toast-header">
    <i class="bx bx-bell me-2"></i>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
    <div class="me-auto fw-semibold"><?php echo "$title ";?>Berhasil ditambahkan</div>
</div>
</div>

<div id="toastUpdate" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert"
aria-live="assertive" aria-atomic="true">
<div class="toast-header">
    <i class="bx bx-bell me-2"></i>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
    <div class="me-auto fw-semibold"><?php echo "$title ";?>Berhasil diPerbarui</div>
</div>
</div>

<div id="toastDelete" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert"
aria-live="assertive" aria-atomic="true">
<div class="toast-header">
    <i class="bx bx-bell me-2"></i>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">
    <div class="me-auto fw-semibold"><?php echo "$title ";?>Berhasil dihapus</div>
</div>
</div>

    <?php include "toast_notification.php"?>
    