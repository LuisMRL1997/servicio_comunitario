<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
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
        <?php
        session_start();
        if (isset($_SESSION['ULTIMA_ACTIVIDAD']) && (time() - $_SESSION['ULTIMA_ACTIVIDAD'] > 3600)) {
            session_unset();
            session_destroy();
            header("Location: iniciarSesion.php"); 
        }
        $_SESSION['ULTIMA_ACTIVIDAD'] = time(); 
        include("conexion2.php");
        if (isset($_SESSION['nombre_usuario'])) {
            $nombre_usuario = $_SESSION['nombre_usuario'];
            $stmt = $db->prepare("SELECT [es_maestro], [es_administrador] FROM [usuarios] WHERE [nombre_usuario] = ?");
            $stmt->execute([$nombre_usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $rol = $user['es_administrador'] ? 'Administrador' : ($user['es_maestro'] ? 'Maestro' : '');
            echo '<p>Actualmente estás en la cuenta (' . $_SESSION['nombre_usuario'] . ') (' . $rol . ')</p>';
        }
        ?>
    </div>
    <div class="menu-bar">
        <button id="cerrarSesion" onclick="window.location.href='indexRegistros.php'">Inicio</button>
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
    <div class="form-container">
    <?php
    $mensaje = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contraseña = $_POST['contraseña'];    
        $stmt = $db->prepare("SELECT * FROM [usuarios] WHERE [nombre_usuario] = ?");
        $stmt->execute([$nombre_usuario]);       
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($contraseña, $user['contraseña'])) {
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['ULTIMA_ACTIVIDAD'] = time();
                header('Location: indexRegistros.php');
                exit;
            } else {
                $mensaje = "Contraseña incorrecta.";
            }
        } else {
            $mensaje = "Nombre de usuario incorrecto.";
        }
    }
    if ($mensaje != '') {
        echo '<p>' . $mensaje . '</p>';
    }
    ?>
    <form class="formulario-iniciar-Sesion" method="POST">
        Nombre de Usuario: <input type="text" name="nombre_usuario" required><br>
        Contraseña: <input type="password" name="contraseña" required><br>
        <a href="restablecerContrasena.php">¿Has olvidado tu contraseña?</a><br>
        <div class="input-row">
            <input type="submit" value="Iniciar Sesión" class="btn">
            <a href="registroUsuario.php" id="botonInsertar" class="btn">Registrarse</a>
        </div>   
    </form> 
    <button id="botonInsertar" onclick="location.href='indexRegistros.php'">Volver</button>
    </div>  
    </div>  
</body>
</html>
