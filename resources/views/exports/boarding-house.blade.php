<div>
    <table>
        <thead class="thead-light">
            <tr>
                <th scope="col">House Name</th>
                <th scope="col">Address</th>
                <th scope="col">Vacant &amp; Occupied House&#47;Room</th>
                <th scope="col">Contact</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($boardingHouses as $boardingHouse)
                <tr>
                    <th scope="row">{{ $boardingHouse->houseName }}</th>
                    <td>{{ $boardingHouse->address }}</td>
                    <td>{{ $boardingHouse->vacant_rooms }} &#47; {{ $boardingHouse->occupied_rooms }}</td>
                    <td>{{ $boardingHouse->contact }}</td>
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
