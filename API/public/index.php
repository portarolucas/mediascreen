<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use MediaScreenAPI\Controller\Controller as API;

require_once '../vendor/autoload.php';

$config = parse_ini_file('../config/db.ini');
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$debug = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$d = new \Slim\Container($debug);
$app = new \Slim\App($d);

$app->get('/sequences', function(Request $req, Response $resp, $args) {
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getSequences());
    return $response;
});

$app->get('/sequence/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getSequence($id));
    return $response;
});

$app->get('/ecrans', function(Request $req, Response $resp, $args) {
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcrans());
    return $response;
});

$app->get('/ecrans/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcransSequence($id));
    return $response;
});

$app->get('/ecran/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcran($id));
    return $response;
});

$app->run();