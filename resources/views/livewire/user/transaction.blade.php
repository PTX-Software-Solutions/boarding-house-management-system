<div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">{{ __('Transactions') }}</h1>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">House</th>
                <th scope="col">Room</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Rate</th>
            </tr>
        </thead>
        <tbody style="color: white">
            @forelse ($reservations as $reservation)
                <tr wire:key="{{ $reservation->id }}">
                    <td>{{ $reservation->getHouse->houseName }}</td>
                    <td><span class="badge badge-primary">{{ $reservation->getRoom->name }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($reservation->checkIn)->format('Y-m-d') }}</td>
                    <td>{{ $reservation->checkOut ? \Carbon\Carbon::parse($reservation->checkOut)->format('Y-m-d') : '-' }}
                    <td>
                        <span
                            class="badge {{ $reservation->getStatus->serial_id === 3 ? 'badge-danger' : 'badge-success' }}">
                            {{ $reservation->getStatus->name }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if ($reservation->getRating)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $reservation->getRating->rating)
                                    {{-- <span wire:click.prevent="rateReservation({{ json_encode($data) }})"
                                @if ($rating >= $i) class="text-warning" @endif
                                style="cursor:pointer; font-size: 18px;">&#9733;</span> --}}
                                    <i class="fa fa-star text-primary" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                @endif
                            @endfor
                        @elseif ($reservation->getStatus->serial_id === 2)
                            @if (!$isRatingClicked || $selectedToggleReservation !== $reservation->id)
                                <button wire:click="toggleReservation({{ json_encode($reservation->id) }})"
                                    class="btn btn-primary delete-header m-1 btn-sm text-white" title="Edit"
                                    data-toggle="modal" data-target="#boardingHouseModal">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    Rate Me
                                </button>
                            @else
                                @if ($reservation->id === $selectedToggleReservation)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $data = [
                                                'rate' => $i,
                                                'reservationId' => $reservation->id,
                                                'houseId' => $reservation->getHouse->id,
                                            ];
                                        @endphp
                                        <span wire:click.prevent="rateReservation({{ json_encode($data) }})"
                                            @if ($rating >= $i) class="text-warning" @endif
                                            style="cursor:pointer; font-size: 18px;">&#9733;</span>
                                    @endfor
                                @endif
                            @endif
                        @endif
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
        Livewire.on('success-reservation', (event) => {
            setTimeout(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'BH reservation successfully created!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000)
        })

        Livewire.on('rateReservation', (event) => {
            Swal.fire({
                title: "Enter your password",
                input: "password",
                inputLabel: "Password",
                inputPlaceholder: "Enter your password",
                inputAttributes: {
                    maxlength: "10",
                    autocapitalize: "off",
                    autocorrect: "off"
                }
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
