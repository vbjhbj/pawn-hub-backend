<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\DeletedUser;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\Functions;




class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $shop = DB::table("shops")->where('user_id', $user->id)->first();
        $connections = DB::table("connections")->where('shop_id', $shop->id)->get();
        $page = $request->query("page")-1;
        $key = $request->query("searchKey");
        $sFor = $request->query("searchIn");
        $order = $request->query("orderBy");
        if($request->query("asc")){
            $asc = "asc";
        }
        else{
            $asc = "desc";
        }
        
        $results = DB::table("customers")->where('shop_id', $shop->id)->where($sFor, 'like', '%'.$key.'%')->orderBy($order, $asc)->skip($page*30)->take(30)->get();
        foreach ($connections as $con){
            DB::table("customers")->where('id', $con->customer_id)->where($sFor, 'like', '%'.$key.'%')->orderBy($order, $asc)->skip($page*30)->take(30)->get();
        }
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId=Auth::id();
        $user=User::findOrFail($userId);
        $shop=Shop::where("user_id", $userId)->first();
        $customer=new customer;
        $customer->name = $request->input('name');
        $customer->idCardNum = $request->input('idCardNum');
        $customer->birthday = $request->input('birthday');
        $customer->idCardExp = $request->input('idCardExp');
        $customer->user_id = null;
        $customer->shop_id = $shop->id;
        $customer->shippingAddress = $request->input('shippingAddress');
		$customer->billingAddress = $request->input('billingAddress');
		$customer->mobile = $request->input('mobile');
        $customer->email = $request->input('email');
		$customer->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customerId)
    {
        $customer = Customer::find($customerId);
        if (!empty($customer)){
            
            return response()->json($customer);
        }
        else {
            return response()->json([
                'message' => 'Az elem nem létezik!'
            ],404);
        }
        
    }

    public function showNU(customer $customer)
    {
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
        try {
            $validated = $request->validate([
                'username' => 'unique:users|max:25|min:3|regex:/^[a-zA-Z0-9_.-]+$/', // Allowed: A-Z, a-z, 0-9, and tree specials: -._
                'email' => 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'password' => 'min:8',
                'name' => "regex:/^(?:[A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]+(?:[-'][A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]*)*)(?: (?:[A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]+(?:[-'][A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]*)*))+(?:\\. (?=[A-Z]))?$/", // At least 1 spaces; Capitalized words; ". ", "'" and "-" allowed
                'idCardExp' => 'date',
                'iban' => ['regex:/(?:^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$|^<null>$)/']
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                "errors" => $e->errors()
                
            ], 422);

        }

        $user=User::findOrFail(Auth::user()->id);

        $customer=Customer::where("user_id", $user->id)->first();

        if ($customer){
            $customer->idCardNum = $request->input('idCardNum') ?? $customer->idCardNum;
            $customer->birthday = $request->input('birthday') ?? $customer->birthday;
            $customer->idCardExp = $request->input('idCardExp') ?? $customer->idCardExp;
            $customer->shippingAddress = Functions::handleNull($request->input('shippingAddress')) ?? $customer->shippingAddress;
            $customer->billingAddress = Functions::handleNull($request->input('billingAddress')) ?? $customer->billingAddress;
            $customer->mobile = Functions::handleNull($request->input('mobile')) ?? $customer->mobile;
            $customer->name = $request->input('name') ?? $customer->name;

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
                    $customer->email = $request->input('email');
                }
            }

            $user->password = Hash::make($request->input('password')) ?? $user->password;
            $user->iban = Functions::handleNull($request->input('iban')) ?? $user->iban;
            $user->img = $request->input('img') ?? $user->img;

            $user->save();
            $customer->save();

            return response()->json([
                "message" => 'Data modified.'
            ], 200);

        } else {
            $shop=Shop::where("user_id", $user->id);
            $customer=customer::where("shop_id", $shop->id)->where("id", $request->input('id'));
            $customer->idCardNum = $request->input('idCardNum') ?? $customer->idCardNum;
            $customer->birthday = $request->input('birthday') ?? $customer->birthday;
            $customer->idCardExp = $request->input('idCardExp') ?? $customer->idCardExp;
            $customer->shippingAddress = $request->input('shippingAddress') ?? $customer->shippingAddress;
            $customer->billingAddress = $request->input('billingAddress') ?? $customer->billingAddress;
            $customer->mobile = $request->input('mobile') ?? $customer->mobile;
            $customer->email = $request->input('email') ?? $customer->email;
            $customer->save();
        }
        

        
    }

    public function create(Request $request)
    {

        try {
            $validated = $request->validate([
                'username' => 'required|unique:users|max:25|min:3|regex:/^[a-zA-Z0-9_.-]+$/', // Allowed: A-Z, a-z, 0-9, and tree specials: -._
                'email' => 'required|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'password' => 'required|min:8',
                'name' => "required|regex:/^(?:[A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]+(?:[-'][A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]*)*)(?: (?:[A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]+(?:[-'][A-ZÁÉÍÓÖŐÚÜŰÄÖÜẞÈÊËÑÅÆØČĆĐŠŽŁŃĘÓ][a-záéíóöőúüűäöüßèêëñåæøčćđšžłńęó]*)*))+(?:\\. (?=[A-Z]))?$/", // At least 1 spaces; Capitalized words; ". ", "'" and "-" allowed
                'idCardNum' => 'required',
                'idCardExp' => 'required|date',
                'iban' => ['regex:/(?:^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$|^$)/']
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
        $user->img = $request->input('img');
        $user->isCustomer = true;
        
		$user->save();

        $customer=new customer;
        $customer->name = $request->input('name');
        $customer->idCardNum = $request->input('idCardNum');
        $customer->birthday = $request->input('birthday');
        $customer->idCardExp = $request->input('idCardExp');
        $customer->user_id = $user->id;
        $customer->shop_id = null;
        $customer->shippingAddress = $request->input('shippingAddress');
		$customer->billingAddress = $request->input('billingAddress');
		$customer->mobile = $request->input('mobile');
        $customer->email = $request->input('email');
		$customer->save();

        return response()->json([
            
            'message' => 'Customer created.'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customerId)
    {
        $user = User::find(Auth::user()->id);
        $customer = Customer::find($customerId);
        if ($customer->user_id == NULL && $customer->shop_id ==$user->id){
            $customer->delete();
        }
        else if ($customer->user_id == $user->id){
            $deletedUser = new DeletedUser;
            $deletedUser->lastTransaction= $user->lastTransaction;
            $deletedUser->iban = $user->iban;
            $deletedUser->name = $customer->name;
            $customer->delete();
            $user->delete();
        }
    }
}
