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
        $this->middleware('auth:api', ['except' => ['getProductByCat', 'discountedProduct']]);
    }

    /**
     * @OA\Get(
     *      path="/api/productbycat",
     *      operationId="getProduct",
     *      tags={"Product"},
     *      summary="Get Product By Category",
     *      description="Get product form category",
     *     @OA\Parameter(
     *          name="isAll",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
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
    public function getProductByCat(Request $request)
    {
        if( $request->isAll ) {
            $products = [
                'Album' => Productcat::where('title', 'Album')->first()->products()
                    ->orderBy('id', 'DESC')->get()->all(),
                'MetalPin' => Productcat::where('title', 'MetalPin')->first()->products()
                    ->orderBy('id', 'DESC')->get()->all(),
                'Sticker' => Productcat::where('title', 'Sticker')->first()->products()
                    ->orderBy('id', 'DESC')->get()->all(),
            ];
        }
        else {
            $products = [
                'Album' => Productcat::where('title', 'Album')->first()->products()
                    ->orderBy('id', 'DESC')->take(4)->get()->all(),
                'MetalPin' => Productcat::where('title', 'MetalPin')->first()->products()
                    ->orderBy('id', 'DESC')->take(4)->get()->all(),
                'Sticker' => Productcat::where('title', 'Sticker')->first()->products()
                    ->orderBy('id', 'DESC')->take(4)->get()->all(),
            ];
        }
        ;
        $response = [
            'products' => $products,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/product",
     *      operationId="getAllProduct",
     *      tags={"Product"},
     *      summary="Get Products",
     *      description="Get all product",
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
        $product = Product::orderBy('id', 'DESC')->get();
        $response = [
            'products' => $product,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }
    /**
     * @OA\Get(
     *      path="/api/discounted/products",
     *      operationId="getAllProduct",
     *      tags={"Product"},
     *      summary="Get discounted Products",
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function discountedProduct()
    {
        $products = [
            'Album' => Productcat::where('title', 'Album')->first()->products()
                ->has('discount')->with('discount')->orderBy('id', 'DESC')->take(4)->get()->all(),
            'MetalPin' => Productcat::where('title', 'MetalPin')->first()->products()
                ->has('discount')->with('discount')->orderBy('id', 'DESC')->take(4)->get()->all(),
            'Sticker' => Productcat::where('title', 'Sticker')->first()->products()
                ->has('discount')->with('discount')->orderBy('id', 'DESC')->take(4)->get()->all(),
        ];
        $response = [
            'discounted_products' => $products,
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
     *                @OA\Property(property="title",type="string",),
     *                 @OA\Property(property="summary",type="string",),
     *                 @OA\Property(property="description",type="string",),
     *                 @OA\Property(property="media_id",type="integer",),
     *                 @OA\Property(property="code",type="string",),
     *                 @OA\Property(property="price",type="integer",),
     *                 @OA\Property(property="inventory",type="integer",),
     *                 @OA\Property(property="productcat_id",type="integer",),
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
        $product = Product::create($request->all());
        $response = [
            'products' => $product,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/product/{productId}",
     *      operationId="getProductByID",
     *      tags={"Product"},
     *     @OA\Parameter(
     *          name="productId",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
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
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $response = [
            'product' => $product,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }


    /**
     * @OA\Put(
     *      path="/api/product/{product}",
     *      operationId="updateProduct",
     *      tags={"Product"},
     *     @OA\Parameter(
     *          name="product",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="raw",
     *             @OA\Schema(
     *                @OA\Property(property="title",type="string",),
     *                 @OA\Property(property="summary",type="string",),
     *                 @OA\Property(property="description",type="string",),
     *                 @OA\Property(property="media_id",type="integer",),
     *                 @OA\Property(property="code",type="string",),
     *                 @OA\Property(property="price",type="integer",),
     *                 @OA\Property(property="inventory",type="integer",),
     *                 @OA\Property(property="productcat_id",type="integer",),
     *          )
     *         ),
     *     ),
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
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $data = $product->update( $request->all() );
        $response = [
            'product' => $product,
            'message' => 'ok'
        ];
        return response()->json($request->all(), 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/product/{product}",
     *      operationId="deleteProduct",
     *      tags={"Product"},
     *      summary="Delete product",
     *      description="Delete product",
     *     @OA\Parameter(
     *          name="product",
     *          description="Product id",
     *          required=true,
     *          in="path",
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
     * @param Request $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $data = Product::find($product->id)->delete();
        $response = [
            'data' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }
}
