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
    use ApiResponseTrait;  public function getCityId($city)
    {
        $cityResult = City::where('city', 'like', '%' . $city . '%')->first();
        if ($cityResult) {
            return ['success' => true, 'id' => $cityResult->id];
        } else {
            return ['success' => false, 'message' => 'the service is not available in your city yet we will notify you when the service is available'];
        }
    }

    public function getCountryId($country)
    {
        $countryResult = Country::where('name', 'like', '%' . $country . '%')->first();
        if ($countryResult) {
            return ['success' => true, 'id' => $countryResult->id];
        } else {
            return ['success' => false, 'message' => 'the service is not available in your country yet we will notify you when the service is available'];
        }
    }
}