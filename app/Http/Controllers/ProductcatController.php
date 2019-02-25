<?php

namespace App\Http\Controllers;

use App\Productcat;
use Illuminate\Http\Request;

class ProductcatController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api',  ['except' => ['show', 'index']]);
    }
    /**
     * @OA\Get(
     *      path="/api/products/category",
     *      operationId="getAllProductCategory",
     *      tags={"Product_Category"},
     *      summary="Get Products Category",
     *      description="Get all product Category",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      security={ {"bearer": {}} },
     * )
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $productCategory = Productcat::all();
        $response = [
            'categories' => $productCategory,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json('ok', 200);
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
