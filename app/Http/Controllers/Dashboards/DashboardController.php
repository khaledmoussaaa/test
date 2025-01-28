<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ClassRoom;
use App\Models\Kid;
use App\Models\Nursery;
use App\Models\ParentKid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function mind()
    {
        // Nursery Query
        $nurseries = Nursery::query();

        // Query to count nurseries by month and year
        $nurseryGrowth = Nursery::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('status', 'approved') // Assuming 'status' column indicates active nurseries
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $nursery_kids = Nursery::withCount('kids')->get()->setVisible(['id', 'name', 'kids_count']);

        $data = [
            'nurseries_approved' => (clone $nurseries)->where('status', 'approved')->count(),
            'nurseries_pending' => (clone $nurseries)->where('status', 'pending')->count(),
            'nurseries_rejected' => (clone $nurseries)->where('status', 'rejected')->count(),
            'nursery_kids' => $nursery_kids,
            'nursery_growth' => $nurseryGrowth,
        ];
        return contentResponse($data);
    }

    public function nursery(Request $request)
    {
        // Employees Teachers Counts
        $users_counts = User::where('branch_id', $request->branch_id)->whereHasRole(['admin', 'teacher'])->count();
        // Employees Counts
        $kids_counts = Kid::branchScope($request)->count();
        // Kids Counts
        $parents_counts = ParentKid::branchScope($request)->count();
        // Classes Counts
        $classRooms_counts = ClassRoom::branchScope($request)->count();

        $data = [
            'users_counts' => $users_counts,
            'kids_counts' => $kids_counts,
            'parent_counts' => $parents_counts,
            'classRooms_counts' => $classRooms_counts,
        ];

        if ($request->has('nursery_id')) {
            $branches_counts = Branch::nurseryScope($request)->count();
            $data['branches_count'] = $branches_counts;
        }

        return contentResponse($data);
    }
}
