<?php 
    $resultado ="";
    try { 
        
        $manager = new MongoDB\Driver\Manager(); 

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'tweets',
            'pipeline' => [
                ['$group' => ['_id' => '$language', 'total'=> ['$sum' => 1]]],
                ['$sort' => ['total' => -1]]
            ],
            'cursor' => new stdClass,
        ]);
        
        $cursor = $manager->executeCommand("Twitter", $command);

        //https://www.dyclassroom.com/chartjs/chartjs-how-to-create-doughnut-chart-using-data-from-mysql-mariadb-table-and-php
        if($cursor!=""){ 
            //almacena cada uno de los idiomas en los que hay tweets  
            $idiomas = array();        
            //almacena el número de tweets que hay de cada idioma  
            $tweetsPorIdioma = array();
            foreach ($cursor as $row) {
                $idiomas[] = $row->_id;
                $tweetsPorIdioma[] = $row->total;
            } 
            //componemos el array que vamos a parsear
            $data = array(
                "language" => $idiomas,
                "tweets" => $tweetsPorIdioma 
            );
            // parsear los datos que queremos mostrar
            $resultado = json_encode($data);           
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