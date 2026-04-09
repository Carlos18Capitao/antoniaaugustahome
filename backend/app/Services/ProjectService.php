<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProjectService
{
    public function list(int $perPage = 12): LengthAwarePaginator
    {
        return Project::with('images')
            ->active()
            ->ordered()
            ->paginate($perPage);
    }

    public function adminList(int $perPage = 15): LengthAwarePaginator
    {
        return Project::withCount('images')
            ->ordered()
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): Project
    {
        return Project::with('images')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
    }

    public function find(int $id): Project
    {
        return Project::with('images')->findOrFail($id);
    }

    public function create(array $data): Project
    {
        return DB::transaction(function () use ($data) {
            return Project::create($data);
        });
    }

    public function update(int $id, array $data): Project
    {
        return DB::transaction(function () use ($id, $data) {
            $project = Project::findOrFail($id);
            $project->update($data);
            return $project->fresh('images');
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $project = Project::with('images')->findOrFail($id);

            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->path);
                if ($image->thumbnail) {
                    Storage::disk('public')->delete($image->thumbnail);
                }
            }

            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }

            $project->delete();
        });
    }

    public function uploadImage(int $projectId, UploadedFile $file): ProjectImage
    {
        $project = Project::findOrFail($projectId);

        $path = $file->store('projects/' . $project->id, 'public');

        $thumbnailPath = 'projects/' . $project->id . '/thumbs';
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->makeDirectory($thumbnailPath);

        $image = Image::read($file->getPathname());
        $image->scale(width: (int) config('app.thumbnail_width', 400));

        $fullPath = Storage::disk('public')->path($thumbnailPath . '/' . $filename);
        $image->save($fullPath, quality: (int) config('app.image_quality', 85));

        $sortOrder = $project->images()->max('sort_order') + 1;

        return $project->images()->create([
            'path' => $path,
            'thumbnail' => $thumbnailPath . '/' . $filename,
            'alt_text' => $project->title,
            'sort_order' => $sortOrder,
        ]);
    }

    public function deleteImage(int $imageId): void
    {
        $image = ProjectImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        if ($image->thumbnail) {
            Storage::disk('public')->delete($image->thumbnail);
        }
        $image->delete();
    }

    public function getFeatured(int $limit = 6)
    {
        return Project::active()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }
}
