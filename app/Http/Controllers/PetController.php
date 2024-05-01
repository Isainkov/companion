<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pet\ListByIdsRequest;
use App\Http\Requests\Pet\StorePetRequest;
use App\Http\Requests\Pet\UpdatePetRequest;
use App\Models\Pet;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pet::all();
    }

    /**
     * @param StorePetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePetRequest $request)
    {
        $data = $request->validated();

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();

        unset($data['image']);

        /** @var Pet $pet */
        $pet = Pet::create($data);

        $imagePath = $image->storeAs('public/images/pets/' . $pet->id, $imageName, 'public');

        $pet->update(['images' => $imagePath]);

        if (!$pet) {
            return response()->json(['status' => false]);
        }

        return response()->json(['status' => true, 'data' => $pet]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        return $pet;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $data = $request->validated();

        $status = $pet->update($data);

        return response()->json(['status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $status = $pet->delete();

        return response()->json(['status' => $status]);
    }

    /**
     * @param ListByIdsRequest $request
     * @return mixed
     */
    public function getListByIds(ListByIdsRequest $request)
    {
        $ids = $request->input('ids');
        $pets = Pet::whereIn('id', $ids)->get();

        return response()->json($pets);
    }
}
