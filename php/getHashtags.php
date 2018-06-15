<?php 
    $resultado ="";
    try { 
        
        $manager = new MongoDB\Driver\Manager(); 

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'tweets',
            'pipeline' => [
                ['$unwind' => '$hashtags'],  //comprobar que sea un array!!! https://docs.mongodb.com/manual/reference/operator/aggregation/unwind/
                ['$group' => ['_id' => '$hashtags']],
                ['$sort' => ['_id' => 1]]
            ],
            'cursor' => new stdClass,
        ]);
        
        $cursor = $manager->executeCommand("Twitter", $command);

        if($cursor!=""){ 
            foreach ($cursor as $row) {
                    $resultado = $resultado. '<option value="' .$row->_id. '>' .$row->_id. '</option>';
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
?>