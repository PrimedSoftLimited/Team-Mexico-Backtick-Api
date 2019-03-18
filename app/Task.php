<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function goal()
    {
        return $this-> belongsTo(Goal::class);
    }

}