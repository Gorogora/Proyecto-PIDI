<?php 
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado ="";
        try { 
            
            $mongo = new MongoDB();
            $cursor = $mongo->getLugaresTweets($coleccion);

            /*
            $manager = new MongoDB\Driver\Manager(); 

            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$place', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $manager->executeCommand("Twitter", $command);
            */

            //https://www.dyclassroom.com/chartjs/chartjs-how-to-create-doughnut-chart-using-data-from-mysql-mariadb-table-and-php
            if($cursor!=""){ 
                //almacena cada uno de los paises en los que hay tweets  
                $paises = array();        
                //almacena el número de tweets que hay de cada pais  
                $tweetsPorPais = array();
                foreach ($cursor as $row) {
                    $paises[] = $row->_id;
                    $tweetsPorPais[] = $row->total;
                } 
                //componemos el array que vamos a parsear
                $data = array(
                    "place" => $paises,
                    "tweets" => $tweetsPorPais 
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
    }
?>