<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\CompactDisc;

class CompactDiscController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    /**
     * Insert new compact disc to database
     * 
     * @param Request $request
     * @return Response
     */
    public function insert(Request $request)
    {
        return response()->json(CompactDisc::create($request->all(), 200));
    }

    /**
     * Retrieve the compact disc for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json(CompactDisc::findOrFail($id), 200);
    }

    /**
     * Retrive all compact disc from db
     * 
     * @return Response
     */
    public function index()
    {
        return response()->json(CompactDisc::all(), 200);
    }

    /**
     * Update data the compact disc for the given ID
     * 
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id){
        $compactDisc = CompactDisc::findOrFail($id);
        $compactDisc->title = $request->title;
        $compactDisc->rate = $request->rate;
        $compactDisc->category = $request->category;
        $compactDisc->quantity = $request->quantity;

        $compactDisc->save();

        return response()->json($compactDisc, 201);
    }    

    /**
     * Update data the compact disc for the given ID
     * 
     * @param Request $request
     * @return Response
     */
    public function updateStock(Request $request, $id)
    {
        $compactDisc = CompactDisc::findOrFail($id);
        $compactDisc->quantity = $request->quantity;

        $compactDisc->save();
        
        return response()->json($compactDisc, 201);
    }     
}
