<?php
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion2.php");
    $camposObligatorios = ['primer_nombre', 'primer_apellido', 'prefijo_identidad', 'numero_identidad', 'nombre_usuario', 'correo_electronico', 'contraseña', 'fecha_nacimiento', 'direccion', 'ciudad', 'estado', 'pais', 'numero_telefono', 'genero', 'pregunta_secreta', 'respuesta_secreta'];

    foreach ($camposObligatorios as $campo) {
        if (empty($_POST[$campo])) {
            $error = "Error: El campo $campo es obligatorio.";
            break;
        }
    }

    if (empty($error)) {
        $camposUnicos = ['correo_electronico', 'documenti_identidad', 'nombre_usuario'];
        foreach ($camposUnicos as $campo) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE $campo = :valor");
            $stmt->bindParam(':valor', $_POST[$campo]);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $error = "Error: El $campo ya está en uso.";
                break;
            }
        }
    }

    if (empty($error) && $_POST['contraseña'] != $_POST['confirmar_contraseña']) {
        $error = "Error: Las contraseñas no coinciden.";
    }

    if (empty($error)) {
        $sql = "INSERT INTO [usuarios] (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, genero, documenti_identidad, fecha_nacimiento, nombre_usuario, correo_electronico, numero_telefono, direccion, ciudad, estado, pais, codigo_postal, contraseña, pregunta_secreta, respuesta_secreta) VALUES (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :genero, :documenti_identidad, :fecha_nacimiento, :nombre_usuario, :correo_electronico, :numero_telefono, :direccion, :ciudad, :estado, :pais, :codigo_postal, :contraseña, :pregunta_secreta, :respuesta_secreta)";

        $stmt = $db->prepare($sql);

        $contraseña_hash = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
        $pregunta_secreta_hash = password_hash($_POST['pregunta_secreta'], PASSWORD_DEFAULT);
        $respuesta_secreta_hash = password_hash($_POST['respuesta_secreta'], PASSWORD_DEFAULT);

        $stmt->bindParam(':primer_nombre', $_POST['primer_nombre']);
        $stmt->bindParam(':segundo_nombre', $_POST['segundo_nombre']);
        $stmt->bindParam(':primer_apellido', $_POST['primer_apellido']);
        $stmt->bindParam(':segundo_apellido', $_POST['segundo_apellido']);
        $stmt->bindParam(':genero', $_POST['genero']);
        $documenti_identidad = $_POST['prefijo_identidad'] . $_POST['numero_identidad'];
        $stmt->bindParam(':documenti_identidad', $documenti_identidad);
        $stmt->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento']);
        $stmt->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
        $stmt->bindParam(':correo_electronico', $_POST['correo_electronico']);
        $stmt->bindParam(':numero_telefono', $_POST['numero_telefono']);
        $stmt->bindParam(':direccion', $_POST['direccion']);
        $stmt->bindParam(':ciudad', $_POST['ciudad']);
        $stmt->bindParam(':estado', $_POST['estado']);
        $stmt->bindParam(':pais', $_POST['pais']);
        $stmt->bindParam(':codigo_postal', $_POST['codigo_postal']);
        $stmt->bindParam(':contraseña', $contraseña_hash);
        $stmt->bindParam(':pregunta_secreta', $pregunta_secreta_hash);
        $stmt->bindParam(':respuesta_secreta', $respuesta_secreta_hash);

        $stmt->execute();

        // Redirige al usuario a indexRegistros.php después de un registro exitoso
        header('Location: indexRegistros.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="stylesRegistros.css">
    <style>
        .obligatorio::after {
            content: " *";
            color: red;
        }
    </style>
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
        <form method="POST">
    <h2>Formulario de Registro</h2> 
        
    <div class="input-row">
        <div class="input-group">
            <label for="primer_nombre" class="obligatorio">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" required>
        </div>
        <div class="input-group">
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre">
        </div>
        <div class="input-group">
            <label for="primer_apellido" class="obligatorio">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" required>
        </div>
        <div class="input-group">
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido">
        </div>
    </div>
    <br>
    <br>
    <div class="input-row">
        <div class="input-group">
            <label class="obligatorio">Documento de Identidad</label>: 
            <div class="input-group-identidad">
                <select name="prefijo_identidad" required>
                    <option value="">...</option>
                    <option value="V-">V-</option>
                    <option value="E-">E-</option>
                </select>
                <input type="text" name="numero_identidad" required>
            </div>
            <br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Fecha de Nacimiento</label>: 
            <input type="date" name="fecha_nacimiento" required><br>
        </div>
        <div class="input-group">
        <label class="obligatorio">Género</label>:
            <select name="genero" required>
                <option value="">Selecciona...</option>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
                <option value="Prefiero no decirlo">Prefiero no decirlo</option>
            </select><br>
        </div>
    </div>
    <div class="input-row">
        <div class="input-group">
            <label class="obligatorio">País</label>: 
            <input type="text" name="pais" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Estado</label>: 
            <input type="text" name="estado" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Ciudad</label>: 
            <input type="text" name="ciudad" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Dirección</label>: 
            <input type="text" name="direccion" required><br>
        </div>
    </div>
    <div class="input-row">
        <div class="input-group">
            <label class="obligatorio">Correo Electrónico</label>: 
            <input type="email" name="correo_electronico" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Número de Teléfono</label>: 
            <input type="text" name="numero_telefono" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Nombre de Usuario</label>: 
            <input type="text" name="nombre_usuario" required><br>
        </div>
        <div class="input-group">
            Código Postal: 
            <input type="text" name="codigo_postal"><br>
        </div>
    </div>
    <div class="input-row">
        <div class="input-group">
            <label class="obligatorio">Contraseña</label>: 
            <input type="password" name="contraseña" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Confirmar Contraseña</label>: 
            <input type="password" name="confirmar_contraseña" required><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Pregunta Secreta</label>: 
            <select name="pregunta_secreta" required>
                <option value="">Selecciona...</option>
                <option value="lugar_nacimiento_papa">¿Cuál es el lugar de nacimiento de tu papá?</option>
                <option value="nombre_primera_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="apellido_soltera_mama">¿Cuál es el apellido de soltera de tu mamá?</option>
                <option value="nombre_mejor_amigo">¿Cuál es el nombre de tu mejor amigo de la infancia?</option>
                <option value="nombre_colegio_primaria">¿Cuál es el nombre de tu colegio de primaria?</option>
                <option value="ciudad_favorita">¿Cuál es tu ciudad favorita para visitar?</option>
            </select><br>
        </div>
        <div class="input-group">
            <label class="obligatorio">Respuesta Secreta</label>: 
            <input type="text" name="respuesta_secreta" required><br>
        </div>
    </div> 
        <input type="submit" value="Registrar">
    </form>
        <button id="botonRegreso" onclick="location.href='iniciarSesion.php'">Volver</button>
    </div>
</body>
</html>

<?php if (!empty($error)): ?>
<script>
alert('<?php echo $error; ?>');
</script>
<?php endif; ?>
