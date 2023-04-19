<?php

namespace Tests\Framework;

use Twig\Environment;
use PHPUnit\Framework\TestCase;
use Twig\Loader\FilesystemLoader;
use Framework\Renderer\PHPRenderer;
use Framework\Renderer\TwigRenderer;

class TwigRendererTest extends TestCase{
    
    private $renderer;
    
    public function setUp(){
        $loader = new FilesystemLoader(__DIR__.'/Views');
        $twig = new Environment($loader);

        $this->renderer = new TwigRenderer($loader, $twig);
    }

    // public function testRenderTheRigthPath(){
    //     $this->renderer->addPath( __DIR__.'/Views', 'blog');
    //     $content = $this->renderer->render('@blog/demo');

    //     $this->assertEquals('Bonjour', $content);
    // }

    // public function testRenderTheDefaultPath(){
    //     $content = $this->renderer->render('demo');

    //     $this->assertEquals('Bonjour', $content);
    // }
    
    public function testRenderWithParams(){
        $content = $this->renderer->render('demoparams', [
            'name' => 'Marc'
        ]);

        $this->assertEquals('Salut Marc', $content);
    }


    
    // public function testRenderWithParamsGlobal(){
    //     $this->renderer->addGlobal('name', 'Marc');
    //     $content = $this->renderer->render('demoparams');

    //     $this->assertEquals('Salut Marc', $content);
    // }
}