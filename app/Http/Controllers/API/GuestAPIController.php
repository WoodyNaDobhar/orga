<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGuestAPIRequest;
use App\Http\Requests\API\UpdateGuestAPIRequest;
use App\Models\Guest;
use App\Repositories\GuestRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\GuestResource;

/**
 * Class GuestController
 */

class GuestAPIController extends AppBaseController
{
    /** @var  GuestRepository */
    private $guestRepository;

    public function __construct(GuestRepository $guestRepo)
    {
        $this->guestRepository = $guestRepo;
    }

    /**
     * @OA\Get(
     *      path="/guests",
     *      summary="getGuestList",
     *      tags={"Guest"},
     *      description="Get all Guests",
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
     *                  @OA\Items(ref="#/components/schemas/Guest")
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
        $guests = $this->guestRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(GuestResource::collection($guests), 'Guests retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/guests",
     *      summary="createGuest",
     *      tags={"Guest"},
     *      description="Create Guest",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Guest")
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
     *                  ref="#/components/schemas/Guest"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGuestAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $guest = $this->guestRepository->create($input);

        return $this->sendResponse(new GuestResource($guest), 'Guest saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/guests/{id}",
     *      summary="getGuestItem",
     *      tags={"Guest"},
     *      description="Get Guest",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Guest",
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
     *                  ref="#/components/schemas/Guest"
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
        /** @var Guest $guest */
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            return $this->sendError('Guest not found');
        }

        return $this->sendResponse(new GuestResource($guest), 'Guest retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/guests/{id}",
     *      summary="updateGuest",
     *      tags={"Guest"},
     *      description="Update Guest",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Guest",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Guest")
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
     *                  ref="#/components/schemas/Guest"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGuestAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Guest $guest */
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            return $this->sendError('Guest not found');
        }

        $guest = $this->guestRepository->update($input, $id);

        return $this->sendResponse(new GuestResource($guest), 'Guest updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/guests/{id}",
     *      summary="deleteGuest",
     *      tags={"Guest"},
     *      description="Delete Guest",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Guest",
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
        /** @var Guest $guest */
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            return $this->sendError('Guest not found');
        }

        $guest->delete();

        return $this->sendSuccess('Guest deleted successfully');
    }
}
