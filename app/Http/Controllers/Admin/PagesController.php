<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;

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

    public function product(){

        return view('pages.product');
    }

    public function regions(){

        return view('pages.region');
    }


}
