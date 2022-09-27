<?php

namespace App\Models;

use App\Http\Middleware\VerifyNceApplicationPayment;
use App\Http\Traits\UuidTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class,'user_id');
    }
    public function verifyNceApplicationPayment()
    {
        return $this->hasOne(NceApplicationPayment::class, 'user_id');
    }
    public function ncePersonalData()
    {
        return $this->hasOne(NcePersonalData::class, 'user_id');
    }
    public function nceContactData()
    {
        return $this->hasOne(NceContactData::class, 'user_id');
    }
    public function nceEducationalBackground()
    {
        return $this->hasMany(NceEducationalBackgroundData::class, 'user_id');
    }
    public function nceEmploymentData()
    {
        return $this->hasMany(NceEmploymentData::class, 'user_id');
    }
    public function nceCourseData()
    {
        return $this->hasOne(NceCourseData::class,'user_id');
    }
    public function nceExtraCurricularActivityData()
    {
        return $this->hasMany(NceExtraCurricularActivityData::class, 'user_id');
    }
    public function nceHeldResponsibilityData()
    {
        return $this->hasMany(NceHeldResponsibilityData::class, 'user_id');
    }

    public function ncePassport()
    {
        return $this->hasOne(NcePassport::class, 'user_id');
    }

    public function nceExaminationData()
    {
        return $this->hasMany(NceExaminationData::class, 'user_id');
    }

    public function nceApplicationStatus()
    {
        return $this->hasOne(NceApplicationStatus::class, 'user_id');
    }

    public function nceRegisteredCourseSubject()
    {
        return $this->hasMany(NceRegisteredCourseSubject::class, 'course_subject_id');
    }
    public function nceExaminationCenterData()
    {
        return $this->hasOne(NceExaminationCenterData::class, 'user_id');
    }
    public function nceRegisterationPayment()
    {
        return $this->hasMany(NceRegistrationPayment::class, 'user_id');
    }
    public function nceRequiredDocumentData()
    {
        return $this->hasMany(NceRequiredDocumentData::class, 'user_id');
    }
    public function usedCourseRegisterationCard()
    {
        return $this->hasMany(UsedCourseRegisterationPin::class, 'card_id');
    }
    public function admissionPayments()
    {
        return $this->hasMany(AdmissionPayment::class, 'user_id');
    }
}
