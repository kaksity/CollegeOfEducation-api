<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DipExaminationData extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function examinationCategory()
    {
        return $this->belongsTo(ExaminationCategory::class, 'examination_category_id');
    }

    public function examinationSubject()
    {
        return $this->belongsTo(ExaminationSubject::class, 'examination_subject_id');
    }
}
