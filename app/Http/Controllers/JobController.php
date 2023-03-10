<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class JobController extends Controller
{
    public function createJob(Request $request){
        try{
            $user = Auth::guard('sanctum')->user();
            if($user->userType==User::$admin || $user->userType==User::$fleetOwner){
                
                $request->validate([
                    'title' => 'required',
                    'location' => 'required',
                    'type_of_vehicle' => 'required',
                    'nature_of_job' => 'required',
                    'to' => 'required',
                    'from' => 'required',
                    'vehicle_brand' => 'required',
                    'salary' => 'required',                    
                ], [
                        
                        'title.required' => 'Title is required.',
                        'location.required' => 'Location is required.',
                        'type_of_vehicle.required' => 'Type of Vehicle is required.',
                        'nature_of_job.required' => 'Nature of job is required is required.',
                        'to.required' => 'Route info is required.',
                        'from.required' => 'Route info required.',
                        'vehicle_brand.required' => 'Vehicle Brand is required.',
                        'salary.required' => 'Salary is is required.',
                    ]);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Unautorised access'
                ], 403);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
