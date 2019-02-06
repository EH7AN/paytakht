<?php

namespace App\Http\Controllers;

use App\Productcat;
use Illuminate\Http\Request;

class ProductcatController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'category_id' => 'integer|required',
        ]);
        $product = Productcat::find($request->category_id)->product;
        $response = [
            'product' => $product,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  \App\Productcat  $productcat
     * @return \Illuminate\Http\Response
     */
    public function show(Productcat $productcat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Productcat  $productcat
     * @return \Illuminate\Http\Response
     */
    public function edit(Productcat $productcat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Productcat  $productcat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productcat $productcat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Productcat  $productcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productcat $productcat)
    {
        //
    }
}
