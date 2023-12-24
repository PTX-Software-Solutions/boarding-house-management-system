<?php

namespace App\Livewire\User;

use App\Models\Amenity;
use App\Models\House;
use App\Models\RoomType;
use App\Service\MapboxService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Home extends Component
{
    #[Url(history: true)]
    public $search;

    public $priceRange = 25000;

    public $roomType;

    public $selectedDistance = 3;

    public $selectedAmenities = [];

    public $geoJson;
    public $longitude;      // default longitude of dumaguete city
    public $latitude;       // default latitude of dumaguete city
    public $radius = 3;     // radius in kilometers
    public $isDisplayResult = false;
    public $isSearchClicked = false;
    public $result;

    public function updating($property, $value)
    {
        if ($property === "search") {
            $this->isDisplayResult = strlen($value) > 0;
            $this->isSearchClicked = false;
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->priceRange = 25000;
        $this->roomType = null;
        $this->selectedDistance = 0;
        $this->selectedAmenities = [];
    }

    public function forwardGeocode(string|null $query)
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            'https://api.mapbox.com/geocoding/v5/mapbox.places/' . urlencode($query) . '.json',
            [
                'query' => [
                    'access_token' => env('MAPBOX_API_KEY'),
                ],
            ]
        );

        return json_decode($response->getBody(), true);
    }

    public function mount()
    {
        if ($this->search) {
            $reloadData = $this->forwardGeocode($this->search);

            $data = [
                'longitude' => $reloadData['features'][0]['center'][0] ?? 0,
                'latitude'  => $reloadData['features'][0]['center'][1] ?? 0,
                'searchText' => $this->search
            ];

            $this->changeCoordinates($data);
        }

    }

    #[On('hide-results')]
    public function hideResult()
    {
        $this->isDisplayResult = false;
    }

    public function filterSearch()
    {
        $reloadData = $this->forwardGeocode($this->search);

        $data = [
            'longitude' => $reloadData['features'][0]['center'][0] ?? 0,
            'latitude'  => $reloadData['features'][0]['center'][1] ?? 0,
            'searchText' => $this->search
        ];

        $this->changeCoordinates($data);
    }

    public function changeCoordinates($data)
    {
        $this->isSearchClicked = true;
        $this->search = $data['searchText'] ?? '';
        $this->longitude = $data['longitude'] ?? 0;
        $this->latitude = $data['latitude'] ?? 0;

        $haversine = "(6371 * acos(cos(radians(" . $this->latitude . ")) * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $this->longitude . ")) + sin(radians(" . $this->latitude . ")) * sin(radians(latitude))))";

        $houses = House::with(['getHousePhoto' => function($query) {
            $query->select('houseId', 'imageUrl');
        }])
            ->selectRaw(
            "
            id,
            houseName,
            contact,
            address,
            address2,
            city,
            zip,
            longitude,
            latitude,
            {$haversine} AS distance"
        )
            ->whereRaw("{$haversine} < ?", [(int) $this->selectedDistance])
            ->orderBy('created_at', 'desc')
            ->get();

        $customLocations = [];

        foreach ($houses as $house) {
            $images = [];
            
            if ($house->getHousePhoto) {
                foreach($house->getHousePhoto as $photo) {
                    array_push($images, asset('storage/images/' . $photo->imageUrl));
                }
            }

            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$house->longitude, $house->latitude],
                    'type' => 'Point'
                ],
                'properties' => [
                    'locationId' => $house->id,
                    'title' => $house->houseName,
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSO_Vl_AsUMMjBlWvggrRjyyyMVw9HF4y8sRLtbJyJOHlfPc1zcfB4rFBTmn_r0eTvCpWE',
                    'description' => $house->address . ' ' . $house->address2,
                    'link'  => url("/boarding-houses/$house->id?search=$this->search")
                ],
                'images' => $images
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();
        $this->geoJson = $geoJson;

        $this->dispatch('reload-map', longitude: $this->longitude, latitude: $this->latitude, locations: $geoJson);
    }

    #[Layout('components.layouts.userAuth')]
    public function render()
    {
        $roomTypes = RoomType::select('id', 'name')->get();
        $roomAmenities = Amenity::select('id', 'name')->get();

        return view('livewire.user.home', [
            'locations'     => $this->forwardGeocode($this->search),
            'roomTypes'     => $roomTypes,
            'roomAmenities' => $roomAmenities
        ]);
    }
}
