<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;
use Illuminate\Support\Facades\Auth;
use App\Log;

class PagesController extends Controller
{
        /**
     * В конструкторе проверяем залогинен ли пользователь.
     */
    public function __construct()
      {
        $this->middleware('auth');
      }

    public function index(){
        $regions = Region::all();
        return view('pages.index', compact('regions'));
    }

    public function vue(){

        return view('pages.vue');
    }

    public function journal(){

        return view('pages.journal');
    }

    public function permissions(){

        return view('pages.permissions');
    }

    public function users(){

        return view('pages.users');
    }

    public function regions(){

        return view('pages.region');
    }


}
