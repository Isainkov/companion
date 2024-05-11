<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pet\ListByIdsRequest;
use App\Http\Requests\Pet\StoreRequest;
use App\Http\Requests\Pet\UpdateRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use App\Services\StoreImagesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\UploadedFile;

class PetController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum')->except(['show', 'index', 'getListByIds']);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PetResource::collection(Pet::all());
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            unset($data['image']);
        }

        if ($data['breed_type']) {
            $breedTypeIds = $data['breed_type'];
            unset($data['breed_type']);
        }

        /** @var Pet $pet */
        $pet = Pet::create($data);

        if (!empty($breedTypeIds)) {
            $pet->breeds()->sync($breedTypeIds);
        }

        if (!$pet) {
            return $this->errorResponse('Something went wrong. Unable to store the provided pet. See logs.');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $isImagesStored = $this->storeImagesHandler($image, $pet);

            if (!$isImagesStored) {
                return $this->errorResponse(
                    'Something went wrong. The pet was saved, but unable to store the provided image. See logs.',
                    $pet
                );
            }
        }

        return response()->json(['success' => true, 'data' => new PetResource($pet)]);
    }

    /**
     * @param Pet $pet
     * @return PetResource
     */
    public function show(Pet $pet): PetResource
    {
        return new PetResource($pet);
    }

    /**
     * @param UpdateRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Pet $pet): JsonResponse
    {
        $data = $request->validated();

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Provided params are invalid']);
        }

        if ($data['breed_type']) {
            $breedTypeIds = $data['breed_type'];
            unset($data['breed_type']);
            $pet->breeds()->sync($breedTypeIds);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $isImagesStored = $this->storeImagesHandler($image, $pet);

            if (!$isImagesStored) {
                return $this->errorResponse(
                    'Something went wrong. The pet was saved, but unable to store the provided image. See logs.',
                    $pet
                );
            }
        }

        $status = $pet->update($data);

        return response()->json(['success' => $status, 'data' => new PetResource($pet->fresh())]);
    }

    /**
     * @param Pet $pet
     * @return JsonResponse
     */
    public function destroy(Pet $pet): JsonResponse
    {
        $status = $pet->delete();

        return response()->json(['success' => $status]);
    }

    /**
     * @param ListByIdsRequest $request
     * @return JsonResponse
     */
    public function getListByIds(ListByIdsRequest $request): JsonResponse
    {
        $ids = $request->input('ids');
        $pets = Pet::whereIn('id', $ids)->get();

        return response()->json(PetResource::collection($pets));
    }

    /**
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    private function errorResponse(string $message, mixed $data = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param UploadedFile|UploadedFile[] $image
     * @param Pet $pet
     * @return bool
     */
    private function storeImagesHandler(UploadedFile|array $image, Pet $pet): bool
    {
        $storeImagesService = new StoreImagesService();

        $imagePath = is_array($image)
            ? $storeImagesService->massSave($image, Pet::ENTITY_NAME, $pet->id)
            : $storeImagesService->save($image, Pet::ENTITY_NAME, $pet->id);

        if ($imagePath) {
            $pet->images = implode(',', $imagePath);
            $success = $pet->save();
        }

        return $success ?? false;
    }
}
