<?php

namespace App\Validation;

use App\Validation\Exception\InvalidNumberException;

class RoomNumberValidator
{
    public function validate(string $number): void
    {
        if(!is_numeric($number) || strlen($number) !== 4){
            throw new InvalidNumberException();
        }
    }
}

