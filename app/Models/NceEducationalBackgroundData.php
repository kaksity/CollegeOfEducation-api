<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NceEducationalBackgroundData extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
