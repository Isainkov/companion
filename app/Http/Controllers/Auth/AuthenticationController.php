<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function authenticate(LoginRequest $request): JsonResponse
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
        } catch (ValidationException $e) {
            $response = response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function logout(User $user): JsonResponse
    {
        $user->tokens()->where('name', 'api-auth')->delete();

        return response()->json(['success' => true]);
    }
}
