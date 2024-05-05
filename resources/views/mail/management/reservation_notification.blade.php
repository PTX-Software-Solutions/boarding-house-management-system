<x-mail::message>

    Dear Management Team,

    This email confirms a new reservation made through BH Locator.

    Reservation Details:

    Reservation ID: <?= $reservation->id ?>

    Guest Name(s): <?= $user->firstName ?> <?= $user->lastName ?>

    Contact Information (Email & Phone Number): <?= $user->email ?> / <?= $user->phoneNumber ?>

    Arrival Date: <?= $reservation->checkIn ?>

    Departure Date: <?= $reservation->checkOut ?>

    Room/Unit Type: <?= $roomDetail->name ?>

    Additional Information: <?= $reservation->note ?>


    You can access and manage this reservation through the BH Locator Admin platform.
    For any questions regarding this reservation, please contact the guest directly using the information provided
    above.

    We recommend you promptly review this reservation and confirm it with the guest at your earliest convenience.

    Thank you,

    BH Locator
</x-mail::message>
