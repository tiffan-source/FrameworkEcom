<?php

namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Renderer\PHPRenderer;

class PHPRendererTest extends TestCase{
    
    private $renderer;
    
    public function setUp():void{
        $this->renderer = new PHPRenderer(__DIR__.'/Views');
    }

    public function testRenderTheRigthPath(){
        $this->renderer->addPath( __DIR__.'/Views', 'blog');
        $content = $this->renderer->render('@blog/demo');

        $this->assertEquals('Bonjour', $content);
    }

    public function testRenderTheDefaultPath(){
        $content = $this->renderer->render('demo');

        $this->assertEquals('Bonjour', $content);
    }
    
    public function testRenderWithParams(){
        $content = $this->renderer->render('demoparams', [
            'name' => 'Marc'
        ]);

        $this->assertEquals('Salut Marc', $content);
    }


    
    public function testRenderWithParamsGlobal(){
        $this->renderer->addGlobal('name', 'Marc');
        $content = $this->renderer->render('demoparams');

        $this->assertEquals('Salut Marc', $content);
    }
}