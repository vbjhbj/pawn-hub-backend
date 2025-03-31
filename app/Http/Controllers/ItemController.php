<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        

        $key = "%" . $request->query('searchKey') . "%" ?? "%";
        $holding = $request->input('hold');
        $sFor = $request->query("searchIn") ?? "name";
        
        $shop = DB::table("shops")->where('id', $request->query("shop"))->first();
        if ($shop){
            $shopuser = DB::table("users")->where('id', $shop->user_id)->first();
        } else{
            $shopuser = null;
        }
        $user = $request->user();
        if ($request->query("cat")){
            $types[] = explode(',',$request->query("cat"));
        }
        
        $typeG = $request->query("catG");
        $page = $request->query("page")-1;
        if ($page<0){
            $page = 0;
        }
        $order = $request->query("orderBy") ?? "name";
        $settlements[] = explode(',',$request->query("settlements"));
        if($request->query("asc")){
            $asc = "asc";
        }
        else{
            $asc = "desc";
        }
        $stat = $request->query("status");
        if($holding){
            $settlements[] = DB::table("settlements")->where('holding_id', $holding)->get('id');
        }
        $items= array();
        $types[] = DB::table("types")->where('typeGroups_id', $typeG)->get('id');
        //return json_encode($settlements);
        foreach ($settlements as $setl){
            $shops[] = Shop::where("settlement_id", $setl)->get('id');
        }
        
        //return json_encode($types);
        if (is_null($shopuser)||$shopuser != $request->user()){
            if (!count($shops) === 1){
                foreach ($shops as $cshop){
                    if (!count($types) === 1){
                        foreach($types as $type){
                            $items[]=DB::table("items")->where('shop_id', 'like', $cshop)->where($sFor, 'like', $key)->where("loan_id", null)->where("type_id", $type)->orderby($order, $asc)->skip($page*30)->take(30)->get();
                        }
                    }else{
                        $items[]=DB::table("items")->where('shop_id', 'like', $cshop)->where($sFor, 'like', $key)->where("loan_id", null)->orderby($order, $asc)->skip($page*30)->take(30)->get();
                    }
                }
            }else{
                if (!count($types) === 1){
                    foreach($types as $type){
                        $items[]=DB::table("items")->where($sFor, 'like', $key)->where("loan_id", null)->where("type_id", $type)->orderby($order, $asc)->skip($page*30)->take(30)->get();
                    }
                }else{
                    $items[]=DB::table("items")->where($sFor, 'like', $key)->where("loan_id", null)->orderby($order, $asc)->skip($page*30)->take(30)->get();
                }
            }
            if ($shop){
                $items[]=DB::table("items")->where('shop_id', $shop->id)->whereNull("loan_id")->get();
            }
            
        }elseif(is_null($stat)){
            $items[]=DB::table("items")->where('shop_id', $shop->id)->get();
        }elseif($stat){
            $items[]=DB::table("items")->where('shop_id', $shop->id)->where("loan_id","!=", null)->get();
        }else{
            $items[]=DB::table("items")->where('shop_id', $shop->id)->where("loan_id", null)->get();
        }
        


        /*$items = Item::where($sFor, 'like', $key)
            ->where('type_id', '=', $cat)
            ->whereHas('shop', function ($q) use ($shop) {
                $q->whereIn('county', $counties);
            })
            ->with(['shop:id,name,settlement_id']) // Include only selected fields from shop
            ->select('id', 'name', 'shop_id') // Select only necessary fields from Item
            ->get();*/

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
        $item->img = $request->input('img');
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
        $item->img = $request->input('img');
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
