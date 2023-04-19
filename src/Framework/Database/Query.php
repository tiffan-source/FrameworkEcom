<?php
namespace Framework\Database;

use PDO;
use Iterator;
use Exception;
use ArrayAccess;
use Framework\Database\QueryResult;

class Query{

    private $select;
    private $from;
    private $where;
    private $entity;
    private $pdo;
    private $params;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function from(string $table, ?string $alias = null): self
    {
        if(is_null($alias))
            $this->from = [$table];
        else
            $this->from = [$table, $alias];

        return $this;
    }

    public function select(string ...$fields):self
    {
        $this->select = $fields;
        return $this;
    }

    public function where($condition) : self
    {
        if(is_null($this->where))
            $this->where = ["($condition)"];
        else
            $this->where[] = "($condition)";

        return $this;
    }

    public function count() : int
    {
        $this->select("id");
        $data = $this->execute()->fetchAll();
        var_dump($data);die();
        return $data;
    }

    private function execute(){
        $query = $this->__toString();

        if($this->params)
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($this->params);
            return $statement;
        }
        return $this->pdo->query(
            $query
        );
    }

    public function params(array $params):self
    {
        $this->params = $params;
        return $this;
    }

    public function __toString()
    {
        $parts = ['SELECT'];

        if (is_null($this->select)) {
            $parts[] = '*';
        } else {
            $parts[] = join(', ', $this->select);
        }

        $parts[] = 'FROM';

        $parts[] = join(' AS ', $this->from);

        if($this->where)
        {
            $parts[] = 'WHERE';
            $parts[] = join(' AND ', $this->where);
        }

        return join(' ', $parts);
    }

    public function into(string $entity):self
    {
        $this->entity = $entity;
        return $this;
    }

    public function all():QueryResult
    {
        return new QueryResult(
            $this->execute()->fetchAll(PDO::FETCH_ASSOC),
            $this->entity
        );
    }

}