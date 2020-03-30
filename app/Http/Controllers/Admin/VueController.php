<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class VueController extends Controller
{
    public function get(){
    	$data = User::all();
    	return $data;
    }

    public function getOne(Request $id){
    	$data = User::find($id);
    	return $data;
    }
}
