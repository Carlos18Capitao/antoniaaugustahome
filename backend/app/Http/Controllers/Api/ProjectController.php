<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectService->list($request->integer('per_page', 12));
        return response()->json(ProjectResource::collection($projects));
    }

    public function show(string $slug): ProjectResource
    {
        $project = $this->projectService->findBySlug($slug);
        return new ProjectResource($project);
    }

    public function featured(): JsonResponse
    {
        $projects = $this->projectService->getFeatured();
        return response()->json([
            'data' => ProjectResource::collection($projects),
        ]);
    }
}
