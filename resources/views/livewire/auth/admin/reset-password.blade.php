<div class="container" style="opacity: .9">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Reset Password') }}</h1>
                                </div>

                                @error('token')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <form wire:submit="handleResetPassword" wire:keydown.enter="handleResetPassword"
                                    class="user" autocomplete="off">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" wire:model="email"
                                            name="email" placeholder="{{ __('E-Mail Address') }}"
                                            value="{{ old('email') }}" autofocus>
                                        <div>
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            wire:model="password" name="password" placeholder="{{ __('Password') }}"
                                            autofocus>
                                        <div>
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            wire:model="password_confirmation" name="password_confirmation"
                                            placeholder="{{ __('Confirm Password') }}"
                                            value="{{ old('password_confirmation') }}" autofocus>
                                        <div>
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary btn-user btn-block 
                                        d-flex justify-content-center align-items-center">
                                            <div wire:loading wire:loading.class="opacity-50 disabled"
                                                wire:loading.attr="disabled" wire:target="login"
                                                class="spinner-border mx-2" role="status">
                                                <span class="sr-only mx-2">Loading...</span>
                                            </div>
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </form>
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
        Livewire.on('success-login', (event) => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Login successfully"
            }).then(() => {
                @this.dispatch('login-success')
            });
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
