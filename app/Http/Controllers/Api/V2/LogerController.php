<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsResource;
use Illuminate\Http\Request;
use App\Loger;

class LogerController extends Controller
{
    public function index(Request $request){

        $loger = Loger::where('base_id', $request['id'])->orderBy('created_at','desc')->get();

        return CommentsResource::collection($loger);
    }
}
