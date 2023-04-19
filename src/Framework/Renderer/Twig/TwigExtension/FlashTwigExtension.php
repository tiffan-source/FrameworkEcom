<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Twig\TwigFunction;
use Framework\Session\FlashService;
use Twig\Extension\AbstractExtension;

class FlashTwigExtension extends AbstractExtension{

    private $flashService;

    public function __construct(FlashService $flashService){
        $this->flashService = $flashService;
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('flash', [$this, 'getFlash'])
        ];
    }

    public function getFlash(string $type) : ?string
    {
        return $this->flashService->get($type);
    }
}