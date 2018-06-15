<?php
    $resultado = "";
    try { 
        // Conectar al servidor de MongoDB con los valores por defecto
        $manager = new MongoDB\Driver\Manager(); 
        

        $coleccion = $_REQUEST['coleccion'];        
        //contenido de los filtros
        $fechaInicio = $_REQUEST['fechaInicio'];
        $fechaFin = $_REQUEST['fechaFin'];
        $userName = $_REQUEST['userName'];
        $palabras = $_REQUEST['palabras'];
        $idioma = $_REQUEST['idioma'];
        $pais = $_REQUEST['pais'];
        $retweet = $_REQUEST['retweet'];
        $hashtag = $_REQUEST['hashtag'];




        //componer el filtro
        $filtro = [];

        $query = new MongoDB\Driver\Query($filtro);
        $rows = $manager->executeQuery("Twitter.".$coleccion, $query);

        //insertar las filas de la consulta
        $bulk = new MongoDB\Driver\BulkWrite;
        foreach ($rows as $row) {
            $bulk->insert($row);
        }
        
        //Recupera las colecciones de la bbdd
        $cmd = new MongoDB\Driver\Command(['getCollectionNames' => 1]);
        $colecciones = $manager->executeCommand($bbdd, $cmd);
        //en caso de que exista la colección filtro la borramos
        foreach ($colecciones as $nombreColeccion) {
            if(strcmp($row->_id, "filtro") == 0){
                $manager->executeCommand($bbdd, new \MongoDB\Driver\Command(["drop" => "filtro"]));
            }
        }

        //insertar todas las filas a la vez
        $manager->executeBulkWrite($bbdd.".filtro", $bulk);
        
        echo $resultado;        
    }
    catch (MongoDB\Driver\Exception\Exception $e) { 
        $resultado = "<p>";
        $resultado = $resultado. "Exception:". $e->getMessage() . "<br>"; 
        $resultado = $resultado. "In file:". $e->getFile().  "<br>"; 
        $resultado = $resultado. "On line:". $e->getLine(). "<br>"; 
        $resultado = $resultado. "<p>";
        echo $resultado;
    } 
?>