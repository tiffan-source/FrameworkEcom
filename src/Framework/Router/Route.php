<?php

namespace Framework\Router;

class Route{

    private $name;
    private $callback;
    private $parameters;

    public function __construct(string $name, callable $callback, array $parameters){
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    public function getName() : string{
        return $this->name;
    }

    public function getCallback(){
        return $this->callback;
    }

    public function getParameters(): array{
        return $this->parameters;
    }
}