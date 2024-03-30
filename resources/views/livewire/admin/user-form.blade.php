<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">{{ __('Users') }}</h1>

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
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <form wire:submit="save">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <div class="form-group" wire:ignore>
                                                    <label for="exampleFormControlSelect1">User Type</label>
                                                    <select wire:model="userTypeId" id="userTypeId"
                                                        class="form-control user-select" data-control="select2"
                                                        data-placeholder="Select a homeowner">
                                                        <option>-- Select user type --</option>
                                                        @foreach ($userTypes as $userType)
                                                            <option value="{{ $userType->id }}"
                                                                @if ($id && $userTypeId === $userType->id) {{ 'selected' }} @endif>
                                                                {{ $userType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('userTypeId')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <div class="form-group" wire:ignore>
                                                    <label for="exampleFormControlSelect1">User Status</label>
                                                    <select wire:model="statusId" id="statusId"
                                                        class="form-control user-select" data-control="select2"
                                                        data-placeholder="Select a status">
                                                        <option>-- Select status --</option>
                                                        @foreach ($userStatuses as $userStatus)
                                                            <option value="{{ $userStatus->id }}"
                                                                @if ($id && $statusId === $userStatus->id) {{ 'selected' }} @endif>
                                                                {{ $userStatus->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('statusId')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="firstName">First Name</label>
                                                <input type="text" wire:model="firstName" class="form-control"
                                                    id="firstName">
                                                <div>
                                                    @error('firstName')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" wire:model="lastName" class="form-control"
                                                    id="lastName">
                                                <div>
                                                    @error('lastName')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="text" wire:model="email" class="form-control" id="email"
                                                autocomplete="off">
                                            <div>
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        @if (!$id)
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="password">Password</label>
                                                    <input type="password" wire:model="password" class="form-control"
                                                        id="password">
                                                    <div>
                                                        @error('password')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" wire:model="password_confirmation"
                                                        class="form-control" id="password_confirmation">
                                                    <div>
                                                        @error('password_confirmation')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="profileImage" wire:click="$refs.profileImage.click()"
                                                for="profileImage">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                                Upload Image
                                            </label>
                                            <input type="file" wire:model="profileImage" class="form-control"
                                                id="profileImage" style="visibility: hidden;">
                                            @if ($oldImage)
                                                <div class="d-flex flex-wrap">
                                                    <div style="width: 100px; height: 100px; position: relative;"
                                                        class="mx-1">
                                                        <img src="{{ Storage::url('public/images/' . $oldImage) }}"
                                                            class="img-thumbnail rounded"
                                                            style="width: 100%; height: 100%; object-fit: contain;"
                                                            alt="">
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($profileImage)
                                                <span>These will be the new image</span>
                                                <div class="d-flex flex-wrap">
                                                    <div style="width: 100px; height: 100px; position: relative;"
                                                        class="mx-1">
                                                        <img src="{{ $profileImage->temporaryUrl() }}"
                                                            class="img-thumbnail rounded"
                                                            style="width: 100%; height: 100%; object-fit: contain;"
                                                            alt="">
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                @error('profileImage')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="my-3 btn {{ $id ? 'btn-info' : 'btn-primary' }}">
                                            {{ $id ? 'Update Information' : 'Create' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($id)
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">

                                        <form wire:submit="updatePassword">
                                            @csrf
                                            <div class="form-group">
                                                <label for="currentPassword">Current Password</label>
                                                <input type="password" wire:model="currentPassword"
                                                    class="form-control" id="currentPassword" autocomplete="off">
                                                <div>
                                                    @error('currentPassword')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="password">New Password</label>
                                                    <input type="password" wire:model="password" class="form-control"
                                                        id="password">
                                                    <div>
                                                        @error('password')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" wire:model="password_confirmation"
                                                        class="form-control" id="password_confirmation">
                                                    <div>
                                                        @error('password_confirmation')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="my-3 btn btn-info">
                                                Update Password
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script data-navigate-track>
    function generateMapBox() {

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
        // generateMapBox()

        // Livewire.on('init-select2', () => {
        //     $('.user-select').select2();
        // })

        $('#userTypeId').on('select2:select', function(e) {
            let value = $(this).val();
            @this.set('userTypeId', value)
            // $('.user-select').select2();
        });

        $('#statusId').on('select2:select', function(e) {
            let value = $(this).val();
            @this.set('statusId', value)
            // $('.user-select').select2();
        });

        $('.user-select').select2();
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
