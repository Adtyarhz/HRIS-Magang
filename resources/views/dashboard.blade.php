@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    Carbon::setLocale('en');
    $now = Carbon::now()->translatedFormat('l, d F Y H:i');
    $role = Auth::user()->role;
@endphp

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-tachometer-alt text-gray-400 mr-2"></i>Dashboard
    </h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-calendar fa-sm text-white-50 mr-2"></i>{{ $now }}
    </a>
</div>

<div class="row">

    @if($genderStats->isNotEmpty() || $divisionStats->isNotEmpty())

        {{-- Gender Chart (Doughnut) --}}
        @if($genderStats->isNotEmpty())
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Employee Statistics (Gender)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="employee-chart"></canvas>
                    </div>
                    <div class="mt-4 text-center small text-muted">
                        Hover over the chart to see details
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Division Chart (Bar) --}}
        @if(in_array($role, ['superadmin', 'hc', 'direksi']) && $divisionStats->isNotEmpty())
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Employee Distribution (Division)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="division-chart"></canvas>
                    </div>
                    <div class="mt-4 text-center small text-muted">
                        Number of employees per division
                    </div>
                </div>
            </div>
        </div>
        @endif

    @else
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('assets/img/undraw_posting_photo.svg') }}" alt="...">
                    <h4 class="text-gray-500">No data available to display statistics.</h4>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@push('js')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // -- Gender Chart --
    @if($genderStats->isNotEmpty())
    var ctxGender = document.getElementById("employee-chart");
    var employeeChart = new Chart(ctxGender, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($genderStats->toArray())),
            datasets: [{
                data: @json(array_values($genderStats->toArray())),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 80,
        },
    });
    @endif

    // -- Division Chart --
    @if(in_array($role, ['superadmin', 'hc', 'direksi']) && $divisionStats->isNotEmpty())
    var ctxDivision = document.getElementById("division-chart");
    var divisionChart = new Chart(ctxDivision, {
        type: 'bar',
        data: {
            labels: @json($divisionStats->pluck('name')),
            datasets: [{
                label: "Employees",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: @json($divisionStats->pluck('employees_count')),
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: { unit: 'division' },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        padding: 10,
                        stepSize: 1,
                        callback: function(value, index, values) {
                            return value; // Format number
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        }
    });
    @endif
});
</script>
@endpush