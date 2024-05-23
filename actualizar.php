<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Actualizar</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body class="centro">

<h1>ACTUALIZAR</h1>

<?php 

include("conexion2.php");

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



  //consulta SQL
  $sql="UPDATE bautizos SET primer_nombre=:miPrimerNombre, segundo_nombre=:miSegundoNombre, primer_apellido=:miPrimerApellido,
  segundo_apellido=:miSegundoApellido, primer_nombre_papa=:miPrimerNombrePapa, segundo_nombre_papa=:miSegundoNombrePapa,
  primer_apellido_papa=:miPrimerApellidoPapa, segundo_apellido_papa=:miSegundoApellidoPapa, primer_nombre_mama=:miPrimerNombreMama,
  segundo_nombre_mama=:miSegundoNombreMama, primer_apellido_mama=:miPrimerApellidoMama, segundo_apellido_mama=:miSegundoApellidoMama,
  filiacion=:miFiliacion, lugar_de_nacimiento=:miLugardeNacimiento, estado_de_nacimiento=:miEstadodeNacimiento, dia_de_nacimiento=:miDiadeNacimiento,
  mes_de_nacimiento=:miMesdeNacimiento, ano_de_nacimiento=:miAnodeNacimiento, dia_de_bautizo=:miDiadeBautizo, 
  mes_de_bautizo=:miMesdeBautizo, ano_de_bautizo=:miAnodeBautizo, primer_nombre_padrino=:miPrimerNombrePadrino,
  segundo_nombre_padrino=:miSegundoNombrePadrino, primer_apellido_padrino=:miPrimerApellidoPadrino,
  segundo_apellido_padrino=:miSegundoApellidoPadrino, primer_nombre_padrina=:miPrimerNombrePadrina,
  segundo_nombre_padrina=:miSegundoNombrePadrina, primer_apellido_padrina=:miPrimerApellidoPadrina,
  segundo_apellido_padrina=:miSegundoApellidoPadrina, primer_nombre_ministro=:miPrimerNombreMinistro,
  segundo_nombre_ministro=:miSegundoNombreMinistro, primer_apellido_ministro=:miPrimerApellidoMinistro,
  segundo_apellido_ministro=:miSegundoApellidoMinistro, observacion=:miObservación,
  numero_registro_civil=:miNumeroRegistroCivil, ano_registro_civil=:miAnoRegistroCivil 
  
  WHERE id=:miId";

  $resultado=$db->prepare($sql);

  $resultado->execute(array(":miId"=>$Id, ":miPrimerNombre"=>$nom1, ":miSegundoNombre"=>$nom2, ":miPrimerApellido"=>$ape1,
                            ":miSegundoApellido"=>$ape2, ":miPrimerNombrePapa"=>$nom_papa1, ":miSegundoNombrePapa"=>$nom_papa2,
                            ":miPrimerApellidoPapa"=>$apepapa1, ":miSegundoApellidoPapa"=>$apepapa2, 
                            ":miPrimerNombreMama"=>$nom_mama1, ":miSegundoNombreMama"=>$nom_mama2,
                            ":miPrimerApellidoMama"=>$apemama1, ":miSegundoApellidoMama"=>$apemama2,
                            ":miFiliacion"=>$fili, ":miLugardeNacimiento"=>$lugar_nac, ":miEstadodeNacimiento"=>$estado_nac, ":miDiadeNacimiento"=>$dia_nac,
                            ":miMesdeNacimiento"=>$mes_nac, ":miAnodeNacimiento"=>$ano_nac, ":miDiadeBautizo"=>$dia_bau,
                            ":miMesdeBautizo"=>$mes_bau, ":miAnodeBautizo"=>$ano_bau, ":miPrimerNombrePadrino"=>$nom_padri1,
                            ":miSegundoNombrePadrino"=>$nom_padri2, ":miPrimerApellidoPadrino"=>$apepadri1,
                            ":miSegundoApellidoPadrino"=>$apepadri2, ":miPrimerNombrePadrina"=>$nom_madri1,
                            ":miSegundoNombrePadrina"=>$nom_madri2, ":miPrimerApellidoPadrina"=>$apemadri1,
                            ":miSegundoApellidoPadrina"=>$apemadri2, ":miPrimerNombreMinistro"=>$nom_minis1,
                            ":miSegundoNombreMinistro"=>$nom_minis2, ":miPrimerApellidoMinistro"=>$apeminis1,
                            ":miSegundoApellidoMinistro"=>$apeminis2, ":miObservación"=>$observ,
                            ":miNumeroRegistroCivil"=>$num_reg_civil, ":miAnoRegistroCivil"=>$ano_reg_civil));

  header("Location:indexBautizo.php");

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

    
    <tr>
      <td>Primer Nombre</td>
      <td><label for="nom1"></label>
      <input type="text" name="nom1" id="nom1" value="<?php echo $nom1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre</td>
      <td><label for="nom2"></label>
      <input type="text" name="nom2" id="nom2" value="<?php echo $nom2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido</td>
      <td><label for="ape1"></label>
      <input type="text" name="ape1" id="ape1" value="<?php echo $ape1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido</td>
      <td><label for="ape2"></label>
      <input type="text" name="ape2" id="ape2" value="<?php echo $ape2?>"></td>
    </tr>


    <tr>
      <td>Primer Nombre Papa</td>
      <td><label for="nom_papa1"></label>
      <input type="text" name="nom_papa1" id="nom_papa1" value="<?php echo $nom_papa1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Papa</td>
      <td><label for="nom_papa2"></label>
      <input type="text" name="nom_papa2" id="nom_papa2" value="<?php echo $nom_papa2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido Papa</td>
      <td><label for="apepapa1"></label>
      <input type="text" name="apepapa1" id="apepapa1" value="<?php echo $apepapa1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido Papa</td>
      <td><label for="apepapa2"></label>
      <input type="text" name="apepapa2" id="apepapa2" value="<?php echo $apepapa2?>"></td>
    </tr>


    <tr>
      <td>Primer Nombre Mama</td>
      <td><label for="nom_mama1"></label>
      <input type="text" name="nom_mama1" id="nom_mama1" value="<?php echo $nom_mama1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Mama</td>
      <td><label for="nom_mama2"></label>
      <input type="text" name="nom_mama2" id="nom_mama2" value="<?php echo $nom_mama2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido Mama</td>
      <td><label for="apemama1"></label>
      <input type="text" name="apemama1" id="apemama1" value="<?php echo $apemama1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido Mama</td>
      <td><label for="apemama2"></label>
      <input type="text" name="apemama2" id="apemama2" value="<?php echo $apemama2?>"></td>
    </tr>


    <tr>
      <td>Filiacion</td>
      <td><label for="fili"></label>
      <input type="text" name="fili" id="fili" value="<?php echo $fili?>"></td>
    </tr>


    <tr>
      <td>Lugar de Nacimiento</td>
      <td><label for="lugar_nac"></label>
      <input type="text" name="lugar_nac" id="lugar_nac" value="<?php echo $lugar_nac?>"></td>
    </tr>


    <tr>
      <td>Estado de Nacimiento</td>
      <td><label for="estado_nac"></label>
      <input type="text" name="estado_nac" id="estado_nac" value="<?php echo $estado_nac?>"></td>
    </tr>


    <tr>
      <td>Dia de Nacimiento</td>
      <td><label for="dia_nac"></label>
      <input type="text" name="dia_nac" id="dia_nac" value="<?php echo $dia_nac?>"></td>
    </tr>


    <tr>
      <td>Mes de Nacimiento</td>
      <td><label for="mes_nac"></label>
      <input type="text" name="mes_nac" id="mes_nac" value="<?php echo $mes_nac?>"></td>
    </tr>


    <tr>
      <td>Año de Nacimiento</td>
      <td><label for="ano_nac"></label>
      <input type="text" name="ano_nac" id="ano_nac" value="<?php echo $ano_nac?>"></td>
    </tr>


    <tr>
      <td>Dia de Bautizo</td>
      <td><label for="dia_bau"></label>
      <input type="text" name="dia_bau" id="dia_bau" value="<?php echo $dia_bau?>"></td>
    </tr>


    <tr>
      <td>Mes de Bautizo</td>
      <td><label for="mes_bau"></label>
      <input type="text" name="mes_bau" id="mes_bau" value="<?php echo $mes_bau?>"></td>
    </tr>


    <tr>
      <td>Año de Bautizo</td>
      <td><label for="ano_bau"></label>
      <input type="text" name="ano_bau" id="ano_bau" value="<?php echo $ano_bau?>"></td>
    </tr>


    <tr>
      <td>Primer Nombre Padrino</td>
      <td><label for="nom_padri1"></label>
      <input type="text" name="nom_padri1" id="nom_padri1" value="<?php echo $nom_padri1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Padrino</td>
      <td><label for="nom_padri2"></label>
      <input type="text" name="nom_padri2" id="nom_padri2" value="<?php echo $nom_padri2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido Padrino</td>
      <td><label for="apepadri1"></label>
      <input type="text" name="apepadri1" id="apepadri1" value="<?php echo $apepadri1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido Padrino</td>
      <td><label for="apepadri2"></label>
      <input type="text" name="apepadri2" id="apepadri2" value="<?php echo $apepadri2?>"></td>
    </tr>


    <tr>
      <td>Primer Nombre Madrina</td>
      <td><label for="nom_madri1"></label>
      <input type="text" name="nom_madri1" id="nom_madri1" value="<?php echo $nom_madri1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Madrina</td>
      <td><label for="nom_madri2"></label>
      <input type="text" name="nom_madri2" id="nom_madri2" value="<?php echo $nom_madri2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido Madrina</td>
      <td><label for="apemadri1"></label>
      <input type="text" name="apemadri1" id="apemadri1" value="<?php echo $apemadri1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido Madrina</td>
      <td><label for="apemadri2"></label>
      <input type="text" name="apemadri2" id="apemadri2" value="<?php echo $apemadri2?>"></td>
    </tr>


    <tr>
      <td>Primer Nombre Ministro</td>
      <td><label for="nom_minis1"></label>
      <input type="text" name="nom_minis1" id="nom_minis1" value="<?php echo $nom_minis1?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Ministro</td>
      <td><label for="nom_minis2"></label>
      <input type="text" name="nom_minis2" id="nom_minis2" value="<?php echo $nom_minis2?>"></td>
    </tr>


    <tr>
      <td>Segundo Nombre Ministro</td>
      <td><label for="nom_minis2"></label>
      <input type="text" name="nom_minis2" id="nom_minis2" value="<?php echo $nom_minis2?>"></td>
    </tr>


    <tr>
      <td>Primer Apellido Ministro</td>
      <td><label for="apeminis1"></label>
      <input type="text" name="apeminis1" id="apeminis1" value="<?php echo $apeminis1?>"></td>
    </tr>


    <tr>
      <td>Segundo Apellido Ministro</td>
      <td><label for="apeminis2"></label>
      <input type="text" name="apeminis2" id="apeminis2" value="<?php echo $apeminis2?>"></td>
    </tr>


    <tr>
      <td>Observacion</td>
      <td><label for="observ"></label>
      <input type="text" name="observ" id="observ" value="<?php echo $observ?>"></td>
    </tr>


    <tr>
      <td>Numero Registro Civil</td>
      <td><label for="num_reg_civil"></label>
      <input type="text" name="num_reg_civil" id="num_reg_civil" value="<?php echo $num_reg_civil?>"></td>
    </tr>


    <tr>
      <td>Año Registro Civil</td>
      <td><label for="ano_reg_civil"></label>
      <input type="text" name="ano_reg_civil" id="ano_reg_civil" value="<?php echo $ano_reg_civil?>"></td>
    </tr>

    <tr>
      <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>