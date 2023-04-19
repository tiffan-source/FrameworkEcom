<?php

namespace Tests\Framework\Renderer\Twig;

use PHPUnit\Framework\TestCase;
use Framework\Renderer\Twig\TwigExtension\FormTwigExtension;

class FormTwigExtensionTest extends TestCase {
    
    private $formExtension;
    
    public function setUp():void
    {
        $this->formExtension = new FormTwigExtension();
    }


    private function trim(string $string): string
    {  
        $lines = explode("\n", $string);
        $lines = array_map('trim', $lines);
        return implode('', $lines);

    }

    private function assertSimilar(string $expect, string $actual)
    {
        $this->assertEquals(
            $this->trim($expect),
            $this->trim($actual));
    }

    public function testInput()
    {
        $html = $this->formExtension->field([], 'name', 'demo', 'Titre');

        $this->assertSimilar('
        <div>
            <label for="name">Titre</label>
            <input type="text" name="name" id="name" value="demo">
        </div>
        ', $html);
    }


    public function testArea()
    {
        $html = $this->formExtension->field([], 'name', 'demo', 'Titre', [
            'type' => 'textarea'
        ]);

        $this->assertSimilar('
        <div>
            <label for="name">Titre</label>
            <textarea type="text" name="name" id="name">
                demo
            </textarea>
        </div>
        ', $html);
    }


    public function testFieldWithError()
    {
        $html = $this->formExtension->field(['errors'=>['name' => 'Erreur']], 'name', 'demo', 'Titre');

        $this->assertSimilar('
        <div>
            <label for="name">Titre</label>
            <input type="text" name="name" id="name" value="demo">
            <small class="text-red-600">Erreur</small>
        </div>
        ', $html);
    }

    public function testSelect()
    {
        $html = $this->formExtension->field([], 'name', 2, 'Titre', ['options'=>[
            '1' => 'a1',
            '2' => 'a2',
            '3' => 'a3',
        ]]);

        $this->assertSimilar('
        <div>
            <label for="name">Titre</label>
            <select name="name" id="name">
                <option value="1">a1</option>
                <option value="2" selected>a2</option>
                <option value="3">a3</option>
            </select>
        </div>
        ', $html);
    }
}

