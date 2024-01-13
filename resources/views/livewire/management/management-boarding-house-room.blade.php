<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Rooms') }}</h1>

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <input type="text" wire:model.live="search" placeholder="Search Room Name" id="form1"
                class="form-control" autocomplete="off" />
        </div>

        <button wire:click="createRooms"
            class="bg-primary text-white border-radius px-3 py-2
        rounded border my-4">
            <i class="fas fa-plus-circle"></i>
            {{ __('Add') }}
        </button>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Name/Number</th>
                <th scope="col">Monthly Deposit</th>
                <th scope="col">Room Type</th>
                <th scope="col">Room Ammenities</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $room)
                <tr wire:key="{{ $room->id }}">
                    <th scope="row">{{ $room->name }}</th>
                    <td>{{ $room->monthlyDeposit }}</td>
                    <td>{{ $room->getRoomType->name }}</td>
                    <td>
                        @if ($room->amenities->isNotEmpty())
                            @foreach ($room->amenities as $data)
                                <span class="badge badge-primary">{{ $data->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $room->getStatus->name }}</td>
                    <td>
                        <button wire:click="editRoom('{{ $room->id }}')"
                            class="btn btn-info delete-header m-1 btn-sm text-white" title="Edit" data-toggle="modal"
                            data-target="#boardingHouseModal">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit
                        </button>
                        <button wire:click="deleteRoom('{{ $room->id }}')"
                            class="btn btn-danger delete-header m-1 btn-sm" title="Delete">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <p class="text-center">No results found!</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        {{ $rooms->links() }}
    </div>
</div>

<script data-navigate-track>
    function houseTableEvents() {
        Livewire.on('success-insert', (event) => {
            setTimeout(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Room created successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000)
        })

        Livewire.on('success-update', (event) => {
            setTimeout(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Room updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000)
        })

        Livewire.on('deleteBHRoom', (event) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch("removeBHRoom", {
                        id: event.id
                    })
                    Swal.fire(
                        'Deleted!',
                        'Your data has been deleted.',
                        'success'
                    )
                }
            });
        })
    }

    function listener() {
        houseTableEvents()
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
