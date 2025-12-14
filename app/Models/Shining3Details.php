<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shining3Details extends Model
{
    use HasFactory;
    protected $table = 'shining3d_details';
    protected $fillable = [
        'node',
        'auth_csrf',
        'auth_token',
    ];

}
