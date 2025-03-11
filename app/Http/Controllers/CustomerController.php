<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\DeletedUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $customer=customer::findOrFail($request->input('id'));
        $customer->name = $request->input('name');
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

    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|max:25|min:3',
            'email' => 'required|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'password' => 'required|regex:/^[a-zA-Z0-9_-]{3,25}$/',
            'name' => 'required|regex:^(?:[A-Z][a-z]*(?:[-\'][A-Z][a-z]*)*(?:\. (?=[A-Z]))? ?)+$', // At least 1 spaces; Capitalized words; ". ", "'" and "-" allowed
            'idCardNum' => 'required|regex:^\d{6}[A-Z]{2}$',
            'idCardExp' => 'required|date'
        ]);

        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->iban = $request->input('iban');
        $user->isCustomer = false;
        
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
		$customer->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customerId)
    {
        $customer = Customer::find($customerId);
        if ($customer->user_id == NULL){
            $customer->delete();
        }
        else{
            $deletedUser = new DeletedUser;
            $user = User::find($customer->user_id);
            $deletedUser->lastTransaction= $user->lastTransaction;
            $deletedUser->iban = $user->iban;
            $deletedUser->name = $customer->name;
            $customer->delete();
            $user->delete();
        }
    }
}
