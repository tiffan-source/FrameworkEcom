<?php

namespace Tests\Framework\Renderer\Twig;

use DateTime;
use PHPUnit\Framework\TestCase;
use Framework\Renderer\Twig\TwigExtension\TimeTwigExtension;

class TimeTwigExtensionTest extends TestCase
{
    private $timeExtension;

    public function setUp():void
    {
        $this->timeExtension = new TimeTwigExtension();
    }

    public function testDateFormat()
    {
        $date = new DateTime();
        $format = 'd/m/Y H:i';

        $result = '<span class="need_to_be_rendered" datetime="' .
            $date->format(DateTime::ISO8601) . 
            '">' .
            $date->format($format) .
            '</span>';
            
        $this->assertEquals($result, $this->timeExtension->ago($date));
    }
    
}