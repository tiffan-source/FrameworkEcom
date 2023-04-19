<?php

namespace Framework\Validator;

use DateTime;
use Framework\Database\Table;
use Framework\Validator\ValidationError;

class Validator
{
    private $params;
    private $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function required(string ...$keys):self {
        foreach($keys as $key)
        {
            if(!array_key_exists($key, $this->params)){
                $this->addErrors($key, 'required');
            }
        }

        return $this;
    }

    public function slug(string ... $keys):self
    {
        $pattern = '/^[a-zA-Z0-9\-]+$/';
        foreach($keys as $key)
        {
            if(array_key_exists($key, $this->params) && !preg_match($pattern, $this->params[$key])){
                $this->addErrors($key, 'slug');
            }
        }

        return $this;
    }

    public function notEmpty(string ...$keys){
        foreach($keys as $key)
        {
            if(array_key_exists($key, $this->params) && empty($this->params[$key])){
                $this->addErrors($key, 'empty');
            }
        }

        return $this;
    }

    public function length(string $key, int $min, ?int $max = null): self
    {
        $l = mb_strlen($this->params[$key]);
        if($l <= $min || (!is_null($max) && $l >= $max))
        {
            $this->addErrors($key, 'length');
        }
        return $this;
    }

    public function dateTime(string $key, string $format = 'Y-m-d H:i:s'):self
    {
        if(array_key_exists($key, $this->params)){
            $date = DateTime::createFromFormat($format, $this->params[$key]);
            $errors = DateTime::getLastErrors();
            if($errors['error_count'] > 0 || $errors['warning_count'] > 0)
                $this->addErrors($key, 'datetime');
        }
        return $this;
    }


    public function exist(string $key, Table $table) : self
    {
        if(is_null($table->find($this->params[$key])))
        {
            $this->addErrors($key, 'exist');
        }

        return $this;
    }

    private function addErrors(string $key, string $rule)
    {
        $this->errors[$key] = new ValidationError($key, $rule);
    }

    public function getErrors():array
    {
        return $this->errors;
    }

    public function isValid() : bool
    {
        return empty($this->errors);
    }

}