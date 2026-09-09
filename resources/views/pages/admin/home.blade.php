<x-layouts.app>

    <x-slot:title>
        {{ __('admin/dashboard.title_dashboard_admin') }}
    </x-slot:title>

    @php
        $user_registration_data = $user_stats['registration_data'];
        $user_charts = $user_stats['charts'];
        $latest_users = $user_stats['latest_users'];

        $product_registration_data = $product_stats['registration_data'];
        $product_charts = $product_stats['charts'];
        $product_price_stats = $product_stats['price_stats'];
        $top_expensive = $product_stats['top_prices']['top_expensive'];
        $top_cheapest = $product_stats['top_prices']['top_cheapest'];
        $latest_products = $product_stats['latest_products'];

        $order_registration_data = $order_stats['registration_data'];
        $latest_orders = $order_stats['latest_orders'];
        $order_charts = $order_stats['charts'];
    @endphp

    <h1 class="text-center text-5xl font-sans display-1"> {{ __('admin/dashboard.welcome_admin') }} </h1>

    <hr>

    <div class="d-flex justify-content-center gap-3">

        {{-- Users Card --}}
        <div class="col-md-3">
            <div class="card card-warning collapsed-card small-box">
                <div class="card-header">

                    <div class="inner">
                        <h3>{{ $user_registration_data['total'] }}</h3>

                        <p>Total Users</p>
                    </div>

                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13C9.23858 13 7 10.7614 7 8ZM12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5Z"
                            fill="#0F1729" />
                        <path fill="currentColor"
                            d="M6.28645 5.9581C6.81559 5.7999 7.1163 5.2427 6.9581 4.71355C6.7999 4.18441 6.2427 3.8837 5.71355 4.0419C4.06991 4.53331 3 6.1924 3 8C3 9.8076 4.06991 11.4667 5.71355 11.9581C6.2427 12.1163 6.7999 11.8156 6.9581 11.2864C7.1163 10.7573 6.81559 10.2001 6.28645 10.0419C5.62978 9.84558 5 9.07911 5 8C5 6.92089 5.62978 6.15442 6.28645 5.9581Z"
                            fill="#0F1729" />
                        <path fill="currentColor"
                            d="M18.2864 4.0419C17.7573 3.8837 17.2001 4.18441 17.0419 4.71355C16.8837 5.2427 17.1844 5.7999 17.7136 5.9581C18.3702 6.15442 19 6.92089 19 8C19 9.07911 18.3702 9.84558 17.7136 10.0419C17.1844 10.2001 16.8837 10.7573 17.0419 11.2864C17.2001 11.8156 17.7573 12.1163 18.2864 11.9581C19.9301 11.4667 21 9.8076 21 8C21 6.1924 19.9301 4.53331 18.2864 4.0419Z"
                            fill="#0F1729" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 14C10.0062 14 8.09544 14.2542 6.64442 14.8986C5.16516 15.5554 4 16.7142 4 18.5C4 18.9667 4.08524 19.4978 4.40272 20.0043C4.72017 20.5106 5.20786 20.8939 5.83781 21.1789C7.04688 21.7259 8.98391 22 12 22C15.0161 22 16.9531 21.7259 18.1622 21.1789C18.7921 20.8939 19.2798 20.5106 19.5973 20.0043C19.9148 19.4978 20 18.9667 20 18.5C20 16.7142 18.8348 15.5554 17.3556 14.8986C15.9046 14.2542 13.9938 14 12 14ZM6 18.5C6 17.7858 6.40184 17.1946 7.45609 16.7264C8.53857 16.2458 10.1278 16 12 16C13.8722 16 15.4614 16.2458 16.5439 16.7264C17.5982 17.1946 18 17.7858 18 18.5C18 18.7236 17.9602 18.8502 17.9027 18.942C17.8452 19.0338 17.7079 19.1893 17.3378 19.3567C16.5469 19.7145 14.9839 20 12 20C9.01609 20 7.45312 19.7145 6.66219 19.3567C6.29214 19.1893 6.15483 19.0338 6.09728 18.942C6.03976 18.8502 6 18.7236 6 18.5Z"
                            fill="#0F1729" />
                        <path fill="currentColor"
                            d="M19.1042 13.5555C19.3497 13.0608 19.9498 12.8587 20.4445 13.1042C21.9384 13.8456 23 15.1261 23 17C23 17.5523 22.5523 18 22 18C21.4477 18 21 17.5523 21 17C21 16.0458 20.525 15.3769 19.5555 14.8958C19.0608 14.6503 18.8587 14.0502 19.1042 13.5555Z"
                            fill="#0F1729" />
                        <path fill="currentColor"
                            d="M4.44452 14.8958C4.93924 14.6503 5.14127 14.0502 4.89577 13.5555C4.65027 13.0608 4.0502 12.8587 3.55548 13.1042C2.06158 13.8456 1 15.1261 1 17C1 17.5523 1.44772 18 2 18C2.55228 18 3 17.5523 3 17C3 16.0458 3.47503 15.3769 4.44452 14.8958Z"
                            fill="#0F1729" />
                    </svg>

                    <div class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"
                            aria-label="Collapse card">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"> More Info </i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"> Collapse </i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="box-sizing: border-box; display: none;">
                    <div class="d-flex justify-content-between">
                        <h6>Users registered today:</h6>
                        <h5>{{ $user_registration_data['today'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Users registered this month:</h6>

                        <h5>{{ $user_registration_data['this_month'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Users registered this year:</h6>
                        <h5>{{ $user_registration_data['this_year'] }}</h5>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        {{-- Products Card --}}
        <div class="col-md-3">
            <div class="card card-danger collapsed-card small-box">
                <div class="card-header">

                    <div class="inner">
                        <h3>{{ $product_registration_data['total'] }}</h3>

                        <p>Total Products</p>
                    </div>

                    <svg class="small-box-icon" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>product</title>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="icon" fill="#000000" transform="translate(64.000000, 34.346667)">
                                <path fill="pink"
                                    d="M192,7.10542736e-15 L384,110.851252 L384,332.553755 L192,443.405007 L1.42108547e-14,332.553755 L1.42108547e-14,110.851252 L192,7.10542736e-15 Z M127.999,206.918 L128,357.189 L170.666667,381.824 L170.666667,231.552 L127.999,206.918 Z M42.6666667,157.653333 L42.6666667,307.920144 L85.333,332.555 L85.333,182.286 L42.6666667,157.653333 Z M275.991,97.759 L150.413,170.595 L192,194.605531 L317.866667,121.936377 L275.991,97.759 Z M192,49.267223 L66.1333333,121.936377 L107.795,145.989 L233.374,73.154 L192,49.267223 Z"
                                    id="Combined-Shape">

                                </path>
                            </g>
                        </g>
                    </svg>

                    <div class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"
                            aria-label="Collapse card">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"> More Info </i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"> Collapse </i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="box-sizing: border-box; display: none;">
                    <div class="d-flex justify-content-between">
                        <h6>Products registered today:</h6>
                        <h5>{{ $product_registration_data['today'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Products registered this month:</h6>
                        <h5>{{ $product_registration_data['this_month'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Products registered this year:</h6>
                        <h5>{{ $product_registration_data['this_year'] }}</h5>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        {{-- Orders Card --}}
        <div class="col-md-3">
            <div class="card card-primary collapsed-card small-box">
                <div class="card-header">

                    <div class="inner">
                        <h3>{{ $order_registration_data['total'] }}</h3>

                        <p>Total Orders</p>
                    </div>

                    <svg class="small-box-icon" fill="indigo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path
                            d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                        </path>
                    </svg>

                    <div class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"
                            aria-label="Collapse card">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"> More Info </i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"> Collapse </i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="box-sizing: border-box; display: none;">
                    <div class="d-flex justify-content-between">
                        <h6>Orders issued today:</h6>
                        <h5>{{ $order_registration_data['today'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Orders issued this month:</h6>
                        <h5>{{ $order_registration_data['this_month'] }}</h5>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>Orders issued this year:</h6>
                        <h5>{{ $order_registration_data['this_year'] }}</h5>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>

    <hr>

    {{-- Stats Section --}}
    <div class="container">

        {{-- User Stats Section --}}
        <div class="card mb-3">

            <div class="card-header">
                <h3 class="card-title">Users</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                        aria-label="Collapse card">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="container w-100">
                    {{ $user_charts['registrations']->container() }}
                </div>

                <hr>

                <div class="container d-flex justify-content-between mb-3">

                    <div class="container">
                        {{ $user_charts['role_distribution']->container() }}
                    </div>

                    <div class="container">
                        {{ $user_charts['status_distribution']->container() }}
                    </div>

                </div>

                <div class="container w-100">

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Latest Members</h2>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"
                                    aria-label="Collapse card">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="row d-flex justify-content-center text-center m-1">

                                @foreach ($latest_users as $user)
                                    <div class="col-3 p-2">

                                        @php
                                            $src = $user->profile
                                                ? asset('storage/profiles/' . $user->profile->getSrc())
                                                : 'https://ui-avatars.com/api/?name=' .
                                                    urlencode($user->name) .
                                                    '&color=7F9CF5&background=EBF4FF';

                                            $date = $user->created_at;
                                            $dateText = match (true) {
                                                $date->isToday() => 'Today',
                                                $date->isYesterday() => 'Yesterday',
                                                $date->isCurrentWeek() => $date->format('l'),
                                                $date->isCurrentYear() => $date->format('M d'),
                                                default => $date->format('M d, Y'),
                                            };

                                            $role = $user->role->getRoleName();
                                        @endphp

                                        <img class="img-fluid rounded-circle d-flex mx-auto"
                                            src="{{ $src }}" alt="User Image">

                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                            href="{{ route('admin.users.inspect', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                        <div class="fs-8">{{ $dateText }}</div>
                                        <div class="fs-8">
                                            <x-datatable.badges.role-badge :role="$role" />
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.users') }}"
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View
                                All Users
                            </a>
                        </div>
                        <!-- /.card-footer -->
                    </div>

                </div>

            </div>
        </div>

        {{-- Products Stats Section --}}
        <div class="card mb-3">

            <div class="card-header">
                <h3 class="card-title">Products</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                        aria-label="Collapse card">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>

            <div class="card-body ">

                <div class="card mb-3">

                    <div class="card-header">
                        <h3 class="card-title">Stock Metrics</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                                aria-label="Collapse card">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container d-flex justify-content-between mb-3">

                            <div class="container">
                                {{ $product_charts['stock_availability']->container() }}
                            </div>
                            <div class="container">
                                {{ $product_charts['stock_level_distribution']->container() }}
                            </div>
                        </div>

                        <hr>

                        <div class="container w-100">
                            <div class="container">
                                {{ $product_charts['available_stock_per_category']->container() }}
                            </div>
                        </div>

                        <div class="container mb-3 w-75">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Products</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"
                                            aria-label="Collapse card">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0" style="box-sizing: border-box; display: block;">
                                    <div class="px-2">
                                        @foreach ($latest_products as $product)
                                            <div class="d-flex border-top py-2 px-1">
                                                <div class="col-12">
                                                    <a href="{{ route('admin.products.inspect', $product->id) }}"
                                                        class="fw-bold">
                                                        {{ $product->name }}
                                                        <span class="badge text-bg-warning float-end">
                                                            ${{ $product->price }}
                                                        </span>
                                                    </a>
                                                    <div class="text-start">
                                                        <x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" />
                                                    </div>
                                                    <div class="text-truncate" style="max-width: 800px">
                                                        {{ $product->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-center" style="box-sizing: border-box; display: block;">
                                    <a href="{{ route('admin.products') }}"> View All Products </a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Price Metrics</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                                aria-label="Collapse card">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="container d-flex justify-content-center gap-3 mb-3">

                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box text-bg-success bg-gradient">
                                    <span class="info-box-icon">
                                        <i class="bi bi-calculator-fill"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Average Price</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>

                                        <span
                                            class="info-box-number">${{ number_format($product_price_stats['average_price'], 2) }}</span>

                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box text-bg-success bg-gradient">
                                    <span class="info-box-icon">
                                        <i class="bi bi-bar-chart-fill"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Median Price</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>

                                        <span
                                            class="info-box-number">${{ number_format($product_price_stats['median_price'], 2) }}</span>

                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box text-bg-success bg-gradient">
                                    <span class="info-box-icon">
                                        <i class="bi bi-arrows-expand"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Price Range</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>

                                        <span
                                            class="info-box-number">${{ number_format($product_price_stats['price_range']['min'], 2) }}
                                            - ${{ number_format($product_price_stats['price_range']['max'], 2) }}
                                        </span>

                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                        </div>

                        <hr>

                        <div class="container w-100 d-flex justify-content-between">
                            <div class="container">
                                {{ $product_charts['price_distribution']->container() }}
                            </div>
                        </div>

                        <hr>

                        <div class="container w-100">
                            <div class="container">
                                {{ $product_charts['average_category_price']->container() }}
                            </div>
                        </div>

                        <div class="container d-flex justify-content-between">

                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Top {{ count($top_expensive) }} Most Expensive Products
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool"
                                                data-lte-toggle="card-collapse" aria-label="Collapse card">
                                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0" style="box-sizing: border-box; display: block;">
                                        <div class="px-2">
                                            @foreach ($top_expensive as $product)
                                                <div class="d-flex border-top py-2 px-1">
                                                    <div class="col-12">
                                                        <a href="{{ route('admin.products.inspect', $product->id) }}"
                                                            class="fw-bold">
                                                            {{ $product->name }}
                                                            <span class="badge text-bg-warning float-end">
                                                                ${{ $product->price }}
                                                            </span>
                                                        </a>
                                                        <div class="text-start">
                                                            <x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" />
                                                        </div>
                                                        <div class="text-truncate" style="max-width: 550px">
                                                            {{ $product->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-center"
                                        style="box-sizing: border-box; display: block;">
                                        <a href="{{ route('admin.products') }}"> View All Products </a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                            </div>

                            <div class="container">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Top {{ count($top_cheapest) }} Cheapest Products</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool"
                                                data-lte-toggle="card-collapse" aria-label="Collapse card">
                                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0" style="box-sizing: border-box; display: block;">
                                        <div class="px-2">
                                            @foreach ($top_cheapest as $product)
                                                <div class="d-flex border-top py-2 px-1">
                                                    <div class="col-12">
                                                        <a href="{{ route('admin.products.inspect', $product->id) }}"
                                                            class="fw-bold">
                                                            {{ $product->name }}
                                                            <span class="badge text-bg-warning float-end">
                                                                ${{ $product->price }}
                                                            </span>
                                                        </a>
                                                        <div class="text-start">
                                                            <x-datatable.badges.product-type-badge :type="$product->type->getTypeName()" />
                                                        </div>
                                                        <div class="text-truncate" style="max-width: 550px">
                                                            {{ $product->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-center"
                                        style="box-sizing: border-box; display: block;">
                                        <a href="{{ route('admin.products') }}"> View All Products </a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Orders & Sales</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                        aria-label="Collapse card">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="card mb-3">

                    <div class="card-header">
                        <h3 class="card-title">Revenue Statistics</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                                aria-label="Collapse card">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container w-100">
                            <div class="container">
                                {{ $order_charts['monthly_revenue']->container() }}
                            </div>
                            <div class="container">
                                {{ $order_charts['monthly_orders']->container() }}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card mb-3">

                    <div class="card-header">
                        <h3 class="card-title">Status Breakdowns</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool tw:size-6" data-lte-toggle="card-collapse"
                                aria-label="Collapse card">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container w-100 d-flex justify-content-between">
                            <div class="container">
                                {{ $order_charts['order_status_breakdown']->container() }}
                            </div>
                            <div class="container">
                                {{ $order_charts['payment_status_breakdown']->container() }}
                            </div>
                            <div class="container">
                                {{ $order_charts['shipment_status_breakdown']->container() }}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Orders</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Collapse card">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0" role="table">
                        <thead>
                          <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Item</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Shipment Status</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach ($latest_orders as $order )
                                <tr>
                                    <td>
                                    <a href="{{ route('admin.orders.view', $order->id) }}" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">#{{ $order->id }}</a>
                                    </td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>
                                        <x-datatable.badges.order-status-badge :status="$order->getOrderStatus()" />
                                    </td>
                                    <td>
                                        <x-datatable.badges.payment-status-badge :status="$order->getPaymentStatus()" />
                                    </td>
                                    <td>
                                        <x-datatable.badges.shipment-status-badge :status="$order->getShipmentStatus()" />
                                    </td>
                                    <td>
                                        <span class="text-success"> ${{ $order->total_price }} </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-secondary float-end">
                      View All Orders
                    </a>
                  </div>
                  <!-- /.card-footer -->
                </div>

            </div>

        </div>

    </div>



    @foreach ($user_charts as $chart)
        {{ $chart->script() }}
    @endforeach

    @foreach ($product_charts as $chart)
        {{ $chart->script() }}
    @endforeach

    @foreach ($order_charts as $chart)
        {{ $chart->script() }}
    @endforeach
</x-layouts.app>
