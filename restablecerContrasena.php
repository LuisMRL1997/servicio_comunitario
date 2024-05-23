<?php
ob_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion2.php");

    // Verificar que los campos obligatorios no estén vacíos
    $camposObligatorios = ['nombre_usuario', 'prefijo_identidad', 'numero_identidad', 'numero_telefono', 'correo_electronico', 'contraseña', 'confirmar_contraseña', 'pregunta_secreta', 'respuesta_secreta'];
    foreach ($camposObligatorios as $campo) {
        if (empty($_POST[$campo])) {
            echo "<script>
            document.getElementById('error-message').textContent = 'Error: El campo $campo es obligatorio.';
            </script>";
            exit;
        }
    }

    // Verificar que las contraseñas coincidan
    if ($_POST['contraseña'] != $_POST['confirmar_contraseña']) {
        echo "<script>
        document.getElementById('error-message').textContent = 'Error: Las contraseñas no coinciden.';
        </script>";
        exit;
    }

    // Verificar que el usuario exista
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario");
    $stmt->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar que los datos proporcionados coincidan
        $documenti_identidad = $_POST['prefijo_identidad'] . $_POST['numero_identidad'];
        if ($documenti_identidad == $user['documenti_identidad'] && $_POST['numero_telefono'] == $user['numero_telefono'] && $_POST['correo_electronico'] == $user['correo_electronico'] && password_verify($_POST['pregunta_secreta'], $user['pregunta_secreta']) && password_verify($_POST['respuesta_secreta'], $user['respuesta_secreta'])) {
            // Si todo está bien, actualizar la contraseña del usuario
            $sql = "UPDATE usuarios SET contraseña = :contraseña WHERE nombre_usuario = :nombre_usuario";

            $stmt = $db->prepare($sql);

            $contraseña_hash = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

            $stmt->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
            $stmt->bindParam(':contraseña', $contraseña_hash);

            $stmt->execute();

            // Redirige al usuario a indexRegistros.php después de un restablecimiento de contraseña exitoso
            header('Location: indexRegistros.php'); // Redirige al usuario
            ob_end_flush();
            exit;
        } else {
            echo "<script>
            document.getElementById('error-message').textContent = 'Error: Los datos proporcionados no coinciden con nuestros registros.';
            </script>";
            exit;
        }
    } else {
        echo "<script>
        document.getElementById('error-message').textContent = 'Error: El usuario no existe.';
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restablecer Contraseña</title>
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
            $stmt = $db->prepare("SELECT es_maestro, es_administrador FROM usuarios WHERE nombre_usuario = ?");
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
            <div id="error-message"></div>
            <form class="formulario-registro" method="POST">
                <!-- Aquí va tu código para el formulario -->
                <div class="input-row">
                    <div class="input-group">
                        <label for="nombre_usuario" class="obligatorio">Nombre de Usuario:</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Documento de Identidad:</label>
                        <div class="input-group-identidad">
                            <select name="prefijo_identidad" required>
                                <option value="">...</option>
                                <option value="V-">V-</option>
                                <option value="E-">E-</option>
                            </select>
                            <input type="text" name="numero_identidad" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Número de Teléfono:</label>
                        <input type="text" name="numero_telefono" required>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Correo Electrónico:</label>
                        <input type="email" name="correo_electronico" required>
                    </div>
                </div>
                <div class="input-row">
                    <div class="input-group">
                        <label class="obligatorio">Nueva Contraseña:</label>
                        <input type="password" name="contraseña" required>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Confirmar Nueva Contraseña:</label>
                        <input type="password" name="confirmar_contraseña" required>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Pregunta Secreta:</label>
                        <select name="pregunta_secreta" required>
                            <option value="">Selecciona...</option>
                            <option value="lugar_nacimiento_papa">¿Cuál es el lugar de nacimiento de tu papá?</option>
                            <option value="nombre_primera_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                            <option value="apellido_soltera_mama">¿Cuál es el apellido de soltera de tu mamá?</option>
                            <option value="nombre_mejor_amigo">¿Cuál es el nombre de tu mejor amigo de la infancia?</option>
                            <option value="nombre_colegio_primaria">¿Cuál es el nombre de tu colegio de primaria?</option>
                            <option value="ciudad_favorita">¿Cuál es tu ciudad favorita para visitar?</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="obligatorio">Respuesta Secreta:</label>
                        <input type="text" name="respuesta_secreta" required>
                    </div>
                </div>
                <input  type="submit" value="Restablecer Contraseña">
            </form>
            <button id="botonRegreso" onclick="location.href='iniciarSesion.php'">Volver</button>
        </div>
    </div>
</body>
</html>