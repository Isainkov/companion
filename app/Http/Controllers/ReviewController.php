<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store']);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function getReviewsByUserId(User $user): JsonResponse
    {
        $userReviews = $user->reviews;

        return response()->json($userReviews);
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $review = Review::create($data);

        return response()->json(['success' => true, 'review' => $review]);
    }
}
