<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'districts';
    
    protected $fillable = ['district_name','state_id'];
}
