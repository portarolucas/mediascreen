<?php
require_once '../vendor/autoload.php';

use App\Controllers\PagesGetController;
use App\Controllers\PagesPostController;

session_start();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require '../app/container.php';
require '../app/database.php';

$container = $app->getContainer();

// Middlewares
$app->add(new \App\Middlewares\FlashMiddleware($container->view->getEnvironment()));

// Route : Page d'accueil (GET)
$app->get('/', PagesGetController::class . ':home')->setName('home');

// Route : Page de connexion (GET)
$app->get('/login', PagesGetController::class . ':login')->setName('login');

// Route : Page de création d'une séquence (GET)
$app->get('/create/sequence', PagesGetController::class . ':createSequence')->setName('createSequence');

// Route : Page de création d'une séquence (POST)
$app->post('/create/sequence', PagesPostController::class . ':createSequence');

// Route : Page de création d'un écran (GET)
$app->get('/create/screen/{id}', PagesGetController::class . ':createScreen')->setName('createScreen');

// Route : Page de création d'un écran (POST)
$app->post('/create/screen/{id}', PagesPostController::class . ':createScreen');

// Route : Page de gestion des séquences (GET)
$app->get('/sequences', PagesGetController::class . ':sequences')->setName('sequences');

// Route : Page de gestion des écrans (GET)
$app->get('/screens/{id}', PagesGetController::class . ':screens')->setName('screens');

// Route : Suppression d'un écran (POST)
$app->post('/screen/delete', PagesPostController::class . ':screenDelete')->setName('screenDelete');

// Route : Modification d'un écran (POST)
$app->post('/screen/update', PagesPostController::class . ':screenUpdate')->setName('screenUpdate');

// Route : Suppression d'une séquence (POST)
$app->post('/sequence/delete', PagesPostController::class . ':sequenceDelete')->setName('sequenceDelete');

// Route : Modification d'une séquence (POST)
$app->post('/sequence/update', PagesPostController::class . ':sequenceUpdate')->setName('sequenceUpdate');

$app->run();