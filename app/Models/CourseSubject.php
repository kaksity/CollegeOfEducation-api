<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSubject extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function nceRegisteredCourseSubject()
    {
        return $this->hasMany(NceRegisteredCourseSubject::class, 'course_subject_id');
    }
}
