<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $table = 'lists';

    protected $fillable = [
        'user_id', 'list'
    ];
}
