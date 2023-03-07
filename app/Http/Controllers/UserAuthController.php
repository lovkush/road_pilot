<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'firebaseId' => 'required',
            'addressLine1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pin' => 'required',
            'userType' => 'required',
        ], [
                'phone.required' => 'Phone field is required.',
                'f_name.required' => 'The first name field is required.',
                'l_name.required' => 'The last name field is required.',
                'firebase_id.required' => 'Phone number not Verified',
                'addressLine1.required' => 'Address is required.',
                'city.required' => 'City is required.',
                'state.required' => 'State is required.',
                'pin.required' => 'Pin is required',
                'userType.required' => 'User type not found!',
            ]);
        //Save point to refeer
        if ($request->ref_code) {

        }

        $user = User::where('firebase_id', $request->firebaseId)->first();
        if ($user == null) {
            $user = User::insert([
                'f_name' => $request->fname,
                'l_name' => $request->lname,
                'password'=>Hash::make($request->password),
                'firebase_id' => $request->firebaseId,
                'email' => $request->email,
                'phone' => $request->phone,
                'addressLine1' => $request->addressLine1,
                'addressLine2' => $request->addressLine2,
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
            $user = User::where('firebase_id', $request->firebaseId)->first();

            // $token = $user->createToken('CustomerAuth')->accessToken;

            return response()->json(['user' => $user, 'status' => true], 200);
        } else {
            return response()->json(['message' => 'User Already Exist', 'status' => false], 403);
        }


    }

    public function getUser()
    {
        $user =  Auth::guard('sanctum')->user();
        if ($user == null) {
            return response()->json(['message' => 'User doesnot Exist', 'status' => false], 403);
        } else {
            return response()->json(['user' => $user, 'status' => true], 200);
        }
    }

 public function uploadProfilePicture(Request $request)
    {
        $user =  Auth::guard('sanctum')->user();
        
        try{
            
            $request->validate([
                'image' => 'required|image'
            ], [
                    'image.required' => 'Image is required.',
                    'image.image' => 'Invalid file',
                ]);
            if ($request->hasFile('image')) {
                $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $request->image->extension();
                $request->image->move(public_path('upload/profileImage/'), $name);
                $pic_name = 'upload/profileImage/' . $name;
    
                $user = User::where('id',$user->id)->update([
                    'image' => $pic_name,
                ]);
                
                return response( )->json(['msg' => 'Image updated successfully', 'status' => true], 200);
            }    
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
       

    }

}