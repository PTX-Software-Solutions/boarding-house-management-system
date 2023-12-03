<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Boarding House') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-street-view" aria-hidden="true"></i>
                                Map
                            </div>
                            <div class="card-body">
                                <div wire:ignore.self id='map' style='width: 100%; height: 50vh;' wire:ignore>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $currentTab === 1 ? 'active' : '' }}" id="home-tab" data-toggle="tab"
                        wire:click="changeTab(1)" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">House Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentTab === 2 ? 'active' : '' }}" id="profile-tab" data-toggle="tab"
                        wire:click="changeTab(2)" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">Nearby
                        Attraction</a>
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
                                    <div class="form-group col-md-12">
                                        <div class="form-group" wire:ignore>
                                            <label for="exampleFormControlSelect1">Homeowner</label>
                                            <select wire:model="userId" id="userId" class="form-control test-select"
                                                data-control="select2" data-placeholder="Select a homeowner">
                                                <option>-- Select homeowner --</option>
                                                @foreach ($homeOwners as $homeOwner)
                                                    <option value="{{ $homeOwner->id }}"
                                                        @if ($id && $userId === $homeOwner->id) {{ 'selected' }} @endif>
                                                        {{ $homeOwner->firstName }} {{ $homeOwner->lastName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            @error('userId')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="houseName">House Name</label>
                                        <input type="text" wire:model="houseName"
                                            class="form-control @error('houseName') border border-danger @enderror"
                                            id="houseName">
                                        <div>
                                            @error('houseName')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contact">Contact</label>
                                        <input type="text" wire:model="contact"
                                            class="form-control @error('contact') border border-danger @enderror"
                                            id="contact">
                                        <div>
                                            @error('contact')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" wire:model="address"
                                        class="form-control @error('address') border border-danger @enderror"
                                        id="address" placeholder="1234 Main St">
                                    <div>
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address2">Address 2</label>
                                    <input type="text" wire:model="address2"
                                        class="form-control @error('address2') border border-danger @enderror"
                                        id="address2" placeholder="Apartment, studio, or floor">
                                    <div>
                                        @error('address2')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="city">City</label>
                                        <input type="text" wire:model="city"
                                            class="form-control @error('city') border border-danger @enderror"
                                            id="city">
                                        <div>
                                            @error('city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="zip">Zip</label>
                                        <input type="text" wire:model="zip"
                                            class="form-control @error('zip') border border-danger @enderror"
                                            id="zip">
                                        <div>
                                            @error('zip')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="my-3 btn {{ $id ? 'btn-info' : 'btn-primary' }}">
                                    {{ $id ? 'Update' : 'Create' }}
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
                                    <button type="button" wire:click="addAttraction" class="btn btn-primary my-3">
                                        <i class="fas fa-plus-circle"></i>
                                        Add</button>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Distance</th>
                                            <th scope="col">Distance Type</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($attractionLists as $index => $attractionList)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            wire:model="attractionLists.{{ $index }}.name"
                                                            class="form-control @error("attractionLists.{$index}.name") border border-danger @enderror"
                                                            aria-describedby="emailHelp" placeholder="...">
                                                    </div>
                                                    <small>
                                                        @error("attractionLists.{$index}.name")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </th>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="number"
                                                            wire:model="attractionLists.{{ $index }}.distance"
                                                            class="form-control @error("attractionLists.{$index}.distance") border border-danger @enderror"
                                                            min="1" aria-describedby="emailHelp"
                                                            placeholder="123">
                                                    </div>
                                                    <small>
                                                        @error("attractionLists.{$index}.distance")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select
                                                            class="form-control @error("attractionLists.{$index}.distanceType") border border-danger @enderror"
                                                            wire:model="attractionLists.{{ $index }}.distanceType"
                                                            id="exampleFormControlSelect1">
                                                            <option>-- Select type --</option>
                                                            @foreach ($distanceTypes as $distanceType)
                                                                <option value="{{ $distanceType->id }}">
                                                                    {{ $distanceType->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small>
                                                        @error("attractionLists.{$index}.distanceType")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        wire:click="removeAttraction({{ $index }})">
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
    function generateMapBox() {
        console.log('IM IN THE HOUSE FORM SCRIPT')
        const longitude = {{ $longitude }}
        const latitude = {{ $latitude }}

        console.log('longitude: ', longitude)
        console.log('latitude: ', latitude)

        mapboxgl.accessToken =
            '{{ env('MAPBOX_API_KEY') }}';
        map = new mapboxgl.Map({
            container: 'map',
            center: [longitude, latitude],
            zoom: 13,
        });

        marker = new mapboxgl.Marker({
            color: '#ff3333',
            anchor: 'center'
        }).setLngLat([longitude, latitude]).addTo(map)

        map.on('move', () => {
            const {
                lng,
                lat
            } = map.getCenter()

            @this.longitude = lng
            @this.latitude = lat

            // Set the center marker on the map
            marker.setLngLat(map.getCenter());
        })

        // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
        const style = 'streets-v11'
        map.setStyle(`mapbox://styles/mapbox/${style}`)
        map.addControl(new mapboxgl.NavigationControl())
    }

    function listener() {
        generateMapBox()

        // Livewire.on('init-select2', () => {
        //     $('.test-select').select2();
        // })

        $('#userId').on('select2:select', function(e) {
            let value = $(this).val();
            //@this.set('categoryId', value);
            // @this.dispatch('user-id', {
            //     userId: value
            // });
            console.log('VALUE: ', value)
            @this.set('userId', value)
            // $('.test-select').select2();
        });

        $('.test-select').select2();
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
