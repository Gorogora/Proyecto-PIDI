<?php
    class MongoDB {
        private $db_name, $manager;
    
        //permite crear la conexion con la base de datos
        public function __construct() {
            $this->db_name = "Twitter";
            $this->manager = new MongoDB\Driver\Manager();
        }

        //devuelve un listado de todas las colecciones
        public function getcolecciones(){
            $stats = new MongoDB\Driver\Command(['listCollections' => 1]);
            // ejecutar el comando
            $colecciones = $this->manager->executeCommand($this->db_name, $stats);
            
            return $colecciones;
        }

        public function getStoredTweets($coleccion){
            $filtro = [];
            $campos = ["projection" => ['_id' => 1]];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $this->manager->executeQuery($this->db_name.".".$coleccion, $query);

            return $rows;
        }

        public function getFirstTweet($coleccion){
            $filtro = [];
            $campos = ['projection' => ['created_at' => 1, 'user' => 1, 'text' =>1],
                    'sort' => ['created_at' => 1],
                    'limit' => 1];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $this->manager->executeQuery($this->db_name.".".$coleccion, $query);

            return $rows;
        }

        public function getLastTweet($coleccion){
            $filtro = [];
            $campos = ['projection' => ['created_at' => 1, 'user' => 1, 'text' =>1],
                    'sort' => ['created_at' => -1],
                    'limit' => 1];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $this->manager->executeQuery($this->db_name.".".$coleccion, $query);

            return $rows;
        }

        public function getHashtags($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$unwind' => '$hashtags'],  
                    ['$group' => ['_id' => '$hashtags']],
                    ['$sort' => ['_id' => 1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getIdiomas($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$language']],
                    ['$sort' => ['_id' => 1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getLugares($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$place']],
                    ['$sort' => ['_id' => 1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getUsuarios($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$user']],
                    ['$sort' => ['_id' => 1]],
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getHashtagMasFrecuente($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$unwind' => '$hashtags'],  
                    ['$group' => ['_id' => '$hashtags', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]],
                    ['$limit' => 1] 
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getIdiomasTweets($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$language', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getLugaresTweets($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$place', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]]
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getMinutoMasCaliente($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$project' => [
                        'hour' => ['$hour' => '$created_at'],
                        'minute' => ['$minute' => '$created_at'],
                        'tweet' => 1
                        ]
                    ],
                    ['$group' => [
                        '_id' => [
                            'hour' => '$hour',
                            'minute' => '$minute'
                        ], 
                        'total' => ['$sum' => 1]]],
                    ['$sort'=>['total'=>-1]],
                    ['$limit'=>5]
                    ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getTweetMasRetwitteado($coleccion){
            $filtro = [ "isRetweet" => ['$eq' => 0]];   //que sea un tweet y no un retweet
            $campos = ['projection' => ['retweets' => 1, 'text' => 1, 'user' => 1],
                    'sort' => ['retweets' => -1],
                    'limit' => 1,];
            $query = new MongoDB\Driver\Query($filtro, $campos);
            $rows = $this->manager->executeQuery($this->db_name.".".$coleccion, $query);

            return $rows;
        }

        public function getUsuarioConMasTweet($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$group' => ['_id' => '$user', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]],
                    ['$limit' => 1] 
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }

        public function getUsuariosMasMencionados($coleccion){
            $command = new MongoDB\Driver\Command([
                'aggregate' => $coleccion,
                'pipeline' => [
                    ['$unwind' => '$usersMentioned'],  //comprobar que sea un array!!! https://docs.mongodb.com/manual/reference/operator/aggregation/unwind/
                    ['$group' => ['_id' => '$usersMentioned', 'total'=> ['$sum' => 1]]],
                    ['$sort' => ['total' => -1]],
                    ['$limit' => 3] 
                ],
                'cursor' => new stdClass,
            ]);
            
            $cursor = $this->manager->executeCommand($this->db_name, $command);

            return $cursor;
        }
    }

?>