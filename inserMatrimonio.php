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
        
        if (empty($_POST['primer_nombre_esposo']) || empty($_POST['primer_apellido_esposo']) ||
        empty($_POST['primer_nombre_papa_esposo']) || empty($_POST['primer_apellido_papa_esposo']) ||
        empty($_POST['primer_nombre_mama_esposo']) || empty($_POST['primer_apellido_mama_esposo']) ||
        empty($_POST['lugar_de_nacimiento_esposo']) || empty($_POST['estado_de_nacimiento_esposo']) ||
        empty($_POST['pais_de_nacimiento_esposo']) || empty($_POST['dia_de_nacimiento_esposo']) ||
        empty($_POST['mes_de_nacimiento_esposo']) || empty($_POST['ano_de_nacimiento_esposo']) ||
        empty($_POST['dia_de_bautizo_esposo']) || empty($_POST['mes_de_bautizo_esposo']) ||
        empty($_POST['ano_de_bautizo_esposo']) || empty($_POST['iglesia_de_bautizo_esposo']) || 
        empty($_POST['lugar_de_bautizo_esposo']) || empty($_POST['estado_de_bautizo_esposo']) ||
        empty($_POST['pais_de_bautizo_esposo']) || empty($_POST['dia_de_matrimonio']) || 
        empty($_POST['mes_de_matrimonio']) || empty($_POST['ano_de_matrimonio']) ||
        empty($_POST['primer_nombre_esposa']) || empty($_POST['primer_apellido_esposa']) ||
        empty($_POST['primer_nombre_papa_esposa']) || empty($_POST['primer_apellido_papa_esposa']) ||
        empty($_POST['primer_nombre_mama_esposa']) || empty($_POST['primer_apellido_mama_esposa']) ||
        empty($_POST['lugar_de_nacimiento_esposa']) || empty($_POST['estado_de_nacimiento_esposa']) ||
        empty($_POST['pais_de_nacimiento_esposa']) || empty($_POST['dia_de_nacimiento_esposa']) ||
        empty($_POST['mes_de_nacimiento_esposa']) || empty($_POST['ano_de_nacimiento_esposa']) || 
        empty($_POST['dia_de_bautizo_esposa']) || empty($_POST['mes_de_bautizo_esposa']) || 
        empty($_POST['ano_de_bautizo_esposa']) || empty($_POST['iglesia_de_bautizo_esposa']) || 
        empty($_POST['lugar_de_bautizo_esposa']) || empty($_POST['estado_de_bautizo_esposa']) ||
        empty($_POST['pais_de_bautizo_esposa']) || empty($_POST['primer_nombre_padrino_esposo']) || 
        empty($_POST['primer_apellido_padrino_esposo']) || empty($_POST['primer_nombre_madrina_esposo']) || 
        empty($_POST['primer_apellido_madrina_esposo']) || empty($_POST['primer_nombre_padrino_esposa']) || 
        empty($_POST['primer_apellido_padrino_esposa']) || empty($_POST['primer_nombre_madrina_esposa']) || 
        empty($_POST['primer_apellido_madrina_esposa']) || empty($_POST['primer_nombre_ministro']) || 
        empty($_POST['primer_apellido_ministro']) || empty($_POST['numLibro_matrimonio']) || 
        empty($_POST['folio_matrimonio']) || empty($_POST['numeral_matrimonio']) ||
        empty($_POST['notaMar_matrimonio']) || empty($_POST['finalidad'])) {          
            echo 'Por favor, completa todos los campos obligatorios. De nada!.';
        } else if ((empty($_POST['primer_nombre_padrino_esposo']) && empty($_POST['primer_apellido_padrino_esposo'])) && (empty($_POST['primer_nombre_madrina_esposo']) && empty($_POST['primer_apellido_madrina_esposo']))) {
            echo 'Por favor, completa los campos requeridos de los padrinos del esposo.';
        } else if ((empty($_POST['primer_nombre_padrino_esposa']) && empty($_POST['primer_apellido_padrino_esposa'])) && (empty($_POST['primer_nombre_madrina_esposa']) && empty($_POST['primer_apellido_madrina_esposa']))) {
            echo 'Por favor, completa los campos requeridos de los padrinos de la esposa.';
        } else if ((empty($_POST['primer_nombre_papa_esposo']) && empty($_POST['primer_apellido_papa_esposo'])) && (empty($_POST['primer_nombre_mama_esposo']) && empty($_POST['primer_apellido_mama_esposo']))) {
            echo 'Por favor, completa los campos requeridos de los padres del esposo.';
        } else if ((empty($_POST['primer_nombre_papa_esposa']) && empty($_POST['primer_apellido_papa_esposa'])) && (empty($_POST['primer_nombre_mama_esposa']) && empty($_POST['primer_apellido_mama_esposa']))) {
          echo 'Por favor, completa los campos requeridos de los padres de la esposa.';
        } else {
            $stmt = $db->prepare('INSERT INTO "matrimonios" (
                "primer_nombre_esposo",
                "segundo_nombre_esposo", 
                "primer_apellido_esposo",
                "segundo_apellido_esposo", 
                "primer_nombre_papa_esposo", 
                "segundo_nombre_papa_esposo",
                "primer_apellido_papa_esposo",
                "segundo_apellido_papa_esposo", 
                "primer_nombre_mama_esposo",
                "segundo_nombre_mama_esposo", 
                "primer_apellido_mama_esposo", 
                "segundo_apellido_mama_esposo",
                "lugar_de_nacimiento_esposo", 
                "estado_de_nacimiento_esposo", 
                "pais_de_nacimiento_esposo",
                "dia_de_nacimiento_esposo", 
                "mes_de_nacimiento_esposo", 
                "ano_de_nacimiento_esposo",
                "dia_de_bautizo_esposo", 
                "mes_de_bautizo_esposo",
                "ano_de_bautizo_esposo",
                "iglesia_de_bautizo_esposo", 
                "lugar_de_bautizo_esposo", 
                "estado_de_bautizo_esposo", 
                "pais_de_bautizo_esposo", 
                "dia_de_matrimonio",
                "mes_de_matrimonio", 
                "ano_de_matrimonio", 
                "primer_nombre_esposa", 
                "segundo_nombre_esposa",
                "primer_apellido_esposa", 
                "segundo_apellido_esposa", 
                "primer_nombre_papa_esposa",
                "segundo_nombre_papa_esposa", 
                "primer_apellido_papa_esposa", 
                "segundo_apellido_papa_esposa",
                "primer_nombre_mama_esposa", 
                "segundo_nombre_mama_esposa", 
                "primer_apellido_mama_esposa",
                "segundo_apellido_mama_esposa", 
                "lugar_de_nacimiento_esposa", 
                "estado_de_nacimiento_esposa", 
                "pais_de_nacimiento_esposa", 
                "dia_de_nacimiento_esposa", 
                "mes_de_nacimiento_esposa",
                "ano_de_nacimiento_esposa", 
                "dia_de_bautizo_esposa", 
                "mes_de_bautizo_esposa", 
                "ano_de_bautizo_esposa",
                "iglesia_de_bautizo_esposa", 
                "lugar_de_bautizo_esposa", 
                "estado_de_bautizo_esposa", 
                "pais_de_bautizo_esposa",
                "primer_nombre_padrino_esposo", 
                "segundo_nombre_padrino_esposo", 
                "primer_apellido_padrino_esposo", 
                "segundo_apellido_padrino_esposo", 
                "primer_nombre_madrina_esposo", 
                "segundo_nombre_madrina_esposo",
                "primer_apellido_madrina_esposo", 
                "segundo_apellido_madrina_esposo", 
                "primer_nombre_padrino_esposa",
                "segundo_nombre_padrino_esposa", 
                "primer_apellido_padrino_esposa", 
                "segundo_apellido_padrino_esposa",
                "primer_nombre_madrina_esposa", 
                "segundo_nombre_madrina_esposa", 
                "primer_apellido_madrina_esposa",
                "segundo_apellido_madrina_esposa", 
                "primer_nombre_ministro", 
                "segundo_nombre_ministro",
                "primer_apellido_ministro", 
                "segundo_apellido_ministro", 
                "numLibro_matrimonio", 
                "folio_matrimonio",
                "numeral_matrimonio", 
                "notaMar_matrimonio", 
                "finalidad"                 
            ) VALUES (
                :primer_nombre_esposo,
                :segundo_nombre_esposo, 
                :primer_apellido_esposo,
                :segundo_apellido_esposo, 
                :primer_nombre_papa_esposo, 
                :segundo_nombre_papa_esposo,
                :primer_apellido_papa_esposo,
                :segundo_apellido_papa_esposo, 
                :primer_nombre_mama_esposo,
                :segundo_nombre_mama_esposo, 
                :primer_apellido_mama_esposo, 
                :segundo_apellido_mama_esposo,
                :lugar_de_nacimiento_esposo, 
                :estado_de_nacimiento_esposo, 
                :pais_de_nacimiento_esposo,
                :dia_de_nacimiento_esposo, 
                :mes_de_nacimiento_esposo, 
                :ano_de_nacimiento_esposo,
                :dia_de_bautizo_esposo, 
                :mes_de_bautizo_esposo,
                :ano_de_bautizo_esposo,
                :iglesia_de_bautizo_esposo, 
                :lugar_de_bautizo_esposo, 
                :estado_de_bautizo_esposo, 
                :pais_de_bautizo_esposo, 
                :dia_de_matrimonio,
                :mes_de_matrimonio, 
                :ano_de_matrimonio, 
                :primer_nombre_esposa, 
                :segundo_nombre_esposa,
                :primer_apellido_esposa, 
                :segundo_apellido_esposa, 
                :primer_nombre_papa_esposa,
                :segundo_nombre_papa_esposa, 
                :primer_apellido_papa_esposa, 
                :segundo_apellido_papa_esposa,
                :primer_nombre_mama_esposa, 
                :segundo_nombre_mama_esposa, 
                :primer_apellido_mama_esposa,
                :segundo_apellido_mama_esposa, 
                :lugar_de_nacimiento_esposa, 
                :estado_de_nacimiento_esposa, 
                :pais_de_nacimiento_esposa, 
                :dia_de_nacimiento_esposa, 
                :mes_de_nacimiento_esposa,
                :ano_de_nacimiento_esposa, 
                :dia_de_bautizo_esposa, 
                :mes_de_bautizo_esposa, 
                :ano_de_bautizo_esposa,
                :iglesia_de_bautizo_esposa, 
                :lugar_de_bautizo_esposa, 
                :estado_de_bautizo_esposa, 
                :pais_de_bautizo_esposa,
                :primer_nombre_padrino_esposo, 
                :segundo_nombre_padrino_esposo, 
                :primer_apellido_padrino_esposo, 
                :segundo_apellido_padrino_esposo, 
                :primer_nombre_madrina_esposo, 
                :segundo_nombre_madrina_esposo,
                :primer_apellido_madrina_esposo, 
                :segundo_apellido_madrina_esposo, 
                :primer_nombre_padrino_esposa,
                :segundo_nombre_padrino_esposa, 
                :primer_apellido_padrino_esposa, 
                :segundo_apellido_padrino_esposa,
                :primer_nombre_madrina_esposa, 
                :segundo_nombre_madrina_esposa, 
                :primer_apellido_madrina_esposa,
                :segundo_apellido_madrina_esposa, 
                :primer_nombre_ministro, 
                :segundo_nombre_ministro,
                :primer_apellido_ministro, 
                :segundo_apellido_ministro, 
                :numLibro_matrimonio, 
                :folio_matrimonio,
                :numeral_matrimonio, 
                :notaMar_matrimonio, 
                :finalidad
            )');

            $stmt->bindValue(':primer_nombre_esposo', $_POST['primer_nombre_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_esposo', $_POST['segundo_nombre_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_esposo', $_POST['primer_apellido_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_esposo', $_POST['segundo_apellido_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_papa_esposo', $_POST['primer_nombre_papa_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_papa_esposo', $_POST['segundo_nombre_papa_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_papa_esposo', $_POST['primer_apellido_papa_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_papa_esposo', $_POST['segundo_apellido_papa_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_mama_esposo', $_POST['primer_nombre_mama_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_mama_esposo', $_POST['segundo_nombre_mama_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_mama_esposo', $_POST['primer_apellido_mama_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_mama_esposo', $_POST['segundo_apellido_mama_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':lugar_de_nacimiento_esposo', $_POST['lugar_de_nacimiento_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':estado_de_nacimiento_esposo', $_POST['estado_de_nacimiento_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':pais_de_nacimiento_esposo', $_POST['pais_de_nacimiento_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':dia_de_nacimiento_esposo', $_POST['dia_de_nacimiento_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_nacimiento_esposo', $_POST['mes_de_nacimiento_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_nacimiento_esposo', $_POST['ano_de_nacimiento_esposo'], PDO::PARAM_INT);
            $stmt->bindValue(':dia_de_bautizo_esposo', $_POST['dia_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_bautizo_esposo', $_POST['mes_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_bautizo_esposo', $_POST['ano_de_bautizo_esposo'], PDO::PARAM_INT);
            $stmt->bindValue(':iglesia_de_bautizo_esposo', $_POST['iglesia_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':lugar_de_bautizo_esposo', $_POST['lugar_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':estado_de_bautizo_esposo', $_POST['estado_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':pais_de_bautizo_esposo', $_POST['pais_de_bautizo_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':dia_de_matrimonio', $_POST['dia_de_matrimonio'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_matrimonio', $_POST['mes_de_matrimonio'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_matrimonio', $_POST['ano_de_matrimonio'], PDO::PARAM_INT);
            $stmt->bindValue(':primer_nombre_esposa', $_POST['primer_nombre_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_esposa', $_POST['segundo_nombre_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_esposa', $_POST['primer_apellido_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_esposa', $_POST['segundo_apellido_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_papa_esposa', $_POST['primer_nombre_papa_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_papa_esposa', $_POST['segundo_nombre_papa_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_papa_esposa', $_POST['primer_apellido_papa_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_papa_esposa', $_POST['segundo_apellido_papa_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_mama_esposa', $_POST['primer_nombre_mama_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_mama_esposa', $_POST['segundo_nombre_mama_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_mama_esposa', $_POST['primer_apellido_mama_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_mama_esposa', $_POST['segundo_apellido_mama_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':lugar_de_nacimiento_esposa', $_POST['lugar_de_nacimiento_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':estado_de_nacimiento_esposa', $_POST['estado_de_nacimiento_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':pais_de_nacimiento_esposa', $_POST['pais_de_nacimiento_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':dia_de_nacimiento_esposa', $_POST['dia_de_nacimiento_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_nacimiento_esposa', $_POST['mes_de_nacimiento_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_nacimiento_esposa', $_POST['ano_de_nacimiento_esposa'], PDO::PARAM_INT);
            $stmt->bindValue(':dia_de_bautizo_esposa', $_POST['dia_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_bautizo_esposa', $_POST['mes_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_bautizo_esposa', $_POST['ano_de_bautizo_esposa'], PDO::PARAM_INT);
            $stmt->bindValue(':iglesia_de_bautizo_esposa', $_POST['iglesia_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':lugar_de_bautizo_esposa', $_POST['lugar_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':estado_de_bautizo_esposa', $_POST['estado_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':pais_de_bautizo_esposa', $_POST['pais_de_bautizo_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_padrino_esposo', $_POST['primer_nombre_padrino_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_padrino_esposo', $_POST['segundo_nombre_padrino_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_padrino_esposo', $_POST['primer_apellido_padrino_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_padrino_esposo', $_POST['segundo_apellido_padrino_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_madrina_esposo', $_POST['primer_nombre_madrina_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_madrina_esposo', $_POST['segundo_nombre_madrina_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_madrina_esposo', $_POST['primer_apellido_madrina_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_madrina_esposo', $_POST['segundo_apellido_madrina_esposo'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_padrino_esposa', $_POST['primer_nombre_padrino_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_padrino_esposa', $_POST['segundo_nombre_padrino_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_padrino_esposa', $_POST['primer_apellido_padrino_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_padrino_esposa', $_POST['segundo_apellido_padrino_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_madrina_esposa', $_POST['primer_nombre_madrina_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_madrina_esposa', $_POST['segundo_nombre_madrina_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_madrina_esposa', $_POST['primer_apellido_madrina_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_madrina_esposa', $_POST['segundo_apellido_madrina_esposa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_ministro', $_POST['primer_nombre_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_ministro', $_POST['segundo_nombre_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_ministro', $_POST['primer_apellido_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_ministro', $_POST['segundo_apellido_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':numLibro_matrimonio', $_POST['numLibro_matrimonio'], PDO::PARAM_INT);
            $stmt->bindValue(':folio_matrimonio', $_POST['folio_matrimonio'], PDO::PARAM_INT);
            $stmt->bindValue(':numeral_matrimonio', $_POST['numeral_matrimonio'], PDO::PARAM_INT);
            $stmt->bindValue(':notaMar_matrimonio', $_POST['notaMar_matrimonio'], PDO::PARAM_STR);
            $stmt->bindValue(':finalidad', $_POST['finalidad'], PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo 'Matrimonio agregado exitosamente!';
            } else {
                echo 'Hubo un error al agregar el matrimonio.';
            }
        }
    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>Agregar Matrimonio</title>
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
        <h1>Agregar Matrimonio</h1>
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
            <button id="cerrarSesion" onclick="window.location.href='indexMatrimonio.php'">Volver</button>
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
        </div>
    <div class="container">
    <form class="formulario-estilizado" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_esposo" class="obligatorio">Primer Nombre del esposo:</label>
                <input type="text" id="primer_nombre_esposo" name="primer_nombre_esposo" required>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_esposo">Segundo Nombre del esposo:</label>
                <input type="text" id="segundo_nombre_esposo" name="segundo_nombre_esposo">
            </div>
            <div class="input-group">
                <label for="primer_apellido_esposo" class="obligatorio">Primer Apellido del esposo:</label>
                <input type="text" id="primer_apellido_esposo" name="primer_apellido_esposo" required>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_esposo">Segundo Apellido del esposo:</label>
                <input type="text" id="segundo_apellido_esposo" name="segundo_apellido_esposo">
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_de_nacimiento_esposo" class="obligatorio">Ciudad de Nacimiento del esposo:</label><br>
                <input type="text" id="lugar_de_nacimiento_esposo" name="lugar_de_nacimiento_esposo" required><br>
            </div>
            <div class="input-group">
                <label for="estado_de_nacimiento_esposo"class="obligatorio">Estado de Nacimiento del esposo:</label><br>
                <input type="text" id="estado_de_nacimiento_esposo" name="estado_de_nacimiento_esposo" required><br>
            </div>
            <div class="input-group">
                <label for="pais_de_nacimiento_esposo"class="obligatorio">Pais de Nacimiento del esposo:</label><br>
                <input type="text" id="pais_de_nacimiento_esposo" name="pais_de_nacimiento_esposo" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_nacimiento_esposo" class="obligatorio">Día de Nacimiento del esposo:</label><br>
                <input type="text" id="dia_de_nacimiento_esposo" name="dia_de_nacimiento_esposo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_nacimiento_esposo" class="obligatorio">Mes de Nacimiento del esposo:</label><br>
                <input type="text" id="mes_de_nacimiento_esposo" name="mes_de_nacimiento_esposo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_nacimiento_esposo" class="obligatorio">Año de Nacimiento del esposo:</label><br>
                <input type="text" id="ano_de_nacimiento_esposo" name="ano_de_nacimiento_esposo" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_bautizo_esposo" class="obligatorio">Día de Bautizo del esposo:</label><br>
                <input type="text" id="dia_de_bautizo_esposo" name="dia_de_bautizo_esposo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_bautizo_esposo" class="obligatorio">Mes de Bautizo del esposo:</label><br>
                <input type="text" id="mes_de_bautizo_esposo" name="mes_de_bautizo_esposo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_bautizo_esposo" class="obligatorio">Año de Bautizo del esposo:</label><br>
                <input type="text" id="ano_de_bautizo_esposo" name="ano_de_bautizo_esposo" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="iglesia_de_bautizo_esposo" class="obligatorio">Iglesia de Bautizo del esposo:</label><br>
                <input type="text" id="iglesia_de_bautizo_esposo" name="iglesia_de_bautizo_esposo" required><br>
            </div>
            <div class="input-group">
                <label for="lugar_de_bautizo_esposo" class="obligatorio">Ciudad de Bautizo del esposo:</label><br>
                <input type="text" id="lugar_de_bautizo_esposo" name="lugar_de_bautizo_esposo" required><br>
            </div>
            <div class="input-group">
                <label for="estado_de_bautizo_esposo" class="obligatorio">Estado de Bautizo del esposo:</label><br>
                <input type="text" id="estado_de_bautizo_esposo" name="estado_de_bautizo_esposo" required><br>
            </div>
            <div class="input-group">
                <label for="pais_de_bautizo_esposo" class="obligatorio">Pais de Bautizo del esposo:</label><br>
                <input type="text" id="pais_de_bautizo_esposo" name="pais_de_bautizo_esposo" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_papa_esposo">Primer Nombre Papá del esposo:</label>
                <input type="text" id="primer_nombre_papa_esposo" name="primer_nombre_papa_esposo">
            </div>
            <div class="input-group">
                <label for="segundo_nombre_papa_esposo">Segundo Nombre Papá del esposo:</label>
                <input type="text" id="segundo_nombre_papa_esposo" name="segundo_nombre_papa_esposo">
            </div>
            <div class="input-group">
                <label for="primer_apellido_papa_esposo" class="etiqueta-larga">Primer Apellido Papá del esposo:</label>
                <input type="text" id="primer_apellido_papa_esposo" name="primer_apellido_papa_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_papa_esposo" class="etiqueta-larga">Segundo Apellido Papá del esposo:</label>
                <input type="text" id="segundo_apellido_papa_esposo" name="segundo_apellido_papa_esposo"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_mama_esposo">Primer Nombre Mamá del esposo:</label><br>
                <input type="text" id="primer_nombre_mama_esposo" name="primer_nombre_mama_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_mama_esposo">Segundo Nombre Mamá del esposo:</label><br>
                <input type="text" id="segundo_nombre_mama_esposo" name="segundo_nombre_mama_esposo"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_mama_esposo">Primer Apellido Mamá del esposo:</label><br>
                <input type="text" id="primer_apellido_mama_esposo" name="primer_apellido_mama_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_mama_esposo">Segundo Apellido Mama del esposo:</label><br>
                <input type="text" id="segundo_apellido_mama_esposo" name="segundo_apellido_mama_esposo"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_padrino_esposo">Primer Nombre del Padrino del esposo:</label><br>
                <input type="text" id="primer_nombre_padrino_esposo" name="primer_nombre_padrino_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_padrino_esposo">Segundo Nombre del Padrino del esposo:</label><br>
                <input type="text" id="segundo_nombre_padrino_esposo" name="segundo_nombre_padrino_esposo"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_padrino_esposo">Primer Apellido del Padrino del esposo:</label><br>
                <input type="text" id="primer_apellido_padrino_esposo" name="primer_apellido_padrino_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_padrino_esposo">Segundo Apellido del Padrino del esposo:</label><br>
                <input type="text" id="segundo_apellido_padrino_esposo" name="segundo_apellido_padrino_esposo"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_madrina_esposo">Primer Nombre de la Madrina del esposo:</label><br>
                <input type="text" id="primer_nombre_madrina_esposo" name="primer_nombre_madrina_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_madrina_esposo">Segundo Nombre de la Madrina del esposo:</label><br>
                <input type="text" id="segundo_nombre_madrina_esposo" name="segundo_nombre_madrina_esposo"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_madrina_esposo">Primer Apellido de la Madrina del esposo:</label><br>
                <input type="text" id="primer_apellido_madrina_esposo" name="primer_apellido_madrina_esposo"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_madrina_esposo">Segundo Apellido de la Madrina del esposo:</label><br>
                <input type="text" id="segundo_apellido_madrina_esposo" name="segundo_apellido_madrina_esposo"><br>
            </div>
        </div> 

        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_esposa" class="obligatorio">Primer Nombre de la esposa:</label>
                <input type="text" id="primer_nombre_esposa" name="primer_nombre_esposa" required>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_esposa">Segundo Nombre de la esposa:</label>
                <input type="text" id="segundo_nombre_esposa" name="segundo_nombre_esposa">
            </div>
            <div class="input-group">
                <label for="primer_apellido_esposa" class="obligatorio">Primer Apellido de la esposa:</label>
                <input type="text" id="primer_apellido_esposa" name="primer_apellido_esposa" required>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_esposa">Segundo Apellido de la esposa:</label>
                <input type="text" id="segundo_apellido_esposa" name="segundo_apellido_esposa">
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_de_nacimiento_esposa" class="obligatorio">Ciudad de Nacimiento de la esposa:</label><br>
                <input type="text" id="lugar_de_nacimiento_esposa" name="lugar_de_nacimiento_esposa" required><br>
            </div>
            <div class="input-group">
                <label for="estado_de_nacimiento_esposa"class="obligatorio">Estado de Nacimiento de la esposa:</label><br>
                <input type="text" id="estado_de_nacimiento_esposa" name="estado_de_nacimiento_esposa" required><br>
            </div>
            <div class="input-group">
                <label for="pais_de_nacimiento_esposa"class="obligatorio">Pais de Nacimiento de la esposa:</label><br>
                <input type="text" id="pais_de_nacimiento_esposa" name="pais_de_nacimiento_esposa" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_nacimiento_esposa" class="obligatorio">Día de Nacimiento de la esposa:</label><br>
                <input type="text" id="dia_de_nacimiento_esposa" name="dia_de_nacimiento_esposa" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_nacimiento_esposa" class="obligatorio">Mes de Nacimiento de la esposa:</label><br>
                <input type="text" id="mes_de_nacimiento_esposa" name="mes_de_nacimiento_esposa" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_nacimiento_esposa" class="obligatorio">Año de Nacimiento de la esposa:</label><br>
                <input type="text" id="ano_de_nacimiento_esposa" name="ano_de_nacimiento_esposa" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_bautizo_esposa" class="obligatorio">Día de Bautizo de la esposa:</label><br>
                <input type="text" id="dia_de_bautizo_esposa" name="dia_de_bautizo_esposa" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_bautizo_esposa" class="obligatorio">Mes de Bautizo de la esposa:</label><br>
                <input type="text" id="mes_de_bautizo_esposa" name="mes_de_bautizo_esposa" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_bautizo_esposa" class="obligatorio">Año de Bautizo de la esposa:</label><br>
                <input type="text" id="ano_de_bautizo_esposa" name="ano_de_bautizo_esposa" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="iglesia_de_bautizo_esposa" class="obligatorio">Iglesia de Bautizo de la esposa:</label><br>
                <input type="text" id="iglesia_de_bautizo_esposa" name="iglesia_de_bautizo_esposa" required><br>
            </div>
            <div class="input-group">
                <label for="lugar_de_bautizo_esposa" class="obligatorio">Ciudad de Bautizo de la esposa:</label><br>
                <input type="text" id="lugar_de_bautizo_esposa" name="lugar_de_bautizo_esposa" required><br>
            </div>
            <div class="input-group">
                <label for="estado_de_bautizo_esposa" class="obligatorio">Estado de Bautizo de la esposa:</label><br>
                <input type="text" id="estado_de_bautizo_esposa" name="estado_de_bautizo_esposa" required><br>
            </div>
            <div class="input-group">
                <label for="pais_de_bautizo_esposa" class="obligatorio">Pais de Bautizo de la esposa:</label><br>
                <input type="text" id="pais_de_bautizo_esposa" name="pais_de_bautizo_esposa" required><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_papa_esposa">Primer Nombre Papá de la esposa:</label>
                <input type="text" id="primer_nombre_papa_esposa" name="primer_nombre_papa_esposa">
            </div>
            <div class="input-group">
                <label for="segundo_nombre_papa_esposa">Segundo Nombre Papá de la esposa:</label>
                <input type="text" id="segundo_nombre_papa_esposa" name="segundo_nombre_papa_esposa">
            </div>
            <div class="input-group">
                <label for="primer_apellido_papa_esposa" class="etiqueta-larga">Primer Apellido Papá de la esposa:</label>
                <input type="text" id="primer_apellido_papa_esposa" name="primer_apellido_papa_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_papa_esposa" class="etiqueta-larga">Segundo Apellido Papá de la esposa:</label>
                <input type="text" id="segundo_apellido_papa_esposa" name="segundo_apellido_papa_esposa"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_mama_esposa">Primer Nombre Mamá de la esposa:</label><br>
                <input type="text" id="primer_nombre_mama_esposa" name="primer_nombre_mama_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_mama_esposa">Segundo Nombre Mamá de la esposa:</label><br>
                <input type="text" id="segundo_nombre_mama_esposa" name="segundo_nombre_mama_esposa"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_mama_esposa">Primer Apellido Mamá de la esposa:</label><br>
                <input type="text" id="primer_apellido_mama_esposa" name="primer_apellido_mama_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_mama_esposa">Segundo Apellido Mama de la esposo:</label><br>
                <input type="text" id="segundo_apellido_mama_esposa" name="segundo_apellido_mama_esposa"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_padrino_esposa">Primer Nombre del Padrino de la esposa:</label><br>
                <input type="text" id="primer_nombre_padrino_esposa" name="primer_nombre_padrino_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_padrino_esposa">Segundo Nombre del Padrino de la esposa:</label><br>
                <input type="text" id="segundo_nombre_padrino_esposa" name="segundo_nombre_padrino_esposa"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_padrino_esposa">Primer Apellido del Padrino de la esposa:</label><br>
                <input type="text" id="primer_apellido_padrino_esposa" name="primer_apellido_padrino_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_padrino_esposa">Segundo Apellido del Padrino de la esposa:</label><br>
                <input type="text" id="segundo_apellido_padrino_esposa" name="segundo_apellido_padrino_esposa"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_madrina_esposa">Primer Nombre de la Madrina de la esposa:</label><br>
                <input type="text" id="primer_nombre_madrina_esposa" name="primer_nombre_madrina_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_madrina_esposa">Segundo Nombre de la Madrina de la esposa:</label><br>
                <input type="text" id="segundo_nombre_madrina_esposa" name="segundo_nombre_madrina_esposa"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_madrina_esposa">Primer Apellido de la Madrina de la esposa:</label><br>
                <input type="text" id="primer_apellido_madrina_esposa" name="primer_apellido_madrina_esposa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_madrina_esposa">Segundo Apellido de la Madrina de la esposa:</label><br>
                <input type="text" id="segundo_apellido_madrina_esposa" name="segundo_apellido_madrina_esposa"><br>
            </div>
        </div> 
        
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_matrimonio" class="obligatorio">Día del Matrimonio:</label><br>
                <input type="text" id="dia_de_matrimonio" name="dia_de_matrimonio" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_matrimonio" class="obligatorio">Mes del Matrimonio:</label><br>
                <input type="text" id="mes_de_matrimonio" name="mes_de_matrimonio" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_matrimonio" class="obligatorio">Año del Matrimonio:</label><br>
                <input type="text" id="ano_de_matrimonio" name="ano_de_matrimonio" required pattern="\d{4}"><br>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_ministro" class="obligatorio">Primer Nombre del Ministro del matrimonio:</label><br>
                <input type="text" id="primer_nombre_ministro" name="primer_nombre_ministro" required><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_ministro">Segundo Nombre del Ministro del matrimonio:</label><br>
                <input type="text" id="segundo_nombre_ministro" name="segundo_nombre_ministro"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_ministro" class="obligatorio">Primer Apellido del Ministro del matrimonio:</label><br>
                <input type="text" id="primer_apellido_ministro" name="primer_apellido_ministro" required><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_ministro">Segundo Apellido del Ministro del matrimonio:</label><br>
                <input type="text" id="segundo_apellido_ministro" name="segundo_apellido_ministro"><br>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label for="numLibro_matrimonio" class="obligatorio">Número de Libro del Acta de Matromonio:</label><br>
                <input type="text" id="numLibro_matrimonio" name="numLibro_matrimonio" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="folio_matrimonio" class="obligatorio">Folio del Acta de Matrimonio:</label><br>
                <input type="text" id="folio_matrimonio" name="folio_matrimonio" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="numeral_matrimonio" class="obligatorio">Numeral del Acta de Matrimonio:</label><br>
                <input type="text" id="numeral_matrimonio" name="numeral_matrimonio" required pattern="\d+"><br>
            </div>
        </div>
        <div class="input-row">            
            <div class="input-group">
                <label for="notaMar_matrimonio">Nota Marginal del Acta de Matrimonio:</label><br>
                <input type="text" id="notaMar_matrimonio" name="notaMar_matrimonio"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="finalidad">Finalidad del Acta de Matrimonio:</label><br>
                <input type="text" id="finalidad" name="finalidad"><br>
            </div>
        </div>
    
    
       <input type="submit" value="Agregar Matrimonio">
        </form>
        <button id="botonRegreso" onclick="location.href='indexMatrimonio.php'">Volver</button>
    </div>
</body>
</html>