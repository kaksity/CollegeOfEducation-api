<?php

namespace App\Models;

use App\Http\Middleware\VerifyApplicationPayment;
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
    public function verifyApplicationPayment()
    {
        return $this->hasOne(ApplicationPayment::class, 'user_id');
    }
    public function dipPersonalData()
    {
        return $this->hasOne(DipPersonalData::class, 'user_id');
    }
    public function dipContactData()
    {
        return $this->hasOne(DipContactData::class, 'user_id');
    }
    public function dipEducationalBackground()
    {
        return $this->hasMany(DipEducationalBackgroundData::class, 'user_id');
    }
    public function dipEmploymentData()
    {
        return $this->hasMany(DipEmploymentData::class, 'user_id');
    }
    public function dipCourseData()
    {
        return $this->hasOne(DipCourseData::class,'user_id');
    }
    public function dipExtraCurricularActivityData()
    {
        return $this->hasMany(DipExtraCurricularActivityData::class, 'user_id');
    }
    public function dipHeldResponsibilityData()
    {
        return $this->hasMany(DipHeldResponsibilityData::class, 'user_id');
    }

    public function dipPassport()
    {
        return $this->hasOne(DipPassport::class, 'user_id');
    }

    public function dipExaminationData()
    {
        return $this->hasMany(DipExaminationData::class, 'user_id');
    }

    public function dipApplicationStatus()
    {
        return $this->hasOne(DipApplicationStatus::class, 'user_id');
    }

    public function dipRegisteredCourseSubject()
    {
        return $this->hasMany(DipRegisteredCourseSubject::class, 'course_subject_id');
    }
    public function dipExaminationCenterData()
    {
        return $this->hasOne(DipExaminationCenterData::class, 'user_id');
    }
}
