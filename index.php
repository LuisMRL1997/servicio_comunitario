<!DOCTYPE html>
<html>
<head>
    <title>Graficos</title>
    <link rel="stylesheet" type="text/css" href="stylesRegistros.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            echo '<p style="text-align: center;">Actualmente estás en la cuenta (' . $_SESSION['nombre_usuario'] . ') (' . $rol . ')</p>';
        }

        function numeroAMes($mes) {
            $meses = array(
                '1' => 'Enero',
                '01' => 'Enero',
                '2' => 'Febrero',
                '02' => 'Febrero',
                '3' => 'Marzo',
                '03' => 'Marzo',
                '4' => 'Abril',
                '04' => 'Abril',
                '5' => 'Mayo',
                '05' => 'Mayo',
                '6' => 'Junio',
                '06' => 'Junio',
                '7' => 'Julio',
                '07' => 'Julio',
                '8' => 'Agosto',
                '08' => 'Agosto',
                '9' => 'Septiembre',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
                'Enero' => 'Enero',
                'Febrero' => 'Febrero',
                'Marzo' => 'Marzo',
                'Abril' => 'Abril',
                'Mayo' => 'Mayo',
                'Junio' => 'Junio',
                'Julio' => 'Julio',
                'Agosto' => 'Agosto',
                'Septiembre' => 'Septiembre',
                'Octubre' => 'Octubre',
                'Noviembre' => 'Noviembre',
                'Diciembre' => 'Diciembre'
            );
            return $meses[$mes];
        }

        $stmt = $db->prepare("SELECT mes_de_bautizo, ano_de_bautizo, COUNT(*) as count FROM bautizos GROUP BY mes_de_bautizo, ano_de_bautizo ORDER BY count DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convertir los números de los meses a nombres de meses y añadir el año
        foreach ($result as $key => $row) {
            $result[$key]['mes_de_bautizo'] = numeroAMes($row['mes_de_bautizo']) . ' ' . $row['ano_de_bautizo'];
        }

        // Obtener el total de registros
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM bautizos");
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    ?>
</div>
<div class="menu-bar">
    <?php
    if (isset($_SESSION['nombre_usuario'])) {
        echo '<button id="cerrarSesion" onclick="window.location.href=\'cerrarSesion.php\'">Cerrar Sesión</button>';
    } else {
        echo '<button id="iniciarSesion" onclick="window.location.href=\'iniciarSesion.php\'">Iniciar Sesión</button>';
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
    <div class="chart-container">
        <canvas id="myChart"></canvas>
        <p>Total de bautizos: <?php echo $total; ?></p>
    </div>
</div>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(array_column($result, 'mes_de_bautizo')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($result, 'count')); ?>,
            backgroundColor: [
                'rgba(75, 0, 130, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(128, 0, 128, 0.2)',
                'rgba(255, 165, 0, 0.2)',
                'rgba(0, 128, 0, 0.2)',
                'rgba(138, 43, 226, 0.2)'
            ],
            borderColor: [
                'rgba(75, 0, 130, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(128, 0, 128, 1)',
                'rgba(255, 165, 0, 1)',
                'rgba(0, 128, 0, 1)',
                'rgba(138, 43, 226, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Los 10 meses con más bautizos'
            }
        }
    },
});
</script>

</body>
</html>
