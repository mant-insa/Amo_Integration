<?php

namespace App\Lib;

class AmoContact
{
    public function __construct(
        private $name,
        private $phone,
        private $email,
    )
    {}

    public function getContactName(){
        return $this->name;
    }

    public function getContactPhone(){
        return $this->phone;
    }

    public function getContactEmail(){
        return $this->email;
    }
}