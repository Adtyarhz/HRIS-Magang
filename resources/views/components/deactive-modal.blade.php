@props([
    'modalId',
    'message' => 'Are you sure?',
    'title' => 'Confirmation',
    'action' => '#',
    'method' => 'POST',
    'useFormId' => null,
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ $title }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-gray-800" style="font-size: 1.1em;">{{ $message }}</p>
                <small class="text-muted d-block mt-2">Please verify the details before proceeding.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                
                @if($useFormId)
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('{{ $useFormId }}').submit();">
                        Yes, Deactivate
                    </button>
                @else

                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if(strtoupper($method) !== 'POST')
                            @method($method)
                        @endif
                        <button type="submit" class="btn btn-danger">Yes, Proceed</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>