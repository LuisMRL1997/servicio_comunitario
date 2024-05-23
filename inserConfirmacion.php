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
        
        if (empty($_POST['primer_nombre']) || empty($_POST['primer_apellido']) || empty($_POST['lugar_de_nacimiento']) || 
        empty($_POST['estado_de_nacimiento']) || empty($_POST['pais_de_nacimiento']) || empty($_POST['dia_de_nacimiento']) || empty($_POST['mes_de_nacimiento']) ||
        empty($_POST['ano_de_nacimiento']) || empty($_POST['dia_de_bautizo']) || empty($_POST['mes_de_bautizo']) ||
        empty($_POST['ano_de_bautizo']) || empty($_POST['primer_nombre_ministro']) || empty($_POST['primer_apellido_ministro']) ||
        empty($_POST['numero_registro_civil']) || empty($_POST['ano_registro_civil'])  ||
        empty($_POST['numLibro']) || empty($_POST['folio']) || empty($_POST['numeral'])) {
            echo 'Por favor, completa todos los campos obligatorios.';
        } else if ((empty($_POST['primer_nombre_padrino']) && empty($_POST['primer_apellido_padrino'])) && (empty($_POST['primer_nombre_madrina']) && empty($_POST['primer_apellido_madrina']))) {
            echo 'Por favor, completa los campos requeridos de los padrinos.';
        } else if ((empty($_POST['primer_nombre_papa']) && empty($_POST['primer_apellido_papa'])) && (empty($_POST['primer_nombre_mama']) && empty($_POST['primer_apellido_mama']))) {
            echo 'Por favor, completa los campos requeridos de los padres.';
        } else {
            $stmt = $db->prepare('INSERT INTO "confirmaciones" (
                "primer_nombre", 
                "segundo_nombre", 
                "primer_apellido", 
                "segundo_apellido", 
                "primer_nombre_papa", 
                "segundo_nombre_papa", 
                "primer_apellido_papa", 
                "segundo_apellido_papa", 
                "primer_nombre_mama", 
                "segundo_nombre_mama", 
                "primer_apellido_mama", 
                "segundo_apellido_mama", 
                "filiacion", 
                "lugar_de_nacimiento",
                "estado_de_nacimiento", 
                "pais_de_nacimiento", 
                "dia_de_nacimiento", 
                "mes_de_nacimiento", 
                "ano_de_nacimiento", 
                "dia_de_bautizo", 
                "mes_de_bautizo", 
                "ano_de_bautizo", 
                "primer_nombre_padrino", 
                "segundo_nombre_padrino", 
                "primer_apellido_padrino", 
                "segundo_apellido_padrino", 
                "primer_nombre_madrina", 
                "segundo_nombre_madrina", 
                "primer_apellido_madrina", 
                "segundo_apellido_madrina", 
                "primer_nombre_ministro", 
                "segundo_nombre_ministro", 
                "primer_apellido_ministro", 
                "segundo_apellido_ministro", 
                "observacion", 
                "numero_registro_civil", 
                "ano_registro_civil",
                "numLibro",
                "folio",
                "numeral",
                "notaMar",
                "finalidad"
            ) VALUES (
                :primer_nombre, 
                :segundo_nombre, 
                :primer_apellido, 
                :segundo_apellido, 
                :primer_nombre_papa, 
                :segundo_nombre_papa, 
                :primer_apellido_papa, 
                :segundo_apellido_papa, 
                :primer_nombre_mama, 
                :segundo_nombre_mama, 
                :primer_apellido_mama, 
                :segundo_apellido_mama, 
                :filiacion, 
                :lugar_de_nacimiento,
                :estado_de_nacimiento,
                :pais_de_nacimiento,
                :dia_de_nacimiento, 
                :mes_de_nacimiento, 
                :ano_de_nacimiento, 
                :dia_de_bautizo, 
                :mes_de_bautizo, 
                :ano_de_bautizo, 
                :primer_nombre_padrino, 
                :segundo_nombre_padrino, 
                :primer_apellido_padrino, 
                :segundo_apellido_padrino, 
                :primer_nombre_madrina, 
                :segundo_nombre_madrina, 
                :primer_apellido_madrina, 
                :segundo_apellido_madrina, 
                :primer_nombre_ministro, 
                :segundo_nombre_ministro, 
                :primer_apellido_ministro, 
                :segundo_apellido_ministro, 
                :observacion, 
                :numero_registro_civil, 
                :ano_registro_civil,
                :numLibro,
                :folio,
                :numeral,
                :notaMar,
                :finalidad
            )');

            $stmt->bindValue(':primer_nombre', $_POST['primer_nombre'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre', $_POST['segundo_nombre'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido', $_POST['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido', $_POST['segundo_apellido'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_papa', $_POST['primer_nombre_papa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_papa', $_POST['segundo_nombre_papa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_papa', $_POST['primer_apellido_papa'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_papa', $_POST['segundo_apellido_papa'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_mama', $_POST['primer_nombre_mama'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_mama', $_POST['segundo_nombre_mama'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_mama', $_POST['primer_apellido_mama'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_mama', $_POST['segundo_apellido_mama'], PDO::PARAM_STR);
            $stmt->bindValue(':filiacion', $_POST['filiacion'], PDO::PARAM_STR);
            $stmt->bindValue(':lugar_de_nacimiento', $_POST['lugar_de_nacimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':estado_de_nacimiento', $_POST['estado_de_nacimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':pais_de_nacimiento', $_POST['pais_de_nacimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':dia_de_nacimiento', $_POST['dia_de_nacimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_nacimiento', $_POST['mes_de_nacimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_nacimiento', $_POST['ano_de_nacimiento'], PDO::PARAM_INT);
            $stmt->bindValue(':dia_de_bautizo', $_POST['dia_de_bautizo'], PDO::PARAM_STR);
            $stmt->bindValue(':mes_de_bautizo', $_POST['mes_de_bautizo'], PDO::PARAM_STR);
            $stmt->bindValue(':ano_de_bautizo', $_POST['ano_de_bautizo'], PDO::PARAM_INT);
            $stmt->bindValue(':primer_nombre_padrino', $_POST['primer_nombre_padrino'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_padrino', $_POST['segundo_nombre_padrino'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_padrino', $_POST['primer_apellido_padrino'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_padrino', $_POST['segundo_apellido_padrino'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_madrina', $_POST['primer_nombre_madrina'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_madrina', $_POST['segundo_nombre_madrina'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_madrina', $_POST['primer_apellido_madrina'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_madrina', $_POST['segundo_apellido_madrina'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_nombre_ministro', $_POST['primer_nombre_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_nombre_ministro', $_POST['segundo_nombre_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':primer_apellido_ministro', $_POST['primer_apellido_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':segundo_apellido_ministro', $_POST['segundo_apellido_ministro'], PDO::PARAM_STR);
            $stmt->bindValue(':observacion', $_POST['observacion'], PDO::PARAM_STR);
            $stmt->bindValue(':numero_registro_civil', $_POST['numero_registro_civil'], PDO::PARAM_INT);
            $stmt->bindValue(':ano_registro_civil', $_POST['ano_registro_civil'], PDO::PARAM_INT);
            $stmt->bindValue(':numLibro', $_POST['numLibro'], PDO::PARAM_INT);
            $stmt->bindValue(':folio', $_POST['folio'], PDO::PARAM_INT);
            $stmt->bindValue(':numeral', $_POST['numeral'], PDO::PARAM_INT);
            $stmt->bindValue(':notaMar', $_POST['notaMar'], PDO::PARAM_STR);
            $stmt->bindValue(':finalidad', $_POST['finalidad'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo 'Confirmacion agregado exitosamente!';
            } else {
                echo 'Hubo un error al agregar la Confirmacion.';
            }
        }
    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>Agregar Bautizo</title>
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
            <button id="cerrarSesion" onclick="window.location.href='indexConfirmacion.php'">Volver</button>
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
        <div class="input-row">
            <div class="input-group">
                <label for="lugar_de_nacimiento" class="obligatorio">Lugar de Nacimiento:</label><br>
                <input type="text" id="lugar_de_nacimiento" name="lugar_de_nacimiento" required><br>
            </div>
            <div class="input-group">
                <label for="estado_de_nacimiento" class="obligatorio">Estado de Nacimiento:</label><br>
                <input type="text" id="estado_de_nacimiento" name="estado_de_nacimiento"><br>
            </div>
            <div class="input-group">
                <label for="pais_de_nacimiento" class="obligatorio">Pais de Nacimiento:</label><br>
                <input type="text" id="pais_de_nacimiento" name="pais_de_nacimiento"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_nacimiento" class="obligatorio">Día de Nacimiento:</label><br>
                <input type="text" id="dia_de_nacimiento" name="dia_de_nacimiento" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_nacimiento" class="obligatorio">Mes de Nacimiento:</label><br>
                <input type="text" id="mes_de_nacimiento" name="mes_de_nacimiento" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_nacimiento" class="obligatorio">Año de Nacimiento:</label><br>
                <input type="text" id="ano_de_nacimiento" name="ano_de_nacimiento" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_papa">Primer Nombre Papá:</label>
                <input type="text" id="primer_nombre_papa" name="primer_nombre_papa">
            </div>
            <div class="input-group">
                <label for="segundo_nombre_papa">Segundo Nombre Papá:</label>
                <input type="text" id="segundo_nombre_papa" name="segundo_nombre_papa">
            </div>
            <div class="input-group">
                <label for="primer_apellido_papa" class="etiqueta-larga">Primer Apellido Papá:</label>
                <input type="text" id="primer_apellido_papa" name="primer_apellido_papa"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_papa" class="etiqueta-larga">Segundo Apellido Papá:</label>
                <input type="text" id="segundo_apellido_papa" name="segundo_apellido_papa"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_mama">Primer Nombre Mamá:</label><br>
                <input type="text" id="primer_nombre_mama" name="primer_nombre_mama"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_mama">Segundo Nombre Mamá:</label><br>
                <input type="text" id="segundo_nombre_mama" name="segundo_nombre_mama"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_mama">Primer Apellido Mamá:</label><br>
                <input type="text" id="primer_apellido_mama" name="primer_apellido_mama"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_mama">Segundo Apellido Mama:</label><br>
                <input type="text" id="segundo_apellido_mama" name="segundo_apellido_mama"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_padrino">Primer Nombre del Padrino:</label><br>
                <input type="text" id="primer_nombre_padrino" name="primer_nombre_padrino"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_padrino">Segundo Nombre del Padrino:</label><br>
                <input type="text" id="segundo_nombre_padrino" name="segundo_nombre_padrino"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_padrino">Primer Apellido del Padrino:</label><br>
                <input type="text" id="primer_apellido_padrino" name="primer_apellido_padrino"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_padrino">Segundo Apellido del Padrino:</label><br>
                <input type="text" id="segundo_apellido_padrino" name="segundo_apellido_padrino"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_madrina">Primer Nombre de la Madrina:</label><br>
                <input type="text" id="primer_nombre_madrina" name="primer_nombre_madrina"><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_madrina">Segundo Nombre de la Madrina:</label><br>
                <input type="text" id="segundo_nombre_madrina" name="segundo_nombre_madrina"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_madrina">Primer Apellido de la Madrina:</label><br>
                <input type="text" id="primer_apellido_madrina" name="primer_apellido_madrina"><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_madrina">Segundo Apellido de la Madrina:</label><br>
                <input type="text" id="segundo_apellido_madrina" name="segundo_apellido_madrina"><br>
            </div>
        </div>       
        <div class="input-row">
            <div class="input-group">
                <label for="dia_de_bautizo" class="obligatorio">Día de Bautizo:</label><br>
                <input type="text" id="dia_de_bautizo" name="dia_de_bautizo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="mes_de_bautizo" class="obligatorio">Mes de Bautizo:</label><br>
                <input type="text" id="mes_de_bautizo" name="mes_de_bautizo" required pattern="\d{1,2}"><br>
            </div>
            <div class="input-group">
                <label for="ano_de_bautizo" class="obligatorio">Año de Bautizo:</label><br>
                <input type="text" id="ano_de_bautizo" name="ano_de_bautizo" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="primer_nombre_ministro" class="obligatorio">Primer Nombre del Ministro:</label><br>
                <input type="text" id="primer_nombre_ministro" name="primer_nombre_ministro" required><br>
            </div>
            <div class="input-group">
                <label for="segundo_nombre_ministro">Segundo Nombre del Ministro:</label><br>
                <input type="text" id="segundo_nombre_ministro" name="segundo_nombre_ministro"><br>
            </div>
            <div class="input-group">
                <label for="primer_apellido_ministro" class="obligatorio">Primer Apellido del Ministro:</label><br>
                <input type="text" id="primer_apellido_ministro" name="primer_apellido_ministro" required><br>
            </div>
            <div class="input-group">
                <label for="segundo_apellido_ministro">Segundo Apellido del Ministro:</label><br>
                <input type="text" id="segundo_apellido_ministro" name="segundo_apellido_ministro"><br>
            </div>
        </div> 
        <div class="input-row">
            <div class="input-group">
                <label for="numero_registro_civil" class="obligatorio">Número de Registro Civil:</label><br>
                <input type="text" id="numero_registro_civil" name="numero_registro_civil" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="ano_registro_civil" class="obligatorio">Año de Registro Civil:</label><br>
                <input type="text" id="ano_registro_civil" name="ano_registro_civil" required pattern="\d{4}"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="numLibro" class="obligatorio">Número de Libro:</label><br>
                <input type="text" id="numLibro" name="numLibro" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="folio" class="obligatorio">Folio:</label><br>
                <input type="text" id="folio" name="folio" required pattern="\d+"><br>
            </div>
            <div class="input-group">
                <label for="numeral" class="obligatorio">Numeral:</label><br>
                <input type="text" id="numeral" name="numeral" required pattern="\d+"><br>
            </div>
        </div>
        <div class="input-row">
            <div class="input-group">
                <label for="filiacion">Filiación:</label><br>
                <input type="text" id="filiacion" name="filiacion"><br>
            </div>
            <div class="input-group">
                <label for="observacion">Observación:</label><br>
                <input type="text" id="observacion" name="observacion"><br>
            </div>
            <div class="input-group">
                <label for="notaMar">Nota Marginal:</label><br>
                <input type="text" id="notaMar" name="notaMar"><br>
            </div>
            <div class="input-group">
                <label for="finalidad">Finalidad:</label><br>
                <input type="text" id="finalidad" name="finalidad"><br>
            </div>
        </div>
        <input type="submit" value="Agregar Confirmacion">
    </form>
    <button id="botonRegreso" onclick="location.href='indexConfirmacion.php'">Volver</button>
    </div>
</body>
</html>