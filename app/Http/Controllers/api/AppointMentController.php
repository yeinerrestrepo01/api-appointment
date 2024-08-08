<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequester;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Interface\AppointmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointMentController extends Controller
{
    private AppointmentRepositoryInterface  $appointmentRepositoryInterface;

    public function __construct(AppointmentRepositoryInterface $appointmentRepositoryInterface)
    {
        $this->appointmentRepositoryInterface = $appointmentRepositoryInterface;
    }

    function index()
    {
        $data = $this->appointmentRepositoryInterface->getAll();
        return ApiResponseHelper::sendResponse(AppointmentResource::collection($data), '', 200);
    }

    public function show(string $id)
    {
        $appointment = $this->appointmentRepositoryInterface->getById($id);
        return ApiResponseHelper::sendResponse(new AppointmentResource($appointment), '', 200);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $data = [
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'status' => 'scheduled',
        ];
        DB::beginTransaction();
        try {
            $appointment = $this->appointmentRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseHelper::sendResponse(new AppointmentResource($appointment, 'Cita creada exitosamente', 201));
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }


    public function update(UpdateAppointmentRequest $request, string $id)
    {
        $data = [
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'status' => 'scheduled',
        ];
        DB::beginTransaction();
        try {
            $this->appointmentRepositoryInterface->update($data, $id,);
            DB::commit();
            return ApiResponseHelper::sendResponse(new AppointmentResource(null, 'Cita actualizada exitosamente', 200));
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    public function destroy(string $id)
    {
        $appointment = $this->appointmentRepositoryInterface->delete($id);
        return ApiResponseHelper::sendResponse(null, 'cita cancelada correctamente', 200);
    }
}
