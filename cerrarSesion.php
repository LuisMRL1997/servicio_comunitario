<?php
session_start();
session_destroy();
header('Location: indexRegistros.php');
exit;
?>
