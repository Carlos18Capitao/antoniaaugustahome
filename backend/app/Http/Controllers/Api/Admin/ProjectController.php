<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UploadImageRequest;
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
        $projects = $this->projectService->adminList($request->integer('per_page', 15));
        return response()->json($projects);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->create($request->validated());

        return response()->json([
            'message' => 'Projeto criado com sucesso.',
            'data' => new ProjectResource($project),
        ], 201);
    }

    public function show(int $id): ProjectResource
    {
        return new ProjectResource($this->projectService->find($id));
    }

    public function update(StoreProjectRequest $request, int $id): JsonResponse
    {
        $project = $this->projectService->update($id, $request->validated());

        return response()->json([
            'message' => 'Projeto atualizado com sucesso.',
            'data' => new ProjectResource($project),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->projectService->delete($id);
        return response()->json(['message' => 'Projeto eliminado com sucesso.']);
    }

    public function uploadImage(UploadImageRequest $request, int $id): JsonResponse
    {
        $image = $this->projectService->uploadImage($id, $request->file('image'));

        return response()->json([
            'message' => 'Imagem carregada com sucesso.',
            'data' => $image,
        ], 201);
    }

    public function deleteImage(int $id, int $imageId): JsonResponse
    {
        $this->projectService->deleteImage($imageId);
        return response()->json(['message' => 'Imagem eliminada com sucesso.']);
    }
}
