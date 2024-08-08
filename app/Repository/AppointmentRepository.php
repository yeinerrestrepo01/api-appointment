<?php

namespace App\Repository;

use App\Interface\AppointmentRepositoryInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAll()
    {
        return Appointment::all();
    }

    public function getById($id)
    {
        return Appointment::fineOrFail($id);
    }

    public function store($appointment)
    {
        return Appointment::create($appointment);
    }

    public function update($id, $appointment)
    {
        return Appointment::whereId($id)->Update($appointment);
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }
}
