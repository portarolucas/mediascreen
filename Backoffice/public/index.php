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
$app->get('/create/screen', PagesGetController::class . ':createScreen')->setName('createScreen');

// Route : Page de création d'un écran (POST)
$app->post('/create/screen', PagesPostController::class . ':createScreen');

// Route : Page de gestion des séquences (GET)
$app->get('/sequences', PagesGetController::class . ':sequences')->setName('sequences');

// Route : Page de gestion des écrans (GET)
$app->get('/screens', PagesGetController::class . ':screens')->setName('screens');

$app->run();