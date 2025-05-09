<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Student extends Model{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = ['name', 'email', 'birthdate','gender','class','mobileno','state_id','district_id','taluka_id','user_id','is_deleted'];

    public function state() {
        return $this->belongsTo(State::class);
    }
    
    public function district() {
        return $this->belongsTo(District::class);
    }
    
    public function taluka() {
        return $this->belongsTo(Taluka::class);
    }
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