<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NceRequiredDocumentData extends Model
{
    use UuidTrait, HasFactory, SoftDeletes;
    protected $guarded;
    
    public function requiredDocument()
    {
        return $this->belongsTo(RequiredDocument::class, 'required_document_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
