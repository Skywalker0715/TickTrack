<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterStoreRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if(!Auth::guard('web')->attempt($request->only('email','password'))) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'data' => null
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token
                ]
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi Kesalahan saat login',
                'error' => $e->getMessage()
            ], 500);

        }
    }


    public function me()
    {
        try {
            $user = Auth::user();
            
            return response()->json([
                'message' => 'Profile user berhasil diambil',
                'data' => new UserResource($user),
            ], 200);
            
        } catch (\Exception $e) {

           return response()->json([
                'message' => 'Profile user gagal diambil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout berhasil',
                'data' => null
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi Kesalahan saat logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(RegisterStoreRequest $request){

        DB::beginTransaction();

        try {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        DB::commit();

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data' => [
                'token' => $token,
                'user' => new UserResource($user)
            ]
        ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi Kesalahan saat registrasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}