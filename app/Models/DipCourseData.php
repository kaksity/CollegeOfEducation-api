<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DipCourseData extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function dipCourseDataFirstChoice()
    {
        return $this->belongsTo(Course::class,'first_choice_course_id');
    }
    public function dipCourseDataSecondChoice()
    {
        return $this->belongsTo(Course::class,'second_choice_course_id');
    }
    public function dipCourseDataAdmittedCourse()
    {
        return $this->belongsTo(Course::class,'admitted_course_id');
    }
}
