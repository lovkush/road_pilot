<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class FleetOwnerController extends Controller
{
    //
    public function getAllFleetOwner(){
        try{
            $user = Auth::guard('sanctum')->user();
            if($user!=null){

                $fleetOwners = User::where('userType',2);
                return response()->json([
                    'status'=>true,
                    'fleetOwners' => $fleetOwners
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Unautorised access'
                ], 403);
            }

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
