<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal_Record extends Model
{
  
    protected $table = 'personal_record';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id'
        'movement_id'
        'value'
        'date'
    ];

   
}
