@extends('layouts.admin')

@section('title', 'Add Insurance')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-medical-alt fa-fw mr-2"></i>Add Insurance
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form action="{{ route('employees.insurance.store', $employee) }}" method="POST" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Insurance Details</h6>

                    @include('employees.insurance._form', ['insurance' => null])

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('employees.insurance.index', $employee) }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Submit Insurance</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
    document.getElementById('createForm').addEventListener('submit', function() {
        let btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
        }
    });

    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush