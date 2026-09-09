<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;

class AdminController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    )
    {

    }

    public function index()
    {

        //dd($this->dashboardService->getTopCheapestAndExpensive(5));


        $userStats = [
            'registration_data' => $this->dashboardService->getUserRegistrationData(),
            'latest_users' => $this->dashboardService->getLatestUsers(8),
            'charts' => [
                'registrations' => $this->dashboardService->getUserRegistrationsChart(),
                'role_distribution' => $this->dashboardService->getUserRoleDistributionChart(),
                'status_distribution' => $this->dashboardService->getUserStatusDistributionChart(),
            ]
        ];

        $productStats = [
            'registration_data' => $this->dashboardService->getProductRegistrationData(),
            'price_stats' => $this->dashboardService->getProductPriceStats(),
            'top_prices' => $this->dashboardService->getTopCheapestAndExpensive(5),
            'latest_products' => $this->dashboardService->getLatestProducts(8),
            'charts' => [
                'stock_availability' => $this->dashboardService->getStockAvailabilityDistributionChart(),
                'stock_level_distribution' => $this->dashboardService->getStockLevelDistributionChart(),
                'available_stock_per_category' => $this->dashboardService->getAvailableStockAmongCategoriesChart(),
                'price_distribution' => $this->dashboardService->getProductPriceDistributionChart(),
                'average_category_price' => $this->dashboardService->getAveragePriceByCategoryChart()
            ]
        ];

        $statusBreakdowns = $this->dashboardService->getOrderStatusBreakdownCharts();

        $orderStats = [
            'registration_data' => $this->dashboardService->getOrderRegistrationData(),
            'latest_orders' => $this->dashboardService->getLatestOrders(8),
            'charts' => [
                'monthly_revenue' => $this->dashboardService->getMonthlyRevenueChart(),
                'monthly_orders' => $this->dashboardService->getMonthlyOrdersAmountChart(),
                'order_status_breakdown' => $statusBreakdowns['order_status_breakdown'],
                'payment_status_breakdown' => $statusBreakdowns['payment_status_breakdown'],
                'shipment_status_breakdown' => $statusBreakdowns['shipment_status_breakdown'],
            ]
        ];

        return view("pages.admin.home", [
            'user_stats' => $userStats,
            'product_stats' => $productStats,
            'order_stats' => $orderStats
            ]);
    }
}
