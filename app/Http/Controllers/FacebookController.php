<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialize;

class FacebookController extends Controller
{
    public function login() {
    	return Socialize::with('facebook')->redirect();
    }

    public function feedback() {
    	$user = Socialize::with('facebook')->user();
        return response()->json($user);
    }
}
