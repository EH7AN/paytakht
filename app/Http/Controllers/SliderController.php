<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @OA\Post(
     *      path="/api/slider",
     *      operationId="StoreSlider",
     *      tags={"Slider"},
     *      summary="Store slider",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title",type="string",),
     *                 @OA\Property(property="link",type="string",),
     *                 @OA\Property(property="image_media_id",type="integer",),
     *                 @OA\Property(property="logo_media_id",type="integer",),
     *                 @OA\Property(property="type",type="string",),
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
     * @param  \App\Slider  $silder
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $silder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $silder
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $silder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $silder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $silder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $silder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $silder)
    {
        //
    }
}
