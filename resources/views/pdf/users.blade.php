<div>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
    <table class="table" style="border-collapse: collapse;">
        <thead class="thead-light">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr wire:key="{{ $user['id'] }}">
                    <th scope="row">{{ $user['firstName'] }} {{ $user['lastName'] }}</th>
                    <td>{{ $user['email'] }}</td>
                    <td><span class="badge badge-primary">{{ ucfirst($user['user_type']['name']) ?? '' }}</span></td>
                    <td>
                        <span
                            class="badge
                            @if ($user['status']['serial_id'] == 14) {{ 'badge-success' }}
                            @elseif ($user['status']['serial_id'] == 15)
                            {{ 'badge-secondary' }}
                            @else 
                            {{ 'badge-danger' }} @endif">{{ $user['status']['name'] ?? '' }}
                        </span>
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
