<?php 
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado ="";
        try { 

            $mongo = new MongoDB();
            $cursor = $mongo->getIdiomas($coleccion);
            
            /*
            $manager = new MongoDB\Driver\Manager(); 

            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$language']],
                    ['$sort' => ['_id' => 1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $manager->executeCommand("Twitter", $command);
            */

            if($cursor!=""){ 
                $resultado = '<option value="0">Seleccione una idioma...</option>';
                foreach ($cursor as $row) {
                    /* Comprobar que language != und. Esto significa que no sé 
                    conoce el idioma*/
                    if(strcmp($row->_id, "und") != 0){  
                        $resultado = $resultado. '<option value="' .$row->_id. '">' .$row->_id. '</option>';
                    }
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