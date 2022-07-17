<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExaminationSubject extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function nceExaminationData()
    {
        return $this->hasMany(NceExaminationData::class, 'examination_subject_id');
    }
    public function category()
    {
        return $this->belongsTo(ExaminationCategory::class, 'examination_category_id');
    }
}
