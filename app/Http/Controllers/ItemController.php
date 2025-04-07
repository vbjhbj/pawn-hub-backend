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
        $settlements[] = explode('_',$request->query("settlements"));
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
        foreach ($settlements as $setl){
            $shops[] = Shop::where("settlement_id", $setl)->get('id');
        }
        if (is_null($shopuser)||$shopuser != $request->user()){
            if (!count($shops) === 1){
                foreach ($shops as $cshop){
                    if (!count($types) === 1){
                        foreach($types as $type){
                            $items[]=DB::table("items")->where('shop_id', 'like', $cshop)->where($sFor, 'like', $key)->where("loan_id", null)->where("type_id", $type)->orderby($order, $asc)->get();
                        }
                    }else{
                        $items[]=DB::table("items")->where('shop_id', 'like', $cshop)->where($sFor, 'like', $key)->where("loan_id", null)->orderby($order, $asc)->get();
                    }
                }
            }else{
                if (!count($types) === 1){
                    foreach($types as $type){
                        $items[]=DB::table("items")->where($sFor, 'like', $key)->where("loan_id", null)->where("type_id", $type)->orderby($order, $asc)->get();
                    }
                }else{
                    $items[]=DB::table("items")->where($sFor, 'like', $key)->where("loan_id", null)->orderby($order, $asc)->get();
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


        $length = count($items[0]);
        //$items = array_slice($items, $page*30, 30);

        $itemsOnPage = [];

        for ($i = $page*30; $i < $page*30+30 && $i < count($items[0]); $i++) {
            $itemsOnPage[] = $items[0][$i];
            $item = $itemsOnPage[count($itemsOnPage)-1];

            $shop = Shop::find($item->shop_id);

            $item->shop = [
                'id'=> $item->shop_id,
                'name' => $shop->name,
            ];
            $item->settlement = $shop->settlement;

            $itemsOnPage[count($itemsOnPage)-1] = $item;

        }


        /*foreach ($items[0] as $item){
            $shop = Shop::find($item->shop_id);

            $item->shop = [
                'id'=> $item->shop_id,
                'name' => $shop->name,
            ];
            $item->settlement = $shop->settlement;
        }*/


        return response()->json([
            'length' => $length,
            'items' => $itemsOnPage
        ]);
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
        $item->typeId = $request->input('typeId');
        $item->value = $request->input('value');
        $item->save();
        return response(200);
    }

    public function create(Request $request)
    {
        $userId=Auth::id();
        $user=User::findOrFail($userId);
        $shop=Shop::where("user_id", $userId)->first();
        $item=new Item;
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->img = $request->input('img');
        $item->loanId = $request->input('loanId');
        $item->shopId = $shop->id;
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
        $user = User::find(Auth::user()->id);
        $shop=Shop::where("user_id", $user->id);
        $item = Item::find($itemId);
        if ($item->shop_id == $shop->id){
             $item->delete();
        }
    }
}
