<?php
namespace App\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\Auth\AuthController;

class AuthMiddleware {

    public function __construct(Container $container)
    {
        $this->container = $container;   
    }

    public function __invoke(Request $request, Response $response, $next) {
        if(!AuthController::isLogged()) {
            return $response->withStatus(200)->withHeader('Location', $this->container->router->pathFor('login'));
        }

        return $next($request, $response);
    }

}