<div>

    <button wire:click="back" class="btn btn-sm btn-primary mb-3"><i class="fa fa-chevron-left" aria-hidden="true"></i>
        Back</button>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Reservations') }}</h1>

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
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <form wire:submit="save">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <div class="form-group" wire:ignore>
                                                    <label for="exampleFormControlSelect1">User</label>
                                                    <select wire:model="userId" id="userId"
                                                        class="form-control user-select" data-control="select2"
                                                        data-placeholder="Select a homeowner" style="width: 100%;">
                                                        <option>-- Select user --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                @if ($id && $userId === $user->id) {{ 'selected' }} @endif>
                                                                {{ $user->firstName }} {{ $user->lastName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('userId')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <div class="form-group" wire:ignore>
                                                    <label for="exampleFormControlSelect1">House</label>
                                                    <select wire:model="houseId" id="houseId"
                                                        class="form-control user-select" data-control="select2"
                                                        data-placeholder="Select a status" style="width: 100%">
                                                        <option>-- Select house --</option>
                                                        @foreach ($houses as $house)
                                                            <option value="{{ $house->id }}"
                                                                @if ($id && $houseId === $house->id) {{ 'selected' }} @endif>
                                                                {{ $house->houseName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('houseId')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Room</label>
                                                    <select wire:model="roomId" id="roomId" class="form-control"
                                                        data-placeholder="Select a status" style="width: 100%">
                                                        <option>-- Select room --</option>
                                                        @foreach ($rooms as $room)
                                                            <option value="{{ $room->id }}" class="w-100"
                                                                @if ($id && $roomId === $room->id) {{ 'selected' }} @endif>
                                                                <span>{{ $room->name }}</span>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('roomId')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="checkIn">Check In</label>
                                                <input type="date" wire:model="checkIn" class="form-control"
                                                    id="checkIn">
                                                <div>
                                                    @error('checkIn')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="checkOut">Check Out</label>
                                                <input type="date" wire:model="checkOut" class="form-control"
                                                    id="checkOut">
                                                <div>
                                                    @error('checkOut')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea type="text" wire:model="note" class="form-control" id="note" autocomplete="off"></textarea>
                                            <div>
                                                @error('note')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="my-3 btn {{ $id ? 'btn-info' : 'btn-primary' }}">
                                            {{ $id ? 'Update' : 'Create' }}
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
    function listener() {
        // generateMapBox()

        // Livewire.on('init-select2', () => {
        //     $('.user-select').select2();
        // })

        $('#userId').on('select2:select', function(e) {
            let value = $(this).val();
            @this.set('userId', value)
        });

        $('#houseId').on('select2:select', function(e) {
            let value = $(this).val();
            @this.set('houseId', value)
        });

        $('#roomId').on('select2Room:select', function(e) {
            let value = $(this).val();
            @this.set('roomId', value)
        });

        $('.user-select').select2();
    }

    document.addEventListener('livewire:navigated', listener)
    document.addEventListener('livewire:navigating', () => {
        document.removeEventListener('livewire:navigated', listener)
    })
</script>
