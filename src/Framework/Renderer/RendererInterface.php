<?php

namespace Framework\Renderer;

interface RendererInterface{

    public function addPath(string $path, ?string $namespace = null): void;

    public function render(string $views, array $params = []):string ;

    public function addGlobal(string $key, $value) : void;
}