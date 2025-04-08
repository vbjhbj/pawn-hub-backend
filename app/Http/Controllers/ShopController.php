<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\DeletedUser;
use App\Models\User;
use App\Models\Loan;
use App\Models\Message;
use App\Models\Connection;
use App\Models\Item;
use App\Models\Customer;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Functions;




class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = "%" . $request->query('searchKey') . "%" ?? "%";
        $holding = $request->query('hold');
        $sFor = $request->query("searchIn");
        $page = ($request->query("page") ?? 1) - 1;
        $order = $request->query("orderBy");
        
        $settlements = [];

        if ($request->query("settlements")){
            $settlements[] = explode(',',$request->query("settlements"));
        }
        else {
            $settlements = [];
        }

        if($holding){
            $settlements[] = DB::table("settlements")->where('holding_id', $holding)->get('id');
        }
        if(!$sFor){
            $sFor = "name";
        }
        if(!$order){
            $order= "name";
        }
        if($request->query("asc")){
            $asc = "asc";
        }
        else{
            $asc = "desc";
        }
        if (count($settlements) == 0) {
            $shops[] = Shop::where($sFor, 'like', value: $key)->get();
        }

        foreach ($settlements as $setl){
            $shops[] = Shop::where("settlement_id", $setl)->where($sFor, 'like', $key)->get();
        }
        return response()->json($shops);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */

    public function show($shopId)
    {
        $shop = Shop::with("settlement")->find($shopId);
        if (!empty($shop)){
            $shop->iban = User::where("id", $shop->user_id)->first()->iban;

            unset($shop->settlement_id);

            $user = User::findOrFail($shop->user_id);

            $shop->img = $user->img;
            $shop->email = $user->email;
            $shop->username = $user->username;

            return response()->json($shop);
        }
        else {
            return response()->json([
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'A zálogház nem található.'
                ]
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
        try {
            $request->validate([
                'username' => 'unique:users|max:25|min:3|regex:/^[a-zA-Z0-9_.-]+$/', // Allowed: A-Z, a-z, 0-9, and tree specials: -._
                'email' => 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/',
                'password' => 'min:8',
                'name' => 'min:5|max:100',
                'taxId' => 'regex:/^\\d{8}-\\d-\\d{2}$/', // 12345678-9-12
                'settlement_id' => 'int',
                'website' => ["regex:/(?:^(https?:\\/\\/)([a-zA-Z0-9.-]+\\.[a-zA-Z]{2,})(\\/.*)?$|^<null>$)/"]

            ]); 
        }
        catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                "errors" => $e->errors()
                
            ], 422);

        }
        
        $user=User::findOrFail(Auth::user()->id);
        $shop=Shop::where("user_id", $user->id)->first();
        $shop->name = $request->input('name') ?? $shop->name;
        $shop->taxId = $request->input('taxId') ?? $shop->taxId;
        $shop->mobile = $request->input('mobile') ?? $shop->mobile;
        $shop->website = Functions::handleNull($request->input('website')) ?? $shop->website;
        if ($request->input('estYear')) {
            $estYear = Functions::handleNull($request->input('estYear')) == "" ? null : $request->input('estYear');
            $shop->estYear = $estYear;
        }
		$shop->address = $request->input('address') ?? $shop->address;
		$shop->intro = Functions::handleNull($request->input('intro')) ?? $shop->intro;
		$shop->settlement_id = $request->input('settlement_id') ?? $shop->settlement_id;
        $user->img = Functions::handleNull($request->input('img')) ?? $user->img;
        $user->iban = Functions::handleNull($request->input('iban')) ?? $user->iban;
        if (!is_null($request->input('email')) && $request->input('email') != $user->email){
            if ( User::where("email", $request->input('email'))->first() ){

                return response()->json([
                    "error" => [
                        'code' => "EXISTING_EMAIL",
                        'message' => 'Ez az e-mail-cím már használatban van!'
                    ]
                    
                ], 422);
            }
            else {
                $user->email = $request->input('email');
            }
        }
        if ($request->input('password')) {

            if ($request->input('oldPassword')) {

                if (Hash::check($request->input('oldPassword'), $user->password)){
                    
                    $user->password = Hash::make($request->input('password'));
                }
                else {
                    return response()->json([
                        "error" => [
                            'code' => "INVALID_PASSWORD",
                            'message' => 'Hibás jelszó!'
                        ]
                    ], 403);
                }
            }
            else {
                return response()->json([
                    "error" => [
                        'code' => "INVALID_PASSWORD",
                        'message' => 'Hibás jelszó!'
                    ]
                ], 403);
            }

        }
        $user->save();
		$shop->save();
        return response()->json([
            "message" => 'Data modified.'
        ], 200);
    }
    public function create(Request $request){
        try {
            $request->validate([
                'username' => 'required|unique:users|max:25|min:3|regex:/^[a-zA-Z0-9_.-]+$/', // Allowed: A-Z, a-z, 0-9, and tree specials: -._
                'email' => 'required|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/',
                'password' => 'required|min:8',
                'name' => 'required|min:5|max:100',
                'taxId' => 'required|regex:/^\\d{8}-\\d-\\d{2}$/', // 12345678-9-12
                'settlement_id' => 'required|int',
                'address' => 'required',
                'iban' => ['regex:/(?:^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$|^<null>$)/'],
                'website' => ["regex:/^(https?:\\/\\/)([a-zA-Z0-9.-]+\\.[a-zA-Z]{2,})(\\/.*)?$/"]
            ]); 
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "errors" => $e->errors()
                
            ], 422);
        }
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->iban = $request->input('iban');
        $user->isCustomer = false;
        $user->img = $request->input('img');
        
		$user->save();

        $shop= new Shop;
        $shop->name = $request->input('name');
        $shop->taxId = $request->input('taxId');
        $shop->mobile = $request->input('mobile');
        $shop->website = Functions::handleNull($request->input('website'));
        $shop->user_id = $user->id;
        $shop->estYear = $request->input('estYear');
        $shop->settlement_id = $request->input('settlement_id');
		$shop->address = $request->input('address');
		$shop->intro = $request->input('intro');
		$shop->save();

        return response()->json([
            'message' => 'Shop created.'
        ], 200);
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
        $shop=Shop::where("user_id", $user->id)->first();
        $toDelete = [];
        array_push($toDelete, ...Loan::where("shop_id", $shop->id)->get());
        array_push($toDelete, ...Item::where("shop_id", $shop->id)->get());
        array_push($toDelete, ...Customer::where("shop_id", $shop->id)->get());
        array_push($toDelete, ...Connection::where("shop_id", $shop->id)->get());
        if (count($toDelete) > 0) {
            foreach ($toDelete as $element) {
                $element->delete();
            }
        }

        $shop->delete();
        $user->delete();

        return response()->json([

            'message' => 'Zálogházfiók törölve.'
        ], 200);
    }
}
