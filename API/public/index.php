<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use MediaScreenAPI\Controller\Controller as API;

require_once '../vendor/autoload.php';

// Chargement de la base de données
$config = parse_ini_file('../config/db.ini');
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();


// Slim en mode debug pour afficher le détail des erreurs
// A désactiver en production !
$debug = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$d = new \Slim\Container($debug);
$app = new \Slim\App($d);


// Route : récupérations de toutes les séquences
$app->get('/sequences', function(Request $req, Response $resp, $args) {
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getSequences());
    return $response;
});

// Route : récupération d'une séquence à partir de son ID
$app->get('/sequence/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getSequence($id));
    return $response;
});

// Route : récupérations de tous les écrans
$app->get('/ecrans', function(Request $req, Response $resp, $args) {
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcrans());
    return $response;
});

// Route : récupérations de tous les écrans appartenant à une même séquence à partir de l'ID de celle-ci
$app->get('/ecrans/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcransSequence($id));
    return $response;
});

// Route : récupérations d'un écran à partir de son ID
$app->get('/ecran/{id}', function(Request $req, Response $resp, $args) {
    $id = $args['id'];
    $response = $resp->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(API::getEcran($id));
    return $response;
});

$app->run();