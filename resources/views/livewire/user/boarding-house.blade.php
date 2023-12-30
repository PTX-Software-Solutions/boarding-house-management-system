<div class="row">

    <div class="col-lg-4 order-lg-2">

        <div class="card shadow mb-4">
            <div class="card-profile-image mt-4">
                {{-- <figure class="rounded-circle avatar avatar font-weight-bold"
                    style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->firstName }}">
                </figure> --}}
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h5 class="font-weight-bold">{{ $boardingHouses->houseName }}</h5>
                            <p>Home Owner</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-profile-stats">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fa fa-star text-primary" aria-hidden="true"></i>
                                <i class="fa fa-star text-primary" aria-hidden="true"></i>
                                <i class="fa fa-star text-primary" aria-hidden="true"></i>
                                <i class="fa fa-star text-primary" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                            <span class="description">Ratings</span>
                        </div>
                    </div>
                </div>

                <div class="bg-light rounded" style="height: 70vh; width: 100%">
                    <div class="row justify-content-center" style="height: 100%">
                        <div class="col-md-12" style="height: 100%">
                            <div class="card" style="height: 100%">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div
                                            class="card-profile-stats d-flex justify-content-center align-items-center">
                                            <div class="mx-1">
                                                <i class="fa fa-comment" aria-hidden="true"></i>
                                            </div>
                                            <span class="description">Reviews by tenants</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" id="chatbox" style="height: 100%; overflow-y: auto;">
                                    <!-- Replace the following lines with dynamic messages from your backend -->
                                    <div class="message received d-flex">
                                        <img src="data:image/png;base64,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"
                                            alt="User Avatar" class="avatar mr-1">
                                        <div class="message-content">
                                            <strong>John Doe</strong>
                                            <p
                                                style="padding: 5px; background-color: rgb(238, 237, 237); border-radius: 10px;">
                                                I had an amazing stay at this boarding house. The staff was incredibly
                                                friendly
                                                and went above and beyond to make me feel welcome. The room was
                                                spacious, clean, and beautifully decorated. The amenities, including the
                                                pool and fitness center, were top-notch. The location was also perfect,
                                                with easy access to local attractions. I would highly recommend this
                                                hotel to anyone looking for a comfortable and enjoyable stay
                                            </p>
                                            <p style="font-size:11px; text-align:right; margin-top:-10px;">
                                                3 min
                                                ago</p>
                                        </div>
                                    </div>

                                    <div class="message received d-flex">
                                        <img src="data:image/jpeg;base64,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"
                                            alt="User Avatar" class="avatar mr-1">
                                        <div class="message-content">
                                            <strong>Jane Doe</strong>
                                            <p
                                                style="padding: 5px; background-color: rgb(238, 237, 237); border-radius: 10px;">
                                                My stay at this boarding house had its ups and downs. On the positive
                                                side, the
                                                location was excellent, right in the heart of the city. The lobby and
                                                common areas were well-maintained and aesthetically pleasing. However,
                                                the room I stayed in was a bit outdated, and the bathroom could use some
                                                renovation. The service was hit or miss; some staff members were
                                                friendly, while others seemed indifferent. Overall, it was an okay
                                                experience, but I expected more given the price.
                                            </p>
                                            <p style="font-size:11px; text-align:right; margin-top:-10px;">
                                                4 months
                                                ago</p>
                                        </div>
                                    </div>

                                    <div class="message received d-flex">
                                        <img src="data:image/png;base64,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"
                                            alt="User Avatar" class="avatar mr-1">
                                        <div class="message-content">
                                            <strong>Jessy Doe</strong>
                                            <p
                                                style="padding: 5px; background-color: rgb(238, 237, 237); border-radius: 10px;">
                                                I regret choosing this boarding house for my recent stay. The room was
                                                dirty,
                                                with visible stains on the carpet and sheets. The bathroom smelled
                                                unpleasant, and the towels were old and worn. The noise from the street
                                                outside was also disturbing, making it difficult to get a good night's
                                                sleep. The staff seemed indifferent to my concerns when I brought them
                                                up. I would not recommend this hotel to anyone, as the overall
                                                experience was far below expectations.
                                            </p>
                                            <p style="font-size:11px; text-align:right; margin-top:-10px;">
                                                10 months
                                                ago</p>
                                        </div>
                                    </div>


                                    <p class="text-primary"
                                        style="cursor: pointer; text-align: center; font-size: 12px;">Load more
                                        messages...</p>

                                </div>

                                <div class="card-footer">
                                    <div class="input-group">
                                        <textarea type="text" id="message" class="form-control" placeholder="Type your message..."></textarea>
                                        <div class="input-group-append">
                                            <button onclick="sendMessage()" class="btn btn-primary disabled" disabled>
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="col-lg-8 order-lg-1">

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-start align-items-center">
                <i class="fa fa-bed text-primary" aria-hidden="true"></i>
                <h6 class="m-0 font-weight-bold text-primary mx-2">Rooms</h6>
            </div>

            <div class="card-body">

                <div>

                    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left"
                            aria-hidden="true"></i>
                        Back</button>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">{{ __('Boarding House Rooms:') }}</h1>

                    <div class="container">
                        <div class="row d-flex">
                            @foreach ($rooms as $key => $room)
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 my-2">
                                    <div class="card" style="width: 16rem;">
                                        <div id="{{ 'carouselExampleControls' . $key }}" class="carousel slide"
                                            data-ride="carousel">
                                            <div class="carousel-inner" style="max-height:150px">
                                                @foreach ($room?->getRoomImages as $index => $image)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                                                        style="width: 100%; height: 100%;">
                                                        <img src="{{ asset('storage/images/' . $image->imageUrl) }}"
                                                            class="d-block rounded"
                                                            style="width: 100%; height: 100%; object-fit:cover;"
                                                            alt="...">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-target="{{ '#carouselExampleControls' . $key }}"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-target="{{ '#carouselExampleControls' . $key }}"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">{{ $room->name }}</h5>
                                                <p class="font-weight-light">{{ $room?->getRoomType->name }}</p>
                                            </div>

                                            <div class="d-flex flex-wrap">
                                                @foreach ($room->amenities as $amenity)
                                                    <span style="position: relative;"
                                                        class="m-1 {{ in_array($amenity->id, $selectedAmenities) ? 'badge badge-warning' : 'badge badge-info' }}">
                                                        {{ $amenity->name }}

                                                        @if (in_array($amenity->id, $selectedAmenities))
                                                            <span style="position: absolute; top:-40%; right:-6%;"
                                                                class="text-danger"><i class="fa fa-star"
                                                                    aria-hidden="true"></i></span>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>

                                            <p class="card-text">Monthly Deposit &#8369;
                                                {{ number_format($room->monthlyDeposit, 2) }}
                                                @php
                                                    $linkSelectedAmenity = '';

                                                    foreach ($selectedAmenities as $key => $amenity) {
                                                        $linkSelectedAmenity .= '&selectedAmenities[' . $key . ']=' . $amenity;
                                                    }
                                                @endphp

                                                <a href="{{ url(
                                                    "/boarding-houses/$room->houseId" .
                                                        "/room-details/$room->id/?search=$search" .
                                                        "&priceRange=$this->priceRange" .
                                                        "&roomType=$this->roomType" .
                                                        "&selectedDistance=$this->selectedDistance" .
                                                        $linkSelectedAmenity,
                                                ) }}"
                                                    class="btn btn-primary">View Room</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $rooms->links() }}
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>
