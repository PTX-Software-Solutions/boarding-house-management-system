<div>
    <button wire:click="toggleModal">Open Modal</button>

    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">My Modal</h5>
                        <button type="button" class="close" wire:click="toggleModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Your modal content goes here -->
                        <p>This is the content of the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="toggleModal">Close</button>
                        <!-- Additional modal buttons can be added here -->
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>