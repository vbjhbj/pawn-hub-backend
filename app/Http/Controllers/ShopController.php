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
    public function index()
    {
        
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
        
        $user=User::findOrFail(Auth::user()->id);
        $shop=Shop::findOrFail($shop->user_id);
        $user->email = $request->input('email');
        $user->iban = $request->input('iban');
        $user->save();
        $shop->name = $request->input('name');
        $shop->taxId = $request->input('taxId');
        $shop->mobile = $request->input('mobile');
        $shop->email = $request->input('email');
        $shop->website = $request->input('website');
        $shop->estYear = $request->input('estYear');
		$shop->address = $request->input('address');
		$shop->intro = $request->input('intro');
		$shop->save();
        return response(200);
    }
    public function create(Request $request){
        $request->validate([
            'username' => 'required|max:25|min:3',
            'email' => 'required|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'password' => 'required',
            'name' => 'required', // At least 1 spaces; Capitalized words; ". " allowed
            'taxId' => 'required|regex:/^\d{8}-\d-\d{2}$/',
            'settlement_id' => 'required|int',
            'address' => 'required'
        ]); 
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
    public function destroy()
    {
        $user=User::findOrFail(Auth::user()->id);
        $shop=Shop::findOrFail($shop->user_id);
        $deletedUser = new DeletedUser;
        $deletedUser->lastTransaction= $user->lastTransaction;
        $deletedUser->iban = $user->iban;
        $deletedUser->name = $shop->name;
        $shop->delete();
        $user->delete();
    }
}
