<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\DeletedUser;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $key = $request->query('searchKey');
        $holding = $request->input('hold');
        $sFor = $request->query("searchIn");
        $page = $request->query("page")-1;
        $order = $request->query("orderBy");
        $settlements[] = explode(',',$request->query("settlements"));
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
        foreach ($settlements as $setl){
            $shops[] = Shop::where("settlement_id", $setl)->where($sFor, 'like', '%'.$key.'%')->get();
        }
        return response()->json($shops);
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
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Az elem nem létezik!'
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
                'email' => 'unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/',
                'password' => 'min:8',
                'name' => 'min:5|max:100',
                'taxId' => 'regex:/^\\d{8}-\\d-\\d{2}$/', // 12345678-9-12
                'settlement_id' => 'int',
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
        $shop->website = $request->input('website') ?? $shop->website;
        $shop->estYear = $request->input('estYear') ?? $shop->estYear;
		$shop->address = $request->input('address') ?? $shop->address;
		$shop->intro = $request->input('intro') ?? $shop->intro;
		$shop->settlement_id = $request->input('settlement_id') ?? $shop->settlement_id;

        $user->img = $request->input('img') ?? $user->img;
        $user->iban = $request->input('iban') ?? $user->iban;
        $user->password = Hash::make($request->input('password')) ?? $user->password;

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
        $shop->website = $request->input('website');
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
        $shop=Shop::findOrFail($shop->user_id);
        $deletedUser = new DeletedUser;
        $deletedUser->lastTransaction= $user->lastTransaction;
        $deletedUser->iban = $user->iban;
        $deletedUser->name = $shop->name;
        $shop->delete();
        $user->delete();
    }
}
