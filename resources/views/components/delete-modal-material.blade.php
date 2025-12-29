@props(['modalId', 'message' => 'Are you sure to delete this item?'])

<div class="modal fade" id="deleteModal-{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $modalId }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel-{{ $modalId }}">
                    <i class="fas fa-trash mr-2"></i> Delete Confirmation
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-circle fa-3x text-gray-300"></i>
                </div>
                <p class="text-center text-gray-900 mb-0">{{ $message }}</p>
                <p class="text-center text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="form-{{ $modalId }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    function showDeleteModal(modalId, actionUrl = null) {
        if (actionUrl) {
            $('#form-' + modalId).attr('action', actionUrl);
        }
        $('#deleteModal-' + modalId).modal('show');
    }

    function hideDeleteModal(modalId) {
        $('#deleteModal-' + modalId).modal('hide');
    }
</script>
@endpush