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
                                Map
                            </div>
                            <div class="card-body">
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
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    > 10 km to center
                                </label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="address2" class="font-weight-bold">Room amenities</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Air conditioning
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Ironing facilities
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Refrigerator
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    TV
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
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
                </div>
            </div>
        </div>
    </div>
</div>

<script data-navigate-track>
    function generateMapBox() {
        const longitude = {{ $longitude }}
        const latitude = {{ $latitude }}

        mapboxgl.accessToken =
            '{{ env('MAPBOX_API_KEY') }}';
        map = new mapboxgl.Map({
            container: 'map',
            center: [longitude, latitude],
            zoom: 13,
        });

        const geoJson = {
            "type": "FeatureCollection",
            "features": [{
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.29778254998206",
                            "9.311130951159768"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Mantap",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 30,
                        "title": "Boarding House 1",
                        "image": "1a1eb1e4106fff0cc3467873f0f39cab.jpeg",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "Mantap"
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.30480165336365",
                            "9.298534626396943"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "oke mantap Edit",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 29,
                        "title": "Boarding House 2",
                        "image": "0ea59991df2cb96b4df6e32307ea20ff.png",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "oke mantap Edit"
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.29294916746647",
                            "9.294171377487302"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Update Baru",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 22,
                        "title": "Update Baru Gambar",
                        "image": "d09444b68d8b72daa324f97c999c2301.jpeg",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "Update Baru"
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.28832723134053",
                            "9.282186495579381"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 19,
                        "title": "Boarding House 3",
                        "image": "f0b88ffd980a764b9fca60d853b300ff.png",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.27061074181177",
                            "9.306581793791537"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 18,
                        "title": "adwawd",
                        "image": "4c35cb1b76af09e6205f94024e093fe6.jpeg",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
                    }
                },
                {
                    "type": "Feature",
                    "geometry": {
                        "coordinates": [
                            "123.24752279881176",
                            "9.28515157840647"
                        ],
                        "type": "Point"
                    },
                    "properties": {
                        "message": "awdwad",
                        "iconSize": [
                            50,
                            50
                        ],
                        "locationId": 12,
                        "title": "Boarding House 4",
                        "image": "7c8c949fd0499eb50cb33787d680778c.jpeg",
                        "link": "http://127.0.0.1:8000/boarding-houses/123",
                        "description": "awdwad"
                    }
                }
            ]
        }

        const loadLocations = () => {
            geoJson.features.forEach((location) => {
                const {
                    geometry,
                    properties
                } = location
                const {
                    iconSize,
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
                                        <a href="${link}" class="btn btn-primary">View Boarding House</a>
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

        loadLocations()

        // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
        const style = 'streets-v11'
        map.setStyle(`mapbox://styles/mapbox/${style}`)
        map.addControl(new mapboxgl.NavigationControl())
    }

    function listener() {
        generateMapBox()
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
