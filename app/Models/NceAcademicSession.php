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

    public function getCurrentSession()
    {
        return $this->latest()->first();
    }
    public function nceRegisterationPayments()
    {
        return $this->hasMany(NceRegistrationPayment::class, 'nce_academic_session_id');
    }
}
