<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseRegisterationCard extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;
    protected $guarded = [];

    public function academicSession()
    {
        return $this->belongsTo(NceAcademicSession::class, 'academic_session_id');
    }
    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class, 'course_group_id');
    }
}
