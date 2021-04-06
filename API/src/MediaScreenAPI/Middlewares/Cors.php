<?php
namespace MediaScreenAPI\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class Cors{

    private $c;

    public function __construct(\Slim\Container $container){
        $this->c = $container;
    }

    public function checkAndAddCorsHeaders(Request $rq, Response $rs, callable $next): Response {

        if (! $rq->hasHeader('Origin'))
            return Writer::json_error($rs, 401, "missing Origin Header (cors)");

            $response = $next($rq, $rs);

            $response = $response->withHeader('Access-Control-Allow-Origin', $rq->getHeader('Origin'))
                ->withHeader('Access-Control-Allow-Methods', implode(', ', $this->c['settings']['cors']['methods']))
                ->withHeader('Access-Control-Allow-Headers', implode(', ', $this->c['settings']['cors']['headers.allow']))
                ->withHeader('Access-Control-Max-Age', $this->c['settings']['cors']['max.age']);

            if($this->c['settings']['cors']['credentials'])
                $response = $response->withHeader('Acces-Control-Allow-Credentials', 'true');

            return $response;
    }
}
