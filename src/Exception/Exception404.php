<?php

namespace App\Exception;

use Exception;

class Exception404 extends Exception
{
    protected $data;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}