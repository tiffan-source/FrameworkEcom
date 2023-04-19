<?php
namespace Tests\Framework\Database;

class Demo {
    private $name;

    /**
     * Get the value of slug
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setName($slug)
    {
        $this->name = $slug . 'demo';

        return $this;
    }
}