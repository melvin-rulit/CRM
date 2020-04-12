<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Base;
use Carbon\Carbon;

use App\Http\Resources\ArticleResource;

class VueController extends Controller
{

    public function get(){

    	$data = Base::all();
    	// return $data;
    	 return response()->json($data, 200);
    }

    public function getEmail(){
    	$d = User::find(1);
    	$data = $d->branches;
    	return $data;
    }

    public function getOne(Request $request){

    	$field_name = $request['field_name'];

    	$user = Base::find($request['user_id']);
		$user->$field_name = $request['field_value'];
		$user->save();
		return "OK";



    	
    	$dr = Carbon::createFromDate(1988, 9, 1)->diff(Carbon::now())->format('%y лет, %m месяцев и %d дней');
    	$post = User::find($id);
    	$data = Base::find($id);

    	return $data;

        return [
            'type'          => 'articles',
            'id'            => "1",
            'attributes'    => [
                'title' => "Alexey",
            ],
        ];
    	//return $data;

//return response()->json([$data, $dr]);

// $programmers =  \App\Person::where('type', 'programmer')->get();
// $critic      =  \App\Person::where('type', 'critic')->get();
// $engineer    =  \App\Person::where('type', 'engineer')->get();

// $collection  = new Collection;
// $all = $collection->merge($post)->merge($data);
// return $all;

// $collection = collect(['product_id' => 1, 'name' => 'Desk']);

// $collection->put('price', $dr);

// dd($data);

// return $collection;
//return response()->json(['success' => [$data, 'user' => $post]]);

//   $queue = array("orange", "banana");

 //return dd($data);
// $collection = collect(['product_id' => 1, 'name' => 'Desk']);

// $merged = $data->merge(['price' => 100]);

// return $merged;
// return $queue;  	

// $array = [
//     "foo" => "bar",
//     "bar" => "foo",
// ];

// return array_push($array, "666" => "raspberry");
//return array_merge($data, $array);

    	// return response()->json(['data' => $data, 'dr' => $dr], 200);
    	// return json_encode(array_merge_recursive($data, $data));

    }
}

// Category::with('posts.comments')->get();