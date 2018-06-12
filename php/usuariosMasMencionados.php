<?php 
    $resultado ="";
    try { 
        
        $manager = new MongoDB\Driver\Manager(); 

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'tweets',
            'pipeline' => [
                ['$unwind' => $usersMentioned],  //comprobar que sea un array!!! https://docs.mongodb.com/manual/reference/operator/aggregation/unwind/
                ['$group' => ['_id' => '$usersMentioned', 'total'=> ['$sum' => 1]]],
                ['$sort' => ['total' => -1]],
                ['$limit' => 3] 
            ],
            'cursor' => new stdClass,
        ]);
        
        $cursor = $manager->executeCommand("Twitter", $command);

        if($cursor!=""){             
            foreach ($cursor as $row) {
                //comprobar si saca el id o el nombre
                $resultado = $resultado. "<li>@" .$row->_id. "      " .$row->total. "</li>";
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