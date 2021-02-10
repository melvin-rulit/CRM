<?php

namespace App\Http\Controllers\Api\V2;


use App\Branch;
use App\Http\Controllers\Controller;
use App\UserArticle;
use App\BaseArticle;
use App\Loger;
use App\WarehouseArticle;
use App\Http\Resources\WarehouseArticleResource;
use App\Http\Resources\UsersInBranchResource;
use App\Http\Resources\BasesInBranchResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\increment;

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

    public function addQuantity(Request $request){

        $warehouse_article = WarehouseArticle::find($request->id);
        $warehouse_article->increment('quantity', $request->quantity);
        $warehouse_article->supplier_id = $request->supplier_id ? $request->supplier_id : null;
        $warehouse_article->save();

    }


    public function moveArticle(Request $request){

        // Ищем позицию в складе
        WarehouseArticle::where('article_id', $request->article_id)
            ->where('warehouse_id', $request->warehouse_id)
            ->decrement('quantity', $request->quantity);


        // Добавляем в лог запись
        if($request->comment){

            loger(7, null, $request->id, $request->comment);
        }


        $article = WarehouseArticle::where(
            ['article_id' => $request->article_id, 'warehouse_id' =>  $request->new_warehouse_id]
        )->get();

        if ($article->count() > 0){
            WarehouseArticle::where('article_id', $request->article_id)
                ->where('warehouse_id', $request->new_warehouse_id)
                ->increment('quantity', $request->quantity);
        }else{
            WarehouseArticle::create([
                'article_id'        =>  $request->article_id,
                'warehouse_id'      =>  $request->new_warehouse_id,
                'quantity'          =>  $request->quantity,
                'supplier_id'       =>  $request->supplier_id,
            ]);
        }

    }

    public function removeQuantity(Request $request){

        WarehouseArticle::find($request->id)
            ->decrement('quantity', $request->quantity);

        // Добавляем в лог запись
        if($request->comment){

            loger(7, null, $request->id, $request->comment);
        }
    }

    public function removeBase(Request $request){

        WarehouseArticle::find($request->id)
            ->decrement('quantity', $request->quantity);

        BaseArticle::create([
            'warehouse_article_id'      => $request->id,
            'base_id'                   => $request->base_id,
            'user_id'                   => Auth::user()->id,
            'quantity'                  => $request->quantity,
            'comment'                   => $request->comment,
        ]);
    }

    public function removeUser(Request $request){

        WarehouseArticle::find($request->id)
            ->decrement('quantity', $request->quantity);

        UserArticle::create([
            'warehouse_article_id'      => $request->id,
            'user_id'                   => $request->user_id,
            'who_user_id'               => Auth::user()->id,
            'quantity'                  => $request->quantity,
            'comment'                   => $request->comment,
        ]);
    }

    public function usersInBranch(Request $request){

        $users = Branch::find($request->branch_id);

        return UsersInBranchResource::collection($users->users);
    }

    public function basesInBranch(Request $request){

        $bases = Branch::find($request->branch_id);

        return BasesInBranchResource::collection($bases->bases);
    }


}
