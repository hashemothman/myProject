<?php

namespace App\Http\Traits;

use Exception;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;


trait GetCityId
{
    use ApiResponseTrait;
    public function getCityId($city){
        try {
            $cityId = City::where('name', 'like', '%' . $city . '%')->first();
            return $cityId;
        } catch (Exception $e) {
            Log::error($e);
            return $this->customeResponse(null, 'City not found', 404);
        }
    }
    public function getCountryId($country){
        try {
            $countryId = Country::where('name', 'like', '%' . $country . '%')->first();
            return $countryId;
        } catch (Exception $e) {
            Log::error($e);
            return $this->customeResponse(null, 'City not found', 404);
        }
    }
}