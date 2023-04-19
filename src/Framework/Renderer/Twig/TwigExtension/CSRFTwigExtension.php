<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Framework\Middleware\CSRFMiddleware;

class CSRFTwigExtension extends AbstractExtension
{
    private $csrf;

    public function __construct(CSRFMiddleware $csrf)
    {
        $this->csrf = $csrf;
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('csrf_input', [$this, 'csrf_input'], ['is_safe' => ['html']])
        ];
    }

    public function csrf_input() : string
    {
        return "<input type=\"hidden\" name=\"{$this->csrf->getKeyName()}\" value=\"{$this->csrf->generateToken()}\">";
    }
}