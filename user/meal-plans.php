<?php
$title = "Plans";
$css = "register-dashboard.css"; 

ob_start();
?>




<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");

?>
