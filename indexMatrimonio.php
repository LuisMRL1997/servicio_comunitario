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
$column = (isset($_GET['column'])) ? $_GET['column'] : 'primer_nombre_esposo';

$search2 = (isset($_GET['search2'])) ? $_GET['search2'] : '';
$column2 = (isset($_GET['column2'])) ? $_GET['column2'] : 'primer_apellido_esposo';

$search3 = (isset($_GET['search3'])) ? $_GET['search3'] : '';
$column3 = (isset($_GET['column3'])) ? $_GET['column3'] : 'ano_de_nacimiento_esposo';

$stmt = $db->prepare("SELECT * FROM [matrimonios] WHERE " . $column . " LIKE :search AND " . $column2 . " LIKE :search2 AND " . $column3 . " LIKE :search3");
$stmt->execute(array(':search' => '%' . $search . '%', ':search2' => '%' . $search2 . '%', ':search3' => '%' . $search3 . '%'));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/// Preparar la consulta SQL
$stmt = $db->prepare("SELECT * FROM [matrimonios]");
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
file_put_contents('respaldos monterrey/respaldo_matrimonios.txt', $respaldo);
}
// insertar respaldo
// Comprueba si el archivo de respaldo existe
if (isset($_GET['accion']) && $_GET['accion'] == 'leer_respaldo') {
// Comprueba si el archivo de respaldo existe
if (file_exists('respaldos monterrey/respaldo_matrimonios.txt')) {
    // Lee las líneas del archivo de respaldo
    $lineas = file('respaldos monterrey/respaldo_matrimonios.txt');

    // Inicializa un array vacío para almacenar los datos de un registro
    $registro = [];

    foreach ($lineas as $linea) {
        // Si la línea está vacía, significa que hemos llegado al final de un registro
        if (trim($linea) == '') {
            // Comprueba si el ID ya existe en la base de datos
            $stmt = $db->prepare("SELECT COUNT(*) FROM [matrimonios] WHERE [id] = ?");
            $stmt->execute([$registro['id']]);
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                // Inserta el registro en la base de datos
                $stmt = $db->prepare("INSERT INTO [matrimonios] (id, primer_nombre_esposo, segundo_nombre_esposo, primer_apellido_esposo, segundo_apellido_esposo, primer_nombre_papa_esposo, segundo_nombre_papa_esposo, primer_apellido_papa_esposo, segundo_apellido_papa_esposo, primer_nombre_mama_esposo, segundo_nombre_mama_esposo, primer_apellido_mama_esposo, segundo_apellido_mama_esposo,
                lugar_de_nacimiento_esposo, estado_de_nacimiento_esposo, pais_de_nacimiento_esposo, dia_de_nacimiento_esposo, mes_de_nacimiento_esposo, ano_de_nacimiento_esposo, dia_de_bautizo_esposo, mes_de_bautizo_esposo, ano_de_bautizo_esposo, iglesia_de_bautizo_esposo, lugar_de_bautizo_esposo, estado_de_bautizo_esposo, pais_de_bautizo_esposo, dia_de_matrimonio, mes_de_matrimonio, ano_de_matrimonio, 
                primer_nombre_esposa, segundo_nombre_esposa, primer_apellido_esposa, segundo_apellido_esposa, primer_nombre_papa_esposa, segundo_nombre_papa_esposa, primer_apellido_papa_esposa, segundo_apellido_papa_esposa, primer_nombre_mama_esposa, segundo_nombre_mama_esposa, primer_apellido_mama_esposa, segundo_apellido_mama_esposa, lugar_de_nacimiento_esposa, estado_de_nacimiento_esposa, 
                pais_de_nacimiento_esposa, dia_de_nacimiento_esposa, mes_de_nacimiento_esposa, ano_de_nacimiento_esposa, dia_de_bautizo_esposa, mes_de_bautizo_esposa, ano_de_bautizo_esposa, iglesia_de_bautizo_esposa, lugar_de_bautizo_esposa, estado_de_bautizo_esposa, pais_de_bautizo_esposa, primer_nombre_padrino_esposo, segundo_nombre_padrino_esposo, primer_apellido_padrino_esposo, 
                segundo_apellido_padrino_esposo, primer_nombre_madrina_esposo, segundo_nombre_madrina_esposo, primer_apellido_madrina_esposo, segundo_apellido_madrina_esposo, primer_nombre_padrino_esposa, segundo_nombre_padrino_esposa, primer_apellido_padrino_esposa, segundo_apellido_padrino_esposa, primer_nombre_madrina_esposa, segundo_nombre_madrina_esposa, primer_apellido_madrina_esposa,
                segundo_apellido_madrina_esposa, primer_nombre_ministro, segundo_nombre_ministro, primer_apellido_ministro, segundo_apellido_ministro, numLibro_matrimonio, folio_matrimonio, numeral_matrimonio, notaMar_matrimonio, finalidad) VALUES (:primer_nombre_esposo, :segundo_nombre_esposo, :primer_apellido_esposo, :segundo_apellido_esposo, :primer_nombre_papa_esposo, :segundo_nombre_papa_esposo, 
                :primer_apellido_papa_esposo, :segundo_apellido_papa_esposo, :primer_nombre_mama_esposo, :segundo_nombre_mama_esposo, :primer_apellido_mama_esposo, :segundo_apellido_mama_esposo, :lugar_de_nacimiento_esposo, :estado_de_nacimiento_esposo, :pais_de_nacimiento_esposo, :dia_de_nacimiento_esposo, :mes_de_nacimiento_esposo, :ano_de_nacimiento_esposo, :dia_de_bautizo_esposo, :mes_de_bautizo_esposo,
                :ano_de_bautizo_esposo, :iglesia_de_bautizo_esposo, :lugar_de_bautizo_esposo, :estado_de_bautizo_esposo, :pais_de_bautizo_esposo, :dia_de_matrimonio,:mes_de_matrimonio, :ano_de_matrimonio, :primer_nombre_esposa, :segundo_nombre_esposa, :primer_apellido_esposa, :segundo_apellido_esposa, :primer_nombre_papa_esposa, :segundo_nombre_papa_esposa, :primer_apellido_papa_esposa, :segundo_apellido_papa_esposa,
                :primer_nombre_mama_esposa, :segundo_nombre_mama_esposa, :primer_apellido_mama_esposa, :segundo_apellido_mama_esposa, :lugar_de_nacimiento_esposa, :estado_de_nacimiento_esposa, :pais_de_nacimiento_esposa, :dia_de_nacimiento_esposa, :mes_de_nacimiento_esposa, :ano_de_nacimiento_esposa, :dia_de_bautizo_esposa, :mes_de_bautizo_esposa, :ano_de_bautizo_esposa, :iglesia_de_bautizo_esposa, 
                :lugar_de_bautizo_esposa, :estado_de_bautizo_esposa, :pais_de_bautizo_esposa, :primer_nombre_padrino_esposo, :segundo_nombre_padrino_esposo, :primer_apellido_padrino_esposo, :segundo_apellido_padrino_esposo, :primer_nombre_madrina_esposo, :segundo_nombre_madrina_esposo, :primer_apellido_madrina_esposo, :segundo_apellido_madrina_esposo, :primer_nombre_padrino_esposa, :segundo_nombre_padrino_esposa, 
                :primer_apellido_padrino_esposa, :segundo_apellido_padrino_esposa, :primer_nombre_madrina_esposa, :segundo_nombre_madrina_esposa, :primer_apellido_madrina_esposa, :segundo_apellido_madrina_esposa, :primer_nombre_ministro, :segundo_nombre_ministro, :primer_apellido_ministro, :segundo_apellido_ministro, :numLibro_matrimonio, :folio_matrimonio, :numeral_matrimonio, :notaMar_matrimonio, :finalidad)");
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
    <title>Registros de Matrimonios</title>
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

        <h1>¡Estos son los Matrimonios de nuestra Parroquia!</h1>
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
            echo '<button id="cerrarSesion" onclick="location.href=\'inserMatrimonio.php\'">Insertar Matrimonio</button>';
        }
        ?>
        </div>
            <div class="container">
            <form action="" method="get">
            <div class="search-container">
            <div class="search-bar">
                <select name="column">
                    <option value="primer_nombre_esposo" selected>Primer Nombre esposo</option>
                    <option value="segundo_nombre_esposo">Segundo Nombre esposo</option>
                    <option value="primer_apellido_esposo">Primer Apellido esposo</option>
                    <option value="segundo_apellido_esposo">Segundo Apellido esposo</option>
                    <option value="primer_nombre_papa_esposo">Primer Nombre Papa del esposo</option>
                    <option value="segundo_nombre_papa_esposo">Segundo Nombre Papa del esposo</option>
                    <option value="primer_apellido_papa_esposo">Primer Apellido Papa del esposo</option>
                    <option value="segundo_apellido_papa_esposo">Segundo Apellido Papa del esposo</option>
                    <option value="primer_nombre_mama_esposo">Primer Nombre Mama del esposo</option>
                    <option value="segundo_nombre_mama_esposo">Segundo Nombre Mama del esposo</option>
                    <option value="primer_apellido_mama_esposo">Primer Apellido Mama del esposo</option>
                    <option value="segundo_apellido_mama_esposo">Segundo Apellido Mama del esposo</option>
                    <option value="lugar_de_nacimiento_esposo">Ciudad de Nacimiento del esposo</option>
                    <option value="estado_de_nacimiento_esposo">Estado de Nacimiento del esposo</option>
                    <option value="pais_de_nacimiento_esposo">Pais de Nacimiento del esposo</option>
                    <option value="dia_de_nacimiento_esposo">Dia de Nacimiento del esposo</option>
                    <option value="mes_de_nacimiento_esposo">Mes de Nacimiento del esposo</option>
                    <option value="ano_de_nacimiento_esposo">Año de Nacimiento del esposo</option>
                    <option value="dia_de_bautizo_esposo">Dia de Bautizo del esposo</option>
                    <option value="mes_de_bautizo_esposo">Mes de Bautizo del esposo</option>
                    <option value="ano_de_bautizo_esposo">Año de Bautizo del esposo</option>
                    <option value="Iglesia_de_bautizo_esposo">Iglesia de Bautizo del esposo</option>
                    <option value="lugar_de_bautizo_esposo">Ciudad de Bautizo del esposo</option>
                    <option value="estado_de_bautizo_esposo">Estado de Bautizo del esposo</option>
                    <option value="pais_de_bautizo_esposo">Pais de Bautizo del esposo</option>
                    <option value="dia_de_matrimonio">Dia de matrimonio</option>
                    <option value="mes_de_matrimonio">Mes de matrimonio</option>
                    <option value="ano_de_matrimonio">Año de matrimonio</option>

                    <option value="primer_nombre_esposa">Primer Nombre esposa</option>
                    <option value="segundo_nombre_esposa">Segundo Nombre esposa</option>
                    <option value="primer_apellido_esposa">Primer Apellido esposa</option>
                    <option value="segundo_apellido_esposa">Segundo Apellido esposa</option>
                    <option value="primer_nombre_papa_esposa">Primer Nombre Papa del esposa</option>
                    <option value="segundo_nombre_papa_esposa">Segundo Nombre Papa del esposa</option>
                    <option value="primer_apellido_papa_esposa">Primer Apellido Papa del esposa</option>
                    <option value="segundo_apellido_papa_esposa">Segundo Apellido Papa del esposa</option>
                    <option value="primer_nombre_mama_esposa">Primer Nombre Mama del esposa</option>
                    <option value="segundo_nombre_mama_esposa">Segundo Nombre Mama del esposa</option>
                    <option value="primer_apellido_mama_esposa">Primer Apellido Mama del esposa</option>
                    <option value="segundo_apellido_mama_esposa">Segundo Apellido Mama del esposa</option>
                    <option value="lugar_de_nacimiento_esposa">Ciudad de Nacimiento del esposa</option>
                    <option value="estado_de_nacimiento_esposa">Estado de Nacimiento del esposa</option>
                    <option value="pais_de_nacimiento_esposa">Pais de Nacimiento del esposa</option>
                    <option value="dia_de_nacimiento_esposa">Dia de Nacimiento del esposa</option>
                    <option value="mes_de_nacimiento_esposa">Mes de Nacimiento del esposa</option>
                    <option value="ano_de_nacimiento_esposa">Año de Nacimiento del esposa</option>
                    <option value="dia_de_bautizo_esposa">Dia de Bautizo del esposa</option>
                    <option value="mes_de_bautizo_esposa">Mes de Bautizo del esposa</option>
                    <option value="ano_de_bautizo_esposa">Año de Bautizo del esposa</option>
                    <option value="Iglesia_de_bautizo_esposa">Iglesia de Bautizo de la esposa</option>
                    <option value="lugar_de_bautizo_esposa">Ciudad de Bautizo de la esposa</option>
                    <option value="estado_de_bautizo_esposa">Estado de Bautizo de la esposa</option>
                    <option value="pais_de_bautizo_esposa">Pais de Bautizo de la esposa</option>

                    <option value="primer_nombre_padrino_esposo">Primer Nombre Padrino del esposo</option>
                    <option value="segundo_nombre_padrino_esposo">Segundo Nombre Padrino del esposo</option>
                    <option value="primer_apellido_padrino_esposo">Primer Apellido Padrino del esposo</option>
                    <option value="segundo_apellido_padrino_esposo">Segundo Apellido Padrino del esposo</option>
                    <option value="primer_nombre_madrina_esposo">Primer Nombre Madrina del esposo</option>
                    <option value="segundo_nombre_madrina_esposo">Segundo Nombre Madrina del esposo</option>
                    <option value="primer_apellido_madrina_esposo">Primer Apellido Madrina del esposo</option>
                    <option value="segundo_apellido_madrina_esposo">Segundo Apellido Madrina del esposo</option>

                    <option value="primer_nombre_padrino_esposa">Primer Nombre Padrino de la esposa</option>
                    <option value="segundo_nombre_padrino_esposa">Segundo Nombre Padrino de la esposa</option>
                    <option value="primer_apellido_padrino_esposa">Primer Apellido Padrino de la esposa</option>
                    <option value="segundo_apellido_padrino_esposa">Segundo Apellido Padrino de la esposa</option>
                    <option value="primer_nombre_madrina_esposa">Primer Nombre Madrina de la esposa</option>
                    <option value="segundo_nombre_madrina_esposa">Segundo Nombre Madrina de la esposa</option>
                    <option value="primer_apellido_madrina_esposa">Primer Apellido Madrina de la esposa</option>
                    <option value="segundo_apellido_madrina_esposa">Segundo Apellido Madrina de la esposa</option>

                    <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
                    <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
                    <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
                    <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>

                    <option value="numLibro_matrimonio">Numero de libro de matrimonio</option>
                    <option value="folio_matrimonio">Folio de matrimonio</option>
                    <option value="numeral_matrimonio">Numeral de matrimonio</option>
                    <option value="notaMar_matrimonio">Nota Marginal de matrimonio</option>
                    <option value="finalidad">Finalidad del Acta de matrimonio</option>
                    </select>

            <select name="column2">
                <option value="primer_nombre_esposo" selected>Primer Nombre esposo</option>
                    <option value="segundo_nombre_esposo">Segundo Nombre esposo</option>
                    <option value="primer_apellido_esposo">Primer Apellido esposo</option>
                    <option value="segundo_apellido_esposo">Segundo Apellido esposo</option>
                    <option value="primer_nombre_papa_esposo">Primer Nombre Papa del esposo</option>
                    <option value="segundo_nombre_papa_esposo">Segundo Nombre Papa del esposo</option>
                    <option value="primer_apellido_papa_esposo">Primer Apellido Papa del esposo</option>
                    <option value="segundo_apellido_papa_esposo">Segundo Apellido Papa del esposo</option>
                    <option value="primer_nombre_mama_esposo">Primer Nombre Mama del esposo</option>
                    <option value="segundo_nombre_mama_esposo">Segundo Nombre Mama del esposo</option>
                    <option value="primer_apellido_mama_esposo">Primer Apellido Mama del esposo</option>
                    <option value="segundo_apellido_mama_esposo">Segundo Apellido Mama del esposo</option>
                    <option value="lugar_de_nacimiento_esposo">Ciudad de Nacimiento del esposo</option>
                    <option value="estado_de_nacimiento_esposo">Estado de Nacimiento del esposo</option>
                    <option value="pais_de_nacimiento_esposo">Pais de Nacimiento del esposo</option>
                    <option value="dia_de_nacimiento_esposo">Dia de Nacimiento del esposo</option>
                    <option value="mes_de_nacimiento_esposo">Mes de Nacimiento del esposo</option>
                    <option value="ano_de_nacimiento_esposo">Año de Nacimiento del esposo</option>
                    <option value="dia_de_bautizo_esposo">Dia de Bautizo del esposo</option>
                    <option value="mes_de_bautizo_esposo">Mes de Bautizo del esposo</option>
                    <option value="ano_de_bautizo_esposo">Año de Bautizo del esposo</option>
                    <option value="dia_de_bautizo_esposo">Dia de matrimonio</option>
                    <option value="mes_de_bautizo_esposo">Mes de matrimonio</option>
                    <option value="ano_de_bautizo_esposo">Año de matrimonio</option>
                    <option value="Iglesia_de_bautizo_esposo">Iglesia de Bautizo del esposo</option>
                    <option value="lugar_de_bautizo_esposo">Ciudad de Bautizo de la esposo</option>
                    <option value="estado_de_bautizo_esposo">Estado de Bautizo del esposo</option>
                    <option value="pais_de_bautizo_esposo">Pais de Bautizo del esposo</option>
                    <option value="dia_de_matrimonio">Dia de matrimonio</option>
                    <option value="mes_de_matrimonio">Mes de matrimonio</option>
                    <option value="ano_de_matrimonio">Año de matrimonio</option>

                    <option value="primer_nombre_esposa">Primer Nombre esposa</option>
                    <option value="segundo_nombre_esposa">Segundo Nombre esposa</option>
                    <option value="primer_apellido_esposa">Primer Apellido esposa</option>
                    <option value="segundo_apellido_esposa">Segundo Apellido esposa</option>
                    <option value="primer_nombre_papa_esposa">Primer Nombre Papa del esposa</option>
                    <option value="segundo_nombre_papa_esposa">Segundo Nombre Papa del esposa</option>
                    <option value="primer_apellido_papa_esposa">Primer Apellido Papa del esposa</option>
                    <option value="segundo_apellido_papa_esposa">Segundo Apellido Papa del esposa</option>
                    <option value="primer_nombre_mama_esposa">Primer Nombre Mama del esposa</option>
                    <option value="segundo_nombre_mama_esposa">Segundo Nombre Mama del esposa</option>
                    <option value="primer_apellido_mama_esposa">Primer Apellido Mama del esposa</option>
                    <option value="segundo_apellido_mama_esposa">Segundo Apellido Mama del esposa</option>
                    <option value="lugar_de_nacimiento_esposa">Ciudad de Nacimiento del esposa</option>
                    <option value="estado_de_nacimiento_esposa">Estado de Nacimiento del esposa</option>
                    <option value="pais_de_nacimiento_esposa">Pais de Nacimiento del esposa</option>
                    <option value="dia_de_nacimiento_esposa">Dia de Nacimiento del esposa</option>
                    <option value="mes_de_nacimiento_esposa">Mes de Nacimiento del esposa</option>
                    <option value="ano_de_nacimiento_esposa">Año de Nacimiento del esposa</option>
                    <option value="dia_de_bautizo_esposa">Dia de Bautizo del esposa</option>
                    <option value="mes_de_bautizo_esposa">Mes de Bautizo del esposa</option>
                    <option value="ano_de_bautizo_esposa">Año de Bautizo del esposa</option>
                    <option value="Iglesia_de_bautizo_esposa">Iglesia de Bautizo de la esposa</option>
                    <option value="lugar_de_bautizo_esposa">Ciudad de Bautizo de la esposa</option>
                    <option value="estado_de_bautizo_esposa">Estado de Bautizo de la esposa</option>
                    <option value="pais_de_bautizo_esposa">Pais de Bautizo de la esposa</option>

                    <option value="primer_nombre_padrino_esposo">Primer Nombre Padrino del esposo</option>
                    <option value="segundo_nombre_padrino_esposo">Segundo Nombre Padrino del esposo</option>
                    <option value="primer_apellido_padrino_esposo">Primer Apellido Padrino del esposo</option>
                    <option value="segundo_apellido_padrino_esposo">Segundo Apellido Padrino del esposo</option>
                    <option value="primer_nombre_madrina_esposo">Primer Nombre Madrina del esposo</option>
                    <option value="segundo_nombre_madrina_esposo">Segundo Nombre Madrina del esposo</option>
                    <option value="primer_apellido_madrina_esposo">Primer Apellido Madrina del esposo</option>
                    <option value="segundo_apellido_madrina_esposo">Segundo Apellido Madrina del esposo</option>

                    <option value="primer_nombre_padrino_esposa">Primer Nombre Padrino de la esposa</option>
                    <option value="segundo_nombre_padrino_esposa">Segundo Nombre Padrino de la esposa</option>
                    <option value="primer_apellido_padrino_esposa">Primer Apellido Padrino de la esposa</option>
                    <option value="segundo_apellido_padrino_esposa">Segundo Apellido Padrino de la esposa</option>
                    <option value="primer_nombre_madrina_esposa">Primer Nombre Madrina de la esposa</option>
                    <option value="segundo_nombre_madrina_esposa">Segundo Nombre Madrina de la esposa</option>
                    <option value="primer_apellido_madrina_esposa">Primer Apellido Madrina de la esposa</option>
                    <option value="segundo_apellido_madrina_esposa">Segundo Apellido Madrina de la esposa</option>

                    <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
                    <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
                    <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
                    <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>

                    <option value="numLibro_matrimonio">Numero de libro de matrimonio</option>
                    <option value="folio_matrimonio">Folio de matrimonio</option>
                    <option value="numeral_matrimonio">Numeral de matrimonio</option>
                    <option value="notaMar_matrimonio">Nota Marginal de matrimonio</option>
                    <option value="finalidad">Finalidad del Acta de matrimonio</option>
                    </select>

            <select name="column3">
                <option value="primer_nombre_esposo" selected>Primer Nombre esposo</option>
                    <option value="segundo_nombre_esposo">Segundo Nombre esposo</option>
                    <option value="primer_apellido_esposo">Primer Apellido esposo</option>
                    <option value="segundo_apellido_esposo">Segundo Apellido esposo</option>
                    <option value="primer_nombre_papa_esposo">Primer Nombre Papa del esposo</option>
                    <option value="segundo_nombre_papa_esposo">Segundo Nombre Papa del esposo</option>
                    <option value="primer_apellido_papa_esposo">Primer Apellido Papa del esposo</option>
                    <option value="segundo_apellido_papa_esposo">Segundo Apellido Papa del esposo</option>
                    <option value="primer_nombre_mama_esposo">Primer Nombre Mama del esposo</option>
                    <option value="segundo_nombre_mama_esposo">Segundo Nombre Mama del esposo</option>
                    <option value="primer_apellido_mama_esposo">Primer Apellido Mama del esposo</option>
                    <option value="segundo_apellido_mama_esposo">Segundo Apellido Mama del esposo</option>
                    <option value="lugar_de_nacimiento_esposo">Ciudad de Nacimiento del esposo</option>
                    <option value="estado_de_nacimiento_esposo">Estado de Nacimiento del esposo</option>
                    <option value="pais_de_nacimiento_esposo">Pais de Nacimiento del esposo</option>
                    <option value="dia_de_nacimiento_esposo">Dia de Nacimiento del esposo</option>
                    <option value="mes_de_nacimiento_esposo">Mes de Nacimiento del esposo</option>
                    <option value="ano_de_nacimiento_esposo">Año de Nacimiento del esposo</option>
                    <option value="dia_de_bautizo_esposo">Dia de Bautizo del esposo</option>
                    <option value="mes_de_bautizo_esposo">Mes de Bautizo del esposo</option>
                    <option value="ano_de_bautizo_esposo">Año de Bautizo del esposo</option>
                    <option value="dia_de_bautizo_esposo">Dia de matrimonio</option>
                    <option value="mes_de_bautizo_esposo">Mes de matrimonio</option>
                    <option value="ano_de_bautizo_esposo">Año de matrimonio</option>
                    <option value="Iglesia_de_bautizo_esposo">Iglesia de Bautizo del esposo</option>
                    <option value="lugar_de_bautizo_esposo">Ciudad de Bautizo del esposo</option>
                    <option value="estado_de_bautizo_esposo">Estado de Bautizo del esposo</option>
                    <option value="pais_de_bautizo_esposo">Pais de Bautizo del esposo</option>
                    <option value="dia_de_matrimonio">Dia de matrimonio</option>
                    <option value="mes_de_matrimonio">Mes de matrimonio</option>
                    <option value="ano_de_matrimonio">Año de matrimonio</option>

                    <option value="primer_nombre_esposa">Primer Nombre esposa</option>
                    <option value="segundo_nombre_esposa">Segundo Nombre esposa</option>
                    <option value="primer_apellido_esposa">Primer Apellido esposa</option>
                    <option value="segundo_apellido_esposa">Segundo Apellido esposa</option>
                    <option value="primer_nombre_papa_esposa">Primer Nombre Papa del esposa</option>
                    <option value="segundo_nombre_papa_esposa">Segundo Nombre Papa del esposa</option>
                    <option value="primer_apellido_papa_esposa">Primer Apellido Papa del esposa</option>
                    <option value="segundo_apellido_papa_esposa">Segundo Apellido Papa del esposa</option>
                    <option value="primer_nombre_mama_esposa">Primer Nombre Mama del esposa</option>
                    <option value="segundo_nombre_mama_esposa">Segundo Nombre Mama del esposa</option>
                    <option value="primer_apellido_mama_esposa">Primer Apellido Mama del esposa</option>
                    <option value="segundo_apellido_mama_esposa">Segundo Apellido Mama del esposa</option>
                    <option value="lugar_de_nacimiento_esposa">Ciudad de Nacimiento del esposa</option>
                    <option value="estado_de_nacimiento_esposa">Estado de Nacimiento del esposa</option>
                    <option value="pais_de_nacimiento_esposa">Pais de Nacimiento del esposa</option>
                    <option value="dia_de_nacimiento_esposa">Dia de Nacimiento del esposa</option>
                    <option value="mes_de_nacimiento_esposa">Mes de Nacimiento del esposa</option>
                    <option value="ano_de_nacimiento_esposa">Año de Nacimiento del esposa</option>
                    <option value="dia_de_bautizo_esposa">Dia de Bautizo del esposa</option>
                    <option value="mes_de_bautizo_esposa">Mes de Bautizo del esposa</option>
                    <option value="ano_de_bautizo_esposa">Año de Bautizo del esposa</option>
                    <option value="Iglesia_de_bautizo_esposa">Iglesia de Bautizo de la esposa</option>
                    <option value="lugar_de_bautizo_esposa">Ciudad de Bautizo de la esposa</option>
                    <option value="estado_de_bautizo_esposa">Estado de Bautizo de la esposa</option>
                    <option value="pais_de_bautizo_esposa">Pais de Bautizo de la esposa</option>

                    <option value="primer_nombre_padrino_esposo">Primer Nombre Padrino del esposo</option>
                    <option value="segundo_nombre_padrino_esposo">Segundo Nombre Padrino del esposo</option>
                    <option value="primer_apellido_padrino_esposo">Primer Apellido Padrino del esposo</option>
                    <option value="segundo_apellido_padrino_esposo">Segundo Apellido Padrino del esposo</option>
                    <option value="primer_nombre_madrina_esposo">Primer Nombre Madrina del esposo</option>
                    <option value="segundo_nombre_madrina_esposo">Segundo Nombre Madrina del esposo</option>
                    <option value="primer_apellido_madrina_esposo">Primer Apellido Madrina del esposo</option>
                    <option value="segundo_apellido_madrina_esposo">Segundo Apellido Madrina del esposo</option>

                    <option value="primer_nombre_padrino_esposa">Primer Nombre Padrino de la esposa</option>
                    <option value="segundo_nombre_padrino_esposa">Segundo Nombre Padrino de la esposa</option>
                    <option value="primer_apellido_padrino_esposa">Primer Apellido Padrino de la esposa</option>
                    <option value="segundo_apellido_padrino_esposa">Segundo Apellido Padrino de la esposa</option>
                    <option value="primer_nombre_madrina_esposa">Primer Nombre Madrina de la esposa</option>
                    <option value="segundo_nombre_madrina_esposa">Segundo Nombre Madrina de la esposa</option>
                    <option value="primer_apellido_madrina_esposa">Primer Apellido Madrina de la esposa</option>
                    <option value="segundo_apellido_madrina_esposa">Segundo Apellido Madrina de la esposa</option>

                    <option value="primer_nombre_ministro">Primer Nombre Ministro</option>
                    <option value="segundo_nombre_ministro">Segundo Nombre Ministro</option>
                    <option value="primer_apellido_ministro">Primer Apellido Ministro</option>
                    <option value="segundo_apellido_ministro">Segundo Apellido Ministro</option>

                    <option value="numLibro_matrimonio">Numero de libro de matrimonio</option>
                    <option value="folio_matrimonio">Folio de matrimonio</option>
                    <option value="numeral_matrimonio">Numeral de matrimonio</option>
                    <option value="notaMar_matrimonio">Nota Marginal de matrimonio</option>
                    <option value="finalidad">Finalidad del Acta de matrimonio</option>
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
                echo '<button class="botonInsertar" onclick="window.location.href=\'indexMatrimonio.php?accion=leer_respaldo\'">Leer Respaldo</button>';
            }
            ?>

            <script>
            function hacerRespaldo() {
                // Comprueba si la base de datos está vacía
                <?php
                $stmt = $db->prepare("SELECT COUNT(*) FROM [matrimonios]");
                $stmt->execute();
                $count = $stmt->fetchColumn();
                ?>
                if (<?php echo $count; ?> == 0) {
                    alert("La base de datos está vacía, no se puede hacer el respaldo.");
                } else {
                    window.location.href = 'indexMatrimonio.php?accion=hacer_respaldo';
                }
            }
            </script>

        </form>
            <table>
            <tr>
            <th>ID</th>
            <th>Primer Nombre del esposo</th>
            <th>Segundo Nombre del esposo</th>
            <th>Primer Apellido del esposo</th>
            <th>Segundo Apellido del esposo</th>
            <th>Primer Nombre Papa del esposo</th>
            <th>Segundo Nombre Papa del esposo</th>
            <th>Primer Apellido Papa del esposo</th>
            <th>Segundo Apellido Papa del esposo</th>
            <th>Primer Nombre Mama del esposo</th>
            <th>Segundo Nombre Mama del esposo</th>
            <th>Primer Apellido Mama del esposo</th>
            <th>Segundo Apellido Mama del esposo</th>
            <th>Ciudad de Nacimiento del esposo</th>
            <th>Estado de Nacimiento del esposo</th>
            <th>Pais de Nacimiento del esposo</th>
            <th>Dia de Nacimiento del esposo</th>
            <th>Mes de Nacimiento del esposo</th>
            <th>Año de Nacimiento del esposo</th>
            <th>Dia de Bautizo del esposo</th>
            <th>Mes de Bautizo del esposo</th>
            <th>Año de Bautizo del esposo</th>
            <th>Iglesia de Bautizo del esposo</th>
            <th>Ciudad de Bautizo del esposo</th>
            <th>Estado de Bautizo del esposo</th>
            <th>Pais de Bautizo del esposo</th>
            <th>Dia de matrimonio</th>
            <th>Mes de matrimonio</th>
            <th>Año de matrimonio</th>
            <th>Primer Nombre de la esposa</th>
            <th>Segundo Nombre de la esposa</th>
            <th>Primer Apellido de la esposa</th>
            <th>Segundo Apellido de la esposa</th>
            <th>Primer Nombre Papa de la esposa</th>
            <th>Segundo Nombre Papa de la esposa</th>
            <th>Primer Apellido Papa de la esposa</th>
            <th>Segundo Apellido Papa de la esposa</th>
            <th>Primer Nombre Mama de la esposa</th>
            <th>Segundo Nombre Mama de la esposa</th>
            <th>Primer Apellido Mama de la esposa</th>
            <th>Segundo Apellido Mama de la esposa</th>
            <th>Ciudad de Nacimiento de la esposa</th>
            <th>Estado de Nacimiento de la esposa</th>
            <th>Pais de Nacimiento de la esposa</th>
            <th>Dia de Nacimiento de la esposa</th>
            <th>Mes de Nacimiento de la esposa</th>
            <th>Año de Nacimiento de la esposa</th>
            <th>Dia de Bautizo de la esposa</th>
            <th>Mes de Bautizo de la esposa</th>
            <th>Año de Bautizo de la esposa</th>
            <th>Iglesia de Bautizo de la esposa</th>
            <th>Ciudad de Bautizo de la esposa</th>
            <th>Estado de Bautizo de la esposa</th>
            <th>Pais de Bautizo de la esposa</th>
            <th>Primer Nombre Padrino del esposo</th>
            <th>Segundo Nombre Padrino del esposo</th>
            <th>Primer Apellido Padrino del esposo</th>
            <th>Segundo Apellido Padrino del esposo</th>
            <th>Primer Nombre Madrina del esposo</th>
            <th>Segundo Nombre Madrina del esposo</th>
            <th>Primer Apellido Madrina del esposo</th>
            <th>Segundo Apellido Madrina del esposo</th>
            <th>Primer Nombre Padrino de la esposa</th>
            <th>Segundo Nombre Padrino de la esposa</th>
            <th>Primer Apellido Padrino de la esposa</th>
            <th>Segundo Apellido Padrino de la esposa</th>
            <th>Primer Nombre Madrina de la esposa</th>
            <th>Segundo Nombre Madrina de la esposa</th>
            <th>Primer Apellido Madrina de la esposa</th>
            <th>Segundo Apellido Madrina de la esposa</th>
            <th>Primer Nombre Ministro</th>
            <th>Segundo Nombre Ministro</th>
            <th>Primer Apellido Ministro</th>
            <th>Segundo Apellido Ministro</th>    
            <th>Numero de libro de matrimonio</th>
            <th>Folio de matrimonio</th>
            <th>Numeral de matrimonio</th>
            <th>Nota Marginal de matrimonio</th>
            <th>finalidad</th>
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
                                echo '<a href="documentoMatrimonio.php?id=' . $row['id'] . '"><button type="button">' . $row['id'] . '</button></a>';
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

                                echo '<a href="actualizarMatrimonio.php?id=' . $row['id'] . 
                                        '& nom1_esposo=' . $row['primer_nombre_esposo'] . 
                                        '& nom2_esposo=' . $row['segundo_nombre_esposo'] . 
                                        '& ape1_esposo=' . $row['primer_apellido_esposo'] .
                                        '& ape2_esposo=' . $row['segundo_apellido_esposo'] .
                                        '& nom_papa1_esposo=' . $row['primer_nombre_papa_esposo'] .
                                        '& nom_papa2_esposo=' . $row['segundo_nombre_papa_esposo'] .
                                        '& apepapa1_esposo=' . $row['primer_apellido_papa_esposo'] .
                                        '& apepapa2_esposo=' . $row['segundo_apellido_papa_esposo'] .
                                        '& nom_mama1_esposo=' . $row['primer_nombre_mama_esposo'] .
                                        '& nom_mama2_esposo=' . $row['segundo_nombre_mama_esposo'] .
                                        '& apemama1_esposo=' . $row['primer_apellido_mama_esposo'] .
                                        '& apemama2_esposo=' . $row['segundo_apellido_mama_esposo'] .
                                        '& lugar_nac_esposo=' . $row['lugar_de_nacimiento_esposo'] .
                                        '& estado_nac_esposo=' . $row['estado_de_nacimiento_esposo'] .
                                        '& pais_nac_esposo=' . $row['pais_de_nacimiento_esposo'] .
                                        '& dia_nac_esposo=' . $row['dia_de_nacimiento_esposo'] .
                                        '& mes_nac_esposo=' . $row['mes_de_nacimiento_esposo'] .
                                        '& ano_nac_esposo=' . $row['ano_de_nacimiento_esposo'] .
                                        '& dia_bau_esposo=' . $row['dia_de_bautizo_esposo'] .
                                        '& mes_bau_esposo=' . $row['mes_de_bautizo_esposo'] .
                                        '& ano_bau_esposo=' . $row['ano_de_bautizo_esposo'] .
                                        '& iglesia_bau_esposo=' . $row['iglesia_de_bautizo_esposo'] .
                                        '& lugar_bau_esposo=' . $row['lugar_de_bautizo_esposo'] .
                                        '& estado_bau_esposo=' . $row['estado_de_bautizo_esposo'] .
                                        '& pais_bau_esposo=' . $row['pais_de_bautizo_esposo'] .
                                        '& dia_matrimonio=' . $row['dia_de_matrimonio'] .
                                        '& mes_matrimonio=' . $row['mes_de_matrimonio'] .
                                        '& ano_matrimonio=' . $row['ano_de_matrimonio'] .
                                        '& nom1_esposa=' . $row['primer_nombre_esposa'] . 
                                        '& nom2_esposa=' . $row['segundo_nombre_esposa'] . 
                                        '& ape1_esposa=' . $row['primer_apellido_esposa'] .
                                        '& ape2_esposa=' . $row['segundo_apellido_esposa'] .
                                        '& nom_papa1_esposa=' . $row['primer_nombre_papa_esposa'] .
                                        '& nom_papa2_esposa=' . $row['segundo_nombre_papa_esposa'] .
                                        '& apepapa1_esposa=' . $row['primer_apellido_papa_esposa'] .
                                        '& apepapa2_esposa=' . $row['segundo_apellido_papa_esposa'] .
                                        '& nom_mama1_esposa=' . $row['primer_nombre_mama_esposa'] .
                                        '& nom_mama2_esposa=' . $row['segundo_nombre_mama_esposa'] .
                                        '& apemama1_esposa=' . $row['primer_apellido_mama_esposa'] .
                                        '& apemama2_esposa=' . $row['segundo_apellido_mama_esposa'] .
                                        '& lugar_nac_esposa=' . $row['lugar_de_nacimiento_esposa'] .
                                        '& estado_nac_esposa=' . $row['estado_de_nacimiento_esposa'] .
                                        '& pais_nac_esposa=' . $row['pais_de_nacimiento_esposa'] .
                                        '& dia_nac_esposa=' . $row['dia_de_nacimiento_esposa'] .
                                        '& mes_nac_esposa=' . $row['mes_de_nacimiento_esposa'] .
                                        '& ano_nac_esposa=' . $row['ano_de_nacimiento_esposa'] .
                                        '& dia_bau_esposa=' . $row['dia_de_bautizo_esposa'] .
                                        '& mes_bau_esposa=' . $row['mes_de_bautizo_esposa'] .
                                        '& ano_bau_esposa=' . $row['ano_de_bautizo_esposa'] .
                                        '& iglesia_bau_esposa=' . $row['iglesia_de_bautizo_esposa'] .
                                        '& lugar_bau_esposa=' . $row['lugar_de_bautizo_esposa'] .
                                        '& estado_bau_esposa=' . $row['estado_de_bautizo_esposa'] .
                                        '& pais_bau_esposa=' . $row['pais_de_bautizo_esposa'] .
                                        '& nom_padri1_esposo=' . $row['primer_nombre_padrino_esposo'] .
                                        '& nom_padri2_esposo=' . $row['segundo_nombre_padrino_esposo'] .
                                        '& apepadri1_esposo=' . $row['primer_apellido_padrino_esposo'] .
                                        '& apepadri2_esposo=' . $row['segundo_apellido_padrino_esposo'] .
                                        '& nom_madri1_esposo=' . $row['primer_nombre_madrina_esposo'] .
                                        '& nom_madri2_esposo=' . $row['segundo_nombre_madrina_esposo'] .
                                        '& apemadri1_esposo=' . $row['primer_apellido_madrina_esposo'] .
                                        '& apemadri2_esposo=' . $row['segundo_apellido_madrina_esposo'] .
                                        '& nom_padri1_esposa=' . $row['primer_nombre_padrino_esposa'] .
                                        '& nom_padri2_esposa=' . $row['segundo_nombre_padrino_esposa'] .
                                        '& apepadri1_esposa=' . $row['primer_apellido_padrino_esposa'] .
                                        '& apepadri2_esposa=' . $row['segundo_apellido_padrino_esposa'] .
                                        '& nom_madri1_esposa=' . $row['primer_nombre_madrina_esposa'] .
                                        '& nom_madri2_esposa=' . $row['segundo_nombre_madrina_esposa'] .
                                        '& apemadri1_esposa=' . $row['primer_apellido_madrina_esposa'] .
                                        '& apemadri2_esposa=' . $row['segundo_apellido_madrina_esposa'] .
                                        '& nom_minis1=' . $row['primer_nombre_ministro'] .
                                        '& nom_minis2=' . $row['segundo_nombre_ministro'] .
                                        '& apeminis1=' . $row['primer_apellido_ministro'] .
                                        '& apeminis2=' . $row['segundo_apellido_ministro'] .
                                        '& numLibro_matrimonio=' . $row['numLibro_matrimonio'] .
                                        '& folio_matrimonio=' . $row['folio_matrimonio'] .
                                        '& numeral_matrimonio=' . $row['numeral_matrimonio'] .
                                        '& notaMar_matrimonio=' . $row['notaMar_matrimonio'] .
                                        '& finalidad=' . $row['finalidad'] . '"><input type="button" name="up" id="up" value="Actualizar"></a>';
                                                            } else {
                                                                echo $row['id'];
                                                            }
                                                        } else {
                                                            echo $row['id'];
                                                        }
                                                        ?>
                                                    </td>
                    <td><?php echo $row['primer_nombre_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_esposo'] ; ?></td>
                    <td><?php echo $row['primer_apellido_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_esposo'] ; ?></td>
                    <td><?php echo $row['primer_nombre_papa_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_papa_esposo'] ; ?></td>
                    <td><?php echo $row['primer_apellido_papa_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_papa_esposo'] ; ?></td>
                    <td><?php echo $row['primer_nombre_mama_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_mama_esposo'] ; ?></td>
                    <td><?php echo $row['primer_apellido_mama_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_mama_esposo'] ; ?></td>
                    <td><?php echo $row['lugar_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['estado_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['pais_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['dia_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['mes_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['ano_de_nacimiento_esposo'] ; ?></td>
                    <td><?php echo $row['dia_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['mes_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['ano_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['iglesia_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['lugar_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['estado_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['pais_de_bautizo_esposo'] ; ?></td>
                    <td><?php echo $row['dia_de_matrimonio'] ; ?></td>
                    <td><?php echo $row['mes_de_matrimonio'] ; ?></td>
                    <td><?php echo $row['ano_de_matrimonio'] ; ?></td>
                    <td><?php echo $row['primer_nombre_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_esposa'] ; ?></td>
                    <td><?php echo $row['primer_apellido_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_esposa'] ; ?></td>
                    <td><?php echo $row['primer_nombre_papa_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_papa_esposa'] ; ?></td>
                    <td><?php echo $row['primer_apellido_papa_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_papa_esposa'] ; ?></td>
                    <td><?php echo $row['primer_nombre_mama_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_mama_esposa'] ; ?></td>
                    <td><?php echo $row['primer_apellido_mama_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_mama_esposa'] ; ?></td>
                    <td><?php echo $row['lugar_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['estado_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['pais_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['dia_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['mes_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['ano_de_nacimiento_esposa'] ; ?></td>
                    <td><?php echo $row['dia_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['dia_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['mes_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['ano_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['iglesia_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['lugar_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['estado_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['pais_de_bautizo_esposa'] ; ?></td>
                    <td><?php echo $row['primer_nombre_padrino_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_padrino_esposo'] ; ?></td>
                    <td><?php echo $row['primer_apellido_padrino_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_padrino_esposo'] ; ?></td>
                    <td><?php echo $row['primer_nombre_madrina_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_madrina_esposo'] ; ?></td>
                    <td><?php echo $row['primer_apellido_madrina_esposo'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_madrina_esposo'] ; ?></td>
                    <td><?php echo $row['primer_nombre_padrino_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_padrino_esposa'] ; ?></td>
                    <td><?php echo $row['primer_apellido_padrino_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_padrino_esposa'] ; ?></td>
                    <td><?php echo $row['primer_nombre_madrina_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_madrina_esposa'] ; ?></td>
                    <td><?php echo $row['primer_apellido_madrina_esposa'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_madrina_esposa'] ; ?></td>
                    <td><?php echo $row['primer_nombre_ministro'] ; ?></td>
                    <td><?php echo $row['segundo_nombre_ministro'] ; ?></td>
                    <td><?php echo $row['primer_apellido_ministro'] ; ?></td>
                    <td><?php echo $row['segundo_apellido_ministro'] ; ?></td>
                    <td><?php echo $row['numLibro_matrimonio'] ; ?></td>
                    <td><?php echo $row['folio_matrimonio'] ; ?></td>
                    <td><?php echo $row['numeral_matrimonio'] ; ?></td>
                    <td><?php echo $row['notaMar_matrimonio'] ; ?></td>
                    <td><?php echo $row['finalidad'] ; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

</body>
</html>