<?php 
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado = 0;
        try { 

            $mongo = new MongoDB();
            $rows = $mongo->getStoredTweets($coleccion);

            /*$manager = new MongoDB\Driver\Manager(); 

            $filtro = [];
            $campos = ["projection" => ['_id' => 1]];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $manager->executeQuery("Twitter.".$coleccion, $query);
            */
            
            foreach($rows as $row){
                $resultado = $resultado + 1;
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