<div>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Home') }}</h1>

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
                                <i class="fa fa-map" aria-hidden="true"></i>
                                Map
                            </div>
                            <div class="card-body">
                                @if (!$longitude && !$latitude && !$isSearchClicked)
                                    <p class="text-center font-weight-bold">PLEASE SEARCH YOUR LOCATION</p>
                                @endif
                                <div wire:ignore.self id='map' style='width: 100%; min-height: 70vh;' wire:ignore>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body" style="min-height: 80vh;">
                    <div class="form-group" style="position: relative;">
                        <div class="form-control-range">
                            <div class="form-outline" style="display:flex">
                                <input type="text" wire:model.live.throttle.150ms="search"
                                    placeholder="Search Location..." id="form1" class="form-control"
                                    style="border-top-right-radius: 0; border-bottom-right-radius: 0;" autocomplete="off"/>
                                <button type="button" class="btn btn-primary"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @if ($isDisplayResult && !$isSearchClicked)
                            <div class="bg-secondary rounded"
                                style="position:absolute; z-index: 100; width: 100%; 
                                max-height: 300px; overflow-y: auto;">
                                <div class="list-group">
                                    @if ($search)
                                        @forelse ($locations['features'] as $location)
                                            {{ Log::debug($location) }}
                                            @php
                                                $data = [
                                                    'longitude' => $location['center'][0] ?? 0,
                                                    'latitude' => $location['center'][1] ?? 0,
                                                    'searchText' => $location['text'] ?? '',
                                                ];
                                            @endphp
                                            <a href="#" wire:click="changeCoordinates({{ json_encode($data) }})"
                                                class="list-group-item list-group-item-action">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{ $location['text'] ?? '' }}
                                                <br>
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
                        <form wire:submit="save" autocomplete="off">

                            <div class="form-group">
                                <label for="formControlRange" class="font-weight-bold">Price Range</label>
                                <input type="range" class="form-control-range" id="formControlRange">
                                <div class="d-flex justify-content-between">
                                    <span>&#8369;{{ number_format(0, 2) }}</span>
                                    <span>&#8369;{{ number_format(25000, 2) }}</span>
                                    <span>&#8369;{{ number_format(50000, 2) }}</span>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="address" class="font-weight-bold">Room Type</label>
                                <select class="form-control">
                                    <option>Select a room</option>
                                    <option>1 Person</option>
                                    <option>2 Persons</option>
                                    <option>3 Persons</option>
                                    <option>4 Persons</option>
                                    <option>5 Persons</option>
                                    <option>6 Persons or more</option>
                                </select>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="address" class="font-weight-bold">Sort By</label>
                                <select class="form-control">
                                    <option>Recommendation</option>
                                    <option>By smallest price</option>
                                    <option>By biggest price</option>
                                </select>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="address2" class="font-weight-bold">Distance to center</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Inside the city center
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <2 km to center </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        2-5 km to center
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        5-10 km to center
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        > 10 km to center
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="address2" class="font-weight-bold">Room amenities</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Air conditioning
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Ironing facilities
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Refrigerator
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        TV
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Internet access
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="my-3 btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <span>Search</span>
                                </button>

                                <button type="submit" class="my-3 btn btn-danger">
                                    <i class="fa fa-eraser" aria-hidden="true"></i>
                                    <span>Clear</span>
                                </button>
                            </div>

                        </form>
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
                console.log('RELOAD MAP: ', geoJson)
                geoJson.features.forEach((location) => {
                    const {
                        geometry,
                        properties
                    } = location
                    const {
                        locationId,
                        title,
                        image,
                        description,
                        link
                    } = properties

                    const content = `
                        <div style="overflow-y: auto; max-height:350px, width:100%">
                            <div class="my-3 col-lg-3 col-md-3 col-sm-4">
                                <div class="card" style="width: 250px;">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSO_Vl_AsUMMjBlWvggrRjyyyMVw9HF4y8sRLtbJyJOHlfPc1zcfB4rFBTmn_r0eTvCpWE"
                                        class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">${title}</h5>
                                        <p class="card-text">Some quick example text to build on the Room 1 and make up the bulk of the
                                            card's content.</p>
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

            // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
            const style = 'streets-v11'
            map.setStyle(`mapbox://styles/mapbox/${style}`)
            map.addControl(new mapboxgl.NavigationControl())
        })
    }

    function listener() {
        generateMapBox()
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })

    document.addEventListener('livewire:init', () => {
        const searchInput = document.getElementById('form1');

        searchInput.addEventListener('focusout', (event) => {
            @this.dispatch('hide-results');
        });
    })
</script>
