<div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Users') }}</h1>

    <div class="d-flex justify-content-end">
        <button wire:click="createUser" class="bg-primary text-white border-radius px-3 py-2
        rounded border my-4">
            <i class="fas fa-plus-circle"></i>
            {{ __('Add') }}
        </button>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr wire:key="{{ $user->id }}">
                    <th scope="row">{{ $user->firstName }} {{ $user->lastName }}</th>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-primary">{{ ucfirst($user->userType->name) ?? '' }}</span></td>
                    <td>
                        <span
                            class="badge
                            @if ($user->status->serial_id == 14) {{ 'badge-success' }}
                            @elseif ($user->status->serial_id == 15)
                            {{ 'badge-secondary' }}
                            @else 
                            {{ 'badge-danger' }} @endif">{{ $user->status->name ?? '' }}
                        </span>
                    </td>
                    <td>
                        <button wire:click="editUser('{{ $user->id }}')"
                            class="btn btn-info delete-header m-1 btn-sm text-white" title="Edit" data-toggle="modal"
                            data-target="#boardingHouseModal">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit
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
        {{ $users->links() }}
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

        Livewire.on('deleteBH', (event) => {
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
                    @this.dispatch("removeBH", {
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
