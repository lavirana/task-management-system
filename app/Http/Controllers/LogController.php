<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
        public function index()
        {
            $logs = \App\Models\ActivityLog::with('user', 'task')->latest()->paginate(20);
            return view('logs.index', compact('logs'));
        }

        public function show($id)
        {
            $log = \App\Models\ActivityLog::with('user', 'task')->findOrFail($id);
            return view('logs.show', compact('log'));
        }

        public function destroy($id)
        {
            $log = \App\Models\ActivityLog::findOrFail($id);
            $log->delete();
            return redirect()->route('logs.index')->with('success', 'Log entry deleted successfully!');
        }

        public function clear()
        {
            \App\Models\ActivityLog::truncate();
            return redirect()->route('logs.index')->with('success', 'All log entries cleared successfully!');
        }

        public function export()
        {
            $logs = \App\Models\ActivityLog::with('user', 'task')->latest()->get();
            $csvData = "ID,User,Task,Action,Old Values,New Values,IP Address,User Agent,Created At\n";
            foreach ($logs as $log) {
                $csvData .= "{$log->id},\"{$log->user->name}\",\"{$log->task->title}\",\"{$log->action}\",\"".json_encode($log->old_values)."\",\"".json_encode($log->new_values)."\",\"{$log->ip_address}\",\"{$log->user_agent}\",\"{$log->created_at}\"\n";
            }
            return response($csvData)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="activity_logs.csv"');
        }

}
