<?php

namespace Framework\Database;

use PDO;
use stdClass;
use Pagerfanta\Pagerfanta;
use Framework\Database\PaginatedQuery;
use Framework\Exceptions\NoRecordException;

class Table
{
    private $pdo;
    protected $table;
    protected $entity;
    
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getTable() : string
    {
        return $this->table;
    }

    public function getEntity() : string
    {
        return $this->entity;
    }

    public function getPdo() : PDO
    {
        return $this->pdo;
    }

    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            "SELECT COUNT(id) FROM $this->table",
            $this->entity
        );

        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }

    protected function paginationQuery():string 
    {
        return 'SELECT * FROM '.$this->table;
    }

    public function findOrFail(string $query, array $params = [])
    {
        $query = $this->pdo
        ->prepare($query);

        $query->execute($params);

        if ($this->entity)
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        
        $data = $query->fetch();

        if ($data === false) {
            throw new NoRecordException();
        }
        return $data;
    }

    public function fetchColumn(string $query, array $params = [])
    {
        $query = $this->pdo
        ->prepare($query);

        $query->execute($params);

        if ($this->entity)
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        
        $data = $query->fetchColumn();

        if ($data === false) {
            throw new NoRecordException();
        }
        return $data;
    }


    public function findBy(string $field, string $value)
    {
        return $this->findOrFail("SELECT * FROM $this->table WHERE $field = ?", [$value]);
    }

    public function find(int $id)
    {
        return $this->findOrFail('SELECT * FROM '.$this->table.' WHERE id = ?', [$id]);
    }

    public function findAll():array
    {
        $query = $this->pdo
        ->query('SELECT * FROM '.$this->table);


        if ($this->entity)
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        
        return $query->fetchAll() ?: [];
    }


    public function update($id, array $fields):bool
    {
        $subQuery = $this->buildFieldQuery($fields);

        $fields['id'] = $id;

        $statement = $this->pdo->prepare("UPDATE $this->table SET $subQuery WHERE id = :id");
        return $statement->execute($fields);
    }

    public function create(array $fields) : bool
    {
        $keys = array_keys($fields);
        $values = array_map(function($key){
            return ":$key";
        }, $keys);
        $values = join(', ', $values);
        $keys = join(', ', $keys);

        $statement = $this->pdo
        ->prepare('INSERT INTO '.$this->table.'(' . $keys . ') VALUES (' . $values . ')');
        return $statement->execute($fields);
    }

    public function delete(int $id) : bool
    {
        $statement = $this->pdo->prepare('DELETE FROM '.$this->table.' WHERE id = ?');
        return $statement->execute([$id]);
    }

    public function findList() : array
    {
        $results = $this->pdo->query("SELECT id, name FROM $this->table")
        ->fetchAll(PDO::FETCH_NUM);

        $data = [];
        
        foreach ($results as $result){
            $data[$result[0]]= $result[1];
        }

        return $data;
    }

    public function count() : int
    {
        return $this->fetchColumn(
            "SELECT COUNT(id) FROM $this->table");
    }

    private function buildFieldQuery(array $fields) : string
    {
        return join(', ', array_map(function($field){
            return "$field = :$field";
        }, array_keys($fields)));
    }
}