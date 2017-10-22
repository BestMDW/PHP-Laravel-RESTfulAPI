<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find sellers (users with at least one product).
        $sellers = Seller::has('products')->get();

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $sellers], 200);
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
        // Find seller (user with at least one product) with specific ID.
        $seller = Seller::has('products')->findOrFail($id);

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $seller], 200);
    }
}
