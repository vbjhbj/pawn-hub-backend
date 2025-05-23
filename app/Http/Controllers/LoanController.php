<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Shop;
use App\Models\Customer;
use App\Models\User;
use App\Models\Type;
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
        /*$expiredloans[] = DB::table("loans")->where('expDate', '<=', now()->toDate());
        foreach ($expiredloans as $loan){
            $loan->delete();
        }*/

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

        if (!$shop){
            $loans=DB::table("loans")->where("customer_id", $customer->id)->get();


            for ($i = 0; $i < count($loans); $i++) {

                $tmpShop = Shop::findOrFail($loans[$i]->shop_id);
                $tmpUser = User::findOrFail($tmpShop->user_id);

                $loans[$i]->shop = [
                    'id' => $tmpShop->id,
                    'name' => $tmpShop->name,
                    'img' => $tmpUser->img,
                ];

                unset($loans[$i]->shop_id);

            }


        }else{ // If shop:

            $loans=DB::table("loans")->where("shop_id", $shop->id)->get();

            for ($i = 0; $i < count($loans); $i++) {

                $tmpCust = Customer::findOrFail($loans[$i]->customer_id);
                $tmpUser = User::findOrFail($tmpCust->user_id);

                $loans[$i]->customer = [
                    'id' => $tmpCust->id,
                    'name' => $tmpCust->name,
                    'img' => $tmpUser->img,
                ];

                unset($loans[$i]->customer_id);

            }
        }

        for ($i= 0; $i< count($loans); $i++) {
            $items = DB::table("items")->where("loan_id", $loans[$i]->id)->get();

            for ($j= 0; $j< count($items); $j++) {
                $items[$j]->type = [
                    'id' => $items[$j]->type_id,
                    'name' => Type::find($items[$j]->type_id)->name
                ];
                unset($items[$j]->type_id);
                //unset($items[$j]->img);
            }

            $loans[$i]->items = $items;
            
        }

        return response()->json($loans);
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

    public function update(Request $request)
    {

        $id = $request->input('id');
        $description = $request->input('description');
        $expDate = $request->input('expDate');
        

        $user = Auth::user();
        $shop = DB::table("shops")->where('user_id', $user->id)->first();
        
        $loan = DB::table("loans")->where('id', $id)->first();

        if (!$shop || $loan->shop_id != $shop->id){
            return response()->json([
                'error' => [
                    'code' => 'FORBIDDEN',
                    'message' => 'Nincs joga módosítani az adósságot!'
                ]
            ],403);
        }
        else if (!$loan) {
            return response()->json([
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Az elem nem létezik!'
                ]
            ],404);
        }
        else { // If Everything's OK

            return response()->json([
                'id' => $request->input('id'),
                'description' => $request->input('description'),
                'expDate' => $request->input('expDate')
            ],200);

            if ($expDate && $loan->expDate != $expDate) {
                $loan->expDate = $expDate;
            }
            if ($description && $loan->description != $description) {
                $loan->description = $expDate;
            }

            $loan->save();
            

        }

        return response()->json([
            'message' => 'Adósság frissítve.',
            'id' => $loan->id
        ],200);
    }

    public function create(Request $request)
    {

        $user = Auth::user();
        $shop = DB::table("shops")->where('user_id', $user->id)->first();

        $loan=new Loan;
        $loan->customer_id = $request->input('customer_id');
        $loan->shop_id = $shop->id;
        $loan->expDate = $request->input('expDate');
        $loan->givenAmount = $request->input('givenAmount');
        $loan->interest = $request->input('interest');
        $loan->created_at = $request->input('creationDate');
        $loan->description = $request->input('description');
        $loan->save();

        return response()->json([
            'message' => 'Adósság létrehozva.',
            'id' => $loan->id
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($loanId)
    {
        $user = User::find(Auth::user()->id);
        $shop=Shop::where("user_id", $user->id);
        $loan = Loan::find($loanId);
        if ($loan->shop_id == $shop->id){
            $loan->delete();
       }
    }
}
