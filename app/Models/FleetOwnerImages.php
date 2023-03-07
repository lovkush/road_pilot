<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class FleetOwnerImages extends Model
{
    protected $table = 'fleet_owner_images';

    protected $fillable = [
        'id',
        'pan',
        'gst',
        'visiting_card',
        'created_at',
        'updated_at'
        ];



}
