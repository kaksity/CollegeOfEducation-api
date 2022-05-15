<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use UuidTrait,HasFactory, SoftDeletes;

    protected $guarded;

    public function lgas()
    {
        return $this->hasMany(Lga::class,'state_id');
    }

    public function dipPersonalData()
    {
        return $this->hasMany(DipPersonalData::class,'state_id');
    }
}
