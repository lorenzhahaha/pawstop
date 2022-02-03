@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-xl-4 text-center">
            <div style="position: relative">
                <img src="{{ asset('img/dog-dashboard-img.png') }}" class="dashboard-image" alt="Dashboard Image" height="300px" style="z-index: 100; position: relative; top: 0;">

                <div class="card shadow-sm text-center text-xl-left border-0 w-100 mb-4" id="dashboard-chart-1" style="z-index: 50;">
                    <div class="card-body p-0">
                        <div class="card-content p-3">
                            <span class="float-right">
                                <i class="fas fa-list-ol fa-2x" style="color: #8C6E63"></i>
                            </span>

                            <span class="subtitle d-block mt-2">
                                Dog Categories
                            </span>

                            <div class="badges">
                                <span class="badge badge-secondary d-inline-block">
                                    PRODUCTS
                                </span>
                            </div>

                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productCategories as $productCategory)
                                        <tr>
                                            <td>{{ $productCategory->category }}</td>
                                            <td>{{ $productCategory->count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center border-0 d-flex justify-content-between align-items-center">
                            View More Info
                            <a href="" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8 mb-5 mb-xl-0">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="row">
                        <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                            <div class="card shadow-sm text-center text-xl-left border-0">
                                <div class="card-body p-0">
                                    <div class="card-content p-3">
                                        <span class="float-right">
                                            <i class="fas fa-paw fa-2x" style="color: #8C6E63"></i>
                                        </span>

                                        <span class="title d-block">
                                            {{ number_format($productCount) }}
                                        </span>

                                        <span class="subtitle d-block mt-2">
                                            Total Registered Dogs
                                        </span>

                                        <div class="badges">
                                            <span class="badge badge-secondary d-inline-block">
                                                PRODUCTS
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-0 d-flex justify-content-between align-items-center">
                                        View More Info
                                        <a href="" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                            <div class="card shadow-sm text-center text-xl-left border-0">
                                <div class="card-body p-0">
                                    <div class="card-content p-3">
                                        <span class="float-right">
                                            <i class="fas fa-calendar-day fa-2x" style="color: #8C6E63"></i>
                                        </span>

                                        <span class="title d-block">
                                            {{ number_format($productCountToday) }}
                                        </span>

                                        <span class="subtitle d-block mt-2">
                                            Registered Dogs Today
                                        </span>

                                        <div class="badges">
                                            <span class="badge badge-secondary d-inline-block">
                                                PRODUCTS
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-0 d-flex justify-content-between align-items-center">
                                        View More Info
                                        <a href="" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm text-center text-xl-left border-0">
                                <div class="card-body p-0">
                                    <div class="card-content p-3">
                                        <span class="float-right">
                                            <i class="fas fa-dog fa-2x" style="color: #8C6E63"></i>
                                        </span>

                                        <div class="form-group w-50">
                                            <select class="form-control" id="products-timeline-range">
                                                <option value="last-7-days">Last 7 Days</option>
                                                <option value="last-2-weeks">Last 2 Weeks</option>
                                                <option value="last-6-months">Last 6 Months</option>
                                                <option value="last-1-year">Last 1 Year</option>
                                            </select>
                                        </div>

                                        <canvas id="products-timeline-chart" height="150"></canvas>

                                        <span class="subtitle d-block mt-2">
                                            Registered Dogs per Category
                                        </span>

                                        <div class="badges">
                                            <span class="badge badge-secondary d-inline-block">
                                                PRODUCTS
                                            </span>
                                            <span class="badge badge-info d-inline-block">
                                                CHART
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-0 d-flex justify-content-between align-items-center">
                                        View More Info
                                        <a href="" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    let productsChart = new Chart(document.getElementById("products-timeline-chart"), {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            title: {
                display: false,
            },
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        }
    });

    $(document).on('change', '#products-timeline-range', function() {
        let self = this
        let value = $(self).val()

        if (value) {
            $.ajax({
                url: "{{ route('chart.update-product-categories') }}",
                method: 'POST',
                data: {
                    range: value,
                },
                success: function (response) {
                    productsChart.data.labels = response.labels
                    productsChart.data.datasets = response.datasets
                    productsChart.update()
                }
            })
        }
    })

    $('#products-timeline-range').trigger('change')
})
</script>
@endsection
