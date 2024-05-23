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
            <a href="indexEventos.php">Eventos</a>
            <?php
            if (isset($user) && ($user['es_maestro'] || $user['es_administrador'])) {
                echo '<a href="cuentasRegistradas.php">Cuentas</a>';
            }
            ?>
        </div>
    </div>

    <?php
        if (isset($user) && ($user['es_maestro'] || $user['es_administrador'])) {
            echo '<button id="cerrarSesion" onclick="location.href=\'inserEvento.php\'">Insertar Evento</button>';
        }
        ?>
        </div>
    <div class="container">
        <?php
        session_start();
        include("conexion2.php");
        function numeroAMes($mes) {
            $meses = array(
                '1', '01' => 'Enero',
                '2', '02' => 'Febrero',
                '3', '03' => 'Marzo',
                '4', '04' => 'Abril',
                '5', '05' => 'Mayo',
                '6', '06' => 'Junio',
                '7', '07' => 'Julio',
                '8', '08' => 'Agosto',
                '9', '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
                'enero', 'Enero' => '1',
                'febrero', 'Febrero' => '2',
                'marzo', 'Marzo' => '3',
                'abril', 'Abril' => '4',
                'mayo', 'Mayo' => '5',
                'junio', 'Junio' => '6',
                'julio', 'Julio' => '7',
                'agosto', 'Agosto' => '8',
                'septiembre', 'Septiembre' => '9',
                'octubre', 'Octubre' => '10',
                'noviembre', 'Noviembre' => '11',
                'diciembre', 'Diciembre' => '12'
            );
            return $meses[$mes];
        }
        
        

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT COUNT(*) FROM [eventos] WHERE [id] = $id";
            $count = $db->query($sql)->fetchColumn();
            
            if ($count > 0) {
                $sql = "SELECT * FROM [eventos] WHERE [id] = $id";
                $result = $db->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                echo "<div id='temp-div'></div>";
                echo "<div class='certificado' align-items: center;'>";
                echo "<div id='content-to-capture'>";  
                echo "<div style='display: flex; justify-content: center; align-items: center;'>
                       <img id='logo' src='Logo.png' alt='Escudo' style='width: 150px; height: 150px; margin-right: 20px;'>
                        <div>
                            <div class='titulo1' style='font-size: 20px; text-align: center;'>DIÓCESIS DE SAN CRISTÓBAL</div>
                            <div class='titulo2' style='font-size: 20px; text-align: center;'>PARROQUIA ECLESIÁSTICA</div>
                            <div class='titulo2' style='font-size: 20px; text-align: center;'>“DIVINO MAESTRO”</div>
                            <div class='titulo3' style='font-size: 20px; text-align: center;'>San Cristóbal – Estado Táchira - Venezuela</div>
                        </div>
                    </div>";
                echo "<h2>FE DE EVENTO</h2>";   
                echo "<p style='text-indent: 50px; text-align: center;'>La parroquia Dios Padre Misericordioso te invita a</p>";
                echo "<p style='text-align: center;'>  " . $row["tipo"]. " " . $row["descripcion"]. "</p>";
                echo "<p style='text-align: center;'>que se realizará el " . $row["dia"]. " de " . numeroAMes(trim($row["mes"])). " del año " . $row["ano"]. ".</p>";
                echo "<p style='text-align: center;'>El evento comenzará a las " . $row["hora_inicio"]. " y terminará a las " . $row["hora_fin"]. ".</p>";
                $fecha_formateada = date("d") . " de " . numeroAMes(date("m")) . " del " . date("Y");
                echo "</div>";
                echo "</div>";               
                echo "</div>";
                echo "</div>";
                echo "<button id='download' class='button' style='display: none;'>Descargar como imagen</button>";
                echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js'></script>";
                echo "<script>
                        document.getElementById('download').style.display = 'block';
                        document.getElementById('download').addEventListener('click', function() {
                            var node = document.getElementById('content-to-capture');
                            domtoimage.toPng(node)
                                .then(function (dataUrl) {
                                    var link = document.createElement('a');
                                    link.download = 'Evento de " . $row["tipo"] . " " . $row["descripcion"] . ".png';
                                    link.href = dataUrl;
                                    link.click();
                                })
                                .catch(function (error) {
                                    console.error('oops, something went wrong!', error);
                                });
                        });
                    </script>";

            } else {
                echo "No se encontraron resultados para el ID proporcionado.";
            }
        }
        ?>
    </div>
    <a href="indexEventos.php"><button class="button">Volver</button></a>
    </div>
</body>
</html>
