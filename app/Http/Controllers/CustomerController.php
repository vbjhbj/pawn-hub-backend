<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\DeletedUser;
use Illuminate\Http\Request;

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
        $customer=new customer;
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
        }
    }
}
