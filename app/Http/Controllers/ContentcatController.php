<?php

namespace App\Http\Controllers;

use App\Contentcat;
use Illuminate\Http\Request;

class ContentcatController extends Controller
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
     *      path="/api/content/category",
     *      operationId="getAllContentCategory",
     *      tags={"Content_Category"},
     *      description="Get all Content Category",
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
        $data = Contentcat::all();
        $response = [
            'categories' => $data,
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
     * @param  \App\Contentcat  $contentcat
     * @return \Illuminate\Http\Response
     */
    public function show(Contentcat $contentcat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contentcat  $contentcat
     * @return \Illuminate\Http\Response
     */
    public function edit(Contentcat $contentcat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contentcat  $contentcat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contentcat $contentcat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contentcat  $contentcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contentcat $contentcat)
    {
        //
    }
}
