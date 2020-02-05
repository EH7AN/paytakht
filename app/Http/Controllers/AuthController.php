<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use App\Role;
use App\User;
use http\Env\Response;
use Kavenegar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="ehs.ghasemi@gmail.com"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup', 'sendAcCode',
            'checkActivationCode', 'registerUser']]);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="LoginUser",
     *      tags={"Auth"},
     *      summary="Login user using username and password",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="username",
     *          description="Username",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="User password",
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
     *      @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      security={ {"bearer": {}} },
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username','password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    /**
     * @OA\Get(
     *      path="/api/auth/me",
     *      operationId="Get auth user",
     *      tags={"Auth"},
     *      summary="Get authed user",
     *      description="Returns current authed user",
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
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="LogOut",
     *      tags={"Auth"},
     *      summary="Log the user out (Invalidate the token).",
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
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="RefreshToken",
     *      tags={"Auth"},
     *      summary="Refresh a token.",
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
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => 'bearer '.$token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/signup",
     *      operationId="SignUpUser",
     *      tags={"Auth"},
     *      summary="User sign up",
     *     @OA\Parameter(
     *          name="name",
     *          description="User name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="family",
     *          description="User family",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="email",
     *          description="User email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="User password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          description="User password confirmation",
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
    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'password'=> 'required|confirmed'
        ]);
        $user = new User( $request->all() );
        $user->role_id = Role::where('slug','user')->first()->id;
        $user->save();
        return response()->json(['message' => 'Successfully registered']);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/user/register",
     *      operationId="RegisterUser",
     *      tags={"Auth"},
     *      summary="Register new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="number",type="integer",),
     *                @OA\Property(property="password",type="string",),
     *                @OA\Property(property="password_confirmation",type="string",),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'password'=> 'required|confirmed'
        ]);
        $user = User::where('mobile', $request->number)->first();
        $user->name = $request->name;
        $user->family = $request->family;
        $user->email = $request->email;
        $user->password = $request->password;
        $res = $user->save();
        if ($res) {
            $credentials = request(['email','password']);
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/auth/user/profile/update",
     *      operationId="RegisterUser",
     *      tags={"Auth"},
     *      summary="Register new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="name",type="string",),
     *                @OA\Property(property="family",type="string",),
     *                @OA\Property(property="email",type="string",),
     *                @OA\Property(property="postal_code",type="string",),
     *                @OA\Property(property="national_code",type="string",),
     *                @OA\Property(property="address",type="string",),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update( $request->all() );
        $response = [
            'user' => $user,
            'message' => 'ok',
        ];
        return response()->json($response, 200);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/user/profile/changepass",
     *      operationId="ChangeUserPass",
     *      tags={"Auth"},
     *      summary="Change User Password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="password",type="string",),
     *                @OA\Property(property="password_confirmation",type="string",),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password'=> 'required|confirmed'
        ]);
        $user = auth()->user();
        $user->update( $request->all() );
        return response()->json(['message' => 'Successfully registered']);
    }
}
