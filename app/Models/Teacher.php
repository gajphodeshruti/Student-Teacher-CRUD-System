<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Teacher extends Model{
    protected $table = 'tbl_teacher';

    protected $fillable = ['name', 'email', 'birthdate','gender','mobileno','state_id','university_id','college_id','user_id','is_deleted'];

    public function state()
{
    return $this->belongsTo(State::class);
}

public function university()
{
    return $this->belongsTo(University::class);
}

public function college()
{
    return $this->belongsTo(College::class);
}
     // Ensure the birthdate is cast to a date
     protected $dates = ['birthdate'];

     // Accessor to display date in dd-mm-yyyy format
     public function getBirthdateAttribute($value)
     {
         return Carbon::parse($value)->format('d-m-Y');
     }
     public function user()
{
    return $this->belongsTo(User::class);
}

}
?>


