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
}
