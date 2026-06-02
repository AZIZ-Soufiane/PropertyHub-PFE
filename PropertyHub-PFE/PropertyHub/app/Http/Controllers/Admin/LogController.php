<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');

        $logs = [];
        $levelStats = [
            'emergency' => 0,
            'alert' => 0,
            'critical' => 0,
            'error' => 0,
            'warning' => 0,
            'notice' => 0,
            'info' => 0,
            'debug' => 0,
        ];

        if (File::exists($logFile)) {
            $raw = File::get($logFile);

            if (preg_match_all(
                '/^\[(?P<date>[^\]]+)\]\s+(?P<env>[^.]+)\.(?P<level>[^:]+):\s*(?P<message>.*?)(?=\n\[|\Z)/ms',
                $raw,
                $matches,
                PREG_SET_ORDER
            )) {
                $tail = array_slice($matches, -150);
                foreach ($tail as $m) {
                    $level = strtolower($m['level']);
                    if (array_key_exists($level, $levelStats)) {
                        $levelStats[$level]++;
                    }
                    $logs[] = [
                        'date'    => $m['date'],
                        'env'     => $m['env'],
                        'level'   => strtoupper($m['level']),
                        'message' => trim($m['message']),
                    ];
                }
                $logs = array_reverse($logs);
            }
        }

        return view('admin.logs', compact('logs', 'levelStats'));
    }
}
