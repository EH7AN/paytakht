<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/slider",
     *      operationId="getAllSilders",
     *      tags={"Slider"},
     *      description="Get all Sliders",
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
        $sliders = Slider::all();
        $response = [
            'sliders' => $sliders,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
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
        $slider = Slider::create( $request->all() );
        $response = [
            'sliders' => $slider,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/slider/{sliderId}",
     *      operationId="getASilder",
     *      tags={"Slider"},
     *      description="Get Slider",
     *     @OA\Parameter(
     *          name="sliderId",
     *          description="slider id",
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
     * @param Slider $slider
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Slider $slider)
    {
        $response = [
            'slider' => $slider,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }


    /**
     * @OA\Put(
     *      path="/api/slider/{sliderId}",
     *      operationId="updateSlider",
     *      tags={"Slider"},
     *      summary="Store slider",
     *     @OA\Parameter(
     *          name="sliderId",
     *          description="slider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
    public function update(Request $request, Slider $slider)
    {
        $data = $slider->update( $request->all() );
        $response = [
            'sliders' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/slider/{sliderId}",
     *      operationId="DeleteSlider",
     *      tags={"Slider"},
     *      description="Delete slider",
     *     @OA\Parameter(
     *          name="sliderId",
     *          description="slider id",
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
     * @param Slider $slider
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Slider $slider)
    {
        $data = Slider::find($slider->id)->delete();
        $response = [
            'sliders' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }
}
