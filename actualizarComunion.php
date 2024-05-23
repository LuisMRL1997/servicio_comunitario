<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Comunion</title>
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
            <button id="cerrarSesion" onclick="window.location.href='indexComunion.php'">Volver</button>
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

  $nom1=$_GET["nom1"];

  $nom2=$_GET["nom2"];
  
  $ape1=$_GET["ape1"];
  
  $ape2=$_GET["ape2"];

  $nom_papa1=$_GET["nom_papa1"];

  $nom_papa2=$_GET["nom_papa2"];

  $apepapa1=$_GET["apepapa1"];

  $apepapa2=$_GET["apepapa2"];

  $nom_mama1=$_GET["nom_mama1"];

  $nom_mama2=$_GET["nom_mama2"];

  $apemama1=$_GET["apemama1"];

  $apemama2=$_GET["apemama2"];

  $fili=$_GET["fili"];

  $lugar_nac=$_GET["lugar_nac"];

  $estado_nac=$_GET["estado_nac"];

  $pais_nac=$_GET["pais_nac"];

  $dia_nac=$_GET["dia_nac"];

  $mes_nac=$_GET["mes_nac"];

  $ano_nac=$_GET["ano_nac"];

  $dia_bau=$_GET["dia_bau"];

  $mes_bau=$_GET["mes_bau"];

  $ano_bau=$_GET["ano_bau"];

  $nom_padri1=$_GET["nom_padri1"];

  $nom_padri2=$_GET["nom_padri2"];

  $apepadri1=$_GET["apepadri1"];

  $apepadri2=$_GET["apepadri2"];

  $nom_madri1=$_GET["nom_madri1"];

  $nom_madri2=$_GET["nom_madri2"];

  $apemadri1=$_GET["apemadri1"];

  $apemadri2=$_GET["apemadri2"];

  $nom_minis1=$_GET["nom_minis1"];

  $nom_minis2=$_GET["nom_minis2"];

  $apeminis1=$_GET["apeminis1"];

  $apeminis2=$_GET["apeminis2"];

  $observ=$_GET["observ"];

  $num_reg_civil=$_GET["num_reg_civil"];

  $ano_reg_civil=$_GET["ano_reg_civil"];

  $numLibro=$_GET["numLibro"];

  $folio=$_GET["folio"];

  $numeral=$_GET["numeral"];

  $notaMar=$_GET["notaMar"];

  $finalidad=$_GET["finalidad"];



}else {

    $Id=$_POST["id"];

    $nom1=$_POST["nom1"];

    $nom2=$_POST["nom2"];
    
    $ape1=$_POST["ape1"];
    
    $ape2=$_POST["ape2"];
  
    $nom_papa1=$_POST["nom_papa1"];
  
    $nom_papa2=$_POST["nom_papa2"];
  
    $apepapa1=$_POST["apepapa1"];
  
    $apepapa2=$_POST["apepapa2"];
  
    $nom_mama1=$_POST["nom_mama1"];
  
    $nom_mama2=$_POST["nom_mama2"];
  
    $apemama1=$_POST["apemama1"];
  
    $apemama2=$_POST["apemama2"];
  
    $fili=$_POST["fili"];
  
    $lugar_nac=$_POST["lugar_nac"];

    $estado_nac=$_POST["estado_nac"];
  
    $pais_nac=$_POST["pais_nac"];
  
    $dia_nac=$_POST["dia_nac"];
  
    $mes_nac=$_POST["mes_nac"];
  
    $ano_nac=$_POST["ano_nac"];
  
    $dia_bau=$_POST["dia_bau"];
  
    $mes_bau=$_POST["mes_bau"];
  
    $ano_bau=$_POST["ano_bau"];
  
    $nom_padri1=$_POST["nom_padri1"];
  
    $nom_padri2=$_POST["nom_padri2"];
  
    $apepadri1=$_POST["apepadri1"];
  
    $apepadri2=$_POST["apepadri2"];
  
    $nom_madri1=$_POST["nom_madri1"];
  
    $nom_madri2=$_POST["nom_madri2"];
  
    $apemadri1=$_POST["apemadri1"];
  
    $apemadri2=$_POST["apemadri2"];
  
    $nom_minis1=$_POST["nom_minis1"];
  
    $nom_minis2=$_POST["nom_minis2"];
  
    $apeminis1=$_POST["apeminis1"];
  
    $apeminis2=$_POST["apeminis2"];
  
    $observ=$_POST["observ"];
  
    $num_reg_civil=$_POST["num_reg_civil"];

    $ano_reg_civil=$_POST["ano_reg_civil"];

    $numLibro=$_POST["numLibro"];

    $folio=$_POST["folio"];
  
    $numeral=$_POST["numeral"];
  
    $notaMar=$_POST["notaMar"];

    $finalidad=$_POST["finalidad"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['nom1']) || empty($_POST['ape1']) ||
            empty($_POST['lugar_nac']) || empty($_POST['dia_nac']) ||
            empty($_POST['mes_nac']) || empty($_POST['ano_nac']) || empty($_POST['dia_bau']) ||
            empty($_POST['mes_bau']) || empty($_POST['ano_bau']) || empty($_POST['nom_minis1']) ||
            empty($_POST['apeminis1']) || empty($_POST['num_reg_civil']) || empty($_POST['ano_reg_civil']) || empty($_POST['estado_nac']) ||
            empty($_POST['pais_nac']) || empty($_POST['numLibro']) || empty($_POST['folio']) || empty($_POST['numeral'])) {          
            echo 'Por favor, completa todos los campos obligatorios.';
        } else if ((empty($_POST['nom_padri1']) && empty($_POST['apepadri1'])) && (empty($_POST['nom_madri1']) && empty($_POST['apemadri1']))) {
            echo 'Por favor, completa los campos requeridos de los padrinos.';
        } else if ((empty($_POST['nom_papa1']) && empty($_POST['apepapa1'])) && (empty($_POST['nom_mama1']) && empty($_POST['apemama1']))) {
            echo 'Por favor, completa los campos requeridos de los padres.';
        } else {

  //consulta SQL
  $sql="UPDATE bautizos SET primer_nombre=:miPrimerNombre, segundo_nombre=:miSegundoNombre, primer_apellido=:miPrimerApellido,
  segundo_apellido=:miSegundoApellido, primer_nombre_papa=:miPrimerNombrePapa, segundo_nombre_papa=:miSegundoNombrePapa,
  primer_apellido_papa=:miPrimerApellidoPapa, segundo_apellido_papa=:miSegundoApellidoPapa, primer_nombre_mama=:miPrimerNombreMama,
  segundo_nombre_mama=:miSegundoNombreMama, primer_apellido_mama=:miPrimerApellidoMama, segundo_apellido_mama=:miSegundoApellidoMama,
  filiacion=:miFiliacion, lugar_de_nacimiento=:miLugardeNacimiento, estado_de_nacimiento=:miEstadodeNacimiento, pais_de_nacimiento=:miPaisdeNacimiento, dia_de_nacimiento=:miDiadeNacimiento,
  mes_de_nacimiento=:miMesdeNacimiento, ano_de_nacimiento=:miAnodeNacimiento, dia_de_bautizo=:miDiadeBautizo, 
  mes_de_bautizo=:miMesdeBautizo, ano_de_bautizo=:miAnodeBautizo, primer_nombre_padrino=:miPrimerNombrePadrino,
  segundo_nombre_padrino=:miSegundoNombrePadrino, primer_apellido_padrino=:miPrimerApellidoPadrino,
  segundo_apellido_padrino=:miSegundoApellidoPadrino, primer_nombre_madrina=:miPrimerNombremadrina,
  segundo_nombre_madrina=:miSegundoNombremadrina, primer_apellido_madrina=:miPrimerApellidomadrina,
  segundo_apellido_madrina=:miSegundoApellidomadrina, primer_nombre_ministro=:miPrimerNombreMinistro,
  segundo_nombre_ministro=:miSegundoNombreMinistro, primer_apellido_ministro=:miPrimerApellidoMinistro,
  segundo_apellido_ministro=:miSegundoApellidoMinistro, observacion=:miObservación,
  numero_registro_civil=:miNumeroRegistroCivil, ano_registro_civil=:miAnoRegistroCivil, 
  numLibro=:miNumLibro, folio=:miFolio, numeral=:miNumeral, notaMar=:miNotaMar, finalidad=:mifinalidad 
  
  WHERE id=:miId";

try {
    $db = new PDO('sqlite:Registros.db');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
  $resultado=$db->prepare($sql);

  $resultado->execute(array(":miId"=>$Id, ":miPrimerNombre"=>$nom1, ":miSegundoNombre"=>$nom2, ":miPrimerApellido"=>$ape1,
                            ":miSegundoApellido"=>$ape2, ":miPrimerNombrePapa"=>$nom_papa1, ":miSegundoNombrePapa"=>$nom_papa2,
                            ":miPrimerApellidoPapa"=>$apepapa1, ":miSegundoApellidoPapa"=>$apepapa2, 
                            ":miPrimerNombreMama"=>$nom_mama1, ":miSegundoNombreMama"=>$nom_mama2,
                            ":miPrimerApellidoMama"=>$apemama1, ":miSegundoApellidoMama"=>$apemama2,
                            ":miFiliacion"=>$fili, ":miLugardeNacimiento"=>$lugar_nac, ":miEstadodeNacimiento"=>$estado_nac, ":miPaisdeNacimiento"=>$pais_nac,
                            ":miDiadeNacimiento"=>$dia_nac, ":miMesdeNacimiento"=>$mes_nac, ":miAnodeNacimiento"=>$ano_nac, ":miDiadeBautizo"=>$dia_bau,
                            ":miMesdeBautizo"=>$mes_bau, ":miAnodeBautizo"=>$ano_bau, ":miPrimerNombrePadrino"=>$nom_padri1,
                            ":miSegundoNombrePadrino"=>$nom_padri2, ":miPrimerApellidoPadrino"=>$apepadri1,
                            ":miSegundoApellidoPadrino"=>$apepadri2, ":miPrimerNombremadrina"=>$nom_madri1,
                            ":miSegundoNombremadrina"=>$nom_madri2, ":miPrimerApellidomadrina"=>$apemadri1,
                            ":miSegundoApellidomadrina"=>$apemadri2, ":miPrimerNombreMinistro"=>$nom_minis1,
                            ":miSegundoNombreMinistro"=>$nom_minis2, ":miPrimerApellidoMinistro"=>$apeminis1,
                            ":miSegundoApellidoMinistro"=>$apeminis2, ":miObservación"=>$observ,
                            ":miNumeroRegistroCivil"=>$num_reg_civil, ":miAnoRegistroCivil"=>$ano_reg_civil, 
                            ":miNumLibro"=>$numLibro, ":miFolio"=>$folio, ":miNumeral"=>$numeral, ":miNotaMar"=>$notaMar, ":mifinalidad"=>$finalidad));

  header("Location:indexComunion.php");

}
}
}
?>


<p></p>

<p>&nbsp;</p>
<form class="formulario-estilizado" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <table >
        <tr>
            <td><!-- Aquí estaría el nombre del label, de Id, pero es Hidden, tonces no es necesario --></td>
            <td><label for="id"></label>
            <input type="hidden" name="id" id="id" value="<?php echo $Id?>"></td>
        </tr>

        <div class="input-row">
            <div class="input-group">
                <label for="nom1" class="obligatorio">Primer Nombre:</label>
                <input type="text" id="nom1" name="nom1" value="<?php echo $nom1?>" required>
            </div>
            <div class="input-group">
                <label for="nom2">Segundo Nombre:</label>
                <input type="text" id="nom2" name="nom2" value="<?php echo $nom2?>">
            </div>
            <div class="input-group">
                <label for="ape1" class="obligatorio">Primer Apellido:</label>
                <input type="text" id="ape1" name="ape1" value="<?php echo $ape1?>" required>
            </div>
            <div class="input-group">
                <label for="ape2">Segundo Apellido:</label>
                <input type="text" id="ape2" name="ape2" value="<?php echo $ape2?>">
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_nac" class="obligatorio">Lugar de Nacimiento:</label><br>
                <input type="text" id="lugar_nac" name="lugar_nac" value="<?php echo $lugar_nac?>" required><br>
            </div>
            <div class="input-group">
                <label for="estado_nac" class="obligatorio">Estado de Nacimiento:</label><br>
                <input type="text" id="estado_nac" name="estado_nac" value="<?php echo $estado_nac?>"><br>
            </div>
            <div class="input-group">
                <label for="pais_nac" class="obligatorio">Pais de Nacimiento:</label><br>
                <input type="text" id="pais_nac" name="pais_nac" value="<?php echo $pais_nac?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_nac" class="obligatorio">Día de Nacimiento:</label><br>
                <input type="text" id="dia_nac" name="dia_nac" value="<?php echo $dia_nac?>" required><br>
            </div>
            <div class="input-group">
                <label for="mes_nac" class="obligatorio">Mes de Nacimiento:</label><br>
                <input type="text" id="mes_nac" name="mes_nac" value="<?php echo $mes_nac?>" required><br>
            </div>
            <div class="input-group">
                <label for="ano_nac" class="obligatorio">Año de Nacimiento:</label><br>
                <input type="text" id="ano_nac" name="ano_nac" value="<?php echo $ano_nac?>" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_papa1">Primer Nombre Papá:</label>
                <input type="text" id="nom_papa1" name="nom_papa1" value="<?php echo $nom_papa1?>">
            </div>
            <div class="input-group">
                <label for="nom_papa2">Segundo Nombre Papá:</label>
                <input type="text" id="nom_papa2" name="nom_papa2" value="<?php echo $nom_papa2?>">
            </div>
            <div class="input-group">
                <label for="apepapa1" class="etiqueta-larga">Primer Apellido Papá:</label>
                <input type="text" id="apepapa1" name="apepapa1" value="<?php echo $apepapa1?>"><br>
            </div>
            <div class="input-group">
                <label for="apepapa2" class="etiqueta-larga">Segundo Apellido Papá:</label>
                <input type="text" id="apepapa2" name="apepapa2" value="<?php echo $apepapa2?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_mama1">Primer Nombre Mamá:</label><br>
                <input type="text" id="nom_mama1" name="nom_mama1" value="<?php echo $nom_mama1?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_mama2">Segundo Nombre Mamá:</label><br>
                <input type="text" id="nom_mama2" name="nom_mama2" value="<?php echo $nom_mama2?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama1">Primer Apellido Mamá:</label><br>
                <input type="text" id="apemama1" name="apemama1" value="<?php echo $apemama1?>"><br>
            </div>
            <div class="input-group">
                <label for="apemama2">Segundo Apellido Mama:</label><br>
                <input type="text" id="apemama2" name="apemama2" value="<?php echo $apemama2?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_padri1">Primer Nombre del Padrino:</label><br>
                <input type="text" id="nom_padri1" name="nom_padri1" value="<?php echo $nom_padri1?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_padri2">Segundo Nombre del Padrino:</label><br>
                <input type="text" id="nom_padri2" name="nom_padri2" value="<?php echo $nom_padri2?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri1">Primer Apellido del Padrino:</label><br>
                <input type="text" id="apepadri1" name="apepadri1" value="<?php echo $apepadri1?>"><br>
            </div>
            <div class="input-group">
                <label for="apepadri2">Segundo Apellido del Padrino:</label><br>
                <input type="text" id="apepadri2" name="apepadri2"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="nom_madri1">Primer Nombre de la Madrina:</label><br>
                <input type="text" id="nom_madri1" name="nom_madri1" value="<?php echo $nom_madri1?>"><br>
            </div>
            <div class="input-group">
                <label for="nom_madri2">Segundo Nombre de la Madrina:</label><br>
                <input type="text" id="nom_madri2" name="nom_madri2" value="<?php echo $nom_madri2?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri1">Primer Apellido de la Madrina:</label><br>
                <input type="text" id="apemadri1" name="apemadri1" value="<?php echo $apemadri1?>"><br>
            </div>
            <div class="input-group">
                <label for="apemadri2">Segundo Apellido de la Madrina:</label><br>
                <input type="text" id="apemadri2" name="apemadri2" value="<?php echo $apemadri2?>"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="dia_bau" class="obligatorio">Día de Bautizo:</label><br>
                <input type="text" id="dia_bau" name="dia_bau" value="<?php echo $dia_bau?>" required"><br>
            </div>
            <div class="input-group">
                <label for="mes_bau" class="obligatorio">Mes de Bautizo:</label><br>
                <input type="text" id="mes_bau" name="mes_bau" value="<?php echo $mes_bau?>" required"><br>
            </div>
            <div class="input-group">
                <label for="ano_bau" class="obligatorio">Año de Bautizo:</label><br>
                <input type="text" id="ano_bau" name="ano_bau" value="<?php echo $ano_bau?>" required"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="nom_minis1" class="obligatorio">Primer Nombre del Ministro:</label><br>
                <input type="text" id="nom_minis1" name="nom_minis1" value="<?php echo $nom_minis1?>" required><br>
            </div>
            <div class="input-group">
                <label for="nom_minis2">Segundo Nombre del Ministro:</label><br>
                <input type="text" id="nom_minis2" name="nom_minis2" value="<?php echo $nom_minis2?>"><br>
            </div>
            <div class="input-group">
                <label for="apeminis1" class="obligatorio">Primer Apellido del Ministro:</label><br>
                <input type="text" id="apeminis1" name="apeminis1"  value="<?php echo $apeminis1?>"required><br>
            </div>
            <div class="input-group">
                <label for="apeminis2">Segundo Apellido del Ministro:</label><br>
                <input type="text" id="apeminis2" name="apeminis2" value="<?php echo $apeminis2?>"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="num_reg_civil" class="obligatorio">Número de Registro Civil:</label><br>
                <input type="text" id="num_reg_civil" name="num_reg_civil" value="<?php echo $num_reg_civil?>" required><br>
            </div>
            <div class="input-group">
                <label for="ano_reg_civil" class="obligatorio">Año de Registro Civil:</label><br>
                <input type="text" id="ano_reg_civil" name="ano_reg_civil" value="<?php echo $ano_reg_civil?>" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="numLibro" class="obligatorio">Número de Libro:</label><br>
                <input type="text" id="numLibro" name="numLibro" value="<?php echo $numLibro?>" required><br>
            </div>
            <div class="input-group">
                <label for="folio" class="obligatorio">Folio:</label><br>
                <input type="text" id="folio" name="folio" value="<?php echo $folio?>" required><br>
            </div>
            <div class="input-group">
                <label for="numeral" class="obligatorio">Numeral:</label><br>
                <input type="text" id="numeral" name="numeral" value="<?php echo $numeral?>" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="fili">Filiación:</label><br>
                <input type="text" id="fili" name="fili" value="<?php echo $fili?>"><br>
            </div>
            <div class="input-group">
                <label for="observ">Observación:</label><br>
                <input type="text" id="observ" name="observ" value="<?php echo $observ?>"><br>
            </div>
            <div class="input-group">
                <label for="notaMar">Nota Marginal:</label><br>
                <input type="text" id="notaMar" name="notaMar" value="<?php echo $notaMar?>"><br>
            </div>
            <div class="input-group">
                <label for="finalidad">Finalidad:</label><br>
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