<div>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table style="border-collapse: collapse;">
        <thead>
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
                <tr wire:key="{{ $reservation['id'] }}" style="border: 1px solid">
                    <th scope="row">{{ $reservation['get_user']['firstName'] }}
                        {{ $reservation['get_user']['lastName'] }}</th>
                    <td>{{ $reservation['get_house']['houseName'] }}</td>
                    <td><span class="badge badge-primary">{{ $reservation['get_room']['name'] }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($reservation['checkIn'])->format('Y-m-d') }}</td>
                    <td>{{ $reservation['checkOut'] ? \Carbon\Carbon::parse($reservation['checkOut'])->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        {{-- PENDING --}}
                        @if ($reservation['get_status']['serial_id'] === 1)
                            <span class="badge badge-info">{{ $reservation['get_status']['name'] }}</span>

                            {{-- APPROVED --}}
                        @elseif($reservation['get_status']['serial_id'] === 2)
                            <span class="badge badge-success">{{ $reservation['get_status']['name'] }}</span>

                            {{-- CANCELLED --}}
                        @elseif($reservation['get_status']['serial_id'] === 3)
                            <span class="badge badge-danger">{{ $reservation['get_status']['name'] }}</span>

                            {{-- FOR-APPROVAL --}}
                        @elseif($reservation['get_status']['serial_id'] === 6)
                            <span class="badge badge-warning">{{ $reservation['get_status']['name'] }}</span>
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
