<?php

namespace App\Models;

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
}
