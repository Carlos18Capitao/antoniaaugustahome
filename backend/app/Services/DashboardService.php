<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\PageView;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Support\Carbon;

class DashboardService
{
    public function getMetrics(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'products' => [
                'total' => Product::count(),
                'active' => Product::active()->count(),
                'featured' => Product::featured()->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::active()->count(),
            ],
            'leads' => [
                'total' => Lead::count(),
                'new' => Lead::new()->count(),
                'today' => Lead::whereDate('created_at', $today)->count(),
                'this_month' => Lead::where('created_at', '>=', $thisMonth)->count(),
            ],
            'views' => [
                'today' => PageView::whereDate('created_at', $today)->count(),
                'this_month' => PageView::where('created_at', '>=', $thisMonth)->count(),
                'total' => PageView::count(),
            ],
        ];
    }

    public function getRecentLeads(int $limit = 5)
    {
        return Lead::with('product')
            ->recent()
            ->limit($limit)
            ->get();
    }

    public function getPopularProducts(int $limit = 5)
    {
        return Product::with('primaryImage')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getViewsChart(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);

        $views = PageView::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $chart = [];
        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chart[] = [
                'date' => $date,
                'views' => $views[$date] ?? 0,
            ];
        }

        return $chart;
    }

    public function trackPageView(string $page, ?string $ip, ?string $userAgent, ?string $referrer): void
    {
        PageView::create([
            'page' => $page,
            'ip_address' => $ip,
            'user_agent' => $userAgent ? substr($userAgent, 0, 255) : null,
            'referrer' => $referrer ? substr($referrer, 0, 255) : null,
        ]);
    }
}
