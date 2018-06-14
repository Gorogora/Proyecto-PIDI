<?php
    $resultado = "";
    try { 
        // Conectar al servidor de MongoDB con los valores por defecto
        $manager = new MongoDB\Driver\Manager(); 
        
        //consultar el tweet más retwweteado
        $filtro = [ "isRetweet" => ['$eq' => 0]];   //que sea un tweet y no un retweet
        $campos = ['projection' => ['retweets' => 1, 'text' => 1, 'user' => 1],
                   'sort' => ['retweets' => -1],
                   'limit' => 1,];
        $query = new MongoDB\Driver\Query($filtro, $campos);
        $rows = $manager->executeQuery("Twitter.tweets", $query);

        //mostrar la fecha del primer tweet
        foreach ($rows as $row) {
            $resultado = "<p><b>" .$row->user. "</b></p>";
            $resultado = $resultado. "<p>" .$row->text. "</p>";     
            $resultado = $resultado. '<small><i class="fa fa-retweet"></i> ' .$row->retweets. ' veces</small>';
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