<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileTrait;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponseTrait, FileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();

        return $this->customeResponse(EmployeeResource::collection($employees), 'Data retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $front_card_image_path = $this->UploadFile($request, 'employees', 'front_card_image', 'BasImage');
        $back_card_image_path  = $this->UploadFile($request, 'employees', 'back_card_image', 'BasImage');

        $employee = Employee::create([
            'name'             => $request->name,
            'idNumber'         => $request->idNumber,
            'front_card_image' => $front_card_image_path,
            'back_card_image'  => $back_card_image_path
        ]);

        if ($employee) {
            return $this->customeResponse(new EmployeeResource($employee), 'Created Successfully', 201);

            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        if (!$employee) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        return $this->customeResponse(new EmployeeResource($employee), 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if (!$employee) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $front_card_image_path = $this->FileExists($request, $request->front_card_image, 'front_card_image','employees','BasImage', false, $employee);
        $back_card_image_path  = $this->FileExists($request, $request->back_card_image, 'back_card_image','employees','BasImage', false, $employee);

        $employee->update([
            'name'             => $request->name,
            'idNumber'         => $request->idNumber,
            'front_card_image' => $front_card_image_path,
            'back_card_image'  => $back_card_image_path
        ]);

        return $this->customeResponse(new EmployeeResource($employee), 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if (!$employee) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $employee->delete();
        return $this->customeResponse('', "Employee Deleted", 200);
    }
}
