<?php
return [
     'settings' => [
          'displayErrorDetails'=>true,
          'dbfile'=> __DIR__ .'/db.ini',
          'debug.log'=> __DIR__ .'/../log/debug.log',
          'log.level' => \Monolog\Logger::DEBUG,
          'log.name' =>'slim.log',
          'error.log'=> __DIR__ .'/../log/warn.log',
          'error.level' => \Monolog\Logger::WARNING,
          'error.name' =>'error.log'
     ]
     
];
