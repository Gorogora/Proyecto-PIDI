<?php 
    $resultado ="";
    try { 
        
        $manager = new MongoDB\Driver\Manager(); 

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'tweets',
            'pipeline' => [
                ['$group' => ['_id' => '$user', 'total'=> ['$sum' => 1]]],
                ['$sort' => ['total' => -1]],
                ['$limit' => 1] 
            ],
            'cursor' => new stdClass,
        ]);
        
        $cursor = $manager->executeCommand("Twitter", $command);

        if($cursor!=""){             
            foreach ($cursor as $row) {
                $resultado =  $row->_id. "<br>";
                $resultado = $resultado. "&nbsp;&nbsp;&nbsp;&nbsp;" .$row->total. " tweets";
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