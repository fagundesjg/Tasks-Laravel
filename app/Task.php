<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id','description', 'date', 'status'];
    protected $table = 'tasks';
}
