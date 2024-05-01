<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\throwException;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $success = false;

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $imagePath = $image->storeAs('/images/users/' . $user->id, $imageName, 'public');

        $data['image_url'] = $imagePath;

        if (!empty($data)) {
            $success = $user->update($data);
        }

        return response()->json(['success' => $success]);
    }
}
