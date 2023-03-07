<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FleetOwnerImages;
use App\Models\DriverImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    //
    public function getAllDrivers()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user->userType==User::$admin||$user->userType==User::$fleetOwner) {

                $drivers = User::where('userType', User::$driver);
                return response()->json([
                    'status' => true,
                    'drivers' => $drivers
                ]);

            } else {
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

    public function addImage(Request $request)
    {

        try {
            $user = Auth::guard('sanctum')->user();

            if ($user->userType==User::$admin||$user->userType==User::$driver) {
                
                $request->validate([
                    'pan' => 'image',
                    'driving_license_front' => 'image',
                    'driving_license_back' => 'image',
                    'character_certificate' => 'image',
                ], [
                        
                        'pan.image' => 'Please upload a valid.',
                       
                        'driving_license_front.image' => 'Please upload a valid.',
                        'driving_license_back.image' => 'Please upload a valid.',
                        
                        'character_certificate.image' => 'Please upload a valid.',
                    ]);

                $formData = $request->all();


                $userExists = DB::table('driver_images')
                ->where('id', $user->id)->exists();

                if (isset($formData['pan'])) {

                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $formData['pan']->extension();
                    $formData['pan']->move(public_path('upload/driver/pan/'), $name);
                    $pic_name = 'upload/driver/pan/' . $name;

                    if ($userExists) {

                        DriverImages::where('id', $user->id)->update(
                                ['pan' => $pic_name],
                            );
                    } else {
                        
                        DriverImages::create([
                            'id'=>$user->id,
                            'pan' => $pic_name]);
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);

                } else if (isset($formData['driving_license_front'])) {

                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $formData['driving_license_front']->extension();
                    $formData['driving_license_front']->move(public_path('upload/driver/driving_license/'), $name);
                    $pic_name = 'upload/driver/driving_license/' . $name;

                    if ($userExists) {
                        DriverImages::
                            where('id', $user->id)->update(
                                ['driving_license_front' => $pic_name],
                            );
                    } else {
                        DriverImages::create(
                            [
                                'id'=>$user->id,
                                'driving_license_front' => $pic_name],
                        );
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);


                } else if (isset($formData['driving_license_back'])) {
                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' .$formData['driving_license_back']->extension();
                    $formData['driving_license_back']->move(public_path('upload/driver/driving_license/'), $name);
                    $pic_name = 'upload/driver/driving_license/' . $name;

                    if ($userExists) {
                        DriverImages::where('id', $user->id)->update(
                                ['driving_license_back' => $pic_name],
                            );
                    } else {
                        DriverImages::create(
                            [
                                'id'=>$user->id,
                                'driving_license_back' => $pic_name],
                        );
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);


                } else if (isset($formData['character_certificate'])) {
                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' .$formData['character_certificate']->extension();
                    $formData['character_certificate']->move(public_path('upload/driver/character_certificate/'), $name);
                    $pic_name = 'upload/driver/character_certificate/' . $name;

                    if ($userExists) {
                        DriverImages::where('id', $user->id)->update(
                                ['character_certificate' => $pic_name],
                            );
                    } else {
                        DriverImages::create(
                            [
                                'id'=>$user->id,
                                'character_certificate' => $pic_name],
                        );
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);


                } else {
                    // Do something else
                    return response()->json(['message' => 'Invalid data.'],403);
                }
            }else{
                return response()->json(['message' => 'Unauthorized User.'],401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getDriverImages(Request $request){

        try{
            $user = Auth::guard('sanctum')->user();

            if ($user->userType==User::$admin||$user->userType==User::$driver) {
                
                $data =  DB::table('driver_images')
                ->where('id',$user->id)->first();
              
                    return response()->json(['data' => $data, 'status' => true], 200);

            }else{
                return response()->json(['message' => 'Unauthorized User.'],401);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

}