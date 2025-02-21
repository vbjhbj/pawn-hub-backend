<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $page, string $key, int $orderBy, bool $order, int $cat, int $minP, int $maxP, string $holding, array $setlList)
    {
        return json_encode(DB::select('select * from Items where name like :key and type_id = :cat and value > :minP and value < :maxP and loanId is null order by :orderBy order limit 30*:page, 30'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $page, string $key, int $orderBy, bool $order, int $cat, bool $status, int $shopId)
    {
        if ($status = NULL){
            return json_encode(DB:select('select * from Items where shopId = :shopId and type_id = :cat and name like :key order by :orderBy order limit 30*:page, 30'));
        }elseif($status){
            return json_encode(DB:select('select * from Items where shopId = :shopId and type_id = :cat and name like :key and loan_id is not null order by :orderBy order limit 30*:page, 30'));
        }else{
            return json_encode(DB:select('select * from Items where shopId = :shopId and type_id = :cat and name like :key and loan_id is null order by :orderBy order limit 30*:page, 30'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(int $itemId)
    {
        $item=Item::findOrFail($itemId);
    #    $item = DB::table('Items')->where('id', $itemId)->get();
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
