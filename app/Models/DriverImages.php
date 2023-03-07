<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverImages extends Model
{
    use HasFactory;
  
    protected $table = 'driver_images';

    protected $fillable = ['id', 'pan','driving_license_front','driving_license_back','character_certificate'];

}
