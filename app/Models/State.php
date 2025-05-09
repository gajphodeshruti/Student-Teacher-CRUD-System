<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
        protected $primaryKey = 'id';
         protected $table = 'states';
    
        protected $fillable = ['name'];
    }

