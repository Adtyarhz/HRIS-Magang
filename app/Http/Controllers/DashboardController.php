<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Division;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            $user = auth()->user();
            $role = $user->role;
            $divisionId = $user->employee->division_id ?? null;

            $genderStats = collect();
            $divisionStats = collect();

            // ===============================
            // SUPERADMIN / HC / DIREKSI
            // ===============================
            if (in_array($role, ['superadmin', 'hc', 'direksi'])) {

                $genderStats = Employee::selectRaw('gender, COUNT(*) as total')
                    ->groupBy('gender')
                    ->pluck('total', 'gender')
                    ->mapWithKeys(function ($value, $key) {
                        $englishKey = match (strtolower($key)) {
                            'laki-laki' => 'Male',
                            'perempuan' => 'Female',
                            default => ucfirst($key),
                        };
                        return [$englishKey => $value];
                    });

                $divisionStats = Division::where('name', '!=', 'N/A')
                    ->withCount('employees')
                    ->get();
            }

            // ===============================
            // MANAGER
            // ===============================
            elseif ($role === 'manager' && $divisionId) {

                $genderStats = Employee::where('division_id', $divisionId)
                    ->selectRaw('gender, COUNT(*) as total')
                    ->groupBy('gender')
                    ->pluck('total', 'gender')
                    ->mapWithKeys(function ($value, $key) {
                        $englishKey = match (strtolower($key)) {
                            'laki-laki' => 'Male',
                            'perempuan' => 'Female',
                            default => ucfirst($key),
                        };
                        return [$englishKey => $value];
                    });
            }

            // ===============================
            // SECTION HEAD (JIKA TIDAK ADA MANAGER)
            // ===============================
            elseif ($role === 'section_head' && $divisionId) {

                $hasManager = User::where('role', 'manager')
                    ->whereHas('employee', function ($q) use ($divisionId) {
                        $q->where('division_id', $divisionId);
                    })->exists();

                if (!$hasManager) {
                    $genderStats = Employee::where('division_id', $divisionId)
                        ->selectRaw('gender, COUNT(*) as total')
                        ->groupBy('gender')
                        ->pluck('total', 'gender')
                        ->mapWithKeys(function ($value, $key) {
                            $englishKey = match (strtolower($key)) {
                                'laki-laki' => 'Male',
                                'perempuan' => 'Female',
                                default => ucfirst($key),
                            };
                            return [$englishKey => $value];
                        });
                }
            }

            return view('dashboard', compact('genderStats', 'divisionStats'));

        } catch (\Exception $e) {
            Log::error('Error loading dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
}
