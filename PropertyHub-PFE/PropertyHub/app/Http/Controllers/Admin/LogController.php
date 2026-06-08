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
            $handle = fopen($logFile, 'r');
            if ($handle) {
                $currentLog = null;
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/^\[(?P<date>\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]\s+(?P<env>[^.]+)\.(?P<level>[^\s:]+):\s*(?P<message>.*)/', $line, $m)) {
                        if ($currentLog) {
                            $logs[] = $currentLog;
                        }
                        $level = strtolower($m['level']);
                        if (array_key_exists($level, $levelStats)) {
                            $levelStats[$level]++;
                        }
                        $currentLog = [
                            'date'    => $m['date'],
                            'env'     => $m['env'],
                            'level'   => strtoupper($m['level']),
                            'message' => trim($m['message']) . "\n",
                        ];
                    } else {
                        if ($currentLog) {
                            $currentLog['message'] .= $line;
                        }
                    }
                }
                if ($currentLog) {
                    $logs[] = $currentLog;
                }
                fclose($handle);

                // Keep only the last 150 logs
                $logs = array_slice($logs, -150);
                $logs = array_reverse($logs);
            }
        }

        return view('admin.logs', compact('logs', 'levelStats'));
    }
}
