<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseGroup extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_group_id');
    }

    public function courseData()
    {
        return $this->hasMany(NceCourseData::class, 'course_group_id');
    }

    public function applicantSetPayments()
    {
        return $this->hasMany(CourseGroup::class, 'course_group_id');
    }
}
