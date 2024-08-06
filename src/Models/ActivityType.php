<?php

namespace App\Models;

class ActivityType
{
    public $id;
    public $name;
    public $status;

    public function __construct($id, $name, $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }
}
