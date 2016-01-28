<?php

namespace User\Model\Entity;

class User
{

    public $firstname ; 
    public $lastname ; 
    public $password ; 
    public $email ; 
    public $salt ; 
    public $iddo_User_has_address;

    //put your code here
    public function __construct(Array $data = array())
    {
        $this->exchangeArray($data);
    }

    public function exchangeArray($data)
    {

        $attributes = array_keys($this->getArrayCopy());

        foreach ($attributes as $attr) {
            if (isset($data[$attr])) {
                $this->{$attr} = $data[$attr];
            }
        }
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
