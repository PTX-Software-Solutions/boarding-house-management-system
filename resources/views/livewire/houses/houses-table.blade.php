<div>
    <div class="d-flex justify-content-end">
        <button wire:click="createBoardingHouse"
            class="bg-primary text-white border-radius px-3 py-2
        rounded border my-4">
            {{-- data-toggle="modal" data-target="#boardingHouseModal"> --}}
            <i class="fas fa-plus-circle"></i>
            {{ __('Add') }}
        </button>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">House Name</th>
                <th scope="col">Address</th>
                <th scope="col">Vacant & Occupied House/Room</th>
                <th scope="col">Contact</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($boardingHouses as $boardingHouse)
                <tr wire:key="{{ $boardingHouse->id }}">
                    <th scope="row">{{ $boardingHouse->houseName }}</th>
                    <td>{{ $boardingHouse->address }}</td>
                    <td>10 / 20</td>
                    <td>{{ $boardingHouse->contact }}</td>
                    <td>
                        <button wire:click="editBoardingHouse('{{ $boardingHouse->id }}')"
                            class="btn btn-info delete-header m-1 btn-sm text-white" title="Edit" data-toggle="modal"
                            data-target="#boardingHouseModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button wire:click="deleteBoardingHouse('{{ $boardingHouse->id }}')"
                            class="btn btn-danger delete-header m-1 btn-sm" title="Delete"><i class="fa fa-times"
                                aria-hidden="true"></i></button>
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

    {{-- <!-- Add Boarding Modal-->
    <div class="modal fade" id="boardingHouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false" wire:ignore>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new boarding house') }}</h5>
                    <button class="close" type="button" wire:click="closeBoardingHouse">
                        <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <livewire:houses.houses-form />
                </div>
            </div>
        </div>
    </div> --}}
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
