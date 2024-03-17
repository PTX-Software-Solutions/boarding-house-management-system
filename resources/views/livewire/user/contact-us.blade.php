<div>
    <h1 class="h3 mb-4 text-gray-800">{{ __('Contact') }}</h1>

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
                                Contact Us
                            </div>
                            <div class="card-body">
                                <div>
                                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                                    +63 9521 524 519
                                </div>
                                <div>
                                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                    Meciano Road,
                                    Dumaguete City,
                                    Negros Oriental,
                                    6200
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
