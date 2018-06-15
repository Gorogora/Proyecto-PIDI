<?php 
    $resultado = "";
    try { 

        http://php.net/manual/es/mongodb.getcollectionnames.php
        $manager = new MongoDB\Driver\Manager(); 

        $stats = new MongoDB\Driver\Command(['getCollectionNames' => 1]);
        // ejecutar el comando
        $colecciones = $manager->executeCommand("Twitter", $stats);

        
        for($colecciones as $nombreColeccion){
            $resultado = $resultado. '<option value="' .$nombreColeccion. '>' .$nombreColeccion. '</option>';
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