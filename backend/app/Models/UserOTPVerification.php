<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOTPVerification extends Model
{
    protected $table = 'user_otp_verifications';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'otp',
        'created_at',
        'expires_at',
    ];

    public function getTableName(): string
    {
        return $this->table;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
