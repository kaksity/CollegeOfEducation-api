<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Course extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function dipCourseDataFirstChoice()
    {
        return $this->hasMany(Course::class,'first_choice_course_id');
    }
    public function dipCourseDataSecondChoice()
    {
        return $this->hasMany(Course::class,'second_choice_course_id');
    }
}
