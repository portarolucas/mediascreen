<?php

require_once '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use MediaScreenAPI\Controller\Controller as API;
use MediaScreenAPI\Middlewares\TokenMiddleware;


$settings       = require_once __DIR__ .'/../config/settings.php';
$dependencies   = require_once __DIR__ .'/../config/dependencies.php';
$errors         = require_once __DIR__ .'/../config/errors.php';
 
// Chargement de la base de données
$config = parse_ini_file($settings['settings']['dbfile']);
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$c = new \Slim\Container(array_merge($settings, $dependencies, $errors));
$app = new \Slim\App($c);


$app->add(MediaScreenAPI\Middlewares\Cors::class . ':checkAndAddCorsHeaders');

$app->options('/{routes:.+}', function(Request $rq, Response $rs, array $args) {
    return $rs;
});

$app->group('', function() {
    // Route : récupérations de toutes les séquences
    $this->get('/sequences', function(Request $req, Response $resp, $args) {
        $response = $resp->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(API::getSequences());
        return $response;
    });

    // Route : récupération d'une séquence à partir de son ID
    $this->get('/sequence/{id}', function(Request $req, Response $resp, $args) {
        $id = $args['id'];
        $response = $resp->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(API::getSequence($id));
        return $response;
    });

    // Route : récupérations de tous les écrans
    $this->get('/ecrans', function(Request $req, Response $resp, $args) {
        $response = $resp->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(API::getEcrans());
        return $response;
    });

    // Route : récupérations de tous les écrans appartenant à une même séquence à partir de l'ID de celle-ci
    $this->get('/ecrans/{id}', function(Request $req, Response $resp, $args) {
        $id = $args['id'];
        $response = $resp->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(API::getEcransSequence($id));
        return $response;
    });

    // Route : récupérations d'un écran à partir de son ID
    $this->get('/ecran/{id}', function(Request $req, Response $resp, $args) {
        $id = $args['id'];
        $response = $resp->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(API::getEcran($id));
        return $response;
    });
})->add(new TokenMiddleware($c));

// Route : récupération des écrans de la séquence associée au token
$app->get('/get/{token}', function(Request $req, Response $resp, $args) {
    $token = $args['token'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcransToken($token));
    return $response;
});

$app->run();