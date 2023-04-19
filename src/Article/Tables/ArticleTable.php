<?php

namespace App\Article\Tables;

use PDO;
use stdClass;
use Pagerfanta\Pagerfanta;
use Framework\Database\Table;
use App\Article\Entity\Article;
use Framework\Database\PaginatedQuery;

class ArticleTable extends Table
{
    protected $pdo;

    protected $table = 'articles';

    protected $entity = Article::class;

    public function findPaginatedQueryPublic(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->getPDO(),
            "SELECT a.*
            FROM articles AS a
            LEFT JOIN categories AS c 
            ON a.categorie_id = c.id",
            "SELECT COUNT(id) FROM $this->table",
            $this->entity
        );

        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }


    public function findPaginatedPublicForCategorie(int $perPage, int $currentPage, int $categorie_id): Pagerfanta
    {
        $query = new PaginatedQuery(

            $this->getPDO(),
            
            "SELECT a.*
            FROM articles AS a
            LEFT JOIN categories AS c 
            ON a.categorie_id = c.id
            WHERE a.categorie_id = :categorie_id",
            
            "SELECT COUNT(id) FROM $this->table WHERE categorie_id = :categorie_id",
            $this->entity,

            ['categorie_id' => $categorie_id]
        );

        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }

    public function findWithCategorie(int $id)
    {
        return $this->findOrFail(
            "SELECT a.*, c.name categorie_name
            FROM articles AS a
            LEFT JOIN categories AS c
            ON c.id = a.categorie_id
            WHERE a.id = ?",
            [$id]
        );
    }

    protected function paginationQuery() : string
    {
        return "SELECT a.id, a.name, c.name categorie_name
        FROM {$this->table} AS a
        LEFT JOIN categories AS c ON a.categorie_id = c.id";
    }
}