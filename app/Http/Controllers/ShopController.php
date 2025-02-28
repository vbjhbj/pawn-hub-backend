<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $page, string $key, string $orderBy, bool $order, string $holding, array $settlList)
    {
        $key = '%' + $key + '%';
        return json_encode(DB::select('select * from Shops where name like :key order by :orderBy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */

    public function show($shopId)
    {
        $shop = Shop::find($shopId);
        if (!empty($shop)){
            return response()->json($shop);
        }
        else {
            return response()->json([
                'message' => 'Az elem nem létezik!'
            ],404);
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $shop=Shop::findOrFail($request->input('id'));
        $shop->name = $request->input('name');
        $shop->taxId = $request->input('taxId');
        $shop->mobile = $request->input('mobile');
        $shop->email = $request->input('email');
        $shop->website = $request->input('website');
        $shop->user_id = $request->input('user_id');
        $shop->estYear = $request->input('estYear');
		$shop->adress = $request->input('adress');
		$shop->intro = $request->input('intro');
		$shop->save();
        return response(200);
    }
    public function create(Request $request){
        $shop= new Shop;
        $shop->name = $request->input('name');
        $shop->taxId = $request->input('taxId');
        $shop->mobile = $request->input('mobile');
        $shop->email = $request->input('email');
        $shop->website = $request->input('website');
        $shop->user_id = $request->input('user_id');
        $shop->estYear = $request->input('estYear');
		$shop->adress = $request->input('adress');
		$shop->intro = $request->input('intro');
		$shop->save();
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
