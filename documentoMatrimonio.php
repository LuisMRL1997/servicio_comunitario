<!DOCTYPE html>
<html>
<head>
    <title>Registros de Matrimonios</title>
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

    <h1>¡Estos son los Matrimonios de nuestra Parroquia!</h1>
    
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
            echo '<button id="cerrarSesion" onclick="location.href=\'inserMatrimonio.php\'">Insertar Matrimonio</button>';
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
            $sql = "SELECT COUNT(*) FROM [matrimonios] WHERE [id] = $id";
            $count = $db->query($sql)->fetchColumn();
            
            if ($count > 0) {
                $sql = "SELECT * FROM [matrimonios] WHERE [id] = $id";
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
                        echo "</div>";

                            echo "<div style='text-align: left; line-height: 1.2; padding: 20px; text-indent: 120px'>";
                                echo "<p style='text-align: left; text-indent: 70px; margin-left: 20px; line-height: 1.5; padding: 10px;'>Quien suscribe, Presbitero Joel Javier Escalante Buitrago, en calidad de párroco de esta parroquia, 
                                    certifica y da fe de que en el Libro de Matrimonios N°  </strong> " . $row["numLibro_matrimonio"]. ",  Folio " . $row["folio_matrimonio"]. ",  Numeral " . $row["numeral_matrimonio"]. ", se encuentra el: </p>";                
                                
                                echo "<h2 style='margin-right: 120px;'>ACTA DE MATRIMONIO <br></h2>";                        
                                echo "<p style='margin-left: 0px;'><strong>Del ciudadano:</strong> " . $row["primer_nombre_esposo"]. " " . $row["segundo_nombre_esposo"]. " " . $row["primer_apellido_esposo"]. " " . $row["segundo_apellido_esposo"]. "</p>";
                                echo "<p style='margin-left: 0px;'><strong>Hijo Legitimo de:</strong> " . $row["primer_nombre_papa_esposo"]. " " . $row["segundo_nombre_papa_esposo"]. " " . $row["primer_apellido_papa_esposo"]. " " . $row["segundo_apellido_papa_esposo"]. " y " 
                                        . $row["primer_nombre_mama_esposo"]. " " . $row["segundo_nombre_mama_esposo"]. " " . $row["primer_apellido_mama_esposo"]. " " . $row["segundo_apellido_mama_esposo"]. "</p>";
                                echo "<p style='margin-left: 0px;'><strong>Nació el día:</strong> " . $row["dia_de_nacimiento_esposo"]. " de " . numeroAMes(trim($row["mes_de_nacimiento_esposo"])). " del año " . $row["ano_de_nacimiento_esposo"]. " en " . $row["lugar_de_nacimiento_esposo"]. ", Estado " . $row["estado_de_nacimiento_esposo"]. ", Pais " . $row["pais_de_nacimiento_esposo"]. ".</p>";
                                echo "<p style='margin-left: 0px;'><strong>Bautizado el día:</strong> " . $row["dia_de_bautizo_esposo"]. " de " . numeroAMes(trim($row["mes_de_bautizo_esposo"])). " del año " . $row["ano_de_bautizo_esposo"]. " en " . $row["iglesia_de_bautizo_esposo"]. " de " . $row["lugar_de_bautizo_esposo"]. ", <p style:'padding: 10px;'> Estado " . $row["estado_de_bautizo_esposo"]. ", Pais " . $row["pais_de_bautizo_esposo"]. "<br>". ".</p>";
                                echo "<h2 style='margin-right: 120px;'>CASADO <br></h2>";
                                echo "<p style='text-align: center; margin-right: 100px;'><strong>el día:</strong> " . $row["dia_de_matrimonio"]. " de " . numeroAMes(trim($row["mes_de_matrimonio"])). " del año " . $row["ano_de_matrimonio"]. ".</p>";
                                echo "<p style='margin-left: 0px;'><strong>Con la ciudadana:</strong> " . $row["primer_nombre_esposa"]. " " . $row["segundo_nombre_esposa"]. " " . $row["primer_apellido_esposa"]. " " . $row["segundo_apellido_esposa"]. "</p>";
                                echo "<p style='margin-left: 0px;'><strong>Hija Legitima de:</strong> " . $row["primer_nombre_papa_esposa"]. " " . $row["segundo_nombre_papa_esposa"]. " " . $row["primer_apellido_papa_esposa"]. " " . $row["segundo_apellido_papa_esposa"]. " y " 
                                        . $row["primer_nombre_mama_esposa"]. " " . $row["segundo_nombre_mama_esposa"]. " " . $row["primer_apellido_mama_esposa"]. " " . $row["segundo_apellido_mama_esposa"]. "</p>";
                                echo "<p style='margin-left: 0px;'><strong>Nació el día:</strong> " . $row["dia_de_nacimiento_esposa"]. " de " . numeroAMes(trim($row["mes_de_nacimiento_esposa"])). " del año " . $row["ano_de_nacimiento_esposa"]. " en " . $row["lugar_de_nacimiento_esposa"]. ", Estado " . $row["estado_de_nacimiento_esposa"]. ", Pais " . $row["pais_de_nacimiento_esposa"]. ".</p>";
                                echo "<p style='margin-left: 0px;'><strong>Bautizada el día:</strong> " . $row["dia_de_bautizo_esposa"]. " de " . numeroAMes(trim($row["mes_de_bautizo_esposa"])). " del año " . $row["ano_de_bautizo_esposa"]. " en " . $row["iglesia_de_bautizo_esposa"]. "<p style:'padding: 10px;'> de " . $row["lugar_de_bautizo_esposa"]. ", Estado " . $row["estado_de_bautizo_esposa"]. ", Pais " . $row["pais_de_bautizo_esposa"]. "<br>". ".</p>";
                                echo "<p style='margin-left: 0px;'><strong>Este matrimonio fue presentado por: </strong> " . $row["primer_nombre_ministro"]. " " . $row["segundo_nombre_ministro"]. " " . $row["primer_apellido_ministro"]. " " . $row["segundo_apellido_ministro"]. ".</p>";
                                echo "<p style='margin-left: 0px;'><strong>siendo testigos:</strong> " . $row["primer_nombre_padrino_esposo"]. " " . $row["segundo_nombre_padrino_esposo"]. " " . $row["primer_apellido_padrino_esposo"]. " " . $row["segundo_apellido_padrino_esposo"]. ", " . $row["primer_nombre_madrina_esposo"]. " " . $row["segundo_nombre_madrina_esposo"]. " " . $row["primer_apellido_madrina_esposo"]. " " . $row["segundo_apellido_madrina_esposo"]. ", <p style:'padding: 10px;'>"
                                    . $row["primer_nombre_padrino_esposa"]. " " . $row["segundo_nombre_padrino_esposa"]. " " . $row["primer_apellido_padrino_esposa"]. " " . $row["segundo_apellido_padrino_esposa"]. ", " . $row["primer_nombre_madrina_esposa"]. " " . $row["segundo_nombre_madrina_esposa"]. " " . $row["primer_apellido_madrina_esposa"]. " " . $row["segundo_apellido_madrina_esposa"]. ".</p>";                        
                            echo "</div>";
                            
                            echo "<div id ='fecha_motivo' style='text-align: left; text-indent: 100px'>";
                                echo "<p><strong>De haber una nota marginal, se prescribe a continuación:</strong> " . (!empty($row["notaMar_matrimonio"]) ? $row["notaMar_matrimonio"] : "Sin nota marginal") . ".</p>";
                                    $fecha_formateada = date("d") . " de " . numeroAMes(date("m")) . " del " . date("Y");
                                echo "<p><strong>El presente Documento se expide para fines:</strong>" . (!empty($row["finalidad"]) ? $row["finalidad"] : "Sin Finalidad") ." el dia " . $fecha_formateada . ".</p>";
                            echo "</div>";  
                                
                            echo "<div style='text-align: left;'>";
                                echo "<br><br><br>";
                                echo "<p style='text-align: center;'>____________________________________________</p>";
                                echo "<p style='text-align: center; margin-right: 20px;'>PÁRROCO</p>";
                                    $serial = $row["id"] . $row["ano_de_nacimiento_esposo"] . $row["ano_de_bautizo_esposa"] . $row["ano_de_matrimonio"] . date("Ymd");
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
                                            link.download = 'Acta de Matrimonio de " . $row["primer_nombre_esposo"] . " " . $row["segundo_nombre_esposo"] . " " . $row["primer_apellido_esposo"] . " " . $row["segundo_apellido_esposo"] . " y " . $row["primer_nombre_esposa"] . " " . $row["segundo_nombre_esposa"] . " " . $row["primer_apellido_esposa"] . " " . $row["segundo_apellido_esposa"] . ".png';
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
    <a href="indexMatrimonio.php"><button class="button">Volver</button></a>
    </div>
</body>
</html>
