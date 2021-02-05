<?php

namespace App\Http\Controllers\Api\V2;

use App\Article;
use App\Http\Controllers\Controller;
use App\WarehouseArticle;
use App\Http\Resources\WarehouseArticleResource;
use Illuminate\Http\Request;

class WarehouseArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $warehouse_article = WarehouseArticle::where('article_id', $request->article_id)
            ->where('warehouse_id', $request->warehouse_id)
            ->get();

        if ($warehouse_article->count() == 0) {
            WarehouseArticle::create($request->all());
        }else{
            return [
                'id'    => $warehouse_article->count(),
            ];
        }

//        $warehouse_article = WarehouseArticle::firstOrCreate(
//            ['article_id' => $request->article_id],
//            ['article_id' => $request->article_id, 'warehouse_id' => $request->warehouse_id, 'quantity' => $request->quantity]
//        );
//
//        return [
//            'id'    => $warehouse_article->article_id,
//        ];

//        WarehouseArticle::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showWarehouseArticle(Request $request){

        $warehouse_articles = WarehouseArticle::where('warehouse_id', $request->warehouse_id)->get();

        return WarehouseArticleResource::collection($warehouse_articles);
    }
}
