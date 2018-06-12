<?php
    try { 
        // Conectar al servidor de MongoDB con los valores por defecto
        $manager = new MongoDB\Driver\Manager(); 
        echo "<p>Se ha realizado la conexión con éxito</p>";        
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