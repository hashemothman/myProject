<?php

namespace App\Http\Controllers\API;

use App\Models\Complain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\ComplainRequest;
use App\Http\Resources\ComplainResource;
use App\Http\Requests\UpdateComplainRequest;

class ComplainController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complains = Complain::all();
        return $this->customeResponse(ComplainResource::collection($complains),"Done",200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComplainRequest $request)
    {
        $validated = $request->validated();
        $complain = Complain::create([
            'body'            => $request->body,
            'status'            => 'pending',
        ]);
        return $this->customeResponse(new ComplainResource($complain), 'complain Created Successfuly', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complain $complain)
    {
        if($complain){
            return $this->customeResponse(new ComplainResource($complain),"successfully",200);
        }
        return $this->customeResponse(null,"complain not found",404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplainRequest $request,Complain $complain)
    {
        try {
            $complain->body = $request->input('body') ?? $complain->body;
            $complain->status = $request->input('status') ?? $complain->status;
            $complain->save();
            return $this->customeResponse(new ComplainResource($complain),"complain updated successfully",200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->customeResponse(null,"there is something error",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complain $complain)
    {
        if($complain){
            $complain->delete();
            return $this->customeResponse("","complain deleted successfully",200);
        }
        return $this->customResponse(null,"complain not found",404);
    }
}
