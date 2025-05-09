<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'tbl_university';
    
    protected $fillable = ['name','state_id'];

}