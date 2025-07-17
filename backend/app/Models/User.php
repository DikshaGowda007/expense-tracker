<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'verified',
    ];

    public function getTableName(): string
    {
        return $this->table;
    }
}
