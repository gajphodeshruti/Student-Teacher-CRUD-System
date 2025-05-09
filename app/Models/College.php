<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'tbl_college';
    
    protected $fillable = ['name','university_id'];

}