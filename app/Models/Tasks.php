<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'treatment_plan_id',
        'task',
        'type',
        'user_id',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $primaryKey = 'id';
}
