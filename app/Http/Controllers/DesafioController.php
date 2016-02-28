<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DesafioController extends Controller
{
    public function index(){
    	return view('desafio.home');
    }

    public function ranking() {
    	return view('desafio.ranking');
    }
}
