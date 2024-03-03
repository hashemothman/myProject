<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\Auth\RegisterRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return $this->customeResponse(UserResource::collection($users),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $Validation = $request->validated();
        $user = User::create([
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => Hash::make($request->password),
        ]);
        $roleName = $request->input('role_name');
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            return $this->customResponse(null, 'Role not found', 404);
        }
        $user->assignRole($role);
        return $this->customeResponse(new UserResource($user),'user created successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if($user) {
            return $this->customeResponse(new UserResource($user), 'Done', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterRequest $request, User $user)
    {
        if ($user) {
            $user->update([
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'password'      => Hash::make($request->password),
            ]);
            if ($request->filled('role_name')) {
                $roleName = $request->input('role_name');
                $role = Role::where('name', $roleName)->first();
                if (!$role) {
                    return $this->customResponse(null, 'Role not found', 404);
                }
                $user->syncRoles([$role->id]);
            }
            return $this->customeResponse(new UserResource($user), 'user updated successfully', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
            return $this->customeResponse("", 'user deleted successfully', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }
}
