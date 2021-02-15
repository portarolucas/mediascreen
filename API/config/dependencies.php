<?php

return [
    'dbhost' => function(\Slim\Container $c) {
        $config = parse_ini_file($c->settings['dbfile']);
        return $config['host'];
    },
    
    'logger' => function(\Slim\Container $c){
        $log = new \Monolog\Logger($c->settings['log.name']);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->settings['debug.log'],$c->settings['log.level']));
        return $log;
    },

    'md2html' => function(\Slim\Container $c){
        return function (string $md){
            return \Michelf\Markdown::defaultTransform($md);
        };
    },
    'logger.error' => function(\Slim\Container $c){
        $log = new \Monolog\Logger($c->settings['error.name']);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->settings['error.log'], $c->settings['error.level']));
        return $log;
    }
];
