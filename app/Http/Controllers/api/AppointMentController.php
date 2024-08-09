<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Interface\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 * title="AppointMent API",
 * version = "1.0",
 * description="Api para la gestion y solcitud de citas medicas"
 * )
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class AppointMentController extends Controller
{
    private AppointmentRepositoryInterface  $appointmentRepositoryInterface;

    public function __construct(AppointmentRepositoryInterface $appointmentRepositoryInterface)
    {
        $this->appointmentRepositoryInterface = $appointmentRepositoryInterface;
    }

    /**
     * @OA\Get(
     *     path="/api/appointments",
     *     tags={"appointments"},
     *     summary="Retorna el listado de citas",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AppointmentResource")
     *         )
     *     )
     * )
     */

    function index()
    {
        $data = $this->appointmentRepositoryInterface->getAll();
        return ApiResponseHelper::sendResponse(AppointmentResource::collection($data), '', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/{id}",
     *     tags={"appointments"},
     *     summary="Retorna la información relacionada a una cita según su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la cita",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/AppointmentResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cita no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cita no encontrada")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $appointment = $this->appointmentRepositoryInterface->getById($id);
        return ApiResponseHelper::sendResponse(new AppointmentResource($appointment), '', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/appointments",
     *     tags={"appointments"},
     *     summary="Realiza la creación de un registro de cita",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_name","doctor_name","appointment_date","status"},
     *             @OA\Property(property="patient_name", type="string", example="John Doe"),
     *             @OA\Property(property="doctor_name", type="string", example="Dr. Smith"),
     *             @OA\Property(property="appointment_date", type="string", format="date-time", example="2024-08-08T10:00:00Z"),
     *             @OA\Property(property="status", type="string", example="scheduled")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registro creado exitosamente",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/AppointmentResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     */

    public function store(StoreAppointmentRequest $request)
    {
        $data = [
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
        ];
        DB::beginTransaction();
        try {
            $appointment = $this->appointmentRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseHelper::sendResponse(new AppointmentResource($appointment), 'Cita creada exitosamente', 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/appointments/{id}",
     *     tags={"appointments"},
     *     summary="Actualiza la información de una cita según su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la cita",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_name","doctor_name","appointment_date"},
     *             @OA\Property(property="patient_name", type="string", example="John Doe"),
     *             @OA\Property(property="doctor_name", type="string", example="Dr. Smith"),
     *             @OA\Property(property="appointment_date", type="string", format="date-time", example="2024-08-08T10:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cita actualizada exitosamente",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/AppointmentResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cita no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cita no encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos incorrectos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Datos de entrada inválidos")
     *         )
     *     )
     * )
     */

    public function update(UpdateAppointmentRequest $request, string $id)
    {
        $appointment = $this->appointmentRepositoryInterface->getById($id);

        if (!$appointment) {
            return ApiResponseHelper::sendResponse(null, 'Cita no encontrada', 404);
        }

        // Datos para la actualización
        $data = [
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
        ];

        DB::beginTransaction();
        try {
            $this->appointmentRepositoryInterface->update($data, $id);
            DB::commit();

            return ApiResponseHelper::sendResponse(new AppointmentResource($appointment), 'Cita actualizada exitosamente', 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex, $ex->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/appointments/{id}",
     *     tags={"appointments"},
     *     summary="Elimina una cita según su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la cita",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cita cancelada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cita cancelada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cita no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cita no encontrada")
     *         )
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $appointment = $this->appointmentRepositoryInterface->delete($id);
        return ApiResponseHelper::sendResponse(null, 'cita cancelada correctamente', 200);
    }
}
