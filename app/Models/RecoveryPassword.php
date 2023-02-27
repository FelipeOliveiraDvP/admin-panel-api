<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecoveryPassword extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'recovery_password';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'token',
        'expiration',
        'user_id',
    ];
}
