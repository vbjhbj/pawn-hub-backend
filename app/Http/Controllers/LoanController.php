<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $page, string $key, int $orderBy, bool $order, string $searchParam, bool $param) 
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($loanId)
    {
        $loan = Loan::find($loanId);
        if (!empty($loan)){
            return response()->json($loan);
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $loanId)
    {
        $loan=Loan::findOrFail($loanId);
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
    public function destroy(Loan $loan)
    {
        //
    }
}
