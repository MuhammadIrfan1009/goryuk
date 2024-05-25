<?php
if(isset($_GET["status"])&&$_GET["status"]=="added"){
    echo '<script>
    $(document).ready(function(){
        $("#toastAdd").toast("show");
    })
    </script>';
}

elseif(isset($_GET["status"])&&$_GET["status"]=="updated"){
    echo '<script>
    $(document).ready(function(){
        $("#toastUpdate").toast("show");
    })
    </script>';
}

elseif(isset($_GET["status"])&&$_GET["status"]=="deleted"){
    echo '<script>
    $(document).ready(function(){
        $("#toastDelete").toast("show");
    })
    </script>';
}
?>