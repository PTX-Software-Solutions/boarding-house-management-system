<div>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Find Nearest Boarding House') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <i class="fa fa-map" aria-hidden="true"></i>
                                        Map
                                    </span>
                                    <span class="badge badge-light text-center">
                                        {{ !is_null($bhCount) ? $bhCount . ' Boarding House Found!' : '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (!$longitude && !$latitude && !$isSearchClicked)
                                    <p class="text-center font-weight-bold">PLEASE SEARCH YOUR LOCATION</p>
                                @endif
                                <div wire:ignore.self id='map' style='width: 100%; min-height: 760px;' wire:ignore>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body" style="min-height: 760px;">
                    <div class="form-group" style="position: relative;">
                        <div class="form-control-range">
                            <div class="form-outline" style="display:flex">
                                <input type="text" wire:model.live.throttle.150ms="search"
                                    placeholder="Search Location..." id="form1" class="form-control"
                                    autocomplete="off" />
                            </div>
                        </div>
                        @if ($isDisplayResult && !$isSearchClicked)
                            <div class="bg-secondary rounded"
                                style="position:absolute; z-index: 100; width: 100%; 
                                max-height: 300px; overflow-y: auto;">
                                <div class="list-group">
                                    @if ($search)
                                        @forelse ($locations['features'] as $location)
                                            @php
                                                $data = [
                                                    'longitude' => $location['center'][0] ?? 0,
                                                    'latitude' => $location['center'][1] ?? 0,
                                                    'searchText' => $location['place_name'] ?? '',
                                                ];
                                            @endphp
                                            <a href="#" wire:click="changeCoordinates({{ json_encode($data) }})"
                                                class="list-group-item list-group-item-action">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{ $location['place_name'] ?? '' }}
                                            </a>
                                        @empty
                                            <div class="bg-white text-secondary">
                                                <p>No Data Found!
                                                </p>
                                            </div>
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($latitude && $longitude)

                        <div class="form-group">
                            <label for="formControlRange" class="font-weight-bold">Price Range &#8369;
                                {{ number_format($priceRange, 2) }}</label>
                            <input type="range" wire:model.live="priceRange" class="form-control-range"
                                id="formControlRange" min="0" max="50000" step="1000">
                            <div class="d-flex justify-content-between">
                                <span>&#8369;{{ number_format(0, 2) }}</span>
                                <span>&#8369;{{ number_format(25000, 2) }}</span>
                                <span>&#8369;{{ number_format(50000, 2) }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="address" class="font-weight-bold">Room Type</label>
                            <select class="form-control" wire:model.live="roomType">
                                <option value="">Select a room</option>
                                @foreach ($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="address2" class="font-weight-bold">Distance to center</label>
                            <div class="form-check">
                                <input id="3" class="form-check-input" type="radio"
                                    wire:model="selectedDistance" value="3" id="defaultCheck1">
                                <label for="3" class="form-check-label" for="defaultCheck1">
                                    3 km to center </label>
                            </div>
                            <div class="form-check">
                                <input id="5" class="form-check-input" type="radio"
                                    wire:model="selectedDistance" value="5" id="defaultCheck1">
                                <label for="5" class="form-check-label" for="defaultCheck1">
                                    5 km to center
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="10" class="form-check-input" type="radio"
                                    wire:model="selectedDistance" value="10" id="defaultCheck1">
                                <label for="10" class="form-check-label" for="defaultCheck1">
                                    10 km to center
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="20" class="form-check-input" type="radio"
                                    wire:model="selectedDistance" value="20" id="defaultCheck1">
                                <label for="20" class="form-check-label" for="defaultCheck1">
                                    20 km to center
                                </label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="address2" class="font-weight-bold">Room amenities</label>
                            @foreach ($roomAmenities as $roomAmenity)
                                <div class="form-check">
                                    <input class="form-check-input" id="{{ $roomAmenity->id }}" type="checkbox"
                                        wire:model.live="selectedAmenities" value="{{ $roomAmenity->id }}"
                                        id="defaultCheck1"
                                        {{ in_array($roomAmenity->id, $selectedAmenities) ? 'checked' : '' }}>
                                    <label for="{{ $roomAmenity->id }}" class="form-check-label"
                                        for="defaultCheck1">
                                        {{ $roomAmenity->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="w-100 d-flex justify-content-between">
                            <button type="submit" wire:click="filterSearch"
                                class="w-100 my-3 btn btn-primary d-block">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <span>Search</span>
                            </button>

                            {{-- <button type="submit" wire:click="clearSearch" class="my-3 btn btn-danger">
                                    <i class="fa fa-eraser" aria-hidden="true"></i>
                                    <span>Clear</span>
                                </button> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script data-navigate-track>
    function generateMapBox() {
        Livewire.on('reload-map', (event) => {
            const longitude = event.longitude
            const latitude = event.latitude
            const locations = JSON.parse(event.locations)

            mapboxgl.accessToken =
                '{{ env('MAPBOX_API_KEY') }}';
            map = new mapboxgl.Map({
                container: 'map',
                center: [longitude, latitude],
                zoom: 13,
            });


            const loadLocations = (geoJson) => {
                geoJson.features.forEach((location) => {
                    const {
                        geometry,
                        properties,
                        images
                    } = location
                    const {
                        locationId,
                        title,
                        image,
                        description,
                        link
                    } = properties

                    let imageContent = '';

                    if (images.length) {
                        images.map((imageDisplay, key) => {
                            imageContent = imageContent.concat(`<div class="carousel-item ${key === 0 ? 'active' : ''}" style="width: 100%; height: 100%;">
                                            <img src="${imageDisplay}"
                                                    class="d-block rounded" style="width: 100%; height: 100%; object-fit:cover;" alt="...">
                                            </div>`)
                        })
                    }

                    const content = `
                        <div style="min-height:300px; width:100%;">
                            <div class="my-3 col-lg-3 col-md-3 col-sm-4">
                                <div class="card" style="width: 300px;">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" style="height:150px">${imageContent}</div>
                                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">${title}</h5>
                                        <p class="card-text">${description}</p>
                                        <a href="${link}" class="btn btn-primary" wire:navigate>View Boarding House</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `

                    const popUp = new mapboxgl.Popup({
                        offset: 25
                    }).setHTML(content).setMaxWidth("400px")

                    new mapboxgl.Marker({
                            color: "#ff3333"
                        })
                        .setLngLat(geometry.coordinates)
                        .setPopup(popUp)
                        .addTo(map)
                })
            }

            loadLocations(locations)

            const style = 'streets-v11'
            map.setStyle(`mapbox://styles/mapbox/${style}`)
            map.addControl(new mapboxgl.NavigationControl())
        })
    }

    function listener() {
        console.log('AAA')
        generateMapBox()
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        console.log('BBB')
        document.removeEventListener('livewire:navigated', listener)
    })

    document.addEventListener('livewire:init', () => {
        const searchInput = document.getElementById('form1');

        searchInput.addEventListener('focusout', (event) => {
            @this.dispatch('hide-results');
        });
    })
</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('reload-map', (event) => {
            console.log('IM RELOADED IN HERE2222222')
            const longitude = event.longitude
            const latitude = event.latitude
            const locations = JSON.parse(event.locations)

            mapboxgl.accessToken =
                '{{ env('MAPBOX_API_KEY') }}';
            map = new mapboxgl.Map({
                container: 'map',
                center: [longitude, latitude],
                zoom: 13,
            });


            const loadLocations = (geoJson) => {
                geoJson.features.forEach((location) => {
                    const {
                        geometry,
                        properties,
                        images
                    } = location
                    const {
                        locationId,
                        title,
                        image,
                        description,
                        link
                    } = properties

                    let imageContent = '';

                    if (images.length) {
                        images.map((imageDisplay, key) => {
                            imageContent = imageContent.concat(`<div class="carousel-item ${key === 0 ? 'active' : ''}" style="width: 100%; height: 100%;">
                                            <img src="${imageDisplay}"
                                                    class="d-block rounded" style="width: 100%; height: 100%; object-fit:cover;" alt="...">
                                            </div>`)
                        })
                    }

                    const content = `
                        <div style="min-height:300px; width:100%;">
                            <div class="my-3 col-lg-3 col-md-3 col-sm-4">
                                <div class="card" style="width: 300px;">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" style="height:150px">${imageContent}</div>
                                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">${title}</h5>
                                        <p class="card-text">${description}</p>
                                        <a href="${link}" class="btn btn-primary" wire:navigate>View Boarding House</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `

                    const popUp = new mapboxgl.Popup({
                        offset: 25
                    }).setHTML(content).setMaxWidth("400px")

                    new mapboxgl.Marker({
                            color: "#ff3333"
                        })
                        .setLngLat(geometry.coordinates)
                        .setPopup(popUp)
                        .addTo(map)
                })
            }

            loadLocations(locations)

            const style = 'streets-v11'
            map.setStyle(`mapbox://styles/mapbox/${style}`)
            map.addControl(new mapboxgl.NavigationControl())
        })
    })
</script>
