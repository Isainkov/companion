<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getReviewsByUserId(Request $request, User $user)
    {
        $userReviews = $user->reviews;

        return response()->json($userReviews);
    }

    public function storeReviewByUserId(Request $request, User $user)
    {
        $data = $request->validate([
            'sender_profile_id' => 'required|exists:users,id',
            'rating' => 'required|float|between:0,5',
            'comment' => 'string',
        ]);

        $data['receiver_profile_id'] = $user->id;

        $review = Review::create($data);

        return response()->json(['status' => 'success', 'review' => $review]);
    }
}
