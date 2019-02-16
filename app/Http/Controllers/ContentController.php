<?php

namespace App\Http\Controllers;

use App\Content;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class ContentController extends Controller
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
     *      path="/api/contents",
     *      operationId="getAllContents",
     *      tags={"Contents"},
     *      description="Get all Contents",
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
        $data = Content::all();
        $response = [
            'contents' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/contents",
     *      operationId="SoteContent",
     *      tags={"Contents"},
     *      summary="Store Contents",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="title",type="string",),
     *                 @OA\Property(property="summary",type="string",),
     *                 @OA\Property(property="description",type="string",),
     *                 @OA\Property(property="media_id",type="integer",),
     *                 @OA\Property(property="contentcat_id",type="integer",),
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
        $content = Content::create( $request->all() );
        $response = [
            'content' => $content,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/contents/{contentId}",
     *      operationId="GetContentById",
     *      tags={"Contents"},
     *     @OA\Parameter(
     *          name="contentId",
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
     * @param Content $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        $response = [
            'content' => $content,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Put(
     *      path="/api/contents/{contentId}",
     *      operationId="UpdateContent",
     *      tags={"Contents"},
     *      summary="UpdateContents",
     *     @OA\Parameter(
     *          name="contentId",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="title",type="string",),
     *                 @OA\Property(property="summary",type="string",),
     *                 @OA\Property(property="description",type="string",),
     *                 @OA\Property(property="media_id",type="integer",),
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
    public function update(Request $request, Content $content)
    {
        $data = $content->update( $request->all() );
        $response = [
            'content' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/contents/{contentId}",
     *      operationId="GetContentById",
     *      tags={"Contents"},
     *     @OA\Parameter(
     *          name="contentId",
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
     * @param Content $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $data = Content::find($content->id)->delete();
        $response = [
            'content' => $data,
            'message' => 'ok'
        ];
        return response()->json($response, 200);

    }
}
