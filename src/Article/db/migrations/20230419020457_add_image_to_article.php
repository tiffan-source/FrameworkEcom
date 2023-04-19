<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddImageToArticle extends AbstractMigration
{
    
    public function change(): void
    {
        $this->table('articles')
        ->addColumn('image', 'string', ['null' => true])
        ->update();
    }
}
