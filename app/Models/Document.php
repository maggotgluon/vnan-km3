<?php

namespace App\Models;

use App\Enums\DocumentStatusEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_type',
        'doc_code',
        'doc_ver',
        'doc_name_th',
        'doc_name_en',
        'effective',
        'ages',
        'referance_req_code',
        'status',
    ];


    protected $casts = [
        'effective' => 'date:Y-m-d',
        'status' => DocumentStatusEnums::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ref(){
        return $this->hasOne(DocumentRequest::class,'req_code','referance_req_code');
    }
}
