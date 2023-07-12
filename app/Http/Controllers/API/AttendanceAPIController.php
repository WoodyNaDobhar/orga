<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttendanceAPIRequest;
use App\Http\Requests\API\UpdateAttendanceAPIRequest;
use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AttendanceResource;

/**
 * Class AttendanceController
 */

class AttendanceAPIController extends AppBaseController
{
    /** @var  AttendanceRepository */
    private $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepository = $attendanceRepo;
    }

    /**
     * @OA\Get(
     *      path="/attendances",
     *      summary="getAttendanceList",
     *      tags={"Attendance"},
     *      description="Get all Attendances",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Attendance")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $attendances = $this->attendanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AttendanceResource::collection($attendances), 'Attendances retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/attendances",
     *      summary="createAttendance",
     *      tags={"Attendance"},
     *      description="Create Attendance",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Attendance")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Attendance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttendanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $attendance = $this->attendanceRepository->create($input);

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/attendances/{id}",
     *      summary="getAttendanceItem",
     *      tags={"Attendance"},
     *      description="Get Attendance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attendance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Attendance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/attendances/{id}",
     *      summary="updateAttendance",
     *      tags={"Attendance"},
     *      description="Update Attendance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attendance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Attendance")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Attendance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttendanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance = $this->attendanceRepository->update($input, $id);

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/attendances/{id}",
     *      summary="deleteAttendance",
     *      tags={"Attendance"},
     *      description="Delete Attendance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attendance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance->delete();

        return $this->sendSuccess('Attendance deleted successfully');
    }
}
