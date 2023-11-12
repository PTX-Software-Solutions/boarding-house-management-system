<div>
    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Boarding House Room Details:') }}</h1>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="width: 100%; height: 60vh;">
                        <img src="https://images.pexels.com/photos/262048/pexels-photo-262048.jpeg?cs=srgb&dl=pexels-pixabay-262048.jpg&fm=jpg"
                            class="d-block rounded" style="width: 100%; height: 100%; object-fit:cover;" alt="...">
                    </div>
                    <div class="carousel-item" style="width: 100%; height: 60vh;">
                        <img src="https://www.aureohotels.com/wp-content/uploads/2022/12/Aureo_Superior_1-scaled.jpg"
                            class="d-block rounded" style="width: 100%; height: 100%; object-fit:cover;" alt="...">
                    </div>
                    <div class="carousel-item" style="width: 100%; height: 60vh;">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWwlMjByb29tfGVufDB8fDB8fHww"
                            class="d-block rounded" style="width: 100%; height: 100%; object-fit:cover;" alt="...">
                    </div>
                </div>
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Detail
                            </div>
                            <div class="card-body">

                                <a class="nav-link" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <figure class="img-profile rounded-circle avatar font-weight-bold"
                                        {{-- data-initial="{{ Auth::user()->firstName }}"></figure> --}} data-initial=""></figure>
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hosted by
                                        {{ Auth::user()->firstName }}</span>
                                </a>

                                <hr>

                                <ul>
                                    <li>5 min away from Medical</li>
                                    <li>3 min away from NORSU</li>
                                    <li>5 min away from Market</li>
                                </ul>
                                <hr>
                                <h6>What this place offers</h6>
                                <ul>
                                    <li>Own Kitchen</li>
                                    <li>Own Bathroom</li>
                                    <li>Wifi</li>
                                    <li>Airconditioned</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form wire:submit="save" autocomplete="off">
                        <div class="form-group font-weight-bold">
                            <span>&#8369;{{ number_format(50000, 2) }}</span>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">CHECK-IN</label>
                                <input type="date" class="form-control" id="validationTooltip01" value="Mark"
                                    required>
                                <div class="valid-tooltip">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">CHECK-OUT(Optional)</label>
                                <input type="date" class="form-control" id="validationTooltip02" value="Otto"
                                    required>
                                <div class="valid-tooltip">
                                    Looks good!
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="address2" class="font-weight-bold">Payment</label>

                            <div class="d-flex justify-content-between">
                                <p>Total before taxes</p>
                                <span><span>&#8369;{{ number_format(50000, 2) }}</span></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>BH finder fee</p>
                                <span><span>&#8369;{{ number_format(500, 2) }}</span></span>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="my-3 btn btn-danger d-block w-100">
                            <i class="fa fa-book" aria-hidden="true"></i>
                            <span>Reserve</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
