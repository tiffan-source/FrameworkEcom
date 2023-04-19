<?php

namespace App\Article;

use App\Admin\AdminWidgetInterface;
use App\Article\Tables\ArticleTable;
use Framework\Renderer\RendererInterface;

class ArticleWidget implements AdminWidgetInterface
{
    private $renderer;
    private $articleTable;

    public function __construct(
        RendererInterface $renderer,
        ArticleTable $articleTable)
    {
        $this->renderer= $renderer;
        $this->articleTable = $articleTable;
    }

    public function render() : string
    {
        $count = $this->articleTable->count();
        return $this->renderer->render('@article/admin/articleWidget', compact('count'));
    }

    public function renderMenu(): string
    {
        return $this->renderer->render('@article/admin/articleMenu');
    }
}