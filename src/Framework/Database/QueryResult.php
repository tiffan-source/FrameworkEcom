<?php
namespace Framework\Database;

use ArrayAccess;
use Exception;
use Iterator;
use PDO;

class QueryResult implements ArrayAccess, Iterator{

    private $records;
    private $index = 0;
    private $hydratedRecord = [];
    private $entity;


    public function __construct(array $records, string $entity)
    {
        $this->records = $records;
        $this->entity = $entity;
    }


    public function current(){
        return $this->get($this->index);
    }

    public function next():void
    {
        $this->index++;
    }

    public function key()
    {
        return $this->key();
    }

    public function valid(): bool
    {
        return isset($this->records[$this->index]);
    }

    public function rewind():void
    {
        $this->index = 0;
    }

    public function offsetExists($offset):bool
    {
        return isset($this->records[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new Exception("Can not set value on entity");
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new Exception("Can not set value on entity");        
    }

    public function get(int $index)
    {
        if($this->entity){
            if(!isset($this->hydratedRecord[$index]))
                $this->hydratedRecord[$index] = Hydrator::hydrate($this->records[$index], $this->entity);
            return $this->hydratedRecord[$index];
        }
        else
            return $this->records[$index];
    }

}