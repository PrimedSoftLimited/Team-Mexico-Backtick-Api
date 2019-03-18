<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this-> belongsTo(User::class);
    }

    public function task()
    {
        return $this-> hasMany(Task::class, 'goal_id');
    }

}
