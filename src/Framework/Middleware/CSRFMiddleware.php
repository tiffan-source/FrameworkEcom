<?php

namespace Framework\Middleware;

use Exception;
use TypeError;
use ArrayAccess;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CSRFMiddleware implements MiddlewareInterface {

    private $keyName;
    private $sessionKey;
    private $session;
    private $limit;
    
    public function __construct(
        $session,
        string $keyName = '_csrf',
        string $sessionKey = 'csrf',
        int $limit = 50){

        $this->validSession($session);

        $this->session = $session;
        $this->keyName = $keyName;
        $this->sessionKey = $sessionKey;
        $this->limit = $limit;
    }

    public function getKeyName()
    {
        return $this->keyName;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface
    {
        if(!in_array($request->getMethod(), ['POST', 'PUT', 'DELETE']))
            return $next->handle($request);

        $params = $request->getParsedBody();

        if(is_null($params) || !array_key_exists($this->keyName, $params))
            throw new Exception("No key");

        if(in_array($params[$this->keyName], $this->session[$this->sessionKey] ?? []))
        {
            $this->useToken($params[$this->keyName]);
            return $next->handle($request);
        }
        
        throw new Exception("No key");

    }

    public function generateToken() : string 
    {
        $token = bin2hex(random_bytes(16));

        $list = $this->session[$this->sessionKey] ?? [];

        $list[] = $token;

        $this->session[$this->sessionKey] = $list;

        $this->limitNumberToken();

        return $token;
    }
    
    private function useToken($token) : void
    {
        $lists = $this->session[$this->sessionKey];

        $this->session[$this->sessionKey] = array_filter($lists, function($key) use ($token) {
            return $token !== $key;
        });
    }

    private function limitNumberToken() : void
    {
        $list = $this->session[$this->sessionKey] ?? [];
        if(count($list) > $this->limit)
            array_shift($list);

        $this->session[$this->sessionKey] = $list;
    }

    private function validSession($session)
    {
        if(!is_array($session) && !($session instanceof ArrayAccess))
            throw new TypeError('Session invalid');
    }

    public function getSession(){
        return $this->session;
    }
}