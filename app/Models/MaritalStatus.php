<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\UuidTrait;

class MaritalStatus extends Model
{
    use UuidTrait,HasFactory, SoftDeletes;
    
    protected $guarded;

    public function dipPersonalData()
    {
        return $this->hasMany(DipPersonalData::class, 'marital_status_id');
    }
}
