<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\StoreImagesService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('update');
    }

    /**
     * @param User $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @param StoreImagesService $storeImages
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $user, StoreImagesService $storeImages): JsonResponse
    {
        $data = $request->validated();

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Provided params are invalid']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image_url'] = $storeImages->save($image, User::ENTITY_NAME, $user->id);
        }

        $status = $user->update($data);

        return response()->json(['success' => $status, 'data' => $user->fresh()]);
    }
}
