<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionSetPayment extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    protected $guarded = [];

    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class, 'course_group_id');
    }
}
