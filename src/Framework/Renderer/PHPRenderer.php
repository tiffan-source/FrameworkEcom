<?php

namespace Framework\Renderer;

class PHPRenderer  implements RendererInterface{

    const DEFAULT_NAMESPACE = '__MAIN__';

    private $paths = [];
    private $globals = [];

    public function __construct(?string $defaultPath = null){
        if($defaultPath)
            $this->addPath($defaultPath);
    }

    public function addPath(string $path, ?string $namespace = null): void{
        if($namespace)
            $this->paths[$namespace] = $path;
        else
            $this->paths[self::DEFAULT_NAMESPACE] = $path;
    }

    public function render(string $views, array $params = []):string{
        $path = '';

        if($this->hasNamespace($views))
            $path = $this->replaceNamespace($views) . '.php';
        else{
            $path = $this->paths[self::DEFAULT_NAMESPACE];
            $path .= DIRECTORY_SEPARATOR . $views . '.php';
        }

        ob_start();

        extract($this->globals);
        extract($params);
        $render = $this;
        require($path);

        return ob_get_clean();
    }

    private function hasNamespace(string $views) : bool{
        return $views[0] === '@';
    }

    private function getNamespace(string $views) : string{
        return substr($views, 1, strpos($views, '/') - 1);
    }

    private function replaceNamespace(string $views) : string{
        $namespace = $this->getNamespace($views);
        return str_replace('@'.$namespace, $this->paths[$namespace], $views);
    }

    public function addGlobal(string $key, $value) : void{
        $this->globals[$key] = $value;
    }
}