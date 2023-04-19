<?php

namespace Framework\Validator;

class ValidationError
{
    private $key;
    private $rule;

    private $message = [
        'required' => 'Le champ %s est requis',
        'empty' => 'Le champ %s ne peut etre vide',
        'slug' => 'Le champ %s n\'est pas un slug',
        'exist' => 'La valeur de %s n\'existe pas'
    ];

    public function __construct(string $key, string $rule)
    {
        $this->key = $key;
        $this->rule = $rule;
    }

    public function __toString() : string
    {
        return sprintf($this->message[$this->rule], $this->key);
    }
}