<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NceAcademicSession extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function getCurrentSession($courseGroupId)
    {
        return $this->where('course_group_id', $courseGroupId)->latest()->first();
    }
    public function nceRegisterationPayments()
    {
        return $this->hasMany(NceRegistrationPayment::class, 'nce_academic_session_id');
    }
    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class, 'course_group_id');
    }
    public function courseRegisterationCards()
    {
        return $this->hasMany(CourseRegisterationCard::class, 'academic_session_id');
    }
}
