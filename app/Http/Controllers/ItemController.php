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
    /*public function index(int $page, string $key, int $orderBy, bool $order, int $cat, int $minP, int $maxP, string $holding, array $setlList)
    {
        return json_encode(DB::select('select * from Items where name like :key and type_id = :cat and value > :minP and value < :maxP and loanId is null order by :orderBy order limit 30*:page, 30'));
    }*/

    public function index(Request $request)
    {
        $request->validate([
            'query' => 'string',
            'cat' => 'int',
            'settlements' => 'array',
            'holding' => 'string',

        ]);

        $query = $request->input('query');
        $holding = $request->input('hold');

        $items = Item::where('name', 'like', "%$query%")
            ->where('type_id', '=', $cat)
            /*->whereHas('shop', function ($q) use ($shop) {
                $q->whereIn('county', $counties);
            })*/
            ->with(['shop:id,name,settlement_id']) // Include only selected fields from shop
            ->select('id', 'name', 'shop_id') // Select only necessary fields from Item
            ->get();

        return response()->json($items);
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
    public function show($itemId)
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
    public function update(Request $request)
    {
        $item=Item::findOrFail($request->input('id'));
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->imgUrl = $request->input('imgUrl');
        $item->loanId = $request->input('loanId');
        $item->shopId = $request->input('shopId');
        $item->typeId = $request->input('typeId');
        $item->value = $request->input('value');
        $item->save();
        return response(200);
    }

    public function create(Request $request)
    {
        $item=new Item;
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->imgUrl = $request->input('imgUrl');
        $item->loanId = $request->input('loanId');
        $item->shopId = $request->input('shopId');
        $item->typeId = $request->input('typeId');
        $item->value = $request->input('value');
        $item->save();
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $item = Item::find($itemId);
        $item->delete();
    }
}
