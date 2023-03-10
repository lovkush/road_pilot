<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'id', 
        'fleet_Owner_Id',
        'driver_Id',
        'title',
        'image',
        'location',
        'type_of_vehicle',
        'nature_of_job',
        'to',
        'from',
        'vehicle_brand',
        'salary',
        'compeleted_date',
        'joining_date',
        'status',
    ];

    public static $open = 0;  // job created be fleet owner
    public static $active = 1; // driver hired for job
    public static $closed = 2; // job closed / driver not found
    public static $compeleted = 3; // job compeleted after driver hired

}
