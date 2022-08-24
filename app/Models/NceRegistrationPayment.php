<?php

namespace App\Models;
use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NceRegistrationPayment extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function nceSession()
    {
        return $this->belongsTo(NceAcademicSession::class, 'nce_academic_session_id');
    }
    public function nceCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function nceStudent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
