<?php 
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado ="";
        try { 
            
            $mongo = new MongoDB();
            $cursor = $mongo->getMinutoMasCaliente($coleccion);

            /*
            $manager = new MongoDB\Driver\Manager(); 

            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$project' => [
                        'hour' => ['$hour' => '$created_at'],
                        'minute' => ['$minute' => '$created_at'],
                        'tweet' => 1
                        ]
                    ],
                    ['$group' => [
                        '_id' => [
                            'hour' => '$hour',
                            'minute' => '$minute'
                        ], 
                        'total' => ['$sum' => 1]]],
                    ['$sort'=>['total'=>-1]],
                    ['$limit'=>5]
                    ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $manager->executeCommand("Twitter", $command);
            */
            
            if($cursor!=""){ 
                $hora = array();
                $tweets = array();
                foreach ($cursor as $row) {
                    $hora[] = $row->_id->hour .":". $row->_id->minute;
                    $tweets[] = $row->total;
                }
                
                $data = array(
                    "hora" => $hora,   //array con los minutos con más tweets
                    "tweets" => $tweets   // array con el total de tweets
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