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
                                            style="cursor: pointer; text-align:center;">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            Upload
                                        </label>
                                    </div>
                                    <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <input type="file" wire:model="uploadImage" class="form-control"
                                            style="visibility: hidden;" id="uploadImage" multiple>
                                        <!-- Progress Bar -->
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                        <div>
                                            @if ($oldImage)
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($oldImage as $key => $image)
                                                        <div style="width: 100px; height: 100px; position: relative;"
                                                            class="mx-1">
                                                            <img src="{{ Storage::url('public/images/' . $image) }}"
                                                                class="img-thumbnail rounded"
                                                                style="width: 100%; height: 100%; object-fit: contain;"
                                                                alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if ($uploadImage)
                                                {{-- @dd('asdasd') --}}
                                                <span>These are the new photos</span>
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($uploadImage as $key => $image)
                                                        <div style="width: 100px; height: 100px; position: relative;"
                                                            class="mx-1">
                                                            <img src="{{ $image->temporaryUrl() }}"
                                                                class="img-thumbnail rounded"
                                                                style="width: 100%; height: 100%; object-fit: contain;"
                                                                alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
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
                <li class="nav-item">
                    <a class="nav-link {{ $currentTab === 3 ? 'active' : '' }}" id="profile-tab" data-toggle="tab"
                        wire:click="changeTab(3)" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">Room Utilities</a>
                </li>
            </ul>
            <form wire:submit="save" autocomplete="off">
                <div class="tab-content" id="myTabContent">
                    {{-- Room Info --}}
                    <div class="tab-pane fade {{ $currentTab === 1 ? 'show active' : '' }}" id="home"
                        role="tabpanel" aria-labelledby="home-tab">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nameNumber">Name/Number</label>
                                        <input type="text" wire:model="nameNumber" class="form-control"
                                            id="nameNumber">
                                        <div>
                                            @error('nameNumber')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="monthDeposit">Monthly Deposit</label>
                                        <input type="number" wire:model="monthDeposit" class="form-control"
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
                                    <select class="form-control" wire:model="roomType"
                                        id="exampleFormControlSelect1">
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
                                    <label for="paymentAgreementType">Payment Agreement</label>
                                    <select class="form-control" wire:model="paymentAgreementType"
                                        id="exampleFormControlSelect1">
                                        <option>-- Select type --</option>
                                        @foreach ($paymentAgreements as $paymentAgreement)
                                            <option value="{{ $paymentAgreement->id }}">
                                                {{ $paymentAgreement->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('paymentAgreementType')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address2">Status</label>
                                    <select class="form-control" wire:model="status" id="exampleFormControlSelect1">
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
                                {{-- @dd($roomId) --}}
                                <button type="submit" class="my-3 btn {{ ($roomId ?? false) ? 'btn-info' : 'btn-primary' }}">
                                    {{ $roomId ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Room Amenities --}}
                    <div class="tab-pane fade {{ $currentTab === 2 ? 'show active' : '' }}" id="profile"
                        role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card shadow mb-4">
                            <div class="card-body"
                                style="width: 100%; 
                            max-height: 300px; overflow-y: auto;">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Amenities @if (count($roomAmenities) > 0)
                                                    (Chooses ({{ count($roomAmenities) }}))
                                                @endif
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <small>
                                            @error('roomAmenities')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </small>
                                        @forelse ($amenities as $index => $amenity)
                                            <tr>
                                                <th scope="row" for="{{ $amenity->id }}">
                                                    <div class="form-check">
                                                        <input type="checkbox" wire:model.live="roomAmenities"
                                                            value="{{ $amenity->id }}" id="{{ $amenity->id }}"
                                                            class="form-check-input" aria-describedby="emailHelp"
                                                            {{ $id && $roomId && in_array($amenity->id, $roomAmenities) ? 'checked' : '' }}>
                                                        <label for="{{ $amenity->id }}">
                                                            {{ $amenity->name }}
                                                        </label>
                                                    </div>
                                                </th>
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

                    {{-- Social Media --}}
                    <div class="tab-pane fade {{ $currentTab === 3 ? 'show active' : '' }}" id="profile"
                        role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" wire:click="addUtilities" class="btn btn-primary my-3">
                                        <i class="fas fa-plus-circle"></i>
                                        Add</button>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Utility Type</th>
                                            <th scope="col">Scope</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roomUtilities as $index => $roomUtility)
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control"
                                                            wire:model.live="roomUtilities.{{ $index }}.utilityType"
                                                            id="exampleFormControlSelect1">
                                                            <option>-- Select utility type --</option>
                                                            @foreach ($roomUtilitiesTypes as $roomUtilitiesType)
                                                                <option value="{{ $roomUtilitiesType->id }}"
                                                                    {{ in_array($roomUtilitiesType->id, $selectedUtilities) ? 'disabled' : '' }}>
                                                                    {{ $roomUtilitiesType->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small>
                                                        @error("roomUtilities.{$index}.utilityType")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control"
                                                            wire:model.live="roomUtilities.{{ $index }}.scope"
                                                            id="exampleFormControlSelect1">
                                                            <option>-- Select type --</option>
                                                            @foreach ($roomUtilitiesScopes as $roomUtilitiesScope)
                                                                <option value="{{ $roomUtilitiesScope->id }}">
                                                                    {{ $roomUtilitiesScope->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small>
                                                        @error("roomUtilities.{$index}.scope")
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </small>
                                                </td>
                                                @if ($roomUtilities[$index]['scopeSerialId'] === 2)
                                                    <th scope="row">
                                                        <div class="form-group">
                                                            <input type="number"
                                                                wire:model.live="roomUtilities.{{ $index }}.price"
                                                                class="form-control" aria-describedby="emailHelp"
                                                                placeholder="...">
                                                        </div>
                                                        <small>
                                                            @error("roomUtilities.{$index}.price")
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </small>
                                                    </th>
                                                @else
                                                    <th colspan="1">

                                                    </th>
                                                @endif
                                                <td>
                                                    <a href="#"
                                                        wire:click="removeRoomUtility({{ $index }})">
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
    function listener() {}

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
