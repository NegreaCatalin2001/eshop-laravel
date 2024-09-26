@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistics</h4>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center my-3">
                                <h6>Completed Orders:</h6>
                                <h3><span class="badge badge-pill badge-primary p-3">{{ $completedOrdersCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Pending Orders:</h6>
                                <h3><span class="badge badge-pill badge-danger p-3">{{ $pendingOrdersCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Canceled Orders:</h6>
                                <h3><span class="badge badge-pill badge-primary p-3">{{ $canceledOrdersCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>In Delivery Orders:</h6>
                                <h3><span class="badge badge-pill badge-danger p-3">{{ $inDeliveryOrdersCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Total Number of Users:</h6>
                                <h3><span class="badge badge-pill badge-info p-3">{{ $UserCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Average Order Value:</h6>
                                <h3><span
                                        class="badge badge-pill badge-info p-3">${{ number_format($averageOrderValue, 2) }}</span>
                                </h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Total Number of Products:</h6>
                                <h3><span class="badge badge-pill badge-info p-3">{{ $productCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Products Out of Stock:</h6>
                                <h3><span class="badge badge-pill badge-danger p-3">{{ $outOfStockCount }}</span></h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Total Revenue:</h6>
                                <h3><span
                                        class="badge badge-pill badge-success p-3">${{ number_format($totalRevenue, 2) }}</span>
                                </h3>
                            </div>
                            <div class="col-md-6 text-center my-3">
                                <h6>Total Revenue after Tax:</h6>
                                <h3><span
                                        class="badge badge-pill badge-success p-3">${{ number_format($totalRevenueAfterTax, 2) }}</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
