<?php

namespace App\Core\Abstract;

abstract class AbstractEntity {
    abstract public static function toObject(array $data):static;

    abstract public  function toArray();

     public  function toJson(){
        return json_encode($this->toArray());
     }
}






