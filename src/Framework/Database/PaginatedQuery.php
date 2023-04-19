<?php

namespace Framework\Database;

use PDO;
use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface{
    private $pdo;
    private $query;
    private $countQuery;
    private $entity;
    private $params;

    public function __construct(PDO $pdo, string $query, string $countQuery, ?string $entity, array $params = []){
        $this->pdo = $pdo;
        $this->query=$query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
        $this->params = $params;
    }

    public function getNbResults(): int
    {
        if(!empty($this->params))
        {
            $query = $this->pdo->prepare($this->countQuery);
            foreach ($this->params as $key => $param)
            {
                $query->bindParam($key, $param);
            }

            $query->execute();
            return $query->fetchColumn();
        }
    
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice(int $offset, int $length): iterable
    {
        $query = $this->pdo->prepare($this->query.' LIMIT :offset, :length');

        foreach ($this->params as $key => $param)
        {
            $query->bindParam($key, $param);
        }
    
        $query->bindParam('offset', $offset, PDO::PARAM_INT);
        $query->bindParam('length', $length, PDO::PARAM_INT);
        $query->execute();

        if($this->entity)
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);

        return $query->fetchAll();
    }
}