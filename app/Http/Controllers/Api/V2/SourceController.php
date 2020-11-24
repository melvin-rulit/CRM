<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index(){

        return SourceResource::collection(Source::all());
    }

    public function store(Request $request)
    {
        Source::create($request->all());
    }
}
