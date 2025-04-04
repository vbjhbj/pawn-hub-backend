<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = $request->query("searchKey");
        $pCode = $request->query("postCode");
        if($key!=null){
            $results = DB::table("settlements")->where( 'name', 'like', $key.'%')->get();
        }else{
            $results = DB::table("settlements")->where('postalCode', 'like', $pCode.'%')->get();
        }
        return response()->json($results);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function show($settlementId)
    {
        $settlement = Settlement::with("holding")->find($settlementId);

        return response()->json($settlement);
    }
}
