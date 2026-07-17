<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\SkillAnalysis;
use App\Services\SkillAnalysisService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::where('user_id', auth()->id());

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from) {
            $query->whereDate('applied_at', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('applied_at', '<=', $request->to);
        }

        return Inertia::render('Analysis/Index', [
            'applications' => $query->orderByDesc('applied_at')->get(),
            'filters' => $request->only(['status', 'from', 'to']),
        ]);
    }

    public function history()
    {
        return Inertia::render('Analysis/History', [
            'analyses' => SkillAnalysis::with('application')
                ->where('user_id', auth()->id())
                ->latest()
                ->get()
                ->map(fn ($analysis) => [
                    'id' => $analysis->id,
                    'application' => $analysis->application,
                    'score' => $analysis->score,
                    'matched_skills' => $analysis->matched_skills,
                    'missing_skills' => $analysis->missing_skills,
                    'recommendations' => $analysis->recommendations,
                    'summary' => $analysis->summary,
                    'created_at' => $analysis->created_at?->format('Y-m-d'),
                    'created_at_formatted' => $analysis->created_at?->format('d F Y'),
                ]),
        ]);
    }

    public function show(SkillAnalysis $analysis)
    {
        abort_unless($analysis->user_id === auth()->id(), 403);
        $analysis->load('application');
        return Inertia::render('Analysis/Show', ['analysis' => $analysis]);
    }

    public function store(Request $request, SkillAnalysisService $service)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'resume_text' => 'required|string',
        ]);

        $application = Application::where('id', $request->application_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $result = $service->analyze($application->job_description ?? '', $request->resume_text);

        $analysis = SkillAnalysis::create([
            'user_id' => auth()->id(),
            'application_id' => $application->id,
            'resume_text' => $request->resume_text,
            'score' => $result['score'],
            'matched_skills' => $result['matched_skills'],
            'missing_skills' => $result['missing_skills'],
            'recommendations' => $result['recommendations'],
            'summary' => $result['summary'] ?? null,
        ]);

        return redirect()->back()->with('analysis', $analysis);
    }
}