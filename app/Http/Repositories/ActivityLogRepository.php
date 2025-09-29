<?php

namespace App\Http\Repositories;

use App\Models\ActivityLog;

class ActivityLogRepository{
    public function create(array $data){
        return ActivityLog::create($data);
    }

    public function latest(int $perPage = 30){
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findByUser($user_id){
        return ActivityLog::where('user_id', $user_id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);
    }

    public function getUserMovement($startDate, $endDate){
        return ActivityLog::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function getUserMovementByUser($userId, $startDate, $endDate){
        return ActivityLog::with(['user'])
        ->where('user_id', $userId)
        ->whereBetween('created_at',[$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    }


}
