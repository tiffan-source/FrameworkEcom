<?php

namespace App\Article\Tables;

use PDO;
use stdClass;
use Pagerfanta\Pagerfanta;
use Framework\Database\Table;
use App\Article\Entity\Article;
use Framework\Database\PaginatedQuery;

class CategorieTable extends Table
{
    protected $table = 'categories';

}