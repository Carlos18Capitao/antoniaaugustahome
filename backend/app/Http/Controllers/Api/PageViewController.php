<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageViewController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'required|string|max:255',
        ]);

        $this->dashboardService->trackPageView(
            $request->input('page'),
            $request->ip(),
            $request->userAgent(),
            $request->header('referer')
        );

        return response()->json(['status' => 'ok']);
    }
}
