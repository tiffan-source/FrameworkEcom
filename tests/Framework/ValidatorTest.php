<?php

namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Validator\Validator;

class ValidatorTest extends TestCase
{

    private function newValidator($params){
        return new Validator($params);
    }

    public function testRequire()
    {
        $errors = $this->newValidator([
            'name' => 'Joe'
        ])
        ->required('name', 'content')
        ->getErrors();

        $this->assertCount(1, $errors);
    }

    public function testIfSucces()
    {
        $errors = $this->newValidator([
            'name' => 'Joe'
        ])
        ->required('name')
        ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testTitleSuccess()
    {
        $errors = $this->newValidator([
            'name' => 'Joe'
        ])
        ->slug('name')
        ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testTitleFail()
    {
        $errors = $this->newValidator([
            'name' => 'J.oe',
            'name1' => 'Jo&cd',
            'name2' => 'Bonj/ce'
        ])
        ->slug('name')
        ->slug('name1')
        ->slug('name2')
        ->slug('name4')
        ->getErrors();

        $this->assertCount(3, $errors);
    }

    public function testNotEmpty(){
        $errors = $this->newValidator([
            'name' => 'J.oe',
            'name1' => '',

        ])
        ->notEmpty('name', 'name1')
        ->getErrors();

        $this->assertCount(1, $errors);
    }


    public function testLength(){
        $params = [
            'name' => '123456789 ',
        ];
        $this->assertCount(0, $this->newValidator($params)->length('name', 3)->getErrors());
        $this->assertCount(1, $this->newValidator($params)->length('name', 11)->getErrors());
        $this->assertCount(1, $this->newValidator($params)->length('name', 3, 4)->getErrors());
        $this->assertCount(0, $this->newValidator($params)->length('name', 3, 20)->getErrors());
        $this->assertCount(0, $this->newValidator($params)->length('name', 0, 20)->getErrors());
        $this->assertCount(1, $this->newValidator($params)->length('name', 0, 8)->getErrors());
    }

    public function testDateTime(){
        $errors = $this->newValidator([
            'date' => 'J.oe',
            'date1' => '2020-12-12 11:23:32',
            'date2' => '2020-12-12',
            'date3' => '2023-32-12 00:00:00',
            'date4' => '2023-02-29 00:00:00'

        ])
        ->dateTime('date')
        ->dateTime('date1')
        ->dateTime('date2', 'Y-m-d')
        ->dateTime('date3')
        ->dateTime('date4')
        ->getErrors();

        $this->assertCount(3, $errors);
    }

}