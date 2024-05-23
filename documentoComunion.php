<!DOCTYPE html>
<html>
<head>
    <title>Registros de Comuniones</title>
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
            echo '<button id="cerrarSesion" onclick="location.href=\'inserComunion.php\'">Insertar Comunion</button>';
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
            $sql = "SELECT COUNT(*) FROM [comuniones] WHERE [id] = $id";
            $count = $db->query($sql)->fetchColumn();
            
            if ($count > 0) {
                $sql = "SELECT * FROM [comuniones] WHERE [id] = $id";
                $result = $db->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                echo "<div id='temp-div'></div>";
                echo "<div class='certificado' align-items: center;'>";
                echo "<div id='content-to-capture'>";
                    echo "<div style='display: flex; align-items: flex-start; margin-left: 50px;'>"; // Alinea el texto con la parte superior de la imagen
                        echo "<img id='logo' src='Logo.png' alt='Escudo' style='width: 150px; height: 175px; margin-right: 20px;'>";
                        echo "<div style='text-align: center; line-height: 0.2; margin-left: 20px;'>"; // Reduce el espacio entre las líneas de texto
                            echo "<h1 >DIÓCESIS DE SAN CRISTÓBAL</h1>";
                            echo "<h2 style='margin-right: 30px;'>PARROQUIA ECLESIÁSTICA</h2>";
                            echo "<h3 style='line-height:1.0; margin-right: 40px;'>“DIVINO MAESTRO”</h3>";
                            echo "<h4 style='line-height:1.0; margin-right: 30px;'>San Cristóbal – Estado Táchira - Venezuela</h4>";
                        echo "</div>";
                    echo "</div>";
                    echo "<br>";
                echo "<h2>CONSTANCIA DE PRIMERA COMUNION</h2>";
                echo "<div style='text-align: left; line-height: 1.2; padding: 20px; text-indent: 120px'>";   
                    echo "<p style='text-align: left; text-indent: 70px; margin-left: 20px; line-height: 1.5; padding: 10px;'>Quien suscribe, Presbitero Joel Javier Escalante Buitrago, en calidad de párroco de esta parroquia, certifica y da fe de que el ciudadano(a)</p>";
                    echo "<br>";
                    echo "<p style='margin-left: 50px;'>" . $row["primer_nombre"]. " " . $row["segundo_nombre"]. " " . $row["primer_apellido"]. " " . $row["segundo_apellido"]. "</p>";
                    echo "<p style='margin-left: 50px;'>Fue bautizado (a) el día " . $row["dia_de_bautizo"]. " de " . numeroAMes(trim($row["mes_de_bautizo"])). " del año " . $row["ano_de_bautizo"]. ".</p>";
                    echo "<p style='margin-left: 50px;'>Nació el día " . $row["dia_de_nacimiento"]. " de " . numeroAMes(trim($row["mes_de_nacimiento"])). " del año " . $row["ano_de_nacimiento"]. " en " . $row["lugar_de_nacimiento"]. " Estado " . $row["estado_de_nacimiento"]. " Pais " . $row["pais_de_nacimiento"]. ".</p>";
                    echo "</div>";

                    echo "<div style='display: flex; margin-left: 250px;'>
                            <div style='display: flex; align-items: center;'>
                                <div style='font-size: 20px; text-transform: uppercase; margin-right: 10px;'>PADRES:</div>
                                <div style='color: blue; font-size: 30px; margin-right: 10px;'>{</div>
                                <div>
                                    <p>" . $row["primer_nombre_papa"]. " " . $row["segundo_nombre_papa"]. " " . $row["primer_apellido_papa"]. " " . $row["segundo_apellido_papa"]. "</p>
                                    <p>" . $row["primer_nombre_mama"]. " " . $row["segundo_nombre_mama"]. " " . $row["primer_apellido_mama"]. " " . $row["segundo_apellido_mama"]. ".</p>
                                </div>
                            </div>
                        </div>";            
                    echo "<div style='display: flex; margin-left: 250px;'>
                            <div style='display: flex; align-items: center;'>
                                <div style='font-size: 20px; text-transform: uppercase; margin-right: 10px;'>PADRINOS:</div>
                                <div style='color: blue; font-size: 30px; margin-right: 10px;'>{</div>
                                <div>
                                    <p>" . $row["primer_nombre_padrino"]. " " . $row["segundo_nombre_padrino"]. " " . $row["primer_apellido_padrino"]. " " . $row["segundo_apellido_padrino"]. "</p>
                                    <p>" . $row["primer_nombre_madrina"]. " " . $row["segundo_nombre_madrina"]. " " . $row["primer_apellido_madrina"]. " " . $row["segundo_apellido_madrina"]. ".</p>
                                </div>
                            </div>
                        </div>";
                    echo "<div style='display: flex; margin-left: 250px;'>
                            <div style='display: flex; align-items: center;'>
                                <div style='font-size: 20px; text-transform: uppercase; margin-right: 5px;'>MINISTRO:</div>
                                <div style='color: blue; font-size: 30px; margin-right: 10px;'>{</div>
                                <div>
                                    <p>" . $row["primer_nombre_ministro"]. " " . $row["segundo_nombre_ministro"]. " " . $row["primer_apellido_ministro"]. " " . $row["segundo_apellido_ministro"]. "</p>
                                </div>
                            </div>
                        </div>";
                        echo "<br>";
                    echo "<p style='margin-left: 120px;'>Registrado en el Libro de Primera Comunion Nº: " . $row["numLibro"]. " Folio: " . $row["folio"]. " Numeral: " . $row["numeral"]. ".</p>";
                    echo "<p style='margin-left: 120px;'>De haber una nota marginal, se prescribe a continuación: " . (!empty($row["notaMar"]) ? $row["notaMar"] : "Sin nota marginal") . ".</p>";
                    $fecha_formateada = date("d") . " de " . numeroAMes(date("m")) . " del " . date("Y");
                    echo "<p style='margin-left: 120px;'>Documento que se expide en este despacho a la fecha de hoy: " . $fecha_formateada . ".</p>";
                    echo "<p style='margin-left: 120px;'>Para fines: " . (!empty($row["finalidad"]) ? $row["finalidad"] : "Sin Finalidad") . ".</p>";       
                
                echo "<br><br>";
                echo "<br><br>";
                echo "<p style='text-align: center;'>________________________</p>";
                echo "<p style='text-align: center;'>PÁRROCO</p>";
                $serial = $row["id"] . $row["ano_de_nacimiento"] . $row["ano_de_bautizo"] . date("Ymd");
                echo "<p style='text-align: center;'>Número de serie: " . $serial . "</p>";
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
                                    link.download = 'Primera Comunion de " . $row["primer_nombre"] . " " . $row["segundo_nombre"] . " " . $row["primer_apellido"] . " " . $row["segundo_apellido"] . ".png';
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
    <a href="indexComunion.php"><button class="button">Volver</button></a>
    </div>
</body>
</html>