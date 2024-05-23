<?php
session_start();
include("conexion2.php");

if (isset($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $stmt = $db->prepare("SELECT [es_maestro], [es_administrador] FROM [usuarios] WHERE [nombre_usuario] = ?");
    $stmt->execute([$nombre_usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_SESSION['ULTIMA_ACTIVIDAD']) && (time() - $_SESSION['ULTIMA_ACTIVIDAD'] > 3600)) {
    // última actividad fue hace más de 5 minutos
    session_unset();     // vacía el array $_SESSION
    session_destroy();   // destruye la sesión
    header("Location: iniciarSesion.php"); // redirige al usuario a la página de inicio de sesión
}

$_SESSION['ULTIMA_ACTIVIDAD'] = time(); // actualiza el momento de la última actividad


$search = (isset($_GET['search'])) ? $_GET['search'] : '';
$column = (isset($_GET['column'])) ? $_GET['column'] : 'primer_nombre';

$search2 = (isset($_GET['search2'])) ? $_GET['search2'] : '';
$column2 = (isset($_GET['column2'])) ? $_GET['column2'] : 'primer_apellido';

$search3 = (isset($_GET['search3'])) ? $_GET['search3'] : '';
$column3 = (isset($_GET['column3'])) ? $_GET['column3'] : 'ano_de_nacimiento';

$stmt = $db->prepare("SELECT * FROM [comuniones] WHERE " . $column . " LIKE :search AND " . $column2 . " LIKE :search2 AND " . $column3 . " LIKE :search3");
$stmt->execute(array(':search' => '%' . $search . '%', ':search2' => '%' . $search2 . '%', ':search3' => '%' . $search3 . '%'));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/// Preparar la consulta SQL
$stmt = $db->prepare("SELECT * FROM [comuniones]");
$stmt->execute();

// Fetch all data
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

//crear respaldo
if (isset($_GET['accion']) && $_GET['accion'] == 'hacer_respaldo') {
// Preparar el contenido del archivo de respaldo
$respaldo = "";
foreach ($data as $row) {
    foreach ($row as $key => $value) {
        $respaldo .= "$key: $value\n";
    }
    $respaldo .= "\n";
}

// Crear la carpeta si no existe
if (!file_exists('respaldos monterrey')) {
    mkdir('respaldos monterrey', 0777, true);
}

// Crear el archivo de respaldo en la carpeta "respaldos monterrey"
file_put_contents('respaldos monterrey/respaldo_comuniones.txt', $respaldo);
}
// insertar respaldo
// Comprueba si el archivo de respaldo existe
if (isset($_GET['accion']) && $_GET['accion'] == 'leer_respaldo') {
// Comprueba si el archivo de respaldo existe
if (file_exists('respaldos monterrey/respaldo_comuniones.txt')) {
    // Lee las líneas del archivo de respaldo
    $lineas = file('respaldos monterrey/respaldo_comuniones.txt');

    // Inicializa un array vacío para almacenar los datos de un registro
    $registro = [];

    foreach ($lineas as $linea) {
        // Si la línea está vacía, significa que hemos llegado al final de un registro
        if (trim($linea) == '') {
            // Comprueba si el ID ya existe en la base de datos
            $stmt = $db->prepare("SELECT COUNT(*) FROM [comuniones] WHERE [id] = ?");
            $stmt->execute([$registro['id']]);
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                // Inserta el registro en la base de datos
                $stmt = $db->prepare("INSERT INTO [comuniones] (id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, primer_nombre_papa, segundo_nombre_papa, primer_apellido_papa, segundo_apellido_papa, primer_nombre_mama, segundo_nombre_mama, primer_apellido_mama, segundo_apellido_mama, filiacion, lugar_de_nacimiento, estado_de_nacimiento, dia_de_nacimiento, mes_de_nacimiento, ano_de_nacimiento, dia_de_bautizo, mes_de_bautizo, ano_de_bautizo, primer_nombre_padrino, segundo_nombre_padrino, primer_apellido_padrino, segundo_apellido_padrino, primer_nombre_madrina, segundo_nombre_madrina, primer_apellido_madrina, segundo_apellido_madrina, primer_nombre_ministro, segundo_nombre_ministro, primer_apellido_ministro, segundo_apellido_ministro, observacion, numero_registro_civil, ano_registro_civil, numLibro, folio, numeral, notaMar, finalidad) VALUES (:id, :primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :primer_nombre_papa, :segundo_nombre_papa, :primer_apellido_papa, :segundo_apellido_papa, :primer_nombre_mama, :segundo_nombre_mama, :primer_apellido_mama, :segundo_apellido_mama, :filiacion, :lugar_de_nacimiento, :estado_de_nacimiento, :dia_de_nacimiento, :mes_de_nacimiento, :ano_de_nacimiento, :dia_de_bautizo, :mes_de_bautizo, :ano_de_bautizo, :primer_nombre_padrino, :segundo_nombre_padrino, :primer_apellido_padrino, :segundo_apellido_padrino, :primer_nombre_madrina, :segundo_nombre_madrina, :primer_apellido_madrina, :segundo_apellido_madrina, :primer_nombre_ministro, :segundo_nombre_ministro, :primer_apellido_ministro, :segundo_apellido_ministro, :observacion, :numero_registro_civil, :ano_registro_civil, :numLibro, :folio, :numeral, :notaMar, :finalidad)");
                $stmt->execute($registro);
            }
            // Reinicia el array de registro
            $registro = [];
        } else {
            // Divide la línea en clave y valor
            list($clave, $valor) = explode(': ', $linea);
            // Agrega el valor al registro
            $registro[$clave] = trim($valor);
        }
    }

    echo "Los datos del respaldo han sido guardados en la base de datos.";
} else {
    echo "No se encontró el archivo de respaldo.";
}
}

//fin de respaldos
?>



<!DOCTYPE html>
<html>
<head>
    <title>Registros de Primeras Comuniones</title>
    <link rel="stylesheet" type="text/css" href="stylesRegistros.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

    <?php
    if (isset($user) && ($user['es_maestro'] || $user['es_administrador'])) {
        echo '<button id="cerrarSesion" onclick="location.href=\'inserComunion.php\'">Insertar Comunion</button>';
    }
    ?>
    </div>
    <div class="container">
    <form action="" method="get">
    <div class="search-container">
    <div class="search-bar">
        <select name="column">
            <option value="primer_nombre" selected>Primer Nombre</option>
            <option value="segundo_nombre">Segundo Nombre</option>
            <option value="primer_apellido">Primer Apellido</option>
            <option value="segundo_apellido">Segundo Apellido</option>
            <option value="primer_nombre_papa">Primer Nombre Papa</option>
            <option value="segundo_nombre_papa">Segundo Nombre Papa</option>
            <option value="primer_apellido_papa">Primer Apellido Papa</option>
            <option value="segundo_apellido_papa">Segundo Apellido Papa</option>
            <option value="primer_nombre_mama">Primer Nombre Mama</option>
            <option value="segundo_nombre_mama">Segundo Nombre Mama</option>
            <option value="primer_apellido_mama">Primer Apellido Mama</option>
            <option value="segundo_apellido_mama">Segundo Apellido Mama</option>
            <option value="filiacion">Filiacion</option>
            <option value="lugar_de_nacimiento">Ciudad de Nacimiento</option>
            <option value="estado_de_nacimiento">Estado de Nacimiento</option>
            <option value="Pais_de_nacimiento">Pais de Nacimiento</option>
            <option value="dia_de_nacimiento">Dia de Nacimiento</option>
            <option value="mes_de_nacimiento">Mes de Nacimiento</option>
            <option value="ano_de_nacimiento">Año de Nacimiento</option>
            <option value="dia_de_bautizo">Dia de Bautizo</option>
            <option value="mes_de_bautizo">Mes de Bautizo</option>
            <option value="ano_de_bautizo">Año de Bautizo</option>
            <option value="primer_nombre_padrino">Primer Nombre Padrino</option>
            <option value="segundo_nombre_padrino">Segundo Nombre Padrino</option>
            <option value="primer_apellido_padrino">Primer Apellido Padrino</option>
            <option value="segundo_apellido_padrino">Segundo Apellido Padrino</option>
            <option value="primer_nombre_madrina">Primer Nombre Madrina</option>
            <option value="segundo_nombre_madrina">Segundo Nombre Madrina</option>
            <option value="primer_apellido_madrina">Primer Apellido Madrina</option>
            <option value="segundo_apellido_madrina">Segundo Apellido Madrina</option>
            <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
            <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
            <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
            <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>
            <option value="observacion">Observacion</option>
            <option value="numero_registro_civil">Numero Registro Civil</option>
            <option value="ano_registro_civil">Año Registro Civil</option>
            <option value="numLibro">Numero de libro de bautizo</option>
            <option value="folio">Folio</option>
            <option value="numeral">Numeral</option>
            <option value="notaMar">Nota Marginal</option>
            </select>
    <select name="column2">
        <option value="primer_nombre">Primer Nombre</option>
            <option value="segundo_nombre">Segundo Nombre</option>
            <option value="primer_apellido" selected>Primer Apellido</option>
            <option value="segundo_apellido">Segundo Apellido</option>
            <option value="primer_nombre_papa">Primer Nombre Papa</option>
            <option value="segundo_nombre_papa">Segundo Nombre Papa</option>
            <option value="primer_apellido_papa">Primer Apellido Papa</option>
            <option value="segundo_apellido_papa">Segundo Apellido Papa</option>
            <option value="primer_nombre_mama">Primer Nombre Mama</option>
            <option value="segundo_nombre_mama">Segundo Nombre Mama</option>
            <option value="primer_apellido_mama">Primer Apellido Mama</option>
            <option value="segundo_apellido_mama">Segundo Apellido Mama</option>
            <option value="filiacion">Filiacion</option>
            <option value="lugar_de_nacimiento">Ciudad de Nacimiento</option>
            <option value="estado_de_nacimiento">Estado de Nacimiento</option>
            <option value="Pais_de_nacimiento">Pais de Nacimiento</option>
            <option value="dia_de_nacimiento">Dia de Nacimiento</option>
            <option value="mes_de_nacimiento">Mes de Nacimiento</option>
            <option value="ano_de_nacimiento">Año de Nacimiento</option>
            <option value="dia_de_bautizo">Dia de Bautizo</option>
            <option value="mes_de_bautizo">Mes de Bautizo</option>
            <option value="ano_de_bautizo">Año de Bautizo</option>
            <option value="primer_nombre_padrino">Primer Nombre Padrino</option>
            <option value="segundo_nombre_padrino">Segundo Nombre Padrino</option>
            <option value="primer_apellido_padrino">Primer Apellido Padrino</option>
            <option value="segundo_apellido_padrino">Segundo Apellido Padrino</option>
            <option value="primer_nombre_madrina">Primer Nombre Madrina</option>
            <option value="segundo_nombre_madrina">Segundo Nombre Madrina</option>
            <option value="primer_apellido_madrina">Primer Apellido Madrina</option>
            <option value="segundo_apellido_madrina">Segundo Apellido Madrina</option>
            <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
            <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
            <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
            <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>
            <option value="observacion">Observacion</option>
            <option value="numero_registro_civil">Numero Registro Civil</option>
            <option value="ano_registro_civil">Año Registro Civil</option>
            <option value="numLibro">Numero de libro de bautizo</option>
            <option value="folio">Folio</option>
            <option value="numeral">Numeral</option>
            <option value="notaMar">Nota Marginal</option>
            </select>
    <select name="column3">
        <option value="primer_nombre">Primer Nombre</option>
            <option value="segundo_nombre">Segundo Nombre</option>
            <option value="primer_apellido">Primer Apellido</option>
            <option value="segundo_apellido">Segundo Apellido</option>
            <option value="primer_nombre_papa">Primer Nombre Papa</option>
            <option value="segundo_nombre_papa">Segundo Nombre Papa</option>
            <option value="primer_apellido_papa">Primer Apellido Papa</option>
            <option value="segundo_apellido_papa">Segundo Apellido Papa</option>
            <option value="primer_nombre_mama">Primer Nombre Mama</option>
            <option value="segundo_nombre_mama">Segundo Nombre Mama</option>
            <option value="primer_apellido_mama">Primer Apellido Mama</option>
            <option value="segundo_apellido_mama">Segundo Apellido Mama</option>
            <option value="filiacion">Filiacion</option>
            <option value="lugar_de_nacimiento">Ciudad de Nacimiento</option>
            <option value="estado_de_nacimiento">Estado de Nacimiento</option>
            <option value="pais_de_nacimiento">Pais de Nacimiento</option>
            <option value="dia_de_nacimiento">Dia de Nacimiento</option>
            <option value="mes_de_nacimiento">Mes de Nacimiento</option>
            <option value="ano_de_nacimiento" selected>Año de Nacimiento</option>
            <option value="dia_de_bautizo">Dia de Bautizo</option>
            <option value="mes_de_bautizo">Mes de Bautizo</option>
            <option value="ano_de_bautizo">Año de Bautizo</option>
            <option value="primer_nombre_padrino">Primer Nombre Padrino</option>
            <option value="segundo_nombre_padrino">Segundo Nombre Padrino</option>
            <option value="primer_apellido_padrino">Primer Apellido Padrino</option>
            <option value="segundo_apellido_padrino">Segundo Apellido Padrino</option>
            <option value="primer_nombre_madrina">Primer Nombre Madrina</option>
            <option value="segundo_nombre_madrina">Segundo Nombre Madrina</option>
            <option value="primer_apellido_madrina">Primer Apellido Madrina</option>
            <option value="segundo_apellido_madrina">Segundo Apellido Madrina</option>
            <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
            <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
            <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
            <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>
            <option value="observacion">Observacion</option>
            <option value="numero_registro_civil">Numero Registro Civil</option>
            <option value="ano_registro_civil">Año Registro Civil</option>
            <option value="numLibro">Numero de libro de bautizo</option>
            <option value="folio">Folio</option>
            <option value="numeral">Numeral</option>
            <option value="notaMar">Nota Marginal</option>
            </select>
    </div>

    <div class="search-bar">
      <input type="text" name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar...">
        <input type="text" name="search2" value="<?php echo htmlspecialchars($search2, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar más...">
       <input type="text" name="search3" value="<?php echo htmlspecialchars($search3, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar aún más...">
    </div>

    <input type="submit" value="Buscar">
    
    <?php
    $user = null;
    if (isset($_SESSION['nombre_usuario'])) {
        $nombre_usuario = $_SESSION['nombre_usuario'];
        $stmt = $db->prepare("SELECT [es_administrador], [es_maestro] FROM [usuarios] WHERE [nombre_usuario] = ?");
        $stmt->execute([$nombre_usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($user && ($user['es_administrador'] || $user['es_maestro'])) {
        echo '<button class="botonInsertar" onclick="hacerRespaldo()">Hacer Respaldo</button>';
        echo ' ';
        echo '<button class="botonInsertar" onclick="window.location.href=\'indexComunion.php?accion=leer_respaldo\'">Leer Respaldo</button>';
    }
    ?>




    <script>
    function hacerRespaldo() {
        // Comprueba si la base de datos está vacía
        <?php
        $stmt = $db->prepare("SELECT COUNT(*) FROM [comuniones]");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        ?>
        if (<?php echo $count; ?> == 0) {
            alert("La base de datos está vacía, no se puede hacer el respaldo.");
        } else {
            window.location.href = 'indexComunion.php?accion=hacer_respaldo';
        }
    }
    </script>




    
    
    

    </form>

        <table>
        <tr>
        <th>ID</th>
        <th>Primer Nombre</th>
        <th>Segundo Nombre</th>
        <th>Primer Apellido</th>
        <th>Segundo Apellido</th>
        <th>Primer Nombre Papa</th>
        <th>Segundo Nombre Papa</th>
        <th>Primer Apellido Papa</th>
        <th>Segundo Apellido Papa</th>
        <th>Primer Nombre Mama</th>
        <th>Segundo Nombre Mama</th>
        <th>Primer Apellido Mama</th>
        <th>Segundo Apellido Mama</th>
        <th>Filiacion</th>
        <th>Lugar de Nacimiento</th>
        <th>Estado de Nacimiento</th>
        <th>Pais de Nacimiento</th>
        <th>Dia de Nacimiento</th>
        <th>Mes de Nacimiento</th>
        <th>Año de Nacimiento</th>
        <th>Dia de Bautizo</th>
        <th>Mes de Bautizo</th>
        <th>Año de Bautizo</th>
        <th>Primer Nombre Padrino</th>
        <th>Segundo Nombre Padrino</th>
        <th>Primer Apellido Padrino</th>
        <th>Segundo Apellido Padrino</th>
        <th>Primer Nombre Madrina</th>
        <th>Segundo Nombre Madrina</th>
        <th>Primer Apellido Madrina</th>
        <th>Segundo Apellido Madrina</th>
        <th>Primer Nombre Ministro</th>
        <th>Segundo Nombre Ministro</th>
        <th>Primer Apellido Ministro</th>
        <th>Segundo Apellido Ministro</th>
        <th>Observacion</th>
        <th>Numero Registro Civil</th>
        <th>Año Registro Civil</th>
        <th>Numero de libro de bautizo</th>
        <th>Folio</th>
        <th>Numeral</th>
        <th>Nota Marginal</th>
    </tr>

    <?php foreach ($data as $row): ?>
        <tr>
            <td>
                <?php
                if (isset($_SESSION['nombre_usuario'])) {
                    $nombre_usuario = $_SESSION['nombre_usuario'];
                    $stmt = $db->prepare("SELECT [es_administrador] FROM [usuarios] WHERE [nombre_usuario] = ?");
                    $stmt->execute([$nombre_usuario]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($user['es_administrador']) {
                        echo '<a href="documentoComunion.php?id=' . $row['id'] . '"><button type="button">' . $row['id'] . '</button></a>';
                        echo '<input type="button" name="del" id="del" value="Borrar" onclick="return confirmDelete(' . $row['id'] . ')">';
                        echo '
                        <script>
                            function confirmDelete(id) {
                                var confirmation = confirm("¿Estás seguro de que quieres borrar este registro?");
                                if (confirmation) {
                                    window.location.href = "borrar2.php?id=" + id;
                                }
                                return false;
                            }
                        </script>
                        ';
                        
                        echo '<a href="actualizarComunion.php?id=' . $row['id'] . 
                                '& nom1=' . $row['primer_nombre'] . 
                                '& nom2=' . $row['segundo_nombre'] . 
                                '& ape1=' . $row['primer_apellido'] .
                                '& ape2=' . $row['segundo_apellido'] .
                                '& nom_papa1=' . $row['primer_nombre_papa'] .
                                '& nom_papa2=' . $row['segundo_nombre_papa'] .
                                '& apepapa1=' . $row['primer_apellido_papa'] .
                                '& apepapa2=' . $row['segundo_apellido_papa'] .
                                '& nom_mama1=' . $row['primer_nombre_mama'] .
                                '& nom_mama2=' . $row['segundo_nombre_mama'] .
                                '& apemama1=' . $row['primer_apellido_mama'] .
                                '& apemama2=' . $row['segundo_apellido_mama'] .
                                '& fili=' . $row['filiacion'] .
                                '& lugar_nac=' . $row['lugar_de_nacimiento'] .
                                '& estado_nac=' . $row['estado_de_nacimiento'] .
                                '& pais_nac=' . $row['pais_de_nacimiento'] .
                                '& dia_nac=' . $row['dia_de_nacimiento'] .
                                '& mes_nac=' . $row['mes_de_nacimiento'] .
                                '& ano_nac=' . $row['ano_de_nacimiento'] .
                                '& dia_bau=' . $row['dia_de_bautizo'] .
                                '& mes_bau=' . $row['mes_de_bautizo'] .
                                '& ano_bau=' . $row['ano_de_bautizo'] .
                                '& nom_padri1=' . $row['primer_nombre_padrino'] .
                                '& nom_padri2=' . $row['segundo_nombre_padrino'] .
                                '& apepadri1=' . $row['primer_apellido_padrino'] .
                                '& apepadri2=' . $row['segundo_apellido_padrino'] .
                                '& nom_madri1=' . $row['primer_nombre_madrina'] .
                                '& nom_madri2=' . $row['segundo_nombre_madrina'] .
                                '& apemadri1=' . $row['primer_apellido_madrina'] .
                                '& apemadri2=' . $row['segundo_apellido_madrina'] .
                                '& nom_minis1=' . $row['primer_nombre_ministro'] .
                                '& nom_minis2=' . $row['segundo_nombre_ministro'] .
                                '& apeminis1=' . $row['primer_apellido_ministro'] .
                                '& apeminis2=' . $row['segundo_apellido_ministro'] .
                                '& observ=' . $row['observacion'] .
                                '& num_reg_civil=' . $row['numero_registro_civil'] .
                                '& ano_reg_civil=' . $row['ano_registro_civil'] .
                                '& numLibro=' . $row['numLibro'] .
                                '& folio=' . $row['folio'] .
                                '& numeral=' . $row['numeral'] .
                                '& notaMar=' . $row['notaMar'] .
                                '& finalidad=' . $row['finalidad'] . '"><input type="button" name="up" id="up" value="Actualizar"></a>';
                                                    } else {
                                                        echo $row['id'];
                                                    }
                                                } else {
                                                    echo $row['id'];
                                                }
                                                ?>
                                            </td>
            <td><?php echo $row['primer_nombre']; ?></td>
            <td><?php echo $row['segundo_nombre']; ?></td>
            <td><?php echo $row['primer_apellido']; ?></td>
            <td><?php echo $row['segundo_apellido']; ?></td>
            <td><?php echo $row['primer_nombre_papa']; ?></td>
            <td><?php echo $row['segundo_nombre_papa']; ?></td>
            <td><?php echo $row['primer_apellido_papa']; ?></td>
            <td><?php echo $row['segundo_apellido_papa']; ?></td>
            <td><?php echo $row['primer_nombre_mama']; ?></td>
            <td><?php echo $row['segundo_nombre_mama']; ?></td>
            <td><?php echo $row['primer_apellido_mama']; ?></td>
            <td><?php echo $row['segundo_apellido_mama']; ?></td>
            <td><?php echo $row['filiacion']; ?></td>
            <td><?php echo $row['lugar_de_nacimiento']; ?></td>
            <td><?php echo $row['estado_de_nacimiento']; ?></td>
            <td><?php echo $row['pais_de_nacimiento']; ?></td>
            <td><?php echo $row['dia_de_nacimiento']; ?></td>
            <td><?php echo $row['mes_de_nacimiento']; ?></td>
            <td><?php echo $row['ano_de_nacimiento']; ?></td>
            <td><?php echo $row['dia_de_bautizo']; ?></td>
            <td><?php echo $row['mes_de_bautizo']; ?></td>
            <td><?php echo $row['ano_de_bautizo']; ?></td>
            <td><?php echo $row['primer_nombre_padrino']; ?></td>
            <td><?php echo $row['segundo_nombre_padrino']; ?></td>
            <td><?php echo $row['primer_apellido_padrino']; ?></td>
            <td><?php echo $row['segundo_apellido_padrino']; ?></td>
            <td><?php echo $row['primer_nombre_madrina']; ?></td>
            <td><?php echo $row['segundo_nombre_madrina']; ?></td>
            <td><?php echo $row['primer_apellido_madrina']; ?></td>
            <td><?php echo $row['segundo_apellido_madrina']; ?></td>
            <td><?php echo $row['primer_nombre_ministro']; ?></td>
            <td><?php echo $row['segundo_nombre_ministro']; ?></td>
            <td><?php echo $row['primer_apellido_ministro']; ?></td>
            <td><?php echo $row['segundo_apellido_ministro']; ?></td>
            <td><?php echo $row['observacion']; ?></td>
            <td><?php echo $row['numero_registro_civil']; ?></td>
            <td><?php echo $row['ano_registro_civil']; ?></td>
            <td><?php echo $row['numLibro']; ?></td>
            <td><?php echo $row['folio']; ?></td>
            <td><?php echo $row['numeral']; ?></td>
            <td><?php echo $row['notaMar']; ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

</body>
</html>