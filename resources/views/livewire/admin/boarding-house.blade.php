<div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">{{ __('Boarding House') }}</h1>

    <div class="d-flex justify-content-end">
        <button wire:click="createBoardingHouse"
            class="bg-primary text-white border-radius px-3 py-2
        rounded border my-4">
            <i class="fas fa-plus-circle"></i>
            {{ __('Add') }}
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <button wire:click="exportExcelBoardingHouse"
                class="bg-success text-white border-radius px-3 py-2 rounded border my-4">
                Export to excel
            </button>
            <a href="{{ url('admin/export-pdf-boarding-house/?search=' . $search) }}">
                <button class="bg-danger text-white border-radius px-3 py-2 rounded border my-4">
                    Export to pdf
                </button>
            </a>
        </div>

        <div>
            <input type="text" wire:model.live="search" placeholder="Search House Name" id="form1"
                class="form-control" autocomplete="off" />
        </div>
    </div>


    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">House Name</th>
                <th scope="col">Address</th>
                <th scope="col">Vacant & Occupied House/Room</th>
                <th scope="col">Contact</th>
                <th scope="col">Ratings</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody style="color: white;">
            @forelse ($boardingHouses as $boardingHouse)
                <tr wire:key="{{ $boardingHouse->id }}">
                    <th scope="row">{{ $boardingHouse->houseName }}</th>
                    <td>{{ $boardingHouse->address }}</td>
                    <td>{{ $boardingHouse->vacant_rooms }} / {{ $boardingHouse->occupied_rooms }}</td>
                    <td>{{ $boardingHouse->contact }}</td>
                    @php
                        $ratings = 0;

                        // Calculate the ratings
                        if ($boardingHouse->getRatings) {
                            foreach ($boardingHouse->getRatings as $rate) {
                                $ratings += $rate->rating;
                            }

                            // Only calculate for the house that contains ratings
                            if (count($boardingHouse->getRatings) > 0) {
                                $ratings = $ratings / count($boardingHouse->getRatings);
                            }
                        }
                    @endphp
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $ratings ? 'text-primary' : '' }}" aria-hidden="true"></i>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <button wire:click="rooms('{{ $boardingHouse->id }}')"
                            class="btn btn-primary delete-header m-1 btn-sm text-white" title="Rooms"
                            data-toggle="modal" data-target="#boardingHouseModal">
                            <i class="fa fa-bed" aria-hidden="true"></i>
                            Rooms
                        </button>
                        <button wire:click="editBoardingHouse('{{ $boardingHouse->id }}')"
                            class="btn btn-info delete-header m-1 btn-sm text-white" title="Edit" data-toggle="modal"
                            data-target="#boardingHouseModal">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit
                        </button>
                        <button wire:click="deleteBoardingHouse('{{ $boardingHouse->id }}')"
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
        {{ $boardingHouses->links() }}
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
