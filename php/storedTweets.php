<?php 
    try { 

        $manager = new MongoDB\Driver\Manager(); 

        $stats = new MongoDB\Driver\Command(["dbstats" => 1]);
        // ejecutar el comando dbstats que devuelve información sobre la base de datos
        $res = $manager->executeCommand("Twitter", $stats);

        $stats = current($res->toArray());
        echo $stats->objects;    

        /*
        print_r($stats);
        stdClass Object ( [db] => Twitter [collections] => 1 [views] => 0 [objects] => 86 [avgObjSize] => 301.74418604651 [dataSize] => 25950 [storageSize] => 28672 [numExtents] => 0 [indexes] => 1 [indexSize] => 16384 [fsUsedSize] => 148396494848 [fsTotalSize] => 192268988416 [ok] => 1 ) 
        */
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