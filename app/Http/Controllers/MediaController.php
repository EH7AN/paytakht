<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class MediaController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show']]);
    }

    /**
     * @OA\Post(
     *      path="/api/media",
     *      operationId="StorePhoto",
     *      tags={"Media"},
     *      summary="Store media",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="file",
     *                     format="file",
     *                 ),
     *                 required={"file"}
     *             )
     *         )
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->file->store('medias');
        $media_name = $request->file->hashName();
        $media = new Media([
            'name' => $media_name
        ]);
        $media->save();
        $media['preview_url'] = URL::to('/storage/medias/'.$media_name);
        $response = [
            'data' => $media,
            'msg' => 'ok'
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/media/{media_id}",
     *      operationId="Get Media preview by id",
     *      tags={"Media"},
     *      summary="Get Preview",
     *      description="Returns Preview of given media id",
     *     @OA\Parameter(
     *          name="media_id",
     *          description="Media id for file",
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
     * @param Media $medium
     * @return \Illuminate\Http\Response
     */
    public function show(Media $medium)
    {
        $path = storage_path('app/public/medias/' . $medium->name);
//        return response()->json($path, 200);
        if (!File::exists($path)) {
            return response()->json(['message'=>'file not found'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

}
