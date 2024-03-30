<div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">{{ __('Confirmations') }}</h1>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">User</th>
                <th scope="col">House</th>
                <th scope="col">Room</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody style="color: white">
            @forelse ($reservations as $reservation)
                <tr wire:key="{{ $reservation->id }}">
                    <th scope="row">{{ $reservation->getUser->firstName }} {{ $reservation->getUser->lastName }}</th>
                    <td>{{ $reservation->getHouse->houseName }}</td>
                    <td><span class="badge badge-primary">{{ $reservation->getRoom->name }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($reservation->checkIn)->format('Y-m-d') }}</td>
                    <td>{{ $reservation->checkOut ? \Carbon\Carbon::parse($reservation->checkOut)->format('Y-m-d') : '-' }}
                    </td>
                    <td class="text-center">
                        <button wire:click="cancelReservation('{{ $reservation->id }}')"
                            class="btn btn-danger delete-header m-1 btn-sm text-white" title="Edit"
                            data-toggle="modal" data-target="#boardingHouseModal">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            Cancel
                        </button>
                        <button wire:click="approveReservation('{{ $reservation->id }}')"
                            class="btn btn-primary delete-header m-1 btn-sm text-white" title="Edit"
                            data-toggle="modal" data-target="#boardingHouseModal">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Approve
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

        Livewire.on('approveRes', (event) => {
            Swal.fire({
                title: 'Approve Reservation?',
                text: "You won't be able to revert this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch("approveReserv", {
                        id: event.id
                    })
                    Swal.fire(
                        'Approved!',
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
