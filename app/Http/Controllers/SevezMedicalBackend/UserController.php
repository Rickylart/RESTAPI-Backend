<?php

namespace App\Http\Controllers\SevezMedicalBackend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /****
     *
     * Register new user
     * @param UserRequest $request
     * @return user
     */

     public function registerUser(Request $request){
            try {
                //***** validating request data */
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8'
                ]);

                //***save to the database and return authenticated token */
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                //****return auth token to the frontend */
                return response()->json([
                    'success' => true,
                    'message' => 'User registered successfully',
                ],200);


            } catch (\Throwable $th) {

                //****return failed response */
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ], 422);
            }
     }

     /****
     *
     * Login new user
     * @param UserRequest $request
     * @return user
     */
     public function login(Request $request)
     {
        try {
            //******get requested data */
            $credentials = $request->validate([
                'email' => 'required|string|email|',
                'password' => 'required|string|min:8'
            ]);

            //*******authenticate the user requested data */
            if (!Auth::attempt($credentials)) {
               return response()->json([
                   'success' => false,
                   'message' => 'Email & password do no match',
               ], 401);
            }

            //****search for the user */
            $user = User::where('email', $request->email)->first();


            //******return the success response */
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("Authorization TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {

            //******return the failed response */
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 422);
        }
     }
}
