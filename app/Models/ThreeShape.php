<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreeShape extends Model
{
    use HasFactory;
    protected $table = 'three_shapes';
    protected $fillable = ['user_id', 'access_token', 'refresh_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
