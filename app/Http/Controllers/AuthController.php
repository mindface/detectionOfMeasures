<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
     /**
     * ユーザー登録
     */
    public function register(Request $request)
    {
        try {
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users',
            //     'password' => 'required|string|min:8|confirmed',
            //     'sex' => 'required|string|max:10',
            //     'tokenId' => 'required|string|max:255',
            //     'birth_date' => 'required|date',
            // ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users'),
                ],
                'password' => 'required|string|min:8|confirmed',
                'sex' => 'required|string|max:10',
                'tokenId' => 'required|string|max:255',
                'birth_date' => 'required|date',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'sex' => $request->sex,
                'tokenId' => $request->tokenId,
                'birth_date' => $request->birth_date,
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token,
            ], 201);

        } catch (ValidationException $e) {
            // バリデーションエラーをキャッチ
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // HTTPステータスコード 422はバリデーションエラー
        } catch (\Exception $e) {
            // その他のエラーをキャッチ
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500); // サーバーエラー
        }
    }

    /**
     * ユーザーログイン
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    /**
     * 現在のユーザー情報取得
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * ログアウト
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }   
}
