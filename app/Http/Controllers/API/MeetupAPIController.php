<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMeetupAPIRequest;
use App\Http\Requests\API\UpdateMeetupAPIRequest;
use App\Models\Meetup;
use App\Repositories\MeetupRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MeetupResource;

/**
 * Class MeetupController
 */

class MeetupAPIController extends AppBaseController
{
    /** @var  MeetupRepository */
    private $meetupRepository;

    public function __construct(MeetupRepository $meetupRepo)
    {
        $this->meetupRepository = $meetupRepo;
    }

    /**
     * @OA\Get(
     *      path="/meetups",
     *      summary="getMeetupList",
     *      tags={"Meetup"},
     *      description="Get all Meetups",
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
     *                  @OA\Items(ref="#/components/schemas/Meetup")
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
        $meetups = $this->meetupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(MeetupResource::collection($meetups), 'Meetups retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/meetups",
     *      summary="createMeetup",
     *      tags={"Meetup"},
     *      description="Create Meetup",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Meetup")
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
     *                  ref="#/components/schemas/Meetup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMeetupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $meetup = $this->meetupRepository->create($input);

        return $this->sendResponse(new MeetupResource($meetup), 'Meetup saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/meetups/{id}",
     *      summary="getMeetupItem",
     *      tags={"Meetup"},
     *      description="Get Meetup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Meetup",
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
     *                  ref="#/components/schemas/Meetup"
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
        /** @var Meetup $meetup */
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            return $this->sendError('Meetup not found');
        }

        return $this->sendResponse(new MeetupResource($meetup), 'Meetup retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/meetups/{id}",
     *      summary="updateMeetup",
     *      tags={"Meetup"},
     *      description="Update Meetup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Meetup",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Meetup")
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
     *                  ref="#/components/schemas/Meetup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMeetupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Meetup $meetup */
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            return $this->sendError('Meetup not found');
        }

        $meetup = $this->meetupRepository->update($input, $id);

        return $this->sendResponse(new MeetupResource($meetup), 'Meetup updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/meetups/{id}",
     *      summary="deleteMeetup",
     *      tags={"Meetup"},
     *      description="Delete Meetup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Meetup",
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
        /** @var Meetup $meetup */
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            return $this->sendError('Meetup not found');
        }

        $meetup->delete();

        return $this->sendSuccess('Meetup deleted successfully');
    }
}
