<?php

namespace App\Livewire\Admin;

use App\Enums\StatusEnums;
use App\Enums\UserTypeEnums;
use App\Models\House;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ReservationForm extends Component
{

    public $id;

    public $rooms = [];

    #[Rule('required', message: 'The user is required')]
    public $userId;

    #[Rule('required', message: 'The house is required')]
    public $houseId;

    #[Rule('required', message: 'The room is required')]
    public $roomId;

    #[Rule('required')]
    public $checkIn;

    #[Rule('nullable')]
    public $checkOut;

    #[Rule('nullable')]
    public $note;

    public function updatedHouseId($id)
    {
        $this->rooms = Room::whereHas('getStatus', function ($query) {
            $query->where('serial_id', StatusEnums::VACANT);
        })->where('houseId', $id)->get();
    }

    public function back()
    {
        return $this->redirect('/admin/reservations', navigate: true);
    }

    public function resetInput()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $data = Reservation::findOrFail($id);

        $this->userId   = $data->userId;
        $this->houseId  = $data->houseId;
        $this->roomId   = $data->roomId;
        $this->checkIn  = $data->checkIn ? Carbon::parse($data->checkIn)->format('Y-m-d') : '';
        $this->checkOut = $data->checkOut ? Carbon::parse($data->checkOut)->format('Y-m-d') : '';
        $this->note     = $data->note;

        if ($this->houseId) {
            $this->rooms = Room::whereHas('getStatus', function ($query) {
                $query->where('serial_id', StatusEnums::VACANT);
            })->where('houseId', $this->houseId)->get();
        }
    }

    public function mount($id = null)
    {
        $this->resetInput();
        $this->reset();

        if ($id) {
            $this->id = $id;
            $this->edit($id);
        }
    }

    public function save()
    {

        $data = $this->validate();

        try {

            DB::beginTransaction();


            if ($this->id) {

                $reservation = Reservation::findOrFail($this->id);


                $reservation->update([
                    'userId'    => $data['userId'],
                    'houseId'   => $data['houseId'],
                    'roomId'    => $data['roomId'],
                    'checkIn'   => $data['checkIn'],
                    'checkOut'  => $data['checkOut'],
                    'note'      => $data['note']
                ]);

                DB::commit();
                $this->dispatch('success-update');
            } else {


                // Status default value
                $statusDefault = Status::where('serial_id', StatusEnums::PENDING)->first();

                Reservation::create([
                    'userId'    => $data['userId'],
                    'houseId'   => $data['houseId'],
                    'roomId'    => $data['roomId'],
                    'statusId'  => $statusDefault->id,
                    'checkIn'   => $data['checkIn'],
                    'checkOut'  => $data['checkOut'],
                    'note'      => $data['note']
                ]);

                DB::commit();
                $this->dispatch('success-insert');
            }

            return $this->redirect('/admin/reservations', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $users = User::whereHas('status', function ($query) {
            $query->select('id', 'serial_id')->where('serial_id', StatusEnums::ACTIVE);
        })
            ->whereHas('userType', function ($query1) {
                $query1->select('id', 'serial_id')->where('serial_id', UserTypeEnums::USER);
            })
            ->select(
                'id',
                'firstName',
                'lastName',
                'statusId',
                'userTypeId'
            )
            ->get();

        $houses = House::select(
            'id',
            'houseName'
        )
            ->get();

        return view('livewire.admin.reservation-form', [
            'users'     => $users,
            'houses'    => $houses
        ]);
    }
}
