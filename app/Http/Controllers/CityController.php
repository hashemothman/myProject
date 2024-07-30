<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;

class CityController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cities = City::select('city','is_active')->all();
            return $this->customeResponse($cities, 'Done', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $city = City::create([
                'city' => $request->name,
            ]);
            $city->select('city','is_active');
            return $this->customeResponse($city, 'city created successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        
        try {
            $city->select('city','is_active');
            return $this->customeResponse($city, 'success', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        try {
            $city->city = $request->input('city') ?? $city->city;
            $city->is_active = $request->input('is_active') ?? $city->is_active;
            $city->save();
            $city->select('city','is_active');
            return $this->customeResponse($city, 'city updated successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            $city->delete();
            return $this->customeResponse(null, 'Deleted successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }
}
