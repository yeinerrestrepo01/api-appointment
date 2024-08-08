<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * @OA\Schema(
     *  schema="AppointmentResource",
     * type="object",
     * @OA\property(
     *    property="id",
     *    type="intger",
     *    description="Identificador de cita"
     *  ),
     * *  @OA\property(
     *    property="patient_name",
     *    type="string",
     *    description="Nombre del paciente"
     *  ),
     * *  @OA\property(
     *    property="doctor_name",
     *    type="string",
     *    description="Nombre de medico"
     *  ),
     * *  @OA\property(
     *    property="appointment_date",
     *    type="datetime",
     *    description="fecha de cita"
     *  ),
     * *  @OA\property(
     *    property="status",
     *    type="string",
     *    description="estado de cita"
     *  ),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient_name,
            'doctor_name' => $this->doctor_name,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status
        ];
    }
}
