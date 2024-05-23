<!DOCTYPE html>
<html>
<head>
    <title>Registros de Usuarios</title>
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
    session_start();
    include("conexion2.php");
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
                echo '<a href="respaldo.php">Hacer Respaldo</a>';
                echo '<button onclick="window.location.href=\'respaldo.php\'">Hacer respaldo</button>'; // Botón de respaldo
            }
            ?>
        </div>
    </div>
    <button id="cerrarSesion" onclick="window.location.href='indexEventos.php'">Eventos</button>
    <?php
    if (isset($user) && ($user['es_maestro'] || $user['es_administrador'])) {
        echo '<button id="cerrarSesion" onclick="location.href=\'inserBautizo.php\'">Insertar Bautizo</button>';
    }
    ?>
    </div>
    <div class="container">
        <?php
        // Consulta SQL para obtener todos los usuarios
        $sql = "SELECT * FROM [usuarios]";
        $result = $db->query($sql);

        // Comprobamos si la consulta ha devuelto resultados
        if ($result) {
            // Creamos una tabla para mostrar los resultados
            echo "<table>";
            echo "<tr><th></th><th>ID</th><th>Primer Nombre</th><th>Segundo Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Género</th><th>Documento de Identidad</th><th>Fecha de Nacimiento</th><th>Nombre de Usuario</th><th>Correo Electrónico</th><th>Número de Teléfono</th><th>Dirección</th><th>Ciudad</th><th>Estado</th><th>País</th><th>Código Postal</th><th>Rol</th><th>Es Administrador</th><th>Es Maestro</th><th>Fecha de Registro</th><th>Fecha Último Ingreso</th></tr>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                if (isset($_SESSION['nombre_usuario'])) {
                    $nombre_usuario = $_SESSION['nombre_usuario'];
                    $stmt = $db->prepare("SELECT es_maestro FROM [usuarios] WHERE [nombre_usuario] = ?");
                    $stmt->execute([$nombre_usuario]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($user['es_maestro']) {
                        echo '<td><a href="borrarUsuario.php?id=' . $row['id'] . '"><button>Borrar</button></a></td>';
                    } else {
                        echo '<td></td>';
                    }
                }
                foreach ($row as $key => $value) {
                    if ($key == 'es_maestro' || $key == 'es_administrador') {
                        echo "<td>" . ($value ? 'Sí' : 'No') . "</td>";
                    } elseif ($key != 'contraseña' && $key != 'pregunta_secreta' && $key != 'respuesta_secreta') {
                        echo "<td>" . $value . "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron usuarios.";
        }
        ?>
    </div>
</body>
</html>
