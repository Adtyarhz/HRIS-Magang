@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <div style="display: flex; align-items: center; gap: 10px; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 24px;">
        <i class="fas fa-home" style="color: #000;"></i>
        <span>Dashboard</span>
    </div>
@endsection

@section('content')
@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    Carbon::setLocale('en');
    $now = Carbon::now()->translatedFormat('l, d F Y H:i');
    $role = Auth::user()->role;
@endphp

<div style="width: 100%; min-height: 100vh; background: #FEFEF9; padding: 15px;">
    
    {{-- Current Date --}}
    <div style="margin-bottom: 20px; font-family: Montserrat; font-size: 20px; font-weight: 600; display: inline-block; border-bottom: 1px solid black; padding-bottom: 5px;">
        {{ $now }}
    </div>

    {{-- Employee Statistics --}}
    @if($genderStats->isNotEmpty() || $divisionStats->isNotEmpty())
        <div style="background: #FFFEF9; border-radius: 10px; border: 1px solid rgba(0, 0, 0, 0.2); padding: 20px;">
            
            <div style="text-align: center; font-size: 22px; font-family: Montserrat; font-weight: 500; border-bottom: 1px solid rgba(0,0,0,0.3); padding-bottom: 10px; margin-bottom: 20px;">
                <b>Employee Statistics</b>
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">

                {{-- Gender Chart --}}
                @if($genderStats->isNotEmpty())
                    <div style="flex: 1; min-width: 250px;">
                        <div style="font-size: 18px; font-weight: 500; text-align:center; margin-bottom: 10px; font-family: Montserrat;">
                            By Gender
                        </div>
                        <div style="height: 300px;">
                            <canvas id="employee-chart"></canvas>
                        </div>
                    </div>
                @endif

                {{-- Division Chart --}}
                @if(in_array($role, ['superadmin', 'hc', 'direksi']) && $divisionStats->isNotEmpty())
                    <div style="flex: 1; min-width: 250px;">
                        <div style="font-size: 18px; font-weight: 500; text-align:center; margin-bottom: 10px; font-family: Montserrat;">
                            By Division
                        </div>
                        <div style="height: 300px;">
                            <canvas id="division-chart"></canvas>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Gender Chart
    @if($genderStats->isNotEmpty())
    new Chart(document.getElementById('employee-chart'), {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($genderStats->toArray())),
            datasets: [{
                data: @json(array_values($genderStats->toArray())),
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
    @endif

    // Division Chart
    @if(in_array($role, ['superadmin', 'hc', 'direksi']) && $divisionStats->isNotEmpty())
    new Chart(document.getElementById('division-chart'), {
        type: 'bar',
        data: {
            labels: @json($divisionStats->pluck('name')),
            datasets: [{
                data: @json($divisionStats->pluck('employees_count')),
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    @endif

});
</script>
@endpush
@endsection
