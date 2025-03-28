<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $expiredloans[] = DB::table("loans")->where('expDate', '<=', now()->toDate());
        foreach ($expiredloans as $loan){
            $loan->delete();
        }


        $user = Auth::user();
        $shop = DB::table("shops")->where('user_id', $user->id)->first();
        if (!$shop){
            $customer = DB::table("customers")->where('user_id', $user->id)->first();
        }
        $page = $request->query("page")-1;
        $key = $request->query("searchKey");
        $sFor = $request->query("searchIn");
        if(!$sFor){
            $sFor="expDate";
        }
        $order = $request->query("orderBy");
        if(!$order){
            $order="expDate";
        }
        if($request->query("asc")){
            $asc = "asc";
        }
        else{
            $asc = "desc";
        }
        $results = array();
        if (!$shop){
            $loans=DB::table("loans")->where("customer_id", $customer->id)->get();
        }else{
            $loans= DB::table("loans")
            ->where($sFor, 'like', '%'.$key.'%')
            ->orderBy($order, $asc)
            ->skip($page*30)->take(30)->get();
        }
        $results[]=$loans;
        foreach ($loans as $loan){
            $results[]=DB::table("items")->where("loan_id", $loan->id)->get();
        }
        return json_encode($results);
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($loanId)
    {
        $loan = Loan::find($loanId);
        $items = DB::table('items')->where("loan_id", $loanId)->get();
        $loan += $items;
        if (!empty($loan)){
            return response()->json($loan);
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $loan=Loan::findOrFail($request->input('id'));
        $loan->customer_id = $request->input('customer_id');
        $loan->shop_id = $request->input('shop_id');
        $loan->expDate = $request->input('expDate');
        $loan->givenAmount = $request->input('givenAmount');
        $loan->interest = $request->input('interest');
        $loan->save();
    }

    public function create(Request $request)
    {
        $loan=new Loan;
        $loan->customer_id = $request->input('customer_id');
        $loan->shop_id = $request->input('shop_id');
        $loan->expDate = $request->input('expDate');
        $loan->givenAmount = $request->input('givenAmount');
        $loan->interest = $request->input('interest');
        $loan->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($loanId)
    {
        $loan = Loan::find($loanId);
        $loan->delete();
    }
}
