<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\ActivityLogRepository;

class ActivityLogService{
    protected $activityLogRepo;

    public function __construct(ActivityLogRepository $activityLogRepo){
        $this->activityLogRepo = $activityLogRepo;
    }

    public function log(string $action, ?string $description = null){
        $this->activityLogRepo->create([
            'user_id'       => Auth::id(),
            'action'        => $action,
            'description'   => $description,
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
        ]);
    }

    public function getLatestByFilter($strat, $end, int $perPage = 30){
        return $this->activityLogRepo->latest($perPage);
    }

    public function getLogsByUser($user_id){
        return $this->activityLogRepo->findByUser($user_id);
    }

    public function getReport($startDate, $endDate){
        return [
            'details' => $this->activityLogRepo->getUserMovement($startDate, $endDate),
            'periode' => [$startDate, $endDate]
        ];
    }

    public function getReportByUser($userId, $start, $end){
        return [
            'details' => $this->activityLogRepo->getUserMovementByUser($userId,$start, $end),
            'periode' => [$start, $end]
        ];
    }
}
