<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NceCourseData extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class, 'course_group_id');
    }
    public function NceCourseDataFirstChoice()
    {
        return $this->belongsTo(Course::class,'first_choice_course_id');
    }
    public function NceCourseDataSecondChoice()
    {
        return $this->belongsTo(Course::class,'second_choice_course_id');
    }
    public function NceCourseDataThirdChoice()
    {
        return $this->belongsTo(Course::class,'third_choice_course_id');
    }
    public function NceCourseDataAdmittedCourse()
    {
        return $this->belongsTo(Course::class,'admitted_course_id');
    }
}
