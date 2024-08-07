<?php

namespace App\Http\Controllers\Api;

use App\Models\OfficeInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\OfficeInfoRequest;
use App\Http\Resources\OfficeInfoResource;
use App\Http\Requests\UpdateOfficeInfoRequest;

class OfficeInfoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officeInfo = OfficeInfo::all();

        return $this->customeResponse(OfficeInfoResource::collection($officeInfo), 'Data retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfficeInfoRequest $request)
    {
        $officeInfo = OfficeInfo::create([
            'name'     => $request->name,
            'city_id'  => $request->city_id,
            'location' => $request->location,
        ]);

        if ($officeInfo) {
            return $this->customeResponse(new OfficeInfoResource($officeInfo), 'Created Successfully', 201);
        }else{
            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(OfficeInfo $officeInfo)
    {
        if (!$officeInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        return $this->customeResponse(new OfficeInfoResource($officeInfo), 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeInfoRequest $request, OfficeInfo $officeInfo)
    {
        if (!$officeInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }
        $officeInfo->name = $request->input('name') ?? $officeInfo->name;
        $officeInfo->city_id = $request->input('city_id') ?? $officeInfo->city_id;
        $officeInfo->location = $request->input('location') ?? $officeInfo->location;
        $officeInfo->save();
        return $this->customeResponse(new OfficeInfoResource($officeInfo), 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeInfo $officeInfo)
    {
        if (!$officeInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $officeInfo->delete();
        return $this->customeResponse('', "OfficeInfo Deleted", 200);
    }
}
