<?php

namespace App\Models;


use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NceCoursePayment extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;

    public function nceCourse() 
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
