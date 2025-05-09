<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    //
    protected $primaryKey = 'id';
         protected $table = 'Talukas';
    
        protected $fillable = ['name','district_id'];
    }


