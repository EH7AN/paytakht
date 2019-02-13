<?php

namespace App\Http\Controllers;

use App\Product;
use App\Productcat;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'show']]);
    }
    /**
     * @OA\Get(
     *      path="/api/product",
     *      operationId="getProduct",
     *      tags={"Product"},
     *      summary="Get Product By Category",
     *      description="Get product form category",
     *     @OA\Parameter(
     *          name="category_id",
     *          description="Product category",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      security={ {"bearer": {}} },
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'category_id' => 'integer|required',
        ]);
        $product = Productcat::find($request->category_id)->products;
        $response = [
            'product' => $product,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/product",
     *      operationId="StoreProduct",
     *      tags={"Product"},
     *      summary="Store product",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
 *                      @OA\Property(
     *                      property="title",
     *                      description="Email address of the new user.",
     *                      type="string",
     *                  ),
     *                      @OA\Property(
     *                      property="sa",
     *                      description="Email address of the new user.",
     *                      type="string",
     *                  ),
     *          )
     *         ),
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      security={ {"bearer": {}} },
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json($request->all(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
