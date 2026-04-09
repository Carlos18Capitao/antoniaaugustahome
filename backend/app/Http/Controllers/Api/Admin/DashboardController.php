<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'metrics' => $this->dashboardService->getMetrics(),
            'recent_leads' => $this->dashboardService->getRecentLeads(),
            'popular_products' => $this->dashboardService->getPopularProducts(),
        ]);
    }

    public function viewsChart(): JsonResponse
    {
        return response()->json([
            'data' => $this->dashboardService->getViewsChart(),
        ]);
    }
}
