<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpLook extends Model
{
    use HasFactory;

    protected $table = 'dbip_lookup';

    protected $fillable = [
        'addr_type',
        'ip_start',
        'ip_end',
        'continent',
        'country',
        'stateprov',
        'city',
        'latitude',
        'longitude'
    ];
}
