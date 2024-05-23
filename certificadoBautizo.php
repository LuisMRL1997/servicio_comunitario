<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/boot">
</head>
<body>
    <?php
        include("conexion2.php");
        $sentenciaSQL = $conexion2->prepare("SELECT * FROM bautizos");
        $sentenciaSQL->execute();
        $datosPersona = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <?php
        session_start();
        include("conexion2.php");
        function numeroAMes($numero) {
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
                '12' => 'Diciembre'
            );
            return $meses[$numero];
        }
       

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT COUNT(*) FROM bautizos WHERE id = $id";
            $count = $db->query($sql)->fetchColumn();
            
            if ($count > 0) {
                $sql = "SELECT * FROM bautizos WHERE id = $id";
                $result = $db->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                echo "<div id='content-to-capture'>";
                echo "<div class='certificado' style='display: flex; align-items: start;'>";
                echo "<img src='prueba de logo.png' alt='Escudo' style='width: 100px; height: 100px; margin-right: 20px;'>";
                echo "<div style='text-align: center;'>";
                echo "<h1>DIÓCESIS DE SAN CRISTÓBAL</h1>";
                echo "<h2>PARROQUIA ECLESIÁSTICA “DIVINO MAESTRO”</h2>";
                echo "<h3>San Cristóbal – Estado Táchira - Venezuela</h3>";
                echo "<h2>FE DE BAUTISMO</h2>";   
                echo "<p>Quien suscribe, Presbitero Joel Javier Escalante Buitrago, en calidad de párroco de esta parroquia, certifica y da fe de que:</p>";
                echo "<p><strong>El ciudadano:</strong> " . $row["primer_nombre"]. " " . $row["segundo_nombre"]. " " . $row["primer_apellido"]. " " . $row["segundo_apellido"]. "</p>";
                echo "<p><strong>Fue bautizado (a) el día:</strong> " . $row["dia_de_bautizo"]. " de " . numeroAMes(trim($row["mes_de_bautizo"])). " del año " . $row["ano_de_bautizo"]. ".</p>";
                echo "<p><strong>Nació el día:</strong> " . $row["dia_de_nacimiento"]. " de " . numeroAMes(trim($row["mes_de_nacimiento"])). " del año " . $row["ano_de_nacimiento"]. " en " . $row["lugar_de_nacimiento"]. ", Estado " . $row["estado_de_nacimiento"]. ".</p>";
                echo "<p><strong>Padres:</strong> " . $row["primer_nombre_papa"]. " " . $row["segundo_nombre_papa"]. " " . $row["primer_apellido_papa"]. " " . $row["segundo_apellido_papa"]. " y " . $row["primer_nombre_mama"]. " " . $row["segundo_nombre_mama"]. " " . $row["primer_apellido_mama"]. " " . $row["segundo_apellido_mama"]. ".</p>";
                echo "<p><strong>Padrinos:</strong> " . $row["primer_nombre_padrino"]. " " . $row["segundo_nombre_padrino"]. " " . $row["primer_apellido_padrino"]. " " . $row["segundo_apellido_padrino"]. " y " . $row["primer_nombre_madrina"]. " " . $row["segundo_nombre_madrina"]. " " . $row["primer_apellido_madrina"]. " " . $row["segundo_apellido_madrina"]. ".</p>";
                echo "<p><strong>Ministro:</strong> " . $row["primer_nombre_ministro"]. " " . $row["segundo_nombre_ministro"]. " " . $row["primer_apellido_ministro"]. " " . $row["segundo_apellido_ministro"]. ".</p>";
                echo "<p><strong>Registrado en el libro de Bautismo Nº:</strong> " . $row["numLibro"]. " <strong>Folio:</strong> " . $row["folio"]. " <strong>Numeral:</strong> " . $row["numeral"]. ".</p>";
                echo "<p><strong>De haber una nota marginal, se prescribe a continuación:</strong> " . (!empty($row["notaMar"]) ? $row["notaMar"] : "Sin nota marginal") . ".</p>";
                $fecha_formateada = date("d") . " de " . numeroAMes(date("m")) . " del " . date("Y");
                echo "<p><strong>Documento que se expide en este despacho a la fecha de hoy:</strong> " . $fecha_formateada . ".</p>";
                echo "<p><strong>Para fines:</strong> " . (!empty($row["finalidad"]) ? $row["finalidad"] : "Sin Finalidad") . ".</p>";
                echo "<br><br>";
                echo "<p style='text-align: center;'>________________________</p>";
                echo "<p style='text-align: center;'>PÁRROCO</p>";
                $serial = $row["id"] . $row["ano_de_nacimiento"] . $row["ano_de_bautizo"] . date("Ymd");
                echo "<p style='text-align: center;'>Número de serie: " . $serial . "</p>";
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
                                    link.download = 'Fe de Bautizo de " . $row["primer_nombre"] . " " . $row["segundo_nombre"] . " " . $row["primer_apellido"] . " " . $row["segundo_apellido"] . ".png';
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
</body>
</html>
<?php
    $html = ob_get_clean();
    echo $html;

    require_once "../libreria/dompdf/autoload.inc.php";
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemotedEnabled'=>true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream("CertificadoBautizo.pdf",array("Attachment"=>false));
?>
