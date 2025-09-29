<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use App\Http\Services\ActivityLogService;

class UserLogController extends Controller
{

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService){
        $this->activityLogService = $activityLogService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logs = $this->activityLogService->getLogsByUser($id);
        $user = User::findOrFail($id);

        return view('report.users.index', compact('logs', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function usersExportPdf(Request $request){

        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->activityLogService->getReport($start, $end);
        $pdf  = PDF::loadView('report.users.pdf', compact('data'))
                ->setPaper('a4','landscape');

        return $pdf->download("laporan-activity-users-{$start}-{$end}.pdf");
    }
    public function usersReport(Request $request){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->activityLogService->getReport($start, $end);

        //dd($data);

        return view('report.users.index', compact('data'));
    }

    public function userReport(Request $request, $userId){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->activityLogService->getReportByUser($userId,$start, $end);
        $user = User::findOrFail($userId);

        return view('report.user.index', compact('data', 'user'));

    }
    public function userExportPdf(Request $request, $userId){

        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->activityLogService->getReportByUser($userId, $start, $end);
        $user = User::findOrFail($userId);
        $pdf  = PDF::loadView('report.user.pdf', compact('data', 'user'))
                ->setPaper('a4','landscape');

        return $pdf->download("laporan-activity-user-{$start}-{$end}.pdf");
    }

}
