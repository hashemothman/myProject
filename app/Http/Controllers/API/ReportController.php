<?php

namespace App\Http\Controllers\API;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Traits\UploadFileTrait;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ReportResource;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
{
    use ApiResponseTrait,UploadFileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        return $this->customeResponse(ReportResource::collection($reports),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        $validated = $request->validated();
        $report_file = $this->UploadFile($request, 'reports', 'file', 'files');
        $report = Report::create([
            'account_id'     => $request->account_id,
            'file'          => $report_file,
        ]);
        return $this->customeResponse(new ReportResource($report), 'report Created Successfuly', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        if($report){
            return $this->customeResponse(new ReportResource($report),"Done",200);
        }
        return $this->customeResponse(null,"report not found",404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        if($report){
            $report_file = $this->FileExists($request,$request->file,'file','reports','BasFile', false, $report);
            $report->account_id = $request->input('account_id') ?? $report->account_id;
            $report->file = $report_file;
            $report->save();
            return $this->customeResponse(new ReportResource($report),"report updated successfully",200);
        }
        return $this->customeResponse(null,"report not found",404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        if($report){
            $report->delete();
            return $this->customeResponse("","report deleted successfully",200);
        }
        return $this->customeResponse(null,"report not found",404);
    }
}
