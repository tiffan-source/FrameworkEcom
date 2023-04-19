<?php

namespace Tests\Framework\Renderer\Twig;

use PHPUnit\Framework\TestCase;
use Framework\Renderer\Twig\TwigExtension\TextTwigExtension;

class TextTwigExtensionTest extends TestCase
{
    private $textExtension;

    public function setUp():void
    {
        $this->textExtension = new TextTwigExtension();
    }
    
    public function testExerptWithShortText(){
        $text = 'Bonjour';
        $this->assertEquals($text, $this->textExtension->excerpt($text, 10));
    }
        
    public function testExerptWithLongText(){
        $text = 'Bonjour tout le monde';
        $this->assertEquals('Bonjour...', $this->textExtension->excerpt($text, 7));
        $this->assertEquals('Bonjour...', $this->textExtension->excerpt($text, 10));
        // $this->assertEquals('Bonjour tout le...', $this->textExtension->excerpt($text, 15));
    }
}