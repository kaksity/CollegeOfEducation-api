<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lga extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;

    protected $guarded;

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function ncePersonalData()
    {
        return $this->hasMany(NcePersonalData::class, 'lga_id');
    }
}
