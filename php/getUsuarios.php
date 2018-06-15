<?php 
    $resultado ="";
    try { 
        
        $manager = new MongoDB\Driver\Manager(); 

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'tweets',
            'pipeline' => [
                ['$group' => ['_id' => '$user']],
                ['$sort' => ['_id' => 1]],
            ],
            'cursor' => new stdClass,
        ]);
        
        $cursor = $manager->executeCommand("Twitter", $command);

        if($cursor!=""){             
            foreach ($cursor as $row) {
                $value = substr($row->_id, 1, strln($row->_id));    //quitar la @
                $resultado = $resultado. '<option value="' .$value. '>' .$row->_id. '</option>';
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