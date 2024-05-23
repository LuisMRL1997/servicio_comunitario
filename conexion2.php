<?php
    //$db = new PDO('sqlite:c:\Users\default.LAPTOP-9TH0265F\Desktop\Lapso Intensivo 2023-2\4. Servicio Comunitario\3. Proyecto Como Tal\Tercer intento del servicio comunitario\Base de datos de lso registros de la parroquia.db');

    try{

        //habrá que cambiarle el nombre a la dbname
        $db = new PDO('sqlite:Registros.db');
    
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        //$db->exec("SET CHARACTER SET UTF8");
    
    
        
    }catch(Exception $e){
    
        die('Error: ' . $e->getMessage());
    
        echo "Línea del Error: " . $e->getLine();
    }
?>