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
        $credentials = request(['email','password']);
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
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'email' => 'email|unique:users,email',
            'password'=> 'required|confirmed'
        ]);
        $user = new User( $request->all() );
        $user->role_id = Role::where('slug','user')->first()->id;
        $user->save();
        return response()->json(['message' => 'Successfully registered']);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/activation/send",
     *      operationId="SendSMS",
     *      tags={"Auth"},
     *      summary="SEND SMS",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="number",type="integer",),
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
    public function sendAcCode(Request $request)
    {

        $expiration_time = strtotime(date("Y-m-d h:i:s")) + 60*60;

        $activation_code = rand(5000,6000);
        $msg = 'کد فعال سازی :‌'.$activation_code;
        $data = $last_ac_code = ActivationCode::where([
            'phone_number' => $request->number,
        ])->first();
        if( $data ) {
            $last_ac_code->is_active = 0;
            $last_ac_code->save();
        }

        $saved_ac = ActivationCode::create([
            'phone_number' => $request->number,
            'activation_code' => $activation_code,
            'expiration_time' => $expiration_time
        ]);
       return response()->json(['msg' => $msg ], 200);

//        if ($saved_ac) {
//
//            try{
//                $sender = "100065995";
//                $message = $msg;
//                $receptor = [$request->number];
//                $result = Kavenegar::Send($sender,$receptor,$message);
//                if($result){
//                   return response()->json($result, 200);
//                }
//            }
//            catch(\Kavenegar\Exceptions\ApiException $e){
//                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
//                return response()->json($e->errorMessage(), 500);
//            }
//            catch(\Kavenegar\Exceptions\HttpException $e){
//                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
//                return response()->json($e->errorMessage(), 500);
//            }
//        }
//        else {
//            return response()->json(['message'=>'Error in saving data'], 500);
//        }
    }
    /**
     * @OA\Post(
     *      path="/api/auth/activation/check",
     *      operationId="CheckCode",
     *      tags={"Auth"},
     *      summary="Check activation code",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(property="number",type="integer",),
     *                @OA\Property(property="ac_code",type="integer",),
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
    public function checkActivationCode(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:users,mobile',
        ]);
        $current_time = strtotime(date("Y-m-d h:i:s"));
        $ac_code = ActivationCode::where([
            'phone_number' => $request->number,
            'activation_code' => $request->ac_code,
            'is_active' => 1
        ])->orderBy('id', 'DESC')->first();
        if ( $ac_code ) {
            if( $ac_code->expiration_time > $current_time ) {
                $password = rand(5000, 6000);
                $role_id = Role::where('slug','user')->first()->id;
                $user = User::create([
                    'mobile' => $request->number,
                    'password' => $password,
                    'role_id' => $role_id
                ]);
                if ( $user ) {
                    return response()->json(['message' => 'verified'], 200);
                }
            }
            else {
                $ac_code->is_active = 0;
                $ac_code->save();
                return response()->json(['message' => 'کد فعال سازی منقضی شده است.'], 403);
            }
        }
        else {
            return response()->json(['message' => 'کد فعال سازی نا معتبر می باشد.'], 403);
        }
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
     *                @OA\Property(property="name",type="string",),
     *                @OA\Property(property="family",type="string",),
     *                @OA\Property(property="email",type="string",),
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
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'email' => 'email|unique:users,email',
            'password'=> 'required'
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
