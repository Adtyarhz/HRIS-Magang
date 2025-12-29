@extends('layouts.admin')

@section('title', 'Employee Request Detail')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-info-circle fa-fw mr-2"></i>Detail of Employee Data Change Request
    </h1>
    <a href="{{ route('employee-edit-requests.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Request Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th class="pl-0 text-gray-600" width="40%">Employee:</th>
                        <td class="font-weight-bold text-gray-800">{{ $editRequest->employee->full_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="pl-0 text-gray-600">Method:</th>
                        <td><span class="badge badge-info">{{ ucfirst($editRequest->method) }}</span></td>
                    </tr>
                    <tr>
                        <th class="pl-0 text-gray-600">Submitted At:</th>
                        <td>{{ $editRequest->requested_at ? \Carbon\Carbon::parse($editRequest->requested_at)->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th class="pl-0 text-gray-600">Status:</th>
                        <td>
                            @if ($editRequest->status === 'waiting')
                                <span class="badge badge-warning">Pending</span>
                            @elseif ($editRequest->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif ($editRequest->status === 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="pl-0 text-gray-600">Approved By:</th>
                        <td>{{ $editRequest->approvedBy->name ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Changes Comparison</h6>
            </div>
            <div class="card-body">

                @php
                    use Illuminate\Support\Str;

                    $originalData = is_string($editRequest->original_data) 
                        ? json_decode($editRequest->original_data, true) ?? [] 
                        : ($editRequest->original_data ?? []);

                    $changedData = is_string($editRequest->changed_data) 
                        ? json_decode($editRequest->changed_data, true) ?? [] 
                        : ($editRequest->changed_data ?? []);

                    function formatValue($field, $value) {
                        if (is_array($value)) {
                            return implode(', ', array_map(function($v, $k) {
                                return is_array($v) ? $k . ': ' . json_encode($v) : $k . ': ' . $v;
                            }, $value, array_keys($value)));
                        }
                        if ($field === 'division_id') {
                            $division = \App\Models\Division::find($value);
                            return $division ? $division->name : '-';
                        }
                        if ($field === 'position_id') {
                            $position = \App\Models\Position::find($value);
                            return $position ? $position->title : '-';
                        }
                        if (!empty($value) && str_contains($field, 'date')) {
                            try {
                                return \Carbon\Carbon::parse($value)->format('Y-m-d');
                            } catch (\Exception $e) {
                                return $value;
                            }
                        }
                        if (!empty($value) && is_string($value) && 
                            (str_contains($value, 'certifications/') || str_contains($value, 'storage/') || str_contains($value, '.png') || str_contains($value, '.jpg') || str_contains($value, '.pdf'))
                        ) {
                            $cleanPath = Str::after($value, 'storage/');
                            $url = asset('storage/' . $cleanPath);
                            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                            $filename = basename($cleanPath);

                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                return '<a href="'.$url.'" target="_blank">
                                            <img src="'.$url.'" class="img-thumbnail" style="max-height:80px;">
                                        </a>
                                        <div class="small mt-1"><a href="'.$url.'" download="'.$filename.'"><i class="fas fa-download"></i> '.$filename.'</a></div>';
                            }
                            return '<a href="'.$url.'" download="'.$filename.'" class="btn btn-sm btn-light border"><i class="fas fa-file-download mr-1"></i> '.$filename.'</a>';
                        }
                        return $value ?? '-';
                    }
                @endphp

                @if(!empty($changedData))
                    @php
                        $flattened = [];
                        foreach ($changedData as $table => $records) {
                            if (is_array($records)) {
                                foreach ($records as $recordId => $fields) {
                                    if (is_array($fields)) {
                                        foreach ($fields as $field => $newValue) {
                                            $oldValue = $originalData[$table][$recordId][$field] 
                                                ?? $originalData[$table][$field] 
                                                ?? '-';

                                            $flattened[] = [
                                                'field' => $field,
                                                'old'   => $oldValue,
                                                'new'   => $newValue,
                                            ];
                                        }
                                    } else {
                                        $oldValue = $originalData[$table][$recordId] ?? '-';
                                        $fieldName = is_numeric($recordId) && $recordId == 0 ? 'Certification Supporting files' : $recordId;

                                        if ($fieldName === 'Material files') {
                                            $oldFiles = is_array($oldValue) ? $oldValue : (empty($oldValue) || $oldValue === '-' ? [] : [$oldValue]);
                                            $newFiles = is_array($fields) ? $fields : [$fields];
                                            $flattened[] = [
                                                'field' => $fieldName,
                                                'old'   => count($oldFiles) ? $oldFiles[0] : '-',
                                                'new'   => count($newFiles) ? $newFiles[0] : '-',
                                            ];
                                        } else {
                                            $flattened[] = [
                                                'field' => $fieldName,
                                                'old'   => $oldValue,
                                                'new'   => $fields,
                                            ];
                                        }
                                    }
                                }
                            } else {
                                $oldValue = $originalData[$table] ?? '-';
                                $flattened[] = [
                                    'field' => $table,
                                    'old'   => $oldValue,
                                    'new'   => $records,
                                ];
                            }
                        }
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="25%">Field Name</th>
                                    <th width="37%">Original Data</th>
                                    <th width="38%">Changed Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flattened as $row)
                                    @php
                                        $label = $row['field'];
                                        if ($label === 'division_id') $label = 'Division';
                                        elseif ($label === 'position_id') $label = 'Position';
                                        
                                        $old = $row['old'];
                                        $new = $row['new'];
                                        $normalize = fn($v) => ($v === null || $v === '' || $v === '-' ? null : trim((string) $v));
                                        $isChanged = $normalize($old) !== $normalize($new);
                                    @endphp
                                    <tr class="{{ $isChanged ? 'table-warning text-dark font-weight-bold' : '' }}">
                                        <td class="text-capitalize">{{ str_replace('_', ' ', $label) }}</td>
                                        <td class="text-muted small">{!! formatValue($row['field'], $row['old']) !!}</td>
                                        <td class="text-primary">{!! formatValue($row['field'], $row['new']) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-0">No data changes detected.</p>
                    </div>
                @endif

            </div>
            
            {{-- Action Footer --}}
            @if($editRequest->status === 'waiting')
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-end">
                         <form action="{{ route('employee-edit-requests.reject', $editRequest->id) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-icon-split shadow-sm">
                                <span class="icon text-white-50"><i class="fas fa-times"></i></span>
                                <span class="text">Reject Request</span>
                            </button>
                        </form>
                        <form action="{{ route('employee-edit-requests.approve', $editRequest->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-icon-split shadow-sm">
                                <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                <span class="text">Approve Changes</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection