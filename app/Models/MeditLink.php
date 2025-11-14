<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeditLink extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'medit_link_group_uuid',
        'medit_link_access_token',
        'medit_link_refresh_token',
    ];
}
