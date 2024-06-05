<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $countries = Country::all();
            return $this->customeResponse(CountryResource::collection($countries), 'Done', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        try {
            $country = Country::create([
                'name' => $request->name,
            ]);
            return $this->customeResponse(new CountryResource($country), 'Country created successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        try {
            return $this->customeResponse(new CountryResource($country), 'Done', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request,Country $country)
    {
        try {
            $country->name = $request->input('name') ?? $country->name;
            $country->save();
            return $this->customeResponse(new CountryResource($country), 'Country updated successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        try {
            $country->delete();
            return $this->customeResponse(null, 'Deleted successfully', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null, 'there is something ronge', 500);
        }
    }
}
