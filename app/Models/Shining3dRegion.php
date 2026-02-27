<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shining3dRegion extends Model
{
    use HasFactory;

    protected $table = 'shining3d_region';

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'api_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function countries()
    {
        return $this->hasMany(Shining3dCountryRegionMap::class, 'region_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
