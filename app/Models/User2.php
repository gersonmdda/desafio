<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User2 extends Model
{
  
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

   
}
