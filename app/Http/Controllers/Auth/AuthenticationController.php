<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->authenticate();

            /** @var User $user */
            $user = auth()->user();
            $accessToken = $user->createToken('api-auth')->plainTextToken;

            $response = response()->json([
                'success' => true,
                'access_token' => $accessToken,
                'user_id' => $user->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $user->tokens()->where('name', 'api-auth')->delete();

        return response()->json(['success' => true]);
    }
}
