<?php

namespace App\Interface;

interface AppointmentRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function store($appointment);

    public function update($id, $appointment);

    public function delete($id);
}
