<?php

    include("conexion2.php");
    session_start();

    if (isset($_SESSION['ULTIMA_ACTIVIDAD']) && (time() - $_SESSION['ULTIMA_ACTIVIDAD'] > 3600)) {
        // última actividad fue hace más de 5 minutos
        session_unset();     // vacía el array $_SESSION
        session_destroy();   // destruye la sesión
        header("Location: iniciarSesion.php"); // redirige al usuario a la página de inicio de sesión
    }
    
    $_SESSION['ULTIMA_ACTIVIDAD'] = time(); // actualiza el momento de la última actividad
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (empty($_POST['tipo']) || empty($_POST['descripcion']) || empty($_POST['dia']) || 
        empty($_POST['mes']) || empty($_POST['ano']) || empty($_POST['hora_inicio']) || empty($_POST['hora_fin'])) {
            echo 'Por favor, completa todos los campos obligatorios.';
        } else {
            $stmt = $db->prepare('INSERT INTO "eventos" (
                "tipo", 
                "descripcion", 
                "dia", 
                "mes", 
                "ano", 
                "hora_inicio", 
                "hora_fin"
            ) VALUES (
                :tipo, 
                :descripcion, 
                :dia, 
                :mes, 
                :ano, 
                :hora_inicio, 
                :hora_fin
            )');
            $stmt->bindValue(':tipo', $_POST['tipo'], PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $_POST['descripcion'], PDO::PARAM_STR);
            $stmt->bindValue(':dia', $_POST['dia'], PDO::PARAM_INT);
            $stmt->bindValue(':mes', $_POST['mes'], PDO::PARAM_INT);
            $stmt->bindValue(':ano', $_POST['ano'], PDO::PARAM_INT);
            $stmt->bindValue(':hora_inicio', $_POST['hora_inicio'], PDO::PARAM_STR);
            $stmt->bindValue(':hora_fin', $_POST['hora_fin'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo 'Evento agregado exitosamente!';
            } else {
                echo 'Hubo un error al agregar el evento.';
            }
        }
    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>Agregar Evento</title>
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
    </div>
    <div class="menu-bar">
            <button id="cerrarSesion" onclick="window.location.href='indexRegistros.php'">Inicio</button>
            <button id="cerrarSesion" onclick="window.location.href='indexEventos.php'">Volver</button>
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
    <form class="formulario-estilizado" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="input-row">
            <div class="input-group">
                <label for="tipo" class="obligatorio">Tipo:</label>
                <input type="text" id="tipo" name="tipo" required>
            </div>
            <div class="input-group">
                <label for="descripcion" class="obligatorio">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>
            </div>
            <div class="input-row">
            <div class="input-group">
                <label for="dia" class="obligatorio">Día:</label>
                <input type="number" id="dia" name="dia" required>
            </div>
            <div class="input-group">
                <label for="mes" class="obligatorio">Mes:</label>
                <input type="number" id="mes" name="mes" required>
            </div>
            <div class="input-group">
                <label for="ano" class="obligatorio">Año:</label>
                <input type="number" id="ano" name="ano" required>
            </div>
            </div>
            <div class="input-row">
            <div class="input-group">
                <label for="hora_inicio" class="obligatorio">Hora de inicio:</label>
                <input type="time" id="hora_inicio" name="hora_inicio" required>
            </div>
            <div class="input-group">
                <label for="hora_fin" class="obligatorio">Hora de fin:</label>
                <input type="time" id="hora_fin" name="hora_fin" required>
            </div>
            </div>
        </div>
        <input type="submit" value="Agregar Evento">
    </form>
    <button id="botonRegreso" onclick="location.href='indexEventos.php'">Volver</button>
    </div>
</body>
</html>
