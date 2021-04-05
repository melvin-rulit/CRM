<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){
    	return view('admin.settings.index');
    }
}
