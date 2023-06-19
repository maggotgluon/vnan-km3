<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRequestInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_req_code',
        'meta_value',
    ];
    protected $casts = [
        'meta_value' => 'array',
        // 'meta_value' => AsCollection::class,
    ];
}
