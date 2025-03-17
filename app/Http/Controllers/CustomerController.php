<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\DeletedUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



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
        $shop = DB::table("shops")->where('user_id', $user->id);
        $connections = DB::table("connections")->where('shop_id', $shop->id);
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
        $sFor = $request->query("status");
        $results = DB::table("customers")->where('shop_id', $shop->id)->where($sfor, 'like', '%'.$key.'%')->orderBy($order, $asc)->skip($page*30)->take(30);
        foreach ($connections as $con){
            DB::table("customers")->where('id', $con->customer_id)->where($sfor, 'like', '%'.$key.'%')->orderBy($order, $asc)->skip($page*30)->take(30);
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
        $user=User::findOrFail(Auth::user()->id);
        $shop=Shop::findOrFail($shop->user_id);
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
        $user=User::findOrFail(Auth::user()->id);
        $customer=customer::where("user_id", $user->id);
        if ($customer){
            $customer->idCardNum = $request->input('idCardNum');
            $customer->birthday = $request->input('birthday');
            $customer->idCardExp = $request->input('idCardExp');
            $customer->user_id = $request->input('user_id');
            $customer->shop_id = $request->input('shop_id');
            $customer->shippingAddress = $request->input('shippingAddress');
            $customer->billingAddress = $request->input('billingAddress');
            $customer->mobile = $request->input('mobile');
            $customer->email = $request->input('email');
            $user->email = $request->input('email');
            $user->iban = $request->input('iban');
            $user->save();
            $customer->save();
        }else{
            $shop=Shop::where("user_id", $user->id);
            $customer=customer::where("shop_id", $shop->id)->where("id", $request->input('id'));
            $customer->idCardNum = $request->input('idCardNum');
            $customer->birthday = $request->input('birthday');
            $customer->idCardExp = $request->input('idCardExp');
            $customer->user_id = $request->input('user_id');
            $customer->shop_id = $request->input('shop_id');
            $customer->shippingAddress = $request->input('shippingAddress');
            $customer->billingAddress = $request->input('billingAddress');
            $customer->mobile = $request->input('mobile');
            $customer->email = $request->input('email');
            $customer->save();
        }
        

        
    }

    public function create(Request $request)
    {

        try {
            $validated = $request->validate([
                'username' => 'required|unique:users|max:25|min:3|regex:/^[a-zA-Z0-9_.-]+$/',
                'email' => 'required|unique:users|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'password' => 'required',
                'name' => 'required|regex:/^(?:[A-Z][a-z]*(?:[-\'][A-Z][a-z]*)*(?:\. (?=[A-Z]))? ?)+$/', // At least 1 spaces; Capitalized words; ". ", "'" and "-" allowed
                'idCardNum' => 'required',
                'idCardExp' => 'required|date'
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
