<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = false;

    protected $fillable = [
        'text',
        'amount',
        'notes',
        'category',
        'created_at',
        'updated_at',
    ];
    

    public function getTableName(): string
    {
        return $this->table;
    }
}
