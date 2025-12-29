@php
    $employeeId = $employee->id ?? null;

    $allTabs = [
        'employees.edit'                   => '<i class="fas fa-user mr-1"></i> Personal',
        'employees.address.edit'           => '<i class="fas fa-map-marker-alt mr-1"></i> Address',
        'employees.family-dependents.index' => '<i class="fas fa-users mr-1"></i> Family',
        'employees.educationhistory.index' => '<i class="fas fa-graduation-cap mr-1"></i> Education',
        'employees.work-experience.index'  => '<i class="fas fa-briefcase mr-1"></i> Experience',
        'employees.training-histories.index' => '<i class="fas fa-chalkboard-teacher mr-1"></i> Training',
        'employees.certifications.index'   => '<i class="fas fa-certificate mr-1"></i> Certification',
        'employees.health.edit'            => '<i class="fas fa-heartbeat mr-1"></i> Health',
        'employees.insurance.index'        => '<i class="fas fa-file-medical-alt mr-1"></i> Insurance',
    ];
@endphp

<div class="card mb-4 border-bottom-0 shadow-none" style="background: transparent;">
    <div class="card-header p-0 border-bottom-0 bg-transparent">
        <ul class="nav nav-tabs" id="employeeTab" role="tablist">
            @foreach ($allTabs as $route => $label)
                @php
                    $isRouteActive = Route::has($route) && $employeeId;
                    
                    $routePrefix = preg_replace('/\.(index|edit|create|show)$/', '', $route);
                    $currentRoute = request()->route()->getName();
                    
                    $isActivePage =
                        $currentRoute === $route ||
                        (Str::startsWith($currentRoute, $routePrefix . '.') &&
                        Str::startsWith($routePrefix, 'employees.') &&
                        explode('.', $currentRoute)[1] === explode('.', $routePrefix)[1]);

                    if (request()->routeIs('employees.create') && $route === 'employees.edit') {
                        $isActivePage = true;
                    }
                @endphp

                <li class="nav-item">
                    @if ($isRouteActive)
                        <a class="nav-link {{ $isActivePage ? 'active font-weight-bold text-primary' : 'text-secondary' }}" 
                           href="{{ route($route, $employeeId) }}">
                           {!! $label !!}
                        </a>
                    @else
                        <span class="nav-link disabled text-muted" title="Not available yet">
                            {!! $label !!}
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>