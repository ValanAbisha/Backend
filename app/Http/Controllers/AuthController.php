<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class AuthController extends Controller
{  /**
    * Create a new AuthController instance.
    *
    * @return void
    */
   public function __construct()
   {
    //    $this->middleware('auth:api', ['except' => ['login']]);
   }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
         ]);

         $errors = $validator->errors();

         if ($errors->any()) {
             $errorMessages = [];
             foreach ($errors->all() as $index => $error) {
                 if ($index < 1) {
                     $errorMessages[] = $error;
                 } else {
                     $errorMessages[] = 'and more';
                     break;
                 }
             }
             return response()->json(['message' => 'Please add valid details', 'message' => $errorMessages], 422);
         }

         $credentials = $request->only('email', 'password');

         if (! $token = auth()->attempt($credentials)) {
             return response()->json(['message' => 'Unauthorized'], 401);
         }

         return $this->respondWithToken($token);
     }


    public function signup(Request $request)
    {
        $validated = $request -> validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
            'password_confirmation' => 'required|same:password',

        ]);
       $userData = User::create($request->except('password_confirmation'));
        return response()->json(['message' => "User added successfully!.Please login", 'userData'=>$userData],200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
