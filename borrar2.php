<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
</head>
<body>
<?php

include("conexion2.php");

$Id = $_GET["id"];

$db->query("DELETE FROM [bautizos] WHERE [ID]='$Id'");

header("Location:indexBautizo.php");



?>
</body>
</html>