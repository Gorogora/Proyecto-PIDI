<?php 

    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado ="";
        try { 
            $mongo = new MongoDB();
            $cursor = $mongo->getHashtagMasFrecuente($coleccion);
            
            /*
            $manager = new MongoDB\Driver\Manager(); 

            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$unwind' => '$hashtags'],  
                    ['$group' => ['_id' => '$hashtags', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]],
                    ['$limit' => 1] 
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $manager->executeCommand("Twitter", $command);
            */

            if($cursor!=""){             
                foreach ($cursor as $row) {
                    $resultado = $row->_id;
                }            
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