<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function index()
    {
        $actionStats = [
            'login'            => 0,
            'logout'           => 0,
            'signup'           => 0,
            'create_property'  => 0,
            'approve_property' => 0,
            'reject_property'  => 0,
            'create_user'      => 0,
            'delete_user'      => 0,
        ];

        foreach ($actionStats as $action => $count) {
            $actionStats[$action] = \App\Models\ActivityLog::where('action', $action)->count();
        }

        $activityLogs = \App\Models\ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(150)
            ->get();

        $logs = [];
        foreach ($activityLogs as $item) {
            $logs[] = [
                'date'    => $item->created_at->format('Y-m-d H:i:s'),
                'level'   => strtoupper($item->action),
                'message' => "{$item->description} [IP: {$item->ip_address}]",
                'env'     => 'APP',
            ];
        }

        $levelStats = $actionStats;

        return view('admin.logs', compact('logs', 'levelStats'));
    }
}
