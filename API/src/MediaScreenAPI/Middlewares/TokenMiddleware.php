<?php
namespace MediaScreenAPI\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use MediaScreenAPI\Models\Dispositif;

class TokenMiddleware {

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next) {
        $token = $request->getParam('token');
        if(empty($token)) {
            $resp = $response->withHeader('Content-Type', 'application/json');
            $resp->getBody()->write(json_encode(['error' => 'missing token']));
            return $resp;
        } else {
            $exist = Dispositif::where('token', $token)->count();
            if(!$exist) {
                $resp = $response->withHeader('Content-Type', 'application/json');
                $resp->getBody()->write(json_encode(['error' => 'invalid token']));
                return $resp;
            }
        }

        return $next($request, $response);
    }

}