<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $employeeId = $user?->employee?->id;
            $menu = [];

            if ($user) {               
                switch ($user->role) {
                    case 'superadmin':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],

                            ['label' => 'Employee Request', 'route' => 'employee-edit-requests.index', 'icon' => 'charm:git-request'],
                        ];
                        break;
                    case 'hc':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],

                            ['label' => 'Employee Request', 'route' => 'employee-edit-requests.index', 'icon' => 'charm:git-request'],
                        ];
                        break;
                    case 'direksi':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            $employeeId
                            ? ['label' => 'Employee Information', 'route' => 'employees.show', 'params' => ['employee' => $employeeId], 'icon' => 'icon-park-outline:file-staff-one']
                            : ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],
                        ];
                        break;
                    case 'manager':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            $employeeId
                            ? ['label' => 'Employee Information', 'route' => 'employees.show', 'params' => ['employee' => $employeeId], 'icon' => 'icon-park-outline:file-staff-one']
                            : ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],
                        ];
                        break;
                    case 'section_head':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            $employeeId
                            ? ['label' => 'Employee Information', 'route' => 'employees.show', 'params' => ['employee' => $employeeId], 'icon' => 'icon-park-outline:file-staff-one']
                            : ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],
                        ];
                        break;
                    case 'staff_bisnis':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            $employeeId
                            ? ['label' => 'Employee Information', 'route' => 'employees.show', 'params' => ['employee' => $employeeId], 'icon' => 'icon-park-outline:file-staff-one']
                            : ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],
                        ];
                        break;
                    case 'staff_support':
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'mdi:home-outline'],
                            $employeeId
                            ? ['label' => 'Employee Information', 'route' => 'employees.show', 'params' => ['employee' => $employeeId], 'icon' => 'icon-park-outline:file-staff-one']
                            : ['label' => 'Employee Information', 'route' => 'employees.index', 'icon' => 'icon-park-outline:file-staff-one'],
                        ];
                        break;
                }
            }

            $view->with('menu', $menu);
        });
    }
}
