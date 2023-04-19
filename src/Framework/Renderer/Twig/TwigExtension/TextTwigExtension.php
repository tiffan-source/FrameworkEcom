<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class  TextTwigExtension extends AbstractExtension
{
    public function getFilters() : array
    {
        return [
            new TwigFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    public function excerpt(?string $content, $maxLength = 10) : string
    {
        if(is_null($content)){
            return '';
        }

        if(mb_strlen($content) > $maxLength){
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            // var_dump($lastSpace);die();
            if($lastSpace)
                return mb_substr($excerpt, 0, $lastSpace) . '...';
            return $excerpt . '...';
        }
        return $content;
    }
}