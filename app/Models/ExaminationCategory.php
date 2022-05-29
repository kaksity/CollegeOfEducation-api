<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExaminationCategory extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;
 
    public function dipExaminationData()
    {
        return $this->hasMany(DipExaminationData::class, 'examination_category_id');
    }
    public function subjects()
    {
        return $this->hasMany(ExaminationSubject::class, 'examination_category_id');
    }
}
