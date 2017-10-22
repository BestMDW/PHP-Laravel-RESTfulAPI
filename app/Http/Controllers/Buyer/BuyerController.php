<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find buyers (users with at least one transaction).
        $buyers = Buyer::has('transactions')->get();

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $buyers], 200);
    }

    /******************************************************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find buyer (user with at least one transaction) with specific ID.
        $buyer = Buyer::has('transactions')->findOrFail($id);

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $buyer], 200);
    }
}
