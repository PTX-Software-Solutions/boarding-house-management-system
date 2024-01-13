<div>
    <h1 class="h3 mb-4 text-gray-800">{{ __('My Account') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
                                Information
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <form wire:submit="save">
                                        <div class="form-row">
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
                                        <button type="submit" class="my-3 btn btn-info">
                                            {{ 'Update Information' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                Password
                            </div>
                            <div class="card-body">
                                <div class="card-body">

                                    <form wire:submit="updatePassword">
                                        @csrf
                                        <div class="form-group">
                                            <label for="currentPassword">Current Password</label>
                                            <input type="password" wire:model="currentPassword" class="form-control"
                                                id="currentPassword" autocomplete="off">
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
    </div>
</div>

<script data-navigate-track>
    function houseTableEvents() {
        Livewire.on('success-update', (event) => {
            setTimeout(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Updated data successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000)
        })
    }

    function listener() {
        houseTableEvents()
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>