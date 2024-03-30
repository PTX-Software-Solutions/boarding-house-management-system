<x-mail::message>

    Hi <?= $user->firstName ?>,

    Almost there! Click the button below to confirm your email.
    <?= url('email/verify?token=' . $user->remember_token) ?>


    Thanks,
    BH Locator
</x-mail::message>
