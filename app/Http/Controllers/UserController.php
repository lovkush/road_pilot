<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    function pilot(Request $request){
        $user=User::all();
        return $user;
    }
}
