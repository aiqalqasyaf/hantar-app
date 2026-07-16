<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\SkillAnalysis;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $statusCounts = Application::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $applicationsOverTime = Application::where('user_id', $userId)
            ->select(DB::raw("to_char(applied_at, 'YYYY-MM-DD') as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $avgScore = SkillAnalysis::where('user_id', $userId)->avg('score');

        $recentAnalyses = SkillAnalysis::with('application')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = Application::where('user_id', $userId)
            ->latest('applied_at')
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'statusCounts' => [
                'applied' => $statusCounts['applied'] ?? 0,
                'interview' => $statusCounts['interview'] ?? 0,
                'offer' => $statusCounts['offer'] ?? 0,
                'rejected' => $statusCounts['rejected'] ?? 0,
            ],
            'applicationsOverTime' => $applicationsOverTime,
            'avgScore' => round($avgScore ?? 0),
            'analysisCount' => SkillAnalysis::where('user_id', $userId)->count(),
            'recentAnalyses' => $recentAnalyses,
            'recentApplications' => $recentApplications,
        ]);
    }
}