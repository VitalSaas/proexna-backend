<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::active()->ordered();

        if ($category = $request->query('categoria')) {
            $query->where('category', $category);
        }

        $projects = $query->get();

        $featuredProjects = Project::active()->featured()->ordered()->take(3)->get();

        $availableCategories = Project::active()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('projects.index', [
            'projects' => $projects,
            'featuredProjects' => $featuredProjects,
            'availableCategories' => $availableCategories,
            'categoryLabels' => Project::getCategories(),
            'activeCategory' => $category,
        ]);
    }

    public function show(Project $project)
    {
        if (!$project->is_active) {
            abort(404);
        }

        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->when($project->category, fn ($q) => $q->where('category', $project->category))
            ->ordered()
            ->take(3)
            ->get();

        return view('projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'categoryLabels' => Project::getCategories(),
        ]);
    }
}
