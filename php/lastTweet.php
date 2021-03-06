<?php
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    if( $_REQUEST['coleccion']){

        $coleccion = $_REQUEST['coleccion'];
        $resultado = "";
        try { 
            $mongo = new MongoDB();
            $rows = $mongo->getLastTweet($coleccion);

            /*
            // Conectar al servidor de MongoDB con los valores por defecto
            $manager = new MongoDB\Driver\Manager(); 
            
            //consultar el primer tweet
            $filtro = [];
            $campos = ['projection' => ['created_at' => 1, 'user' => 1, 'text' =>1],
                    'sort' => ['created_at' => -1],
                    'limit' => 1];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $manager->executeQuery("Twitter.".$coleccion, $query);
            */

            //mostrar la fecha del último tweet
            foreach ($rows as $row) {
                $fecha_hora = $row->created_at->toDateTime()->format(\DateTime::ISO8601);
                $resultado = date('d-m-Y', strtotime($fecha_hora));
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