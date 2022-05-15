<?php

namespace App\Models;
use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;
}
