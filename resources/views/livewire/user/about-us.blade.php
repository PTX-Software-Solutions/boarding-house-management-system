<div>
    <h1 class="h3 mb-4 text-white">{{ __('About Us') }}</h1>

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
                                About Us
                            </div>
                            <div class="card-body">
                                <div>
                                    <pre>
                                        Welcome to BH Locator, the leading provider of comprehensive boarding house
                                        management solutions. At BH Locator, we understand the unique challenges
                                        faced by boarding house operators and strive to simplify and streamline their
                                        operations through our innovative management system.

                                        With years of experience in the industry, our team is dedicated to developing
                                        cutting-edge technology tailored to meet the specific needs of boarding house
                                        management. We are committed to providing reliable, user-friendly, and efficient
                                        solutions that empower boarding house owners and administrators to effectively
                                        manage their properties.

                                        Our Boarding House Management System offers a range of features designed to optimize
                                        every aspect of daily operations, from tenant management and room allocation to
                                        maintenance tracking and financial reporting. With our intuitive platform, you can
                                        streamline processes, enhance communication, and ensure the smooth operation of your
                                        boarding house.

                                        At BH Locator, we prioritize customer satisfaction above all else. We are
                                        here to support you every step of the way, providing personalized assistance,
                                        ongoing updates, and responsive customer support to address any questions or
                                        concerns you may have.

                                        Thank you for choosing BH Locator. We look forward to helping you
                                        streamline your boarding house operations and achieve your business goals.

                                        Sincerely,
                                        BH Locator Team
                                    </pre>
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
