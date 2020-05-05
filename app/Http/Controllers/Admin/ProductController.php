<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Base;
use App\Filters\UsersFilter;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request, UsersFilter $filters)
    {
		// $users = User::with('branches');

		// $users = (new UsersFilter($users, $request))->apply()->get();

		// $users->where('name', 'like', "%$request->name%");

		// $users = $users->get();

		$users = Base::filter($filters)->get();

		if ($request->expectsJson()) {
			return response()->json($users->toArray());
		}

		return view('pages.product', compact('users'));
    }
}
