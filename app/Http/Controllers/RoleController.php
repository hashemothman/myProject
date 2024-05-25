<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Traits\ApiResponseTrait;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ApiResponseTrait;
    function __construct()
    {
        $this->middleware(['permission:role-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:role-create'], ['only' => ['store']]);
        $this->middleware(['permission:role-edit'], ['only' => ['update']]);
        $this->middleware(['permission:role-delete'], ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        return $this->customeResponse(RoleResource::collection($roles),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        // if ($request->has('permission')) {
        //     $role->permissions()->attach($request->input('permission'));
        // }
        return $this->customeResponse(new RoleResource($role),"Role add successfuly",200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        if($role){
            return $this->customeResponse(new RoleResource($role),"Done",200);
        }else{
            return $this->customeResponse(null,"role nut found",404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        if($role) {
            $role->update([
                "name"=> $request->input("name"),
            ]);

            $role->syncPermissions($request->input('permission'));


            // if ($request->has('permission')) {
            //     $role->permissions()->detach();
            //     $role->permissions()->attach($request->input('permission'));
            // }

            return $this->customeResponse(new RoleResource($role),'Role updated successfully',200);
        }else{
            return $this->customeResponse(null,'Role not found',404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role){
            $role->delete();
            return $this->customeResponse("",'role deleted successfully',200);
        }else{
            return $this->customeResponse(null,'role not found',404);
        }
    }
}

