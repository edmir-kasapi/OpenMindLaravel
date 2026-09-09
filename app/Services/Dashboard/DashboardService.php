<?php

namespace App\Services\Dashboard;

use Akaunting\Apexcharts\Chart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{

    public function getUserRegistrationData(): array
    {
        $total = User::all()->count();

        $today = User::today()->count();
        $thisMonth = User::thisMonth()->count();
        $thisYear = User::thisYear()->count();

        return [
            'total' => $total,
            'today' => $today,
            'this_month' => $thisMonth,
            'this_year' => $thisYear
        ];
    }

    public function getUserRegistrationsChart(): Chart
    {
        $year = now()->year;

        $registrationTimeline = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $monthly_counts = array_fill(1, 12, 0);

        foreach ($registrationTimeline as $data) {
            $monthly_counts[$data->month] = $data->count;
        }

        $monthly_counts = array_values($monthly_counts);

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];


        $registrationsChart = (new Chart)
            ->setType('line')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('User Registrations')
            ->setSubtitle('Monthly Registrations for ' . $year)
            ->setXAxisCategories($months)
            ->setDataset('Regsitered Users', 'line', $monthly_counts);

        return $registrationsChart;
    }

    public function getUserRoleDistributionChart(): Chart
    {
        $roles = Role::withCount('users');

        $labels = $roles->pluck('role')->toArray();
        $counts = $roles->pluck('users_count')->toArray();

        $roleChart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->SetTitle('Role Distribution Among Registered Users')
            ->setSubtitle('Your account is also included')
            ->setLabels($labels)
            ->setDataset('User Role Distribution', 'donut', $counts);

        return $roleChart;
    }

    public function getUserStatusDistributionChart(): Chart
    {
        $verified = User::verified()->count();
        $unverified = User::unverified()->count();

        $data = [$verified, $unverified];
        $labels = ['Verified', 'Unverified'];

        $statusChart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Account Status Distribution Among Registered Users')
            ->setSubtitle('Your account is also included')
            ->setLabels($labels)
            ->setColors([
                '#20ad0d',
                '#c50303'
            ])
            ->setDataset('User Status Distribution', 'donut', $data)
            ->setOptions([
                'stroke' => [
                    'width' => 0,
                ],
            ]);

        return $statusChart;
    }

    public function getLatestUsers(int $limit): Collection
    {
        return User::with(['role', 'profile'])
            ->sortBy('date-desc')
            ->limit($limit)
            ->get();
    }

    public function getProductRegistrationData(): array
    {
        $total = Product::all()->count();

        $today = Product::today()->count();
        $thisMonth = Product::thisMonth()->count();
        $thisYear = Product::thisYear()->count();

        return [
            'total' => $total,
            'today' => $today,
            'this_month' => $thisMonth,
            'this_year' => $thisYear
        ];
    }

    public function getStockAvailabilityDistributionChart(): Chart
    {
        $data = [
            'Available' => (int)Product::sum('available_stock'),
            'Reserved' =>  (int)Product::sum('reserved_stock')
        ];

        $chart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Stock Availablity Distribution')
            ->setSubtitle(' ')
            ->setLabels(array_keys($data))
            ->setColors([
                '#F59E0B',
                '#8B5CF6'
            ])
            ->setDataset('Stock Availability distribution', 'donut', array_values($data))
            ->setOptions([
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'labels' => [
                                'show' => true,
                                'total' => [
                                    'show' => true,
                                    'label' => 'Total Stock'
                                ],
                            ],

                        ]
                    ]
                ],
                'dataLabels' => [
                    'enabled' => true,
                ],
                'stroke' => [
                    'width' => 0
                ]
            ]);

        return $chart;
    }

    public function getStockLevelDistributionChart(): Chart
    {

        $data = [
            'Out of Stock' => Product::outOfStock()->count(),
            'Low Stock' => Product::lowStock()->count(),
            'Medium Stock' => Product::mediumStock()->count(),
            'In Stock' => Product::inStock()->count()
        ];

        $chart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Stock Level Distribution')
            ->setSubtitle(' ')
            ->setLabels(array_keys($data))
            ->setColors([
                '#dc3545',
                '#ffc107',
                '#0dcaf0',
                '#198754',
            ])
            ->setDataset('Stock Availability distribution', 'donut', array_values($data))
            ->setOptions([
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'labels' => [
                                'show' => true,
                            ],

                        ]
                    ]
                ],
                'dataLabels' => [
                    'enabled' => true,
                ],
                'stroke' => [
                    'width' => 0
                ]
            ]);

        return $chart;
    }

    public function getAvailableStockAmongCategoriesChart(): Chart
    {
        $data_available = ProductType::withSum('products', 'available_stock')
            ->get()
            ->pluck('products_sum_available_stock', 'type')
            ->toArray();

        $data_reserved = ProductType::withSum('products', 'reserved_stock')
            ->get()
            ->pluck('products_sum_reserved_stock', 'type')
            ->toArray();

        $chart = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(900)
            ->setTitle('Inventory Stock')
            ->setSubtitle('Split among product categories')
            ->setLabels(array_keys($data_available))
            ->setColors([
                '#0F766E',
                '#CA8A04'
            ])
            ->setDataset('Available Stock', 'bar', array_values($data_available))
            ->setDataset('reserved Stock', 'bar', array_values($data_reserved))
            ->setOptions([
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => true,
                        //'distributed' => true,
                    ],
                ],
                'chart' => [
                    'stacked' => true,
                    'fontFamily' => 'Inter, sans-serif',
                    'fontSize' => '20px'
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'fontSize' => '14px',
                            'fontFamily' => 'Inter, sans-serif',
                        ],
                    ],
                ],
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'fontSize' => '14px',
                            'fontFamily' => 'Inter, sans-serif',
                        ],
                    ],
                ],
                'legend' => [
                    'position' => 'top'
                ],
                'stroke' => [
                    'width' => 0
                ]
            ]);

        return $chart;
    }

    public function getProductPriceStats(): array
    {

        return [
            'average_price' => Product::average('price'),
            'median_price' => Product::pluck('price')->median(),
            'price_range' => [
                'max' => Product::max('price'),
                'min' => Product::min('price')
            ]
        ];
    }

    public function getProductPriceDistributionChart(): Chart
    {
        $data = [
            '< $25'       => Product::maxPrice('24.99')->count(),
            '$25 - <$50'   => Product::minPrice('25')->maxPrice('49.99')->count(),
            '$50 - <$100'  => Product::minPrice('50')->maxPrice('99.99')->count(),
            '$100 - <$250' => Product::minPrice('100')->maxPrice('249.99')->count(),
            '$250 - <$500' => Product::minPrice('250')->maxPrice('499.99')->count(),
            '$500+'       => Product::minPrice('500')->count(),
        ];

        $chart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Price Distribution')
            ->setSubtitle('Distribution of price ranges among products')
            ->setLabels(array_keys($data))
            ->setColors([
                '#a6aeb8',
                '#7c899b',
                '#526072',
                '#3f4c5e',
                '#2b3849',
                '#141c29',
            ])
            ->setDataset('Stock Availability distribution', 'donut', array_values($data))
            ->setOptions([
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'labels' => [
                                'show' => true,
                            ],

                        ]
                    ]
                ],
                'dataLabels' => [
                    'enabled' => true,
                ],
                'stroke' => [
                    'width' => 0
                ]
            ]);

        return $chart;
    }

    public function getAveragePriceByCategoryChart()
    {
        $data = ProductType::withAvg('products', 'price')
            ->has('products')
            ->get()
            ->mapWithKeys(
                function ($type) {
                    return [
                        $type->type => number_format($type->products_avg_price, 0, '.', ',')
                    ];
                }
            )
            ->toArray();

        $chart = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(900)
            ->setTitle('Average Price')
            ->setSubtitle('Split among product categories')
            ->setLabels(array_keys($data))
            ->setDataset('Average Price', 'bar', array_values($data))
            ->setOptions([
                'plotOptions' => [
                    'bar' => [
                        //'horizontal' => true,
                        'distributed' => true,
                    ],
                ],
                'chart' => [
                    'fontFamily' => 'Inter, sans-serif',
                    'fontSize' => '20px'
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'fontSize' => '14px',
                            'fontFamily' => 'Inter, sans-serif',
                        ],
                    ],
                ],
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'fontSize' => '14px',
                            'fontFamily' => 'Inter, sans-serif',
                        ],
                    ],
                ],
                'legend' => [
                    'position' => 'top'
                ],
                'stroke' => [
                    'width' => 0
                ]
            ]);

        return $chart;
    }

    public function getTopCheapestAndExpensive(int $limit): array
    {
        return [
            'top_cheapest' => Product::sortBy('price-asc')->limit($limit)->get(),
            'top_expensive' => Product::sortBy('price-desc')->limit($limit)->get()
        ];
    }

    public function getLatestProducts(int $limit)
    {
        return Product::with('type')
            ->sortBy('date_desc')
            ->limit($limit)
            ->get();
    }

    public function getOrderRegistrationData(): array
    {
        return [
            'total' => Order::all()->count(),
            'today' => Order::today()->count(),
            'this_month' => Order::thisMonth()->count(),
            'this_year' => Order::thisYear()->count()
        ];
    }

    public function getMonthlyRevenueChart(): Chart
    {
        $year = now()->year;

        $registrationTimeline = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total'),
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $monthly_revenues = array_fill(1, 12, 0);

        foreach ($registrationTimeline as $data) {
            $monthly_revenues[$data->month] = (int) number_format($data->total, 0, '.', '');
        }

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $colors = ['#00fd87'];

        $chart = (new Chart)
            ->setType('area')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Monthly Revenue')
            ->setSubtitle('Monthly revenue report for ' . $year)
            ->setXAxisCategories($months)
            ->setColors($colors)
            ->setDataset('Revenue', 'area', array_values($monthly_revenues))
            ->setOptions([
                'stroke' => [
                    'colors' => $colors,
                    'curve' => 'smooth'
                ]
            ]);

        return $chart;
    }

    function getMonthlyOrdersAmountChart(): Chart
    {
        $year = now()->year;

        $registrationTimeline = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $monthly_order_counts = array_fill(1, 12, 0);

        foreach ($registrationTimeline as $data) {
            $monthly_order_counts[$data->month] = $data->count;
        }

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $chart = (new Chart)
            ->setType('area')
            ->setWidth('100%')
            ->setHeight(350)
            ->setTitle('Monthly Orders Issued')
            ->setSubtitle('Monthly amount of orders issued for ' . $year)
            ->setXAxisCategories($months)
            ->setDataset('Orders', 'area', array_values($monthly_order_counts));

        return $chart;
    }

    public function getOrderStatusBreakdownCharts(): array
    {
        $order_statuses = [
            'Pending' => Order::findOrderStatus(1)->count(),
            'Confirmed' => Order::findOrderStatus(2)->count(),
            'Cancelled' => Order::findOrderStatus(3)->count(),
            'Completed' => Order::findOrderStatus(4)->count(),
        ];

        $payment_statuses = [
            'Unpaid' => Order::findPaymentStatus(1)->count(),
            'Paid' => Order::findPaymentStatus(2)->count(),
            'Refund Pending' => Order::findPaymentStatus(3)->count(),
            'Refunded' => Order::findPaymentStatus(4)->count(),
            'Partially Refunded' => Order::findPaymentStatus(5)->count(),
            'Failed' => Order::findPaymentStatus(6)->count(),
        ];

        $shipment_statuses = [
            'Not Shipped' => Order::findShipmentStatus(1)->count(),
            'Packed' => Order::findShipmentStatus(2)->count(),
            'Shipped' => Order::findShipmentStatus(3)->count(),
            'Delivered' => Order::findShipmentStatus(4)->count(),
            'Returned' => Order::findShipmentStatus(5)->count(),
        ];

        $colors1 = [
            '#2563EB',
            '#16A34A',
            '#F59E0B',
            '#DC2626',
        ];

        // 6 colors
        $colors2 = [
            '#2563EB',
            '#7C3AED',
            '#16A34A',
            '#F59E0B',
            '#DC2626',
            '#0891B2',
        ];

        // 5 colors
        $colors3 = [
            '#3B82F6',
            '#22C55E',
            '#EAB308',
            '#F97316',
            '#A855F7',
        ];


        $orderStatusChart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->SetTitle('Order Status Breakdown')
            ->setSubtitle('')
            ->setLabels(array_keys($order_statuses))
            ->setcolors($colors1)
            ->setDataset('Order Status Distribution', 'donut', array_values($order_statuses))
            ->setOptions([
                'stroke' =>[
                    'width' => 0
                ]
            ]);

        $paymentStatusChart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->SetTitle('Payment Status Breakdown')
            ->setSubtitle('')
            ->setLabels(array_keys($payment_statuses))
            ->setcolors($colors2)
            ->setDataset('Payment Status Distribution', 'donut', array_values($payment_statuses))
            ->setOptions([
                'stroke' =>[
                    'width' => 0
                ]
            ]);

        $shipmentStatusChart = (new Chart)
            ->setType('donut')
            ->setWidth('100%')
            ->setHeight(350)
            ->SetTitle('Shipment Status Breakdown')
            ->setSubtitle('')
            ->setLabels(array_keys($shipment_statuses))
            ->setcolors($colors3)
            ->setDataset('Shipment Status Distribution', 'donut', array_values($shipment_statuses))
            ->setOptions([
                'stroke' =>[
                    'width' => 0
                ]
            ]);

            return [
                'order_status_breakdown' => $orderStatusChart,
                'payment_status_breakdown' =>  $paymentStatusChart,
                'shipment_status_breakdown' => $shipmentStatusChart
            ];
    }

    public function getLatestOrders(int $limit): Collection
    {
        return Order::with('product')->latest()->limit($limit)->get();
    }
}
