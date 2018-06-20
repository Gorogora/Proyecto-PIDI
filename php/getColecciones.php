<?php 
    //Llamo al modelo mongodb
    require_once '../modelo/MongoDB.php';

    $resultado = "";
    try { 
        $mongo = new MongoDB();
        $colecciones = $mongo->getcolecciones();

        /*$manager = new MongoDB\Driver\Manager(); 

        $stats = new MongoDB\Driver\Command(['listCollections' => 1]);
        // ejecutar el comando
        $colecciones = $manager->executeCommand("Twitter", $stats);
        */

        $resultado = '<option value="0">Seleccione una colección...</option>';
        foreach($colecciones as $coleccion){
            $resultado = $resultado. '<option value="' .$coleccion->name. '">' .$coleccion->name. '</option>';
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