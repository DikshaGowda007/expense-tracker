<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'text',
        'amount',
        'notes',
        'category_id',
        'created_at',
        'updated_at',
        'status',
        'is_deleted',
    ];

    public function getTableName(): string
    {
        return $this->table;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
