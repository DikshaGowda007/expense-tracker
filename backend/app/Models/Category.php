<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
