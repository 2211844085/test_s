<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::whereIn('status', ['achieved', 'active'])->paginate(6);
        return view('project.explore', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        $data = $request->validated();

        $project = Project::create([
            'title' => $data['title'],
            'short_desc' => $data['short_desc'],
            'full_desc' => $data['full_desc'],
            'funding_goal' => $data['funding_goal'],
            'deadline' => $data['deadline'],
            'creator_id' => auth()->user()->id,
            'status' => 'pending',
            'image' => $data['image']->store('project-images', 'public')
        ]);

        $tagIds = [];
        foreach ($data['tags'] as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $project->tags()->sync($tagIds);

        foreach ($data['tiers'] as $tier) {
            $project->tiers()->create([
                'amount' => $tier['amount'],
                'title' => $tier['title'],
                'desc' => $tier['desc'],
            ]);
        }

        return redirect('/creator');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('comments.author');
        return view('project.detail', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        
        $project->update([
            'title' => $data['title'],
            'short_desc' => $data['short_desc'],
            'full_desc' => $data['full_desc'],
            'image' => isset($data['image']) ? $data['image']->store('project-images', 'public') : $project->image,
        ]);
        $tagIds = [];
        foreach ($data['tags'] as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $project->tags()->sync($tagIds);

        $tierIdsInRequest = collect($data['tiers'])->pluck('id')->filter()->all();
        $project->tiers()->whereNotIn('id', $tierIdsInRequest)->delete();

        foreach ($data['tiers'] as $tierData) {
            if (!empty($tierData['id'])) {
                // Existing tier, update it
                $tier = $project->tiers()->find($tierData['id']);
                if ($tier) {
                    $tier->update([
                        'amount' => $tierData['amount'],
                        'title' => $tierData['title'],
                        'desc' => $tierData['desc'],
                    ]);
                }
            } else {
                // New tier, create it
                $project->tiers()->create([
                    'amount' => $tierData['amount'],
                    'title' => $tierData['title'],
                    'desc' => $tierData['desc'],
                ]);
            }
        }

        return redirect('/creator');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/creator/projects');
    }
}
