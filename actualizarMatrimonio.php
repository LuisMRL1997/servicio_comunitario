<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Matrimonio</title>
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
    <h1>Actualizar Matrimonio</h1>
    <div class="menu-bar">
            <button id="cerrarSesion" onclick="window.location.href='indexRegistros.php'">Inicio</button>
            <button id="cerrarSesion" onclick="window.location.href='indexMatrimonio.php'">Volver</button>
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

session_start();

if (isset($_SESSION['ULTIMA_ACTIVIDAD']) && (time() - $_SESSION['ULTIMA_ACTIVIDAD'] > 3600)) {
    // última actividad fue hace más de 5 minutos
    session_unset();     // vacía el array $_SESSION
    session_destroy();   // destruye la sesión
    header("Location: iniciarSesion.php"); // redirige al usuario a la página de inicio de sesión
}

$_SESSION['ULTIMA_ACTIVIDAD'] = time(); // actualiza el momento de la última actividad
include("conexion2.php");


if(!isset($_POST["bot_actualizar"])){

  $Id=$_GET["id"];

  $nom1_esposo=$_GET["nom1_esposo"];

  $nom2_esposo=$_GET["nom2_esposo"];
  
  $ape1_esposo=$_GET["ape1_esposo"];
  
  $ape2_esposo=$_GET["ape2_esposo"];

  $nom_papa1_esposo=$_GET["nom_papa1_esposo"];

  $nom_papa2_esposo=$_GET["nom_papa2_esposo"];

  $apepapa1_esposo=$_GET["apepapa1_esposo"];

  $apepapa2_esposo=$_GET["apepapa2_esposo"];

  $nom_mama1_esposo=$_GET["nom_mama1_esposo"];

  $nom_mama2_esposo=$_GET["nom_mama2_esposo"];

  $apemama1_esposo=$_GET["apemama1_esposo"];

  $apemama2_esposo=$_GET["apemama2_esposo"];

  $lugar_nac_esposo=$_GET["lugar_nac_esposo"];

  $estado_nac_esposo=$_GET["estado_nac_esposo"];

  $pais_nac_esposo=$_GET["pais_nac_esposo"];

  $dia_nac_esposo=$_GET["dia_nac_esposo"];

  $mes_nac_esposo=$_GET["mes_nac_esposo"];

  $ano_nac_esposo=$_GET["ano_nac_esposo"];

  $dia_bau_esposo=$_GET["dia_bau_esposo"];

  $mes_bau_esposo=$_GET["mes_bau_esposo"];

  $ano_bau_esposo=$_GET["ano_bau_esposo"];
  
  $iglesia_bau_esposo=$_GET["iglesia_bau_esposo"];
  
  $lugar_bau_esposo=$_GET["lugar_bau_esposo"];

  $estado_bau_esposo=$_GET["estado_bau_esposo"];

  $pais_bau_esposo=$_GET["pais_bau_esposo"];

  $dia_matrimonio=$_GET["dia_matrimonio"];

  $mes_matrimonio=$_GET["mes_matrimonio"];

  $ano_matrimonio=$_GET["ano_matrimonio"];

  $nom1_esposa=$_GET["nom1_esposa"];

  $nom2_esposa=$_GET["nom2_esposa"];
  
  $ape1_esposa=$_GET["ape1_esposa"];
  
  $ape2_esposa=$_GET["ape2_esposa"];

  $nom_papa1_esposa=$_GET["nom_papa1_esposa"];

  $nom_papa2_esposa=$_GET["nom_papa2_esposa"];

  $apepapa1_esposa=$_GET["apepapa1_esposa"];

  $apepapa2_esposa=$_GET["apepapa2_esposa"];

  $nom_mama1_esposa=$_GET["nom_mama1_esposa"];

  $nom_mama2_esposa=$_GET["nom_mama2_esposa"];

  $apemama1_esposa=$_GET["apemama1_esposa"];

  $apemama2_esposa=$_GET["apemama2_esposa"];

  $lugar_nac_esposa=$_GET["lugar_nac_esposa"];

  $estado_nac_esposa=$_GET["estado_nac_esposa"];

  $pais_nac_esposa=$_GET["pais_nac_esposa"];

  $dia_nac_esposa=$_GET["dia_nac_esposa"];

  $mes_nac_esposa=$_GET["mes_nac_esposa"];

  $ano_nac_esposa=$_GET["ano_nac_esposa"];

  $dia_bau_esposa=$_GET["dia_bau_esposa"];

  $mes_bau_esposa=$_GET["mes_bau_esposa"];

  $ano_bau_esposa=$_GET["ano_bau_esposa"];
    
  $iglesia_bau_esposa=$_GET["iglesia_bau_esposa"];
  
  $lugar_bau_esposa=$_GET["lugar_bau_esposa"];

  $estado_bau_esposa=$_GET["estado_bau_esposa"];

  $pais_bau_esposa=$_GET["pais_bau_esposa"];

  $nom_padri1_esposo=$_GET["nom_padri1_esposo"];

  $nom_padri2_esposo=$_GET["nom_padri2_esposo"];

  $apepadri1_esposo=$_GET["apepadri1_esposo"];

  $apepadri2_esposo=$_GET["apepadri2_esposo"];

  $nom_madri1_esposo=$_GET["nom_madri1_esposo"];

  $nom_madri2_esposo=$_GET["nom_madri2_esposo"];

  $apemadri1_esposo=$_GET["apemadri1_esposo"];

  $apemadri2_esposo=$_GET["apemadri2_esposo"];

  $nom_padri1_esposa=$_GET["nom_padri1_esposa"];

  $nom_padri2_esposa=$_GET["nom_padri2_esposa"];

  $apepadri1_esposa=$_GET["apepadri1_esposa"];

  $apepadri2_esposa=$_GET["apepadri2_esposa"];

  $nom_madri1_esposa=$_GET["nom_madri1_esposa"];

  $nom_madri2_esposa=$_GET["nom_madri2_esposa"];

  $apemadri1_esposa=$_GET["apemadri1_esposa"];

  $apemadri2_esposa=$_GET["apemadri2_esposa"];

  $nom_minis1=$_GET["nom_minis1"];

  $nom_minis2=$_GET["nom_minis2"];

  $apeminis1=$_GET["apeminis1"];

  $apeminis2=$_GET["apeminis2"];

  $numLibro_matrimonio=$_GET["numLibro_matrimonio"];

  $folio_matrimonio=$_GET["folio_matrimonio"];

  $numeral_matrimonio=$_GET["numeral_matrimonio"];

  $notaMar_matrimonio=$_GET["notaMar_matrimonio"];

  $finalidad=$_GET["finalidad"];

}else {

    $Id=$_POST["id"];

    $nom1_esposo=$_POST["nom1_esposo"];
  
    $nom2_esposo=$_POST["nom2_esposo"];
    
    $ape1_esposo=$_POST["ape1_esposo"];
    
    $ape2_esposo=$_POST["ape2_esposo"];
  
    $nom_papa1_esposo=$_POST["nom_papa1_esposo"];
  
    $nom_papa2_esposo=$_POST["nom_papa2_esposo"];
  
    $apepapa1_esposo=$_POST["apepapa1_esposo"];
  
    $apepapa2_esposo=$_POSTT["apepapa2_esposo"];
  
    $nom_mama1_esposo=$_POST["nom_mama1_esposo"];
  
    $nom_mama2_esposo=$_POST["nom_mama2_esposo"];
  
    $apemama1_esposo=$_POST["apemama1_esposo"];
  
    $apemama2_esposo=$_POST["apemama2_esposo"];
  
    $lugar_nac_esposo=$_POST["lugar_nac_esposo"];
  
    $estado_nac_esposo=$_POST["estado_nac_esposo"];
  
    $pais_nac_esposo=$_POST["pais_nac_esposo"];
  
    $dia_nac_esposo=$_POST["dia_nac_esposo"];
  
    $mes_nac_esposo=$_POST["mes_nac_esposo"];
  
    $ano_nac_esposo=$_POST["ano_nac_esposo"];
  
    $dia_bau_esposo=$_POST["dia_bau_esposo"];
  
    $mes_bau_esposo=$_POST["mes_bau_esposo"];
  
    $ano_bau_esposo=$_POST["ano_bau_esposo"];

    $iglesia_bau_esposo=$_POST["iglesia_bau_esposo"];
  
    $lugar_bau_esposo=$_POST["lugar_bau_esposo"];
  
    $estado_bau_esposo=$_POST["estado_bau_esposo"];
  
    $pais_bau_esposo=$_POST["pais_bau_esposo"];
  
    $dia_matrimonio=$_POST["dia_matrimonio"];
  
    $mes_matrimonio=$_POST["mes_matrimonio"];
  
    $ano_matrimonio=$_POST["ano_matrimonio"];
  
    $nom1_esposa=$_POST["nom1_esposa"];
  
    $nom2_esposa=$_POST["nom2_esposa"];
    
    $ape1_esposa=$_POST["ape1_esposa"];
    
    $ape2_esposa=$_POST["ape2_esposa"];
  
    $nom_papa1_esposa=$_POST["nom_papa1_esposa"];
  
    $nom_papa2_esposa=$_POST["nom_papa2_esposa"];
  
    $apepapa1_esposa=$_POST["apepapa1_esposa"];
  
    $apepapa2_esposa=$_POST["apepapa2_esposa"];
  
    $nom_mama1_esposa=$_POST["nom_mama1_esposa"];
  
    $nom_mama2_esposa=$_POST["nom_mama2_esposa"];
  
    $apemama1_esposa=$_POST["apemama1_esposa"];
  
    $apemama2_esposa=$_POST["apemama2_esposa"];
  
    $lugar_nac_esposa=$_POST["lugar_nac_esposa"];
  
    $estado_nac_esposa=$_POST["estado_nac_esposa"];
  
    $pais_nac_esposa=$_POST["pais_nac_esposa"];
  
    $dia_nac_esposa=$_POST["dia_nac_esposa"];
  
    $mes_nac_esposa=$_POST["mes_nac_esposa"];
  
    $ano_nac_esposa=$_POST["ano_nac_esposa"];
  
    $dia_bau_esposa=$_POST["dia_bau_esposa"];
  
    $mes_bau_esposa=$_POST["mes_bau_esposa"];
  
    $ano_bau_esposa=$_POST["ano_bau_esposa"];

    $iglesia_bau_esposa=$_POST["iglesia_bau_esposa"];
  
    $lugar_bau_esposa=$_POST["lugar_bau_esposa"];
  
    $estado_bau_esposa=$_POST["estado_bau_esposa"];
  
    $pais_bau_esposa=$_POST["pais_bau_esposa"];
  
    $nom_padri1_esposo=$_POST["nom_padri1_esposo"];
  
    $nom_padri2_esposo=$_POST["nom_padri2_esposo"];
  
    $apepadri1_esposo=$_POST["apepadri1_esposo"];
  
    $apepadri2_esposo=$_POST["apepadri2_esposo"];
  
    $nom_madri1_esposo=$_POST["nom_madri1_esposo"];
  
    $nom_madri2_esposo=$_POST["nom_madri2_esposo"];
  
    $apemadri1_esposo=$_POST["apemadri1_esposo"];
  
    $apemadri2_esposo=$_POST["apemadri2_esposo"];
  
    $nom_padri1_esposa=$_POST["nom_padri1_esposa"];
  
    $nom_padri2_esposa=$_POST["nom_padri2_esposa"];
  
    $apepadri1_esposa=$_POST["apepadri1_esposa"];
  
    $apepadri2_esposa=$_POST["apepadri2_esposa"];
  
    $nom_madri1_esposa=$_POST["nom_madri1_esposa"];
  
    $nom_madri2_esposa=$_POST["nom_madri2_esposa"];
  
    $apemadri1_esposa=$_POST["apemadri1_esposa"];
  
    $apemadri2_esposa=$_POST["apemadri2_esposa"];
  
    $nom_minis1=$_POST["nom_minis1"];
  
    $nom_minis2=$_POST["nom_minis2"];
  
    $apeminis1=$_POST["apeminis1"];
  
    $apeminis2=$_POST["apeminis2"];
  
    $numLibro_matrimonio=$_POST["numLibro_matrimonio"];
  
    $folio_matrimonio=$_POST["folio_matrimonio"];
  
    $numeral_matrimonio=$_POST["numeral_matrimonio"];
  
    $notaMar_matrimonio=$_POST["notaMar_matrimonio"];
  
    $finalidad=$_GET["finalidad"];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (empty($_POST['primer_nombre_esposo']) || empty($_POST['primer_apellido_esposo']) ||
      empty($_POST['primer_nombre_papa_esposo']) || empty($_POST['primer_apellido_papa_esposo']) ||
      empty($_POST['primer_nombre_mama_esposo']) || empty($_POST['primer_apellido_mama_esposo']) ||
      empty($_POST['lugar_de_nacimiento_esposo']) || empty($_POST['estado_de_nacimiento_esposo']) ||
      empty($_POST['pais_de_nacimiento_esposo']) || empty($_POST['dia_de_nacimiento_esposo']) ||
      empty($_POST['mes_de_nacimiento_esposo']) || empty($_POST['ano_de_nacimiento_esposo']) || 
      empty($_POST['dia_de_bautizo_esposo']) || empty($_POST['mes_de_bautizo_esposo']) || 
      empty($_POST['ano_de_bautizo_esposo']) || empty($_POST['iglesia_de_bautizo_esposo']) || 
      empty($_POST['lugar_de_bautizo_esposo']) || empty($_POST['estado_de_bautizo_esposo']) ||
      empty($_POST['pais_de_bautizo_esposo']) || empty($_POST['dia_de_matrimonio']) || 
      empty($_POST['mes_de_matrimonio']) || empty($_POST['ano_de_matrimonio']) ||
      empty($_POST['primer_nombre_esposa']) || empty($_POST['primer_apellido_esposa']) ||
      empty($_POST['primer_nombre_papa_esposa']) || empty($_POST['primer_apellido_papa_esposa']) ||
      empty($_POST['primer_nombre_mama_esposa']) || empty($_POST['primer_apellido_mama_esposa']) ||
      empty($_POST['lugar_de_nacimiento_esposa']) || empty($_POST['estado_de_nacimiento_esposa']) ||
      empty($_POST['pais_de_nacimiento_esposa']) || empty($_POST['dia_de_nacimiento_esposa']) ||
      empty($_POST['mes_de_nacimiento_esposa']) || empty($_POST['ano_de_nacimiento_esposa']) || 
      empty($_POST['dia_de_bautizo_esposa']) || empty($_POST['mes_de_bautizo_esposa']) || 
      empty($_POST['ano_de_bautizo_esposa']) || empty($_POST['iglesia_de_bautizo_esposa']) || 
      empty($_POST['lugar_de_bautizo_esposa']) || empty($_POST['estado_de_bautizo_esposa']) ||
      empty($_POST['pais_de_bautizo_esposa']) || empty($_POST['primer_nombre_papa_esposo']) || 
      empty($_POST['primer_apellido_padrino_esposo']) || empty($_POST['primer_nombre_madrina_esposo']) || 
      empty($_POST['primer_apellido_madrina_esposo']) || empty($_POST['primer_nombre_padrino_esposa']) || 
      empty($_POST['primer_apellido_padrino_esposa']) || empty($_POST['primer_nombre_madrina_esposa']) || 
      empty($_POST['primer_apellido_madrina_esposa']) || empty($_POST['primer_nombre_ministro']) || 
      empty($_POST['primer_apellido_ministro']) || empty($_POST['numLibro_matrimonio']) || 
      empty($_POST['folio_matrimonio']) || empty($_POST['numeral_matrimonio']) ||
      empty($_POST['NotaMar_matrimonio']) || empty($_POST['finalidad'])) {          
          echo 'Por favor, completa todos los campos obligatorios.';
      } else if ((empty($_POST['primer_nombre_padrino_esposo']) && empty($_POST['primer_apellido_padrino_esposo'])) && (empty($_POST['primer_nombre_madrina_esposo']) && empty($_POST['primer_apellido_madrina_esposo']))) {
          echo 'Por favor, completa los campos requeridos de los padrinos del esposo.';
      } else if ((empty($_POST['primer_nombre_padrino_esposa']) && empty($_POST['primer_apellido_padrino_esposa'])) && (empty($_POST['primer_nombre_madrina_esposa']) && empty($_POST['primer_apellido_madrina_esposa']))) {
        echo 'Por favor, completa los campos requeridos de los padrinos de la esposa.';
      } else if ((empty($_POST['primer_nombre_papa_esposo']) && empty($_POST['primer_apellido_papa_esposo'])) && (empty($_POST['primer_nombre_mama_esposo']) && empty($_POST['primer_apellido_mama_esposo']))) {
          echo 'Por favor, completa los campos requeridos de los padres del esposo.';
      } else if ((empty($_POST['primer_nombre_papa_esposa']) && empty($_POST['primer_apellido_papa_esposa'])) && (empty($_POST['primer_nombre_mama_esposa']) && empty($_POST['primer_apellido_mama_esposa']))) {
        echo 'Por favor, completa los campos requeridos de los padres de la esposa.';
      } else {

  //consulta SQL
  $sql="UPDATE matrimonios SET primer_nombre_esposo=:miPrimerNombre_esposo, segundo_nombre_esposo=:miSegundoNombre_esposo, primer_apellido_esposo=:miPrimerApellido_esposo,
  segundo_apellido_esposo=:miSegundoApellido_esposo, primer_nombre_papa_esposo=:miPrimerNombrePapa_esposo, segundo_nombre_papa_esposo=:miSegundoNombrePapa_esposo,
  primer_apellido_papa_esposo=:miPrimerApellidoPapa_esposo, segundo_apellido_papa_esposo=:miSegundoApellidoPapa_esposo, primer_nombre_mama_esposo=:miPrimerNombreMama_esposo,
  segundo_nombre_mama_esposo=:miSegundoNombreMama_esposo, primer_apellido_mama_esposo=:miPrimerApellidoMama_esposo, segundo_apellido_mama_esposo=:miSegundoApellidoMama_esposo,
  lugar_de_nacimiento_esposo=:miLugardeNacimiento_esposo, estado_de_nacimiento_esposo=:miEstadodeNacimiento_esposo, pais_de_nacimiento_esposo=:miPaisdeNacimiento_esposo, 
  dia_de_nacimiento_esposo=:miDiadeNacimiento_esposo, mes_de_nacimiento_esposo=:miMesdeNacimiento_esposo, ano_de_nacimiento_esposo=:miAnodeNacimiento_esposo, 
  dia_de_bautizo_esposo=:miDiadeBautizo_esposo, mes_de_bautizo_esposo=:miMesdeBautizo_esposo, ano_de_bautizo_esposo=:miAnodeBautizo_esposo, iglesia_de_bautizo_esposo=:miIglesiadeBautizo_esposo, 
  lugar_de_bautizo_esposo=:miLugardeBautizo_esposo, estado_de_bautizo_esposo=:miEstadodeBautizo_esposo, pais_de_bautizo_esposo=:miPaisdeBautizo_esposo, dia_de_matrimonio=:miDiade_matrimonio, 
  mes_de_matrimonio=:miMesde_matrimonio, ano_de_matrimonio=:miAnode_matrimonio, primer_nombre_esposa=:miPrimerNombre_esposa, segundo_nombre_esposa=:miSegundoNombre_esposa, 
  primer_apellido_esposa=:miPrimerApellido_esposa, segundo_apellido_esposa=:miSegundoApellido_esposa, primer_nombre_papa_esposa=:miPrimerNombrePapa_esposa, 
  segundo_nombre_papa_esposa=:miSegundoNombrePapa_esposa, primer_apellido_papa_esposa=:miPrimerApellidoPapa_esposa, segundo_apellido_papa_esposa=:miSegundoApellidoPapa_esposa, 
  primer_nombre_mama_esposa=:miPrimerNombreMama_esposa, segundo_nombre_mama_esposa=:miSegundoNombreMama_esposa, primer_apellido_mama_esposa=:miPrimerApellidoMama_esposa, 
  segundo_apellido_mama_esposa=:miSegundoApellidoMama_esposa, lugar_de_nacimiento_esposa=:miLugardeNacimiento_esposa, estado_de_nacimiento_esposa=:miEstadodeNacimiento_esposa, 
  pais_de_nacimiento_esposa=:miPaisdeNacimiento_esposa, dia_de_nacimiento_esposa=:miDiadeNacimiento_esposa, mes_de_nacimiento_esposa=:miMesdeNacimiento_esposa, 
  ano_de_nacimiento_esposa=:miAnodeNacimiento_esposa, dia_de_bautizo_esposa=:miDiadeBautizo_esposa, mes_de_bautizo_esposa=:miMesdeBautizo_esposa, ano_de_bautizo_esposa=:miAnodeBautizo_esposa,
  iglesia_de_bautizo_esposa=:miIglesiadeBautizo_esposa, lugar_de_bautizo_esposa=:miLugardeBautizo_esposa, estado_de_bautizo_esposa=:miEstadodeBautizo_esposa, pais_de_bautizo_esposa=:miPaisdeBautizo_esposa, 
  primer_nombre_padrino_esposo=:miPrimerNombrePadrino_esposo, segundo_nombre_padrino_esposo=:miSegundoNombrePadrino_esposo, primer_apellido_padrino_esposo=:miPrimerApellidoPadrino_esposo, 
  segundo_apellido_padrino_esposo=:miSegundoApellidoPadrino_esposo, primer_nombre_madrina_esposo=:miPrimerNombremadrina_esposo, segundo_nombre_madrina_esposo=:miSegundoNombremadrina_esposo, 
  primer_apellido_madrina_esposo=:miPrimerApellidomadrina_esposo, segundo_apellido_madrina_esposo=:miSegundoApellidomadrina_esposo, primer_nombre_padrino_esposa=:miPrimerNombrePadrino_esposa,
  segundo_nombre_padrino_esposa=:miSegundoNombrePadrino_esposa, primer_apellido_padrino_esposa=:miPrimerApellidoPadrino_esposa, segundo_apellido_padrino_esposa=:miSegundoApellidoPadrino_esposa, 
  primer_nombre_madrina_esposa=:miPrimerNombremadrina_esposa, segundo_nombre_madrina_esposa=:miSegundoNombremadrina_esposa, primer_apellido_madrina_esposa=:miPrimerApellidomadrina_esposa,
  segundo_apellido_madrina_esposa=:miSegundoApellidomadrina_esposa, primer_nombre_ministro=:miPrimerNombreMinistro, segundo_nombre_ministro=:miSegundoNombreMinistro, 
  primer_apellido_ministro=:miPrimerApellidoMinistro, segundo_apellido_ministro=:miSegundoApellidoMinistro, numLibro_matrimonio=:miNumLibro_matrimonio, folio_matrimonio=:miFolio_matrimonio, 
  numeral_matrimonio=:miNumeral_matrimonio, notaMar_matrimonio=:miNotaMar_matrimonio, finalidad=:miFinalidad 
  
  WHERE id=:miId";
  try {
      $db = new PDO('sqlite:Registros.db');
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  $resultado=$db->prepare($sql);

  $resultado->execute(array(":miId"=>$Id, ":miPrimerNombre_esposo"=>$nom1_esposo, ":miSegundoNombre_esposo"=>$nom2_esposo, ":miPrimerApellido_esposo"=>$ape1_esposo,
                            ":miSegundoApellido_esposo"=>$ape2_esposo, ":miPrimerNombrePapa_esposo"=>$nom_papa1_esposo, ":miSegundoNombrePapa_esposo"=>$nom_papa2_esposo,
                            ":miPrimerApellidoPapa_esposo"=>$apepapa1_esposo, ":miSegundoApellidoPapa_esposo"=>$apepapa2_esposo, ":miPrimerNombreMama_esposo"=>$nom_mama1_esposo, 
                            ":miSegundoNombreMama_esposo"=>$nom_mama2_esposo, ":miPrimerApellidoMama_esposo"=>$apemama1_esposo, ":miSegundoApellidoMama_esposo"=>$apemama2_esposo,
                            ":miLugardeNacimiento_esposo"=>$lugar_nac_esposo, ":miEstadodeNacimiento_esposo"=>$estado_nac_esposo, ":miPaisdeNacimiento_esposo"=>$pais_nac_esposo,
                            ":miDiadeNacimiento_esposo"=>$dia_nac_esposo, ":miMesdeNacimiento_esposo"=>$mes_nac_esposo, ":miAnodeNacimiento_esposo"=>$ano_nac_esposo, 
                            ":miDiadeBautizo_esposo"=>$dia_bau_esposo, ":miMesdeBautizo_esposo"=>$mes_bau_esposo, ":miAnodeBautizo_esposo"=>$ano_bau_esposo, 
                            ":miIglesiadeBautizo_esposo"=>$iglesia_bau_esposo, ":miLugardeBautizo_esposo"=>$lugar_bau_esposo, ":miEstadodeBautizo_esposo"=>$estado_bau_esposo, ":miPaisdeBautizo_esposo"=>$pais_bau_esposo,
                            ":miDiade_matrimonio"=>$dia_matrimonio, ":miMesde_matrimonio"=>$mes_matrimonio, ":miAnode_matrimonio"=>$ano_matrimonio, 
                            ":miPrimerNombre_esposa"=>$nom1_esposa, ":miSegundoNombre_esposa"=>$nom2_esposa, ":miPrimerApellido_esposa"=>$ape1_esposa,
                            ":miSegundoApellido_esposa"=>$ape2_esposa, ":miPrimerNombrePapa_esposa"=>$nom_papa1_esposa, ":miSegundoNombrePapa_esposa"=>$nom_papa2_esposa,
                            ":miPrimerApellidoPapa_esposa"=>$apepapa1_esposa, ":miSegundoApellidoPapa_esposa"=>$apepapa2_esposa, ":miPrimerNombreMama_esposa"=>$nom_mama1_esposa, 
                            ":miSegundoNombreMama_esposa"=>$nom_mama2_esposa, ":miPrimerApellidoMama_esposa"=>$apemama1_esposa, ":miSegundoApellidoMama_esposa"=>$apemama2_esposa,
                            ":miLugardeNacimiento_esposa"=>$lugar_nac_esposa, ":miEstadodeNacimiento_esposa"=>$estado_nac_esposa, ":miPaisdeNacimiento_esposa"=>$pais_nac_esposa,
                            ":miDiadeNacimiento_esposa"=>$dia_nac_esposa, ":miMesdeNacimiento_esposa"=>$mes_nac_esposa, ":miAnodeNacimiento_esposa"=>$ano_nac_esposa, 
                            ":miDiadeBautizo_esposa"=>$dia_bau_esposa, ":miMesdeBautizo_esposa"=>$mes_bau_esposa, ":miAnodeBautizo_esposa"=>$ano_bau_esposa, 
                            ":miIglesiadeBautizo_esposa"=>$iglesia_bau_esposa, ":miLugardeBautizo_esposa"=>$lugar_bau_esposa, ":miEstadodeBautizo_esposa"=>$estado_bau_esposa, ":miPaisdeBautizo_esposa"=>$pais_bau_esposa,
                            ":miPrimerNombrePadrino_esposo"=>$nom_padri1_esposo, ":miSegundoNombrePadrino_esposo"=>$nom_padri2_esposo, ":miPrimerApellidoPadrino_esposo"=>$apepadri1_esposo,
                            ":miSegundoApellidoPadrino_esposo"=>$apepadri2_esposo, ":miPrimerNombremadrina_esposo"=>$nom_madri1_esposo, ":miSegundoNombremadrina_esposo"=>$nom_madri2_esposo, 
                            ":miPrimerApellidomadrina_esposo"=>$apemadri1_esposo, ":miSegundoApellidomadrina_esposo"=>$apemadri2_esposo, ":miPrimerNombrePadrino_esposa"=>$nom_padri1_esposa, 
                            ":miSegundoNombrePadrino_esposa"=>$nom_padri2_esposa, ":miPrimerApellidoPadrino_esposa"=>$apepadri1_esposa, ":miSegundoApellidoPadrino_esposa"=>$apepadri2_esposa, 
                            ":miPrimerNombremadrina_esposa"=>$nom_madri1_esposa, ":miSegundoNombremadrina_esposa"=>$nom_madri2_esposa, ":miPrimerApellidomadrina_esposa"=>$apemadri1_esposa, 
                            ":miSegundoApellidomadrina_esposa"=>$apemadri2_esposa,":miPrimerNombreMinistro"=>$nom_minis1, ":miSegundoNombreMinistro"=>$nom_minis2, 
                            ":miPrimerApellidoMinistro"=>$apeminis1, ":miSegundoApellidoMinistro"=>$apeminis2, ":miNumLibro_matrimonio"=>$numLibro_matrimonio, ":miFolio_matrimonio"=>$folio_matrimonio, 
                            ":miNumeral_matrimonio"=>$numeral_matrimonio, ":miNotaMar_matrimonio"=>$notaMar_matrimonio, ":miFinalidad"=>$finalidad));

  header("Location:indexMatrimonio.php");

}
}
}
?>


<p></p>

<p>&nbsp;</p>
<form class="formulario-estilizado" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <table>
        <tr>
            <td><!-- Aquí estaría el nombre del label, de Id, pero es Hidden, tonces no es necesario --></td>
            <td><label for="id"></label>
            <input type="hidden" name="id" id="id" value="<?php echo $Id?>"></td>
        </tr>

        <div class="input-row">
            <div class="input-group">
                <label for="nom1_esposo" class="obligatorio">Primer Nombre del esposo:</label>
                <input type="text" id="nom1_esposo" name="nom1_esposo" value="<?php echo $nom1_esposo?>" required>
            </div>
            <div class="input-group">
                <label for="nom2_esposo">Segundo Nombre del esposo:</label>
                <input type="text" id="nom2_esposo" name="nom2_esposo" value="<?php echo $nom2_esposo?>">
            </div>
            <div class="input-group">
                <label for="ape1_esposo" class="obligatorio">Primer Apellido del esposo:</label>
                <input type="text" id="ape1_esposo" name="ape1_esposo" value="<?php echo $ape1_esposo?>" required>
            </div>
            <div class="input-group">
                <label for="ape2_esposo">Segundo Apellido del esposo:</label>
                <input type="text" id="ape2_esposo" name="ape2_esposo" value="<?php echo $ape2_esposo?>">
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_nac_esposo" class="obligatorio">Ciudad de Nacimiento del esposo:</label><br>
                <input type="text" id="lugar_nac_esposo" name="lugar_nac_esposo" value="<?php echo $lugar_nac_esposo?>" required><br>
            </div>
            <div class="input-group">
                <label for="estado_nac_esposo">Estado de Nacimiento del esposo:</label><br>
                <input type="text" id="estado_nac_esposo" name="estado_nac_esposo" value="<?php echo $estado_nac_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="pais_nac_esposo">Pais de Nacimiento del esposo:</label><br>
                <input type="text" id="pais_nac_esposo" name="pais_nac_esposo" value="<?php echo $pais_nac_esposo?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_nac_esposo" class="obligatorio">Día de Nacimiento del esposo:</label><br>
                <input type="text" id="dia_nac_esposo" name="dia_nac_esposo" value="<?php echo $dia_nac_esposo?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_nac_esposo" class="obligatorio">Mes de Nacimiento del esposo:</label><br>
                <input type="text" id="mes_nac_esposo" name="mes_nac_esposo" value="<?php echo $mes_nac_esposo?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_nac_esposo" class="obligatorio">Año de Nacimiento del esposo:</label><br>
                <input type="text" id="ano_nac_esposo" name="ano_nac_esposo" value="<?php echo $ano_nac_esposo?>" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_bau_esposo" class="obligatorio">Día de Bautizo del esposo:</label><br>
                <input type="text" id="dia_bau_esposo" name="dia_bau_esposo" value="<?php echo $dia_bau_esposo?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_bau_esposo" class="obligatorio">Mes de Bautizo del esposo:</label><br>
                <input type="text" id="mes_bau_esposo" name="mes_bau_esposo" value="<?php echo $mes_bau_esposo?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_bau_esposo" class="obligatorio">Año de Bautizo del esposo:</label><br>
                <input type="text" id="ano_bau_esposo" name="ano_bau_esposo" value="<?php echo $ano_bau_esposo?>" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="iglesia_bau_esposo" class="obligatorio">Iglesia de Bautizo del esposo:</label><br>
                <input type="text" id="iglesia_bau_esposo" name="iglesia_bau_esposo" value="<?php echo $iglesia_bau_esposo?>" required><br>
            </div>
            <div class="input-group">
                <label for="lugar_bau_esposo" class="obligatorio">Ciudad de Bautizo del esposo:</label><br>
                <input type="text" id="lugar_bau_esposo" name="lugar_bau_esposo" value="<?php echo $lugar_bau_esposo?>" required><br>
            </div>
            <div class="input-group">
                <label for="estado_bau_esposo">Estado de Bautizo del esposo:</label><br>
                <input type="text" id="estado_bau_esposo" name="estado_bau_esposo" value="<?php echo $estado_bau_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="pais_bau_esposo">Pais de Bautizo del esposo:</label><br>
                <input type="text" id="pais_bau_esposo" name="pais_bau_esposo" value="<?php echo $pais_bau_esposo?>"><br>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label for="nom_papa1_esposo">Primer Nombre Papá del esposo:</label>
                <input type="text" id="nom_papa1_esposo" name="nom_papa1_esposo" value="<?php echo $nom_papa1_esposo?>">
            </div>
            <div class="input-group">
                <label for="nom_papa2_esposo">Segundo Nombre Papá del esposo:</label>
                <input type="text" id="nom_papa2_esposo" name="nom_papa2_esposo" value="<?php echo $nom_papa2_esposo?>">
            </div>
            <div class="input-group">
                <label for="apepapa1_esposo" class="etiqueta-larga">Primer Apellido Papá del esposo:</label>
                <input type="text" id="apepapa1_esposo" name="apepapa1_esposo" value="<?php echo $apepapa1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apepapa2_esposo" class="etiqueta-larga">Segundo Apellido Papá del esposo:</label>
                <input type="text" id="apepapa2_esposo" name="apepapa2_esposo" value="<?php echo $apepapa2_esposo?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_mama1_esposo">Primer Nombre Mamá del esposo:</label><br>
                <input type="text" id="nom_mama1_esposo" name="nom_mama1_esposo" value="<?php echo $nom_mama1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_mama2_esposo">Segundo Nombre Mamá del esposo:</label><br>
                <input type="text" id="nom_mama2_esposo" name="nom_mama2_esposo" value="<?php echo $nom_mama2_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama1_esposo">Primer Apellido Mamá del esposo:</label><br>
                <input type="text" id="apemama1_esposo" name="apemama1_esposo" value="<?php echo $apemama1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama2_esposo">Segundo Apellido Mama del esposo:</label><br>
                <input type="text" id="apemama2_esposo" name="apemama2_esposo" value="<?php echo $apemama2_esposo?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_padri1_esposo">Primer Nombre del Padrino del esposo:</label><br>
                <input type="text" id="nom_padri1_esposo" name="nom_padri1_esposo" value="<?php echo $nom_padri1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_padri2_esposo">Segundo Nombre del Padrino del esposo:</label><br>
                <input type="text" id="nom_padri2_esposo" name="nom_padri2_esposo" value="<?php echo $nom_padri2_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri1_esposo">Primer Apellido del Padrino del esposo:</label><br>
                <input type="text" id="apepadri1_esposo" name="apepadri1_esposo" value="<?php echo $apepadri1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri2_esposo">Segundo Apellido del Padrino del esposo:</label><br>
                <input type="text" id="apepadri2_esposo" name="apepadri2_esposo"value="<?php echo $apepadri1_esposo?>"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="nom_madri1_esposo">Primer Nombre de la Madrina del esposo:</label><br>
                <input type="text" id="nom_madri1_esposo" name="nom_madri1_esposo" value="<?php echo $nom_madri1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_madri2_esposo">Segundo Nombre de la Madrina del esposo:</label><br>
                <input type="text" id="nom_madri2_esposo" name="nom_madri2_esposo" value="<?php echo $nom_madri2_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri1_esposo">Primer Apellido de la Madrina del esposo:</label><br>
                <input type="text" id="apemadri1_esposo" name="apemadri1_esposo" value="<?php echo $apemadri1_esposo?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri2_esposo">Segundo Apellido de la Madrina del esposo:</label><br>
                <input type="text" id="apemadri2_esposo" name="apemadri2_esposo" value="<?php echo $apemadri2_esposo?>"><br>
            </div>
        </div> 

        <div class="input-group">
                <label for="nom1_esposa" class="obligatorio">Primer Nombre de la esposa:</label>
                <input type="text" id="nom1_esposa" name="nom1_esposa" value="<?php echo $nom1_esposa?>" required>
            </div>
            <div class="input-group">
                <label for="nom2_esposa">Segundo Nombre de la esposa:</label>
                <input type="text" id="nom2_esposa" name="nom2_esposa" value="<?php echo $nom2_esposa?>">
            </div>
            <div class="input-group">
                <label for="ape1_esposa" class="obligatorio">Primer Apellido de la esposa:</label>
                <input type="text" id="ape1_esposa" name="ape1_esposa" value="<?php echo $ape1_esposa?>" required>
            </div>
            <div class="input-group">
                <label for="ape2_esposa">Segundo Apellido de la esposa:</label>
                <input type="text" id="ape2_esposa" name="ape2_esposa" value="<?php echo $ape2_esposa?>">
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_nac_esposa" class="obligatorio">Ciudad de Nacimiento de la esposa:</label><br>
                <input type="text" id="lugar_nac_esposa" name="lugar_nac_esposa" value="<?php echo $lugar_nac_esposa?>" required><br>
            </div>
            <div class="input-group">
                <label for="estado_nac_esposa">Estado de Nacimiento de la esposa:</label><br>
                <input type="text" id="estado_nac_esposa" name="estado_nac_esposa" value="<?php echo $estado_nac_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="pais_nac_esposa">Pais de Nacimiento de la esposa:</label><br>
                <input type="text" id="pais_nac_esposa" name="pais_nac_esposa" value="<?php echo $pais_nac_esposa?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_nac_esposa" class="obligatorio">Día de Nacimiento de la esposa:</label><br>
                <input type="text" id="dia_nac_esposa" name="dia_nac_esposa" value="<?php echo $dia_nac_esposa?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_nac_esposa" class="obligatorio">Mes de Nacimiento de la esposa:</label><br>
                <input type="text" id="mes_nac_esposa" name="mes_nac_esposa" value="<?php echo $mes_nac_esposa?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_nac_esposa" class="obligatorio">Año de Nacimiento de la esposa:</label><br>
                <input type="text" id="ano_nac_esposa" name="ano_nac_esposa" value="<?php echo $ano_nac_esposa?>" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_bau_esposa" class="obligatorio">Día de Bautizo de la esposa:</label><br>
                <input type="text" id="dia_bau_esposa" name="dia_bau_esposa" value="<?php echo $dia_bau_esposa?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_bau_esposa" class="obligatorio">Mes de Bautizo de la esposa:</label><br>
                <input type="text" id="mes_bau_esposa" name="mes_bau_esposa" value="<?php echo $mes_bau_esposa?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_bau_esposa" class="obligatorio">Año de Bautizo de la esposa:</label><br>
                <input type="text" id="ano_bau_esposa" name="ano_bau_esposa" value="<?php echo $ano_bau_esposa?>" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="iglesia_bau_esposa" class="obligatorio">Iglesia de Bautizo de la esposa:</label><br>
                <input type="text" id="iglesia_bau_esposa" name="iglesia_bau_esposa" value="<?php echo $iglesia_bau_esposa?>" required><br>
            </div>
            <div class="input-group">
                <label for="lugar_bau_esposa" class="obligatorio">Ciudad de Bautizo de la esposa:</label><br>
                <input type="text" id="lugar_bau_esposa" name="lugar_bau_esposa" value="<?php echo $lugar_bau_esposa?>" required><br>
            </div>
            <div class="input-group">
                <label for="estado_bau_esposa">Estado de Bautizo de la esposa:</label><br>
                <input type="text" id="estado_bau_esposa" name="estado_bau_esposa" value="<?php echo $estado_bau_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="pais_bau_esposa">Pais de Bautizo de la esposa:</label><br>
                <input type="text" id="pais_bau_esposa" name="pais_bau_esposa" value="<?php echo $pais_bau_esposa?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_papa1_esposa">Primer Nombre Papá de la esposa:</label>
                <input type="text" id="nom_papa1_esposa" name="nom_papa1_esposa" value="<?php echo $nom_papa1_esposa?>">
            </div>
            <div class="input-group">
                <label for="nom_papa2_esposa">Segundo Nombre Papá de la esposa:</label>
                <input type="text" id="nom_papa2_esposa" name="nom_papa2_esposa" value="<?php echo $nom_papa2_esposa?>">
            </div>
            <div class="input-group">
                <label for="apepapa1_esposa" class="etiqueta-larga">Primer Apellido Papá de la esposa:</label>
                <input type="text" id="apepapa1_esposa" name="apepapa1_esposa" value="<?php echo $apepapa1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apepapa2_esposa" class="etiqueta-larga">Segundo Apellido Papá de la esposa:</label>
                <input type="text" id="apepapa2_esposa" name="apepapa2_esposa" value="<?php echo $apepapa2_esposa?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_mama1_esposa">Primer Nombre Mamá de la esposa:</label><br>
                <input type="text" id="nom_mama1_esposa" name="nom_mama1_esposa" value="<?php echo $nom_mama1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_mama2_esposa">Segundo Nombre Mamá de la esposa:</label><br>
                <input type="text" id="nom_mama2_esposa" name="nom_mama2_esposa" value="<?php echo $nom_mama2_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama1_esposa">Primer Apellido Mamá de la esposa:</label><br>
                <input type="text" id="apemama1_esposa" name="apemama1_esposa" value="<?php echo $apemama1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama2_esposa">Segundo Apellido Mama de la esposa:</label><br>
                <input type="text" id="apemama2_esposa" name="apemama2_esposa" value="<?php echo $apemama2_esposa?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_padri1_esposa">Primer Nombre del Padrino de la esposa:</label><br>
                <input type="text" id="nom_padri1_esposa" name="nom_padri1_esposa" value="<?php echo $nom_padri1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_padri2_esposa">Segundo Nombre del Padrino de la esposa:</label><br>
                <input type="text" id="nom_padri2_esposa" name="nom_padri2_esposa" value="<?php echo $nom_padri2_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri1_esposa">Primer Apellido del Padrino de la esposa:</label><br>
                <input type="text" id="apepadri1_esposa" name="apepadri1_esposa" value="<?php echo $apepadri1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri2_esposa">Segundo Apellido del Padrino de la esposa:</label><br>
                <input type="text" id="apepadri2_esposa" name="apepadri2_esposa"value="<?php echo $apepadri1_esposa?>"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="nom_madri1_esposa">Primer Nombre de la Madrina de la esposa:</label><br>
                <input type="text" id="nom_madri1_esposa" name="nom_madri1_esposa" value="<?php echo $nom_madri1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_madri2_esposa">Segundo Nombre de la Madrina de la esposa:</label><br>
                <input type="text" id="nom_madri2_esposa" name="nom_madri2_esposa" value="<?php echo $nom_madri2_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri1_esposa">Primer Apellido de la Madrina de la esposa:</label><br>
                <input type="text" id="apemadri1_esposa" name="apemadri1_esposa" value="<?php echo $apemadri1_esposa?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri2_esposa">Segundo Apellido de la Madrina de la esposa:</label><br>
                <input type="text" id="apemadri2_esposa" name="apemadri2_esposa" value="<?php echo $apemadri2_esposa?>"><br>
            </div>
        </div> 
        
        <div class="input-row">
            <div class="input-group">
                <label for="dia_matrimonio" class="obligatorio">Día del Matrimonio:</label><br>
                <input type="text" id="dia_matrimonio" name="dia_matrimonio" value="<?php echo $dia_matrimonio?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_matrimonio" class="obligatorio">Mes del Matrimonio:</label><br>
                <input type="text" id="mes_matrimonio" name="mes_matrimonio" value="<?php echo $mes_matrimonio?>" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_matrimonio" class="obligatorio">Año del Matrimonio:</label><br>
                <input type="text" id="ano_matrimonio" name="ano_matrimonio" value="<?php echo $ano_matrimonio?>" required pattern="\d{4}"><br>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label for="nom_minis1" class="obligatorio">Primer Nombre del Ministro del matrimonio:</label><br>
                <input type="text" id="nom_minis1" name="nom_minis1" value="<?php echo $nom_minis1?>" required><br>
            </div>
            <div class="input-group">
                <label for="nom_minis2">Segundo Nombre del Ministro del matrimonio:</label><br>
                <input type="text" id="nom_minis2" name="nom_minis2" value="<?php echo $nom_minis2?>"><br>
            </div>
            <div class="input-group">
                <label for="apeminis1" class="obligatorio">Primer Apellido del Ministro del matrimonio:</label><br>
                <input type="text" id="apeminis1" name="apeminis1"  value="<?php echo $apeminis1?>"required><br>
            </div>
            <div class="input-group">
                <label for="apeminis2">Segundo Apellido del Ministro del matrimonio:</label><br>
                <input type="text" id="apeminis2" name="apeminis2" value="<?php echo $apeminis2?>"><br>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label for="numLibro_matrimonio" class="obligatorio">Número de Libro del Acta de Matromonio:</label><br>
                <input type="text" id="numLibro_matrimonio" name="numLibro_matrimonio" value="<?php echo $numLibro_matrimonio?>" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="folio_matrimonio" class="obligatorio">Folio del Acta de Matrimonio:</label><br>
                <input type="text" id="folio_matrimonio" name="folio_matrimonio" value="<?php echo $folio_matrimonio?>" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="numeral_matrimonio" class="obligatorio">Numeral del Acta de Matrimonio:</label><br>
                <input type="text" id="numeral_matrimonio" name="numeral_matrimonio" value="<?php echo $numeral_matrimonio?>" required pattern="\d+"><br>
            </div>
        </div>
        <div class="input-row">            
            <div class="input-group">
                <label for="notaMar_matrimonio">Nota Marginal del Acta de Matrimonio:</label><br>
                <input type="text" id="notaMar_matrimonio" name="notaMar_matrimonio" value="<?php echo $notaMar_matrimonio?>"><br>
            </div>
        </div>
        <div class="input-row">            
            <div class="input-group">
                <label for="finalidad">Finalidad del Acta de Matrimonio:</label><br>
                <input type="text" id="finalidad" name="finalidad" value="<?php echo $finalidad?>"><br>
            </div>
        </div>   
    </table>
    <tr>
      <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
    </tr>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>