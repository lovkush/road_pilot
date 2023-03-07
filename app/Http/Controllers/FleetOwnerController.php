<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FleetOwnerImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleetOwnerController extends Controller
{
    //
    public function getAllFleetOwner()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user->userType==1) {

                $fleetOwners = User::where('userType', 2);
                return response()->json([
                    'status' => true,
                    'fleetOwners' => $fleetOwners
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

            if ($user->userType==1) {
                
                $request->validate([
                    'pan' => 'image',
                    'gstin' => 'image',
                    'vCard' => 'image',
                ], [
                        
                        'pan.image' => 'Please upload a valid.',
                       
                        'gstin.image' => 'Please upload a valid.',
                        
                        'vCard.image' => 'Please upload a valid.',
                    ]);

                $formData = $request->all();


                $userExists = DB::table('fleet_owner_images')
                ->where('id', $user->id)->exists();

                if (isset($formData['pan'])) {

                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $formData['pan']->extension();
                    $formData['pan']->move(public_path('upload/pan/'), $name);
                    $pic_name = 'upload/pan/' . $name;

                    if ($userExists) {
                        DB::table('fleet_owner_images')
                            ->where('id', $user->id)->update(
                                ['pan' => $pic_name],
                            );
                    } else {
                        DB::table('fleet_owner_images')
                        ->insert(
                            [
                                'id'=>$user->id,
                                'pan' => $pic_name],
                        );
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);

                } else if (isset($formData['gstin'])) {

                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $formData['gstin']->extension();
                    $formData['gstin']->move(public_path('upload/gstin/'), $name);
                    $pic_name = 'upload/gstin/' . $name;

                    if ($userExists) {
                        DB::table('fleet_owner_images')
                            ->where('id', $user->id)->update(
                                ['gst' => $pic_name],
                            );
                    } else {
                        DB::table('fleet_owner_images')
                        ->insert(
                            [
                                'id'=>$user->id,
                                'gst' => $pic_name],
                        );
                    }
                    return response()->json(['msg' => 'Image updated successfully', 'status' => true], 200);


                } else if (isset($formData['vCard'])) {
                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' .$formData['vCard']->extension();
                    $formData['vCard']->move(public_path('upload/vCard/'), $name);
                    $pic_name = 'upload/vCard/' . $name;

                    if ($userExists) {
                        DB::table('fleet_owner_images')
                            ->where('id', $user->id)->update(
                                ['visiting_card' => $pic_name],
                            );
                    } else {
                        DB::table('fleet_owner_images')
                        ->insert(
                            [
                                'id'=>$user->id,
                                'visiting_card' => $pic_name],
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

    public function getFleetOwnerImages(Request $request){

        try{
            $user = Auth::guard('sanctum')->user();

            if ($user->userType==1) {
                
                $data =  DB::table('fleet_owner_images')
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