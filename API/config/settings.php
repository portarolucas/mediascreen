<?php
return [
     'settings' => [
          'displayErrorDetails'=>true,
          'dbfile'=> __DIR__ .'/db.ini',
          'cors' => [
               "methods" => ["GET", "POST", "PUT", "OPTIONS", "DELETE"],
               "headers.allow" => ['Content-Type', 'Authorization', 'X-commande-token'],
               "headers.expose"=>[],
               "max.age"=> 60*60,
               "credentials"=> true
          ],
          'debug.log'=> __DIR__ .'/../log/debug.log',
          'log.level' => \Monolog\Logger::DEBUG,
          'log.name' =>'slim.log',
          'error.log'=> __DIR__ .'/../log/warn.log',
          'error.level' => \Monolog\Logger::WARNING,
          'error.name' =>'error.log',
          
     ]
     
];
