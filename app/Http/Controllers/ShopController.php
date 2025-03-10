<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\DeletedUser;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;

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
		$shop->address = $request->input('address');
		$shop->intro = $request->input('intro');
		$shop->save();
        return response(200);
    }
    public function create(Request $request){
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->iban = $request->input('iban');
        $user->isCustomer = false;
        
		$user->save();

        $shop= new Shop;
        $shop->name = $request->input('name');
        $shop->taxId = $request->input('taxId');
        $shop->mobile = $request->input('mobile');
        $shop->website = $request->input('website');
        $shop->user_id = $user->id;
        $shop->estYear = $request->input('estYear');
        $shop->settlement_id = $request->input('settlement_id');
		$shop->address = $request->input('address');
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
    public function destroy($shopId)
    {
        $shop = Shop::find($shopId);
        $deletedUser = new DeletedUser;
        $user = User::find($shop->user_id);
        $deletedUser->lastTransaction= $user->lastTransaction;
        $deletedUser->iban = $user->iban;
        $deletedUser->name = $shop->name;
        $shop->delete();
        $user->delete();
    }
}
