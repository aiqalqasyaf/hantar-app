<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Applications/Index', [
        'applications' => Application::where('user_id', auth()->id())
            ->latest('applied_at')
            ->get()
            ->map(fn ($application) => [
                'id' => $application->id,
                'company' => $application->company,
                'role' => $application->role,
                'status' => $application->status,
                'applied_at' => $application->applied_at?->format('Y-m-d'),
                'applied_at_formatted' => $application->applied_at?->format('d F Y'),
                'job_url' => $application->job_url,
                'job_description' => $application->job_description,
                'notes' => $application->notes,
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        auth()->user()->applications()->create($request->validated());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $application->update($request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->back();
    }
}
