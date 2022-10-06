<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Movement extends Model
{
  
    protected $table = 'movement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

   
}
