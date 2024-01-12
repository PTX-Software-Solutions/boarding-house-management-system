<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">User</th>
                <th scope="col">House</th>
                <th scope="col">Room</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col">Status</th>
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
</div>
