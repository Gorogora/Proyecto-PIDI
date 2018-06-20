<?php
    $resultado = "";
    try { 
        // Conectar al servidor de MongoDB con los valores por defecto
        $manager = new MongoDB\Driver\Manager(); 

        $db_name = "Twitter";
        

        $coleccion = $_REQUEST['coleccion'];   
        $filtrosActivos = $_REQUEST['filtrosActivos'];     
        //contenido de los filtros
        $userName = $_REQUEST['userName'];
        $idioma = $_REQUEST['idioma'];
        $pais = $_REQUEST['pais'];
        $hashtag = $_REQUEST['hashtag'];
        $isRetweet = $_REQUEST['isRetweet'];
        $fechaInicio = $_REQUEST['fechaInicio'];
        $fechaFin = $_REQUEST['fechaFin'];
        $palabras = $_REQUEST['palabras'];
        
        //componer el filtro
        $filtro = ['$and'=>[]];
        $index = 0;

        //filtrar por usuario
        if($filtrosActivos[0] == "true"){
            $filtro['$and'][$index] = ['user'=>$userName];
            $index = $index + 1;
        }

        //filtrar por idioma
        if($filtrosActivos[1] == "true"){
            $filtro['$and'][$index] = ['language'=>$idioma];
            $index = $index + 1;
        }

        //filtrar por papis
        if($filtrosActivos[2] == "true"){
            $filtro['$and'][$index] = ['place'=>$pais];
            $index = $index + 1;
        }

        //filtrar por hashtag
        if($filtrosActivos[3] == "true"){
            $filtro['$and'][$index] = ['hashtags'=>['$in'=>[$hashtag]]];
            $index = $index + 1;
        }

        //filtrar si es o no retweet
        if($filtrosActivos[4] == "true"){
            if($isRetweet){
                $filtro['$and'][$index] = ['isRetweet'=>1];
                $index = $index + 1;
            } 
        }

        //filtrar por rango de fecha
        if($filtrosActivos[5] == "true"){
            $fecha_inicio = new DateTime($fechaInicio);
            $fecha_inicio = $fecha_inicio->add(new DateInterval('PT2H'))->getTimestamp();
            $filtro['$and'][$index] = ['created_at'=>['$gte'=>(new MongoDB\BSON\UTCDateTime($fecha_inicio*1000))]];
            
            $fecha_fin = new DateTime($fechaFin);
            $fecha_fin = $fecha_fin->add(new DateInterval('PT2H'))->getTimestamp();
            $filtro['$and'][$index] = ['created_at'=>['$lte'=>(new MongoDB\BSON\UTCDateTime($fecha_fin*1000))]];
            
            $index = $index + 1;
        }

        //filtrar por contenido del tweet
        if($filtrosActivos[6] == "true"){
            $filtro['$and'][$index] = ['text'=>['$regex'=>'.*'.$palabras.'.*']];
            $index = $index + 1;
        }


        $query = new MongoDB\Driver\Query($filtro);
        $rows = $manager->executeQuery("Twitter.".$coleccion, $query);

        //insertar las filas de la consulta
        $tweets = 0;
        $bulk = new MongoDB\Driver\BulkWrite;
        foreach ($rows as $row) {
            $bulk->insert($row);
            $tweets = $tweets + 1;
        }

        $nombre_coleccion_filtrada = "";
        //si no estoy haciendo el filtro sobre una colección ya filtrada
        if (strpos($coleccion, '_filtrada') === false) {
            $nombre_coleccion_filtrada = $coleccion."_filtrada";
        }
        else{
            $nombre_coleccion_filtrada = $coleccion;    //$coleccion ya tendrá _filtrada
            //$manager->executeCommand($db_name, new \MongoDB\Driver\Command(["drop" => $nombre_coleccion_filtrada]));
        }

        $cmd = new MongoDB\Driver\Command(['listCollections' => 1]);
        $colecciones = $manager->executeCommand($db_name, $cmd);
        foreach ($colecciones as $coleccion) {
            if(strcmp($coleccion->name, $nombre_coleccion_filtrada) == 0){
                $manager->executeCommand($db_name, new \MongoDB\Driver\Command(["drop" => $nombre_coleccion_filtrada]));
            }
        }
        /*$cmd = new MongoDB\Driver\Command(['listCollections' => 1]);
        $colecciones = $manager->executeCommand($db_name, $cmd);
        //en caso de que exista la colección _filtrada la borramos
        foreach ($colecciones as $coleccion) {
            if(strcmp($coleccion->name, $nombre_coleccion_filtrada) == 0){
                $manager->executeCommand($db_name, new \MongoDB\Driver\Command(["drop" => $nombre_coleccion_filtrada]));
            }
        }*/

        if($tweets != 0){
            //insertar todas las filas a la vez
            $manager->executeBulkWrite($db_name.".".$nombre_coleccion_filtrada, $bulk);

            $resultado = '<div class="alert alert-success alert-dismissible">';
            $resultado = $resultado. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $resultado = $resultado. '<h4><i class="icon fa fa-check"></i> Colección creada con éxito</h4>';
            $resultado = $resultado. 'La colección tiene ' .$tweets. ' tweets.';
            $resultado = $resultado. '</div>';
        }
        else{
            $resultado = '<div class="alert alert-info alert-dismissible">';
            $resultado = $resultado. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $resultado = $resultado. '<h4><i class="icon fa fa-info"></i> No se ha creado la colección</h4>';
            $resultado = $resultado. 'Los filtros seleccionados no pueden crear una colección.';
            $resultado = $resultado. '</div>';
        }

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