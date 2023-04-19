<?php

namespace Framework\Renderer\Twig\TwigExtension;

use DateTime;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TimeTwigExtension extends AbstractExtension {
    public function getFilters() : array
    {
        return [
            new TwigFilter('ago', [$this, 'ago'], ['is_safe' => ['html']])
        ];
    }

    public function ago(DateTime $date, string $format = 'd/m/Y H:i')
    {
        return '<span class="need_to_be_rendered" datetime="' .
        $date->format(DateTime::ISO8601) . 
        '">' .
        $date->format($format) .
        '</span>';
    }
}