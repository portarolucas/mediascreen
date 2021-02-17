<?php
require_once '../vendor/autoload.php';

use App\Controllers\PagesGetController;
use App\Controllers\PagesPostController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

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

// Routes : utilisateur non connecté
$app->group('', function() {
    // Route : Page de connexion (GET)
    $this->get('/login', PagesGetController::class . ':login')->setName('login');

    // Route : Page de connexion (POST)
    $this->post('/login', PagesPostController::class . ':login');
})->add(new GuestMiddleware($container));

// Routes : utilisateur connecté
$app->group('', function() {
    // Route : Page d'accueil (GET)
    $this->get('/', PagesGetController::class . ':home')->setName('home');

    // Route : Page de création d'une séquence (GET)
    $this->get('/create/sequence', PagesGetController::class . ':createSequence')->setName('createSequence');

    // Route : Page de création d'une séquence (POST)
    $this->post('/create/sequence', PagesPostController::class . ':createSequence');

    // Route : Page de création d'un écran (GET)
    $this->get('/create/screen/{id}', PagesGetController::class . ':createScreen')->setName('createScreen');

    // Route : Page de création d'un écran (POST)
    $this->post('/create/screen/{id}', PagesPostController::class . ':createScreen');

    // Route : Page de gestion des séquences (GET)
    $this->get('/sequences', PagesGetController::class . ':sequences')->setName('sequences');

    // Route : Page de gestion des écrans (GET)
    $this->get('/screens/{id}', PagesGetController::class . ':screens')->setName('screens');

    // Route : Suppression d'un écran (POST)
    $this->post('/screen/delete', PagesPostController::class . ':screenDelete')->setName('screenDelete');

    // Route : Modification d'un écran (POST)
    $this->post('/screen/update', PagesPostController::class . ':screenUpdate')->setName('screenUpdate');

    // Route : Suppression d'une séquence (POST)
    $this->post('/sequence/delete', PagesPostController::class . ':sequenceDelete')->setName('sequenceDelete');

    // Route : Modification d'une séquence (POST)
    $this->post('/sequence/update', PagesPostController::class . ':sequenceUpdate')->setName('sequenceUpdate'); 

    // Route : Page de profil (GET)
    $this->get('/profile', PagesGetController::class . ':profile')->setName('profile');

    // Route : Page de profil (POST)
    $this->post('/profile', PagesPostController::class . ':profile');

    // Route : Page de déconnexion (GET)
    $this->get('/logout', PagesGetController::class . ':logout')->setName('logout');

    // Route : Page de création d'un utilisateur (GET)
    $this->get('/create/user', PagesGetController::class . ':createUser')->setName('createUser');

    // Route : Page de création d'un utilisateur (POST)
    $this->post('/create/user', PagesPostController::class . ':createUser');

})->add(new AuthMiddleware($container));

$app->run();