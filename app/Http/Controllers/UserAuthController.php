<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserAuthController extends Controller
{
    //
      public function register(Request $request)
    {
        
        
        $request -> validate( [
            'phone' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'firebaseId'=>'required',
            'addressLine1'=>'required',
            'city'=>'required',
            'state'=>'required',
            'pin'=>'required',
            'userType'=>'required',
        ], [
            'phone.required' => 'Phone field is required.',
            'f_name.required' => 'The first name field is required.',
            'l_name.required' => 'The last name field is required.',
            'firebase_id.required'=>'Phone number not Verified',
            'addressLine1.required'=>'Address is required.',
            'city.required'=>'City is required.',
            'state.required'=>'State is required.',
            'pin.required'=>'Pin is required',
            'userType.required'=>'User type not found!',
        ]);

        
        //Save point to refeer
        if($request->ref_code) {
           
        }

        $user = User::where('firebase_id',$request->firebaseId)->first();
        if($user==null){

            $user = User::insert([
                'f_name' => $request->fname,
                'l_name' => $request->lname,
                'firebase_id' => $request->firebaseId,
                'email' => $request->email,
                'phone' => $request->phone,
                'addressLine1' => $request->addressLine1,
                'addressLine2' => $request->addressLine2	,
                'landmark' => $request->landmark,
                'city' => $request->city,
                'state' => $request->state,
                'pin' => $request->pin,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'image' => $request->image,
                'userType' => $request->userType,
                'cm_firebase_token' => $request->cm_firebase_token,
                'ref_code' => $request->ref_code,    
                ]);
    $user = User::where('firebase_id',$request->firebaseId)->first();

    // $token = $user->createToken('CustomerAuth')->accessToken;

    return response()->json(['user' => $user,'status' => true ], 200);
        }else{
            return response()->json(['message' => 'User Already Exist','status' => false ], 403);
        }

       
    }

}
