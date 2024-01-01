<?php

namespace App\Console\Commands;

use App\Enums\StatusEnums;
use App\Models\Reservation;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeletePendingReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deletePending:reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete automatically the pending reservations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $previousDay = now()->subDay()->format('Y-m-d');

        // Log::debug($previousDay);

        $pendingReservations = Reservation::whereHas('getStatus', function ($query1) {
            $query1->where('serial_id', StatusEnums::PENDING);
        })->where('checkIn', $previousDay)
            ->get();

        if ($pendingReservations) {

            $status = Status::where('serial_id', StatusEnums::CANCELLED)->first();

            foreach ($pendingReservations as $reservation) {
                $reservation->update([
                    'statusId' => $status->id
                ]);
            }
        }
    }
}
