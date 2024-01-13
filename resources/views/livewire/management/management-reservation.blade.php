<div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Reservations') }}</h1>

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <button wire:click="exportExcelReservation"
                class="bg-success text-white border-radius px-3 py-2 rounded border my-4">
                Export to excel
            </button>
            <a href="{{ url('/management/export-pdf/?search=' . $search) }}">
                <button class="bg-danger text-white border-radius px-3 py-2 rounded border my-4">
                    Export to pdf
                </button>
            </a>
        </div>

        <div>
            <input type="text" wire:model.live="search" placeholder="Search User/House Name"
                id="form1" class="form-control" autocomplete="off" />
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">User</th>
                <th scope="col">House</th>
                <th scope="col">Room</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservations as $reservation)
                <tr wire:key="{{ $reservation->id }}">
                    <th scope="row">{{ $reservation->getUser->firstName }} {{ $reservation->getUser->lastName }}</th>
                    <td>{{ $reservation->getHouse->houseName }}</td>
                    <td><span class="badge badge-primary">{{ $reservation->getRoom->name }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($reservation->checkIn)->format('Y-m-d') }}</td>
                    <td>{{ $reservation->checkOut ? \Carbon\Carbon::parse($reservation->checkOut)->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        {{-- PENDING --}}
                        @if ($reservation->getStatus->serial_id === 1)
                            <span class="badge badge-info">{{ $reservation->getStatus->name }}</span>

                            {{-- APPROVED --}}
                        @elseif($reservation->getStatus->serial_id === 2)
                            <span class="badge badge-success">{{ $reservation->getStatus->name }}</span>

                            {{-- CANCELLED --}}
                        @elseif($reservation->getStatus->serial_id === 3)
                            <span class="badge badge-danger">{{ $reservation->getStatus->name }}</span>

                            {{-- FOR-APPROVAL --}}
                        @elseif($reservation->getStatus->serial_id === 6)
                            <span class="badge badge-warning">{{ $reservation->getStatus->name }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button wire:click="cancelReservation('{{ $reservation->id }}')"
                            class="btn btn-danger delete-header m-1 btn-sm text-white" title="Edit"
                            data-toggle="modal" data-target="#boardingHouseModal"
                            {{ $reservation->getStatus->serial_id === 6 || $reservation->getStatus->serial_id === 3 || $reservation->getStatus->serial_id === 2 ? 'disabled' : '' }}>
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            Cancel
                        </button>
                        <button wire:click="forApprovalReservation('{{ $reservation->id }}')"
                            class="btn btn-primary delete-header m-1 btn-sm text-white" title="Edit"
                            data-toggle="modal" data-target="#boardingHouseModal"
                            {{ $reservation->getStatus->serial_id === 6 || $reservation->getStatus->serial_id === 3 || $reservation->getStatus->serial_id === 2 ? 'disabled' : '' }}>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            For Approval
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
        {{ $reservations->links() }}
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
                    text: 'BH created successfully!',
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
                    text: 'BH updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000)
        })

        Livewire.on('forApproval', (event) => {
            Swal.fire({
                title: 'Update into for-approval?',
                text: "You won't be able to revert this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, for approval!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch("forApprovalRes", {
                        id: event.id
                    })
                    Swal.fire(
                        'For Approval!',
                        'Your data status has been updated.',
                        'success'
                    )
                }
            });
        })

        Livewire.on('cancelRes', (event) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch("cancelReserv", {
                        id: event.id
                    })
                    Swal.fire(
                        'Cancelled!',
                        'Your data has been cancelled.',
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
