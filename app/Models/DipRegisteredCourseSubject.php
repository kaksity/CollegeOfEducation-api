<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DipRegisteredCourseSubject extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class, 'course_subject_id');
    }
}
