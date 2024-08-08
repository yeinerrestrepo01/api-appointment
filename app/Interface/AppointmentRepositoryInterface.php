<?php

namespace App\Interface;

interface AppointmentRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function store(array $appointment);

    public function update(array $appointment, $id);

    public function delete($id);
}
