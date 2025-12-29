@props([
    'modalId',
    'message' => 'Are you sure to delete this item?',
    'method' => 'DELETE',
    'title' => 'Delete Confirmation',
    'action',
    'iconClass' => 'fas fa-trash',
])


<div class="modal fade" id="deleteModal-{{ $modalId }}" tabindex="-1" role="dialog" 
     aria-labelledby="deleteModalLabel-{{ $modalId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold" id="deleteModalLabel-{{ $modalId }}">
                    <i class="{{ $iconClass }} mr-2"></i> {{ $title }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center py-4">
                <div class="mb-3 text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                </div>
                
                <h5 class="text-gray-900 font-weight-bold mb-2">Are you sure?</h5>
                <p class="text-gray-600 mb-0">{{ $message }}</p>
                <small class="text-muted">This action usually cannot be undone.</small>
            </div>

            <div class="modal-footer justify-content-center bg-light">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
                    Cancel
                </button>
                
                <form action="{{ $action }}" method="POST" class="d-inline">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    
                    <button type="submit" class="btn btn-danger px-4">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    if (typeof window.showDeleteModal === 'undefined') {
        window.showDeleteModal = function(modalId) {

            $('#deleteModal-' + modalId).modal('show');
        };
    }

    if (typeof window.hideDeleteModal === 'undefined') {
        window.hideDeleteModal = function(modalId) {
            $('#deleteModal-' + modalId).modal('hide');
        };
    }
</script>
@endpush