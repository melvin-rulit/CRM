<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Branch;
use App\Base;

class BaseController extends Controller
{
    public function index(){

    	$branches = Branch::all();
    	return view('admin.promoter.index', compact('branches'));
    }

    public function store(Request $request)
    {
        Base::create($request->all());

        return redirect()->route('admin.promoter.index')->with('success', 'Ребенок успешно добавлен в базу');
    }
}
