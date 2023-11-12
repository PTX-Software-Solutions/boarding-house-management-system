<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Add new boarding house') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5 order-lg-2">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form wire:submit="save" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="houseName">House Name</label>
                                <input type="text" wire:model="houseName" class="form-control" id="houseName">
                                <div>
                                    @error('houseName')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contact">Contact</label>
                                <input type="text" wire:model="contact" class="form-control" id="contact">
                                <div>
                                    @error('contact')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" wire:model="address" class="form-control" id="address"
                                placeholder="1234 Main St">
                            <div>
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" wire:model="address2" class="form-control" id="address2"
                                placeholder="Apartment, studio, or floor">
                            <div>
                                @error('address2')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" wire:model="city" class="form-control" id="city">
                                <div>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zip">Zip</label>
                                <input type="text" wire:model="zip" class="form-control" id="zip">
                                <div>
                                    @error('zip')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="my-3 btn {{ $id ? 'btn-info' : 'btn-primary' }}">
                            {{ $id ? 'Update' : 'Create' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7 order-lg-1">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
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
    </div>
</div>

<script data-navigate-track>
    function generateMapBox() {
        // console.log('IM IN THE HOUSE FORM SCRIPT')
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
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>


{{-- 
<script data-navigate-once>
    let map;
    let marker;

    // document.addEventListener('livewire:init', () => {
    //     Livewire.on('createInstanceMapbox', (event) => {
    //         console.log('CREATE A NEW MAPBOX INSTANCE')

    //         const longitude = @this.longitude
    //         const latitude = @this.latitude

    //         mapboxgl.accessToken =
    //             '{{ env('MAPBOX_API_KEY') }}';
    //         map = new mapboxgl.Map({
    //             container: 'map',
    //             center: [@this.longitude, @this.latitude],
    //             zoom: 13,
    //         });
    //     })
    // })

    document.addEventListener('livewire:navigated', () => {
        var mapContainer = document.getElementById('map');
        var isCreate = true;

        if (mapContainer) {
            if (mapContainer.hasChildNodes()) {
                while (mapContainer.firstChild) {
                    mapContainer.removeChild(mapContainer.firstChild);
                }
            }

            const longitude = @this.longitude
            const latitude = @this.latitude

            mapboxgl.accessToken =
                '{{ env('MAPBOX_API_KEY') }}';
            map = new mapboxgl.Map({
                container: 'map',
                center: [@this.longitude, @this.latitude],
                zoom: 13,
            });

            marker = new mapboxgl.Marker({
                color: '#ff3333',
                anchor: 'center'
            }).setLngLat([@this.longitude, @this.latitude]).addTo(map)

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

            @this.on('updateCoordinates', (event) => {
                console.log('longitude: ', event[0]['longitude'])
                console.log('latitude: ', event[0]['latitude'])

                const longitude = event[0]['longitude']
                const latitude = event[0]['latitude']

                // var map = new mapboxgl.Map({
                //     container: 'map',
                //     center: [longitude, latitude],
                //     zoom: 13,
                // });

                const marker = new mapboxgl.Marker({
                    color: '#ff3333',
                    anchor: 'center'
                }).setLngLat([longitude, latitude]).addTo(map)

                // map.on('move', () => {
                //     // Set the center marker on the map
                //     marker.setLngLat([longitude, latitude]);
                // })

            });

            Livewire.on('mapSize', () => {
                map.on('load', (event) => {
                    map.resize()
                })
            })

            $('#boardingHouseModal').on('shown.bs.modal', function() {
                map.resize();
            });

            // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
            const style = 'streets-v11'
            map.setStyle(`mapbox://styles/mapbox/${style}`)
            map.addControl(new mapboxgl.NavigationControl())
        }
    })

    // document.addEventListener('livewire:init', () => {
    //     Livewire.on('removeInstanceMapbox', (event) => {
    //         console.log('REMOVE THE INSTANCE OF THE MAPBOX IN HERE')
    //         map.remove();
    //     })
    // })

    // document.addEventListener('livewire:navigating', () => {
    //     var mapContainer = document.getElementById('map');

    //     if (mapContainer) {
    //         if (mapContainer.hasChildNodes()) {
    //             while (mapContainer.firstChild) {
    //                 mapContainer.removeChild(mapContainer.firstChild);
    //             }
    //         }

    //         mapboxgl.accessToken =
    //             '{{ env('MAPBOX_API_KEY') }}';
    //         var map = new mapboxgl.Map({
    //             container: 'map',
    //             center: [123.31, 9.31],
    //             zoom: 13,
    //         });

    //         const marker = new mapboxgl.Marker({
    //             color: '#ff3333',
    //             anchor: 'center'
    //         }).setLngLat([123.31, 9.31]).addTo(map)


    //         map.on('move', () => {
    //             @this.longitude = map.getCenter().lng
    //             @this.latitude = map.getCenter().lat

    //             // Set the center marker on the map
    //             marker.setLngLat(map.getCenter());
    //         })

    //         Livewire.on('mapSize', () => {
    //             map.on('load', (event) => {
    //                 map.resize()
    //             })
    //         })

    //         $('#boardingHouseModal').on('shown.bs.modal', function() {
    //             map.resize();
    //         });


    //         // const geoJson = {
    //         //     "type": "FeatureCollection",
    //         //     "features": [{
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.29778254998206",
    //         //                     "9.311130951159768"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "Mantap",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 30,
    //         //                 "title": "Hello new",
    //         //                 "image": "1a1eb1e4106fff0cc3467873f0f39cab.jpeg",
    //         //                 "description": "Mantap"
    //         //             }
    //         //         },
    //         //         {
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.30480165336365",
    //         //                     "9.298534626396943"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "oke mantap Edit",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 29,
    //         //                 "title": "Rumah saya Edit",
    //         //                 "image": "0ea59991df2cb96b4df6e32307ea20ff.png",
    //         //                 "description": "oke mantap Edit"
    //         //             }
    //         //         },
    //         //         {
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.29294916746647",
    //         //                     "9.294171377487302"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "Update Baru",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 22,
    //         //                 "title": "Update Baru Gambar",
    //         //                 "image": "d09444b68d8b72daa324f97c999c2301.jpeg",
    //         //                 "description": "Update Baru"
    //         //             }
    //         //         },
    //         //         {
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.28832723134053",
    //         //                     "9.282186495579381"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 19,
    //         //                 "title": "awdwad",
    //         //                 "image": "f0b88ffd980a764b9fca60d853b300ff.png",
    //         //                 "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
    //         //             }
    //         //         },
    //         //         {
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.27061074181177",
    //         //                     "9.306581793791537"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 18,
    //         //                 "title": "adwawd",
    //         //                 "image": "4c35cb1b76af09e6205f94024e093fe6.jpeg",
    //         //                 "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
    //         //             }
    //         //         },
    //         //         {
    //         //             "type": "Feature",
    //         //             "geometry": {
    //         //                 "coordinates": [
    //         //                     "123.24752279881176",
    //         //                     "9.28515157840647"
    //         //                 ],
    //         //                 "type": "Point"
    //         //             },
    //         //             "properties": {
    //         //                 "message": "awdwad",
    //         //                 "iconSize": [
    //         //                     50,
    //         //                     50
    //         //                 ],
    //         //                 "locationId": 12,
    //         //                 "title": "adawd",
    //         //                 "image": "7c8c949fd0499eb50cb33787d680778c.jpeg",
    //         //                 "description": "awdwad"
    //         //             }
    //         //         }
    //         //     ]
    //         // }

    //         // const loadLocations = () => {
    //         //     geoJson.features.forEach((location) => {
    //         //         const {
    //         //             geometry,
    //         //             properties
    //         //         } = location
    //         //         const {
    //         //             iconSize,
    //         //             locationId,
    //         //             title,
    //         //             image,
    //         //             description
    //         //         } = properties

    //         //         const content = `
    //         //             <div style="overflow-y: auto; max-height:400px, width:100%">
    //         //                 <table>
    //         //                     <tbody>
    //         //                         <tr>
    //         //                             <td>Title</td>
    //         //                             <td>${title}</td>
    //         //                         </tr>
    //         //                         <tr>
    //         //                             <td>Picture</td>
    //         //                             <td><img src="${image}" loading="lazy"></td>
    //         //                         </tr>
    //         //                         <tr>
    //         //                             <td>Description</td>
    //         //                             <td>${description}</td>
    //         //                         </tr>
    //         //                     </tbody>
    //         //                 </table>
    //         //             </div>
    //         //             `

    //         //         const popUp = new mapboxgl.Popup({
    //         //             offset: 25
    //         //         }).setHTML(content).setMaxWidth("400px")

    //         //         new mapboxgl.Marker({
    //         //                 color: "#ff3333"
    //         //             })
    //         //             .setLngLat(geometry.coordinates)
    //         //             .setPopup(popUp)
    //         //             .addTo(map)
    //         //     })
    //         // }

    //         // loadLocations()

    //         // light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
    //         const style = 'streets-v11'
    //         map.setStyle(`mapbox://styles/mapbox/${style}`)
    //         map.addControl(new mapboxgl.NavigationControl())

    //         // Comment out the below code to see the difference.
    //         Livewire.on('mapSize', () => {
    //             $('#map').on('shown.bs.modal', function() {
    //                 map.resize();
    //             });
    //         })
    //     }
    // })
</script>  --}}
