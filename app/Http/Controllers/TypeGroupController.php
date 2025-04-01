<?php

namespace App\Http\Controllers;

use App\Models\TypeGroup;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$typeGroups = DB::table("typeGroups")->join('types', 'typeGroups_id', '=', 'typeGroups.id')->get();
        $typeGroups = DB::select("SELECT  FROM typeGroups JOIN types ON types.typeGroups_id = typeGroups.id");

        return response()->json($typeGroups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeGroup  $typeGroup
     * @return \Illuminate\Http\Response
     */
    public function show(TypeGroup $typeGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeGroup  $typeGroup
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeGroup  $typeGroup
     * @return \Illuminate\Http\Response
     */

}
