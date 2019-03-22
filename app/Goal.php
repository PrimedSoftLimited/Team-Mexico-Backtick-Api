<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use Notifiable;

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
