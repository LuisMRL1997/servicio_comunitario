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
$column = (isset($_GET['column'])) ? $_GET['column'] : 'id';
$search2 = (isset($_GET['search2'])) ? $_GET['search2'] : '';
$column2 = (isset($_GET['column2'])) ? $_GET['column2'] : 'tipo';
$search3 = (isset($_GET['search3'])) ? $_GET['search3'] : '';
$column3 = (isset($_GET['column3'])) ? $_GET['column3'] : 'ano';

$stmt = $db->prepare("SELECT * FROM [eventos] WHERE " . $column . " LIKE :search AND " . $column2 . " LIKE :search2 AND " . $column3 . " LIKE :search3");
$stmt->execute(array(':search' => '%' . $search . '%', ':search2' => '%' . $search2 . '%', ':search3' => '%' . $search3 . '%'));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $db->prepare("SELECT * FROM [eventos]");
$stmt2->execute();

// Fetch all data
$data2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

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
    $carpeta = 'respaldos monterrey';
    if (!file_exists($carpeta)) {
        if (!mkdir($carpeta, 0777, true)) {
            die('Error al crear la carpeta de respaldos.');
        }
    }

    // Crear el archivo de respaldo en la carpeta "respaldos monterrey"
    $archivo_respaldo = $carpeta . '/respaldo_eventos.txt';
    if (file_put_contents($archivo_respaldo, $respaldo) === false) {
        die('Error al crear el archivo de respaldo.');
    }
}



// insertar respaldo
// Comprueba si el archivo de respaldo existe
if (isset($_GET['accion']) && $_GET['accion'] == 'leer_respaldo') {
// Comprueba si el archivo de respaldo existe
if (file_exists('respaldos monterrey/respaldo_eventos.txt')) {
    // Lee las líneas del archivo de respaldo
    $lineas = file('respaldos monterrey/respaldo_eventos.txt');

    // Inicializa un array vacío para almacenar los datos de un registro
    $registro = [];

    foreach ($lineas as $linea) {
        // Si la línea está vacía, significa que hemos llegado al final de un registro
        if (trim($linea) == '') {
            // Comprueba si el ID ya existe en la base de datos
            $stmt = $db->prepare("SELECT COUNT(*) FROM [eventos] WHERE [id] = ?");
            $stmt->execute([$registro['id']]);
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                // Inserta el registro en la base de datos
                $stmt = $db->prepare("INSERT INTO [eventos] (id, tipo, descripcion, dia, mes, ano, hora_inicio, hora_fin) VALUES (:id, :tipo, :descripcion, :dia, :mes, :ano, :hora_inicio, :hora_fin)");
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
    <title>Registros de Eventos</title>
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
    echo '<button id="cerrarSesion" onclick="location.href=\'inserEvento.php\'">Insertar Evento</button>';
}
?>
</div>
    <div class="container">
    <form action="" method="get">
    <div class="search-container">
    <div class="search-bar">
        <select name="column">
            <option value="id" selected>ID</option>
            <option value="tipo">Tipo</option>
            <option value="descripcion">Descripción</option>
            <option value="dia">Día</option>
            <option value="mes">Mes</option>
            <option value="ano">Año</option>
            <option value="hora_inicio">Hora Inicio</option>
            <option value="hora_fin">Hora Fin</option>
        </select>
    <select name="column2">
        <option value="id">ID</option>
        <option value="tipo" selected>Tipo</option>
        <option value="descripcion">Descripción</option>
        <option value="dia">Día</option>
        <option value="mes">Mes</option>
        <option value="ano">Año</option>
        <option value="hora_inicio">Hora Inicio</option>
        <option value="hora_fin">Hora Fin</option>
    </select>
    <select name="column3">
    <option value="id">ID</option>
        <option value="tipo">Tipo</option>
        <option value="descripcion">Descripción</option>
        <option value="dia">Día</option>
        <option value="mes">Mes</option>
        <option value="ano"selected>Año</option>
        <option value="hora_inicio">Hora Inicio</option>
        <option value="hora_fin">Hora Fin</option>
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
        echo '<button class="botonInsertar" onclick="window.location.href=\'indexEventos.php?accion=leer_respaldo\'">Leer Respaldo</button>';
    }
    ?>


<script>
function hacerRespaldo() {
    // Comprueba si la base de datos está vacía
    <?php
    $stmt = $db->prepare("SELECT COUNT(*) FROM [eventos]");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    ?>
    if (<?php echo $count; ?> == 0) {
        alert("La base de datos está vacía, no se puede hacer el respaldo.");
    } else {
        window.location.href = 'indexEventos.php?accion=hacer_respaldo';
    }
}
</script>  

</form>

    <table>
    <tr>
    <th>ID</th>
    <th>Tipo</th>
    <th>Descripción</th>
    <th>Día</th>
    <th>Mes</th>
    <th>Año</th>
    <th>Hora Inicio</th>
    <th>Hora Fin</th>
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
                        echo '<a href="documentoEvento.php?id=' . $row['id'] . '"><button type="button">' . $row['id'] . '</button></a>';
                        echo '<input type="button" name="del" id="del" value="Borrar" onclick="return confirmDelete(' . $row['id'] . ')">';
                        echo '
                        <script>
                            function confirmDelete(id) {
                                var confirmation = confirm("¿Estás seguro de que quieres borrar este registro?");
                                if (confirmation) {
                                    window.location.href = "borrarEvento.php?id=" + id;
                                }
                                return false;
                            }
                        </script>
                        ';
                        echo '<a href="actualizarEvento.php?id=' . $row['id'] . 
                                '& tipo=' . $row['tipo'] . 
                                '& descripcion=' . $row['descripcion'] . 
                                '& dia=' . $row['dia'] .
                                '& mes=' . $row['mes'] .
                                '& ano=' . $row['ano'] .
                                '& hora_inicio=' . $row['hora_inicio'] .
                                '& hora_fin=' . $row['hora_fin'] . '"><input type="button" name="up" id="up" value="Actualizar"></a>';
                                                    } else {
                                                        echo $row['id'];
                                                    }
                                                } else {
                                                    echo $row['id'];
                                                }
                                                ?>
                                            </td>
            <td><?php echo $row['tipo']; ?></td>
            <td><?php echo $row['descripcion']; ?></td>
            <td><?php echo $row['dia']; ?></td>
            <td><?php echo $row['mes']; ?></td>
            <td><?php echo $row['ano']; ?></td>
            <td><?php echo $row['hora_inicio']; ?></td>
            <td><?php echo $row['hora_fin']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
