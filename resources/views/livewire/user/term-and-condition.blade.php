<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header">

                    <div class="form-group">
                        <a href="/login" class="btn btn-primary btn-user">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            {{ __('Back') }}
                        </a>
                    </div>
                    <div>
                        Terms and Conditions
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <pre>
                            These terms and conditions govern your use of the Boarding House
                            Management System provided by BH Locator. By
                            accessing or using the System, you agree to be bound by these Terms. If you do not
                            agree to these Terms, please do not use the System.

                            1. Acceptance of Terms
                            By accessing or using the System, you agree to be bound by these Terms. If you do
                            not agree to these Terms, you may not use the System.

                            2. Use of the System
                            2.1. The System is intended for the management and administration of boarding house
                            operations.
                            2.2. You agree to use the System only for lawful purposes and in accordance with
                            these Terms.
                            2.3. You are responsible for maintaining the confidentiality of your account
                            credentials and for all activities that occur under your account.

                            3. Data Privacy
                            3.1. The Provider will collect, store, and process personal data in accordance with
                            its Privacy Policy.
                            3.2. You consent to the use of your personal data in accordance with the Privacy
                            Policy.

                            4. Intellectual Property
                            4.1. The System and all related intellectual property rights are owned by the
                            Provider.
                            4.2. You are granted a limited, non-exclusive, non-transferable license to use the
                            System solely for your internal business purposes.

                            5. Limitation of Liability
                            5.1. The Provider shall not be liable for any indirect, incidental, special,
                            consequential, or punitive damages arising out of or in connection with the use of
                            the System.
                            5.2. The Provider's total liability arising out of or in connection with these Terms
                            shall not exceed the total amount paid by you for the use of the System during the
                            twelve (12) months preceding the event giving rise to the liability.

                            6. Indemnification
                            You agree to indemnify and hold harmless the Provider, its affiliates, officers,
                            directors, employees, and agents from and against any and all claims, damages,
                            liabilities, costs, and expenses arising out of or in connection with your use of
                            the System.

                            7. Termination
                            7.1. The Provider may terminate or suspend your access to the System at any time
                            without prior notice for any reason.
                            7.2. Upon termination, all licenses and rights granted to you under these Terms
                            shall immediately terminate.

                            8. Amendments
                            The Provider reserves the right to amend these Terms at any time. The amended Terms
                            will be effective upon posting on the Provider's website. Your continued use of the
                            System after the posting of the amended Terms constitutes your acceptance of the
                            amended Terms.

                            9. Governing Law
                            These Terms shall be governed by and construed in accordance with the laws of RA. 21583, 
                            without regard to its conflict of law principles.

                            10. Contact Information
                            If you have any questions or concerns about these Terms, please contact us at +63 9521 524 519.

                            By using the Boarding House Management System, you acknowledge that you have read,
                            understood, and agree to be bound by these Terms and Conditions.
                        </pre>
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
