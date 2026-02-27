<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shining3dCountryRegionMap extends Model
{
    use HasFactory;

    protected $table = 'shining3d_country_region_map';

    protected $fillable = [
        'region_id',
        'country_name',
        'country_code',
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

    public function region()
    {
        return $this->belongsTo(Shining3dRegion::class, 'region_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeByCountryCode($query, $code)
    {
        return $query->where('country_code', strtoupper($code));
    }
}
