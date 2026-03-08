<?php
namespace App\Http\Controllers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ActivityLog::with('user')->latest())
                ->addIndexColumn()
                ->addColumn('user_name', fn($row) => $row->user->name ?? __('System'))
                ->addColumn('date_fmt', fn($row) => $row->created_at->format('d/m/Y H:i'))
                ->addColumn('model_display', function($row) {
                    if (!$row->model_type) return '-';
                    return class_basename($row->model_type) . ' #' . $row->model_id;
                })
                ->make(true);
        }
        return view('activity-logs.index');
    }
}
