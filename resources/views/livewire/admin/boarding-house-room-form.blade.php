<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Rooms') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                Upload Image
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label wire:click="$refs.uploadImage.click()" for="uploadImage"
                                            style="cursor: pointer; text-align:center;"
                                            class="@error('uploadImage') border border-danger @enderror">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            Add
                                        </label>
                                    </div>
                                    <input type="file" wire:model="uploadImage" class="form-control"
                                        style="visibility: hidden;" id="uploadImage" multiple>
                                    <div wire:loading wire:target="uploadImage">Uploading...</div>
                                    <div>
                                        @if ($uploadImage)
                                            <div class="d-flex flex-wrap">
                                                @foreach ($uploadImage as $key => $image)
                                                    <div style="width: 100px; height: 100px; position: relative;"
                                                        class="mx-1">
                                                        <div style="position: absolute; top: -10px; right: 0; cursor: pointer;"
                                                            wire:click="removeUploadImage({{ $key }})">
                                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                        </div>
                                                        <img src="{{ $image->temporaryUrl() }}"
                                                            class="img-thumbnail rounded"
                                                            style="width: 100%; height: 100%; object-fit: contain;"
                                                            alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        @error('uploadImage')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $currentTab === 1 ? 'active' : '' }}" id="home-tab" data-toggle="tab"
                        wire:click="changeTab(1)" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Room Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentTab === 2 ? 'active' : '' }}" id="profile-tab" data-toggle="tab"
                        wire:click="changeTab(2)" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">Room Ammenities</a>
                </li>
            </ul>
            <form wire:submit="save" autocomplete="off">
                <div class="tab-content" id="myTabContent">
                    {{-- House Info --}}
                    <div class="tab-pane fade {{ $currentTab === 1 ? 'show active' : '' }}" id="home"
                        role="tabpanel" aria-labelledby="home-tab">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nameNumber">Name/Number</label>
                                        <input type="text" wire:model="nameNumber"
                                            class="form-control @error('nameNumber') border border-danger @enderror"
                                            id="nameNumber">
                                        <div>
                                            @error('nameNumber')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="monthDeposit">Monthly Deposit</label>
                                        <input type="number" wire:model="monthDeposit"
                                            class="form-control @error('monthDeposit') border border-danger @enderror"
                                            id="monthDeposit">
                                        <div>
                                            @error('monthDeposit')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roomType">Room Type</label>
                                    <select class="form-control @error('roomType') border border-danger @enderror"
                                        wire:model="roomType" id="exampleFormControlSelect1">
                                        <option>-- Select type --</option>
                                        @foreach ($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}">
                                                {{ $roomType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('roomType')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address2">Status</label>
                                    <select class="form-control @error('status') border border-danger @enderror"
                                        wire:model="status" id="exampleFormControlSelect1">
                                        <option>-- Select status --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="my-3 btn {{ $roomId ? 'btn-info' : 'btn-primary' }}">
                                    {{ $roomId ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Nearby Attraction --}}
                    <div class="tab-pane fade {{ $currentTab === 2 ? 'show active' : '' }}" id="profile"
                        role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" wire:click="addRoomAmmenities"
                                        class="btn btn-primary my-3">
                                        <i class="fas fa-plus-circle"></i>
                                        Add</button>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roomAmmenities as $index => $roomAmmenity)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            wire:model="roomAmmenities.{{ $index }}.name"
                                                            class="form-control @error("roomAmmenities.{$index}.name") border border-danger @enderror"
                                                            aria-describedby="emailHelp" placeholder="...">
                                                    </div>
                                                    <small>
                                                        @error("roomAmmenities.{$index}.name")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </th>
                                                <td>
                                                    <a href="#"
                                                        wire:click="removeRoomAmmenities({{ $index }})">
                                                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="4">No data!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script data-navigate-track>
    // function generateMapBox() {
    //     console.log('IM IN THE HOUSE FORM SCRIPT')

    //     console.log('longitude: ', longitude)
    //     console.log('latitude: ', latitude)

    //     mapboxgl.accessToken =
    //         '{{ env('MAPBOX_API_KEY') }}';
    //     map = new mapboxgl.Map({
    //         container: 'map',
    //         center: [longitude, latitude],
    //         zoom: 13,
    //     });

    //     marker = new mapboxgl.Marker({
    //         color: '#ff3333',
    //         anchor: 'center'
    //     }).setLngLat([longitude, latitude]).addTo(map)

    //     map.on('move', () => {
    //         const {
    //             lng,
    //             lat
    //         } = map.getCenter()

    //         @this.longitude = lng
    //         @this.latitude = lat

    //         // Set the center marker on the map
    //         marker.setLngLat(map.getCenter());
    //     })

    //     // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
    //     const style = 'streets-v11'
    //     map.setStyle(`mapbox://styles/mapbox/${style}`)
    //     map.addControl(new mapboxgl.NavigationControl())
    // }

    function listener() {
        // generateMapBox()

        // // Livewire.on('init-select2', () => {
        // //     $('.test-select').select2();
        // // })

        // $('.test-select').select2();
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
