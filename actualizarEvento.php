<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Evento</title>
    <link rel="stylesheet" type="text/css" href="stylesRegistros.css">
</head>
<body>
<div class="header">
    <p id="fecha"></p>
    <div class="input-row">
        <div class="input-group">
            <img class="lHead" src="LogoHeader.png" alt="Logo">
        </div>
        <div class="input-group">
            <img class="padre" src="ImagenPadre.png" alt="Imagen del Padre">
            <p style='text-align: center; margin-left: 120px;'>Párroco Pbro Joel Javier<br>Escalante Buitrago</p>
        </div>
    </div>
    <script>
        var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
        var dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
        var fecha = new Date();
        var dia = dias[fecha.getDay()];
        var mes = meses[fecha.getMonth()];
        var diaDelMes = fecha.getDate();
        var año = fecha.getFullYear();
        document.getElementById("fecha").innerHTML = dia + ", " + mes + " " + diaDelMes + ", " + año;
    </script>
    <div class="menu-bar">
            <button id="cerrarSesion" onclick="window.location.href='indexRegistros.php'">Inicio</button>
            <button id="cerrarSesion" onclick="window.location.href='indexEventos.php'">Volver</button>
            <?php
            if (isset($_SESSION['nombre_usuario'])) {
                echo '<button id="cerrarSesion" onclick="window.location.href=\'cerrarSesion.php\'">Cerrar Sesión</button>';
            } else {
                echo '<button id="cerrarSesion" onclick="window.location.href=\'iniciarSesion.php\'">Iniciar Sesión</button>';
            }
            ?>

            <div class="menu-registros">
                <button>Registros</button>
                <div class="opciones-registros">
                    <a href="indexBautizo.php">Bautizos</a>
                    <a href="indexComunion.php">Comuniones</a>
                    <a href="indexConfirmacion.php">Confirmaciones</a>
                    <a href="indexMatrimonio.php">Matrimonios</a>
                    <?php
                    if (isset($user) && ($user['es_maestro'] || $user['es_administrador'])) {
                        echo '<a href="cuentasRegistradas.php">Cuentas</a>';
                    }
                    ?>
                </div>
            </div>
            <button id="cerrarSesion" onclick="window.location.href='indexEventos.php'">Eventos</button>
        </div>
    <div class="container">
<?php 

if(!isset($_POST["bot_actualizar"])){

  $Id=$_GET["id"];

  $tipo=$_GET["tipo"];

  $descripcion=$_GET["descripcion"];
  
  $dia=$_GET["dia"];
  
  $mes=$_GET["mes"];

  $ano=$_GET["ano"];

  $hora_inicio=$_GET["hora_inicio"];

  $hora_fin=$_GET["hora_fin"];

}else {

    $Id=$_POST["id"];

    $tipo=$_POST["tipo"];

    $descripcion=$_POST["descripcion"];
    
    $dia=$_POST["dia"];
    
    $mes=$_POST["mes"];
  
    $ano=$_POST["ano"];
  
    $hora_inicio=$_POST["hora_inicio"];
  
    $hora_fin=$_POST["hora_fin"];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['tipo']) || empty($_POST['descripcion']) ||
        empty($_POST['dia']) || empty($_POST['mes']) ||
        empty($_POST['ano']) || empty($_POST['hora_inicio']) ||
        empty($_POST['hora_fin'])) {          
        echo 'Por favor, completa todos los campos obligatorios.';
    } else {

//consulta SQL
$sql="UPDATE eventos SET tipo=:miTipo, descripcion=:miDescripcion, dia=:miDia,
mes=:miMes, ano=:miAno, hora_inicio=:miHoraInicio, hora_fin=:miHoraFin

WHERE id=:miId";

try {
    $db = new PDO('sqlite:Registros.db');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$resultado=$db->prepare($sql);

$resultado->execute(array(":miId"=>$Id, ":miTipo"=>$tipo, ":miDescripcion"=>$descripcion, ":miDia"=>$dia,
                          ":miMes"=>$mes, ":miAno"=>$ano, ":miHoraInicio"=>$hora_inicio,
                          ":miHoraFin"=>$hora_fin));

header("Location:indexEventos.php");

}
}
?>

<p></p>

<p> </p>
<form class="formulario-estilizado" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table >
<tr>
  <td><!-- Aquí estaría el nombre del label, de Id, pero es Hidden, tonces no es necesario --></td>
  <td><label for="id"></label>
  <input type="hidden" name="id" id="id" value="<?php echo $Id?>"></td>
</tr>

<div class="input-row">
        <div class="input-group">
            <label for="tipo" class="obligatorio">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $tipo?>" required>
        </div>
        <div class="input-group">
            <label for="descripcion" class="obligatorio">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion?>" required>
        </div>
        </div>
        <div class="input-row">
        <div class="input-group">
            <label for="dia" class="obligatorio">Día:</label>
            <input type="text" id="dia" name="dia" value="<?php echo $dia?>" required>
        </div>
        <div class="input-group">
            <label for="mes" class="obligatorio">Mes:</label>
            <input type="text" id="mes" name="mes" value="<?php echo $mes?>" required>
        </div>
        <div class="input-group">
            <label for="ano" class="obligatorio">Año:</label>
            <input type="text" id="ano" name="ano" value="<?php echo $ano?>" required>
        </div>
        </div>
        <div class="input-row">
        <div class="input-group">
            <label for="hora_inicio" class="obligatorio">Hora de inicio:</label>
            <input type="text" id="hora_inicio" name="hora_inicio" value="<?php echo $hora_inicio?>" required>
        </div>
        <div class="input-group">
            <label for="hora_fin" class="obligatorio">Hora de fin:</label>
            <input type="text" id="hora_fin" name="hora_fin" value="<?php echo $hora_fin?>" required>
        </div>
        </div>
    </div>
    </table>
    <tr>
      <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
    </tr>
    </form>
    <p> </p>
    </div>
    </body>
    </html>
