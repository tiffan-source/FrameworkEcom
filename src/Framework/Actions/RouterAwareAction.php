<?php

namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

trait RouterAwareAction{
    public function redirect(string $path, array $params = []) : ResponseInterface
    {
        $redirect = $this->router->generateUri($path, $params);
        return (new Response())
        ->withStatus(301)
        ->withHeader('Location', $redirect);
    }
}