<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
   	public function index(){

		return new ProductsResource(Product::all());
	}

	public function addNewProduct(Request $request){

		Product::create($request->all());

		return [
			'success' => 'ok'
		];
	}
}
