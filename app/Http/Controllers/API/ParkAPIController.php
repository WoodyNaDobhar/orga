<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateParkAPIRequest;
use App\Http\Requests\API\UpdateParkAPIRequest;
use App\Models\Park;
use App\Repositories\ParkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ParkResource;

/**
 * Class ParkController
 */

class ParkAPIController extends AppBaseController
{
    /** @var  ParkRepository */
    private $parkRepository;

    public function __construct(ParkRepository $parkRepo)
    {
        $this->parkRepository = $parkRepo;
    }

    /**
     * @OA\Get(
     *      path="/parks",
     *      summary="getParkList",
     *      tags={"Park"},
     *      description="Get all Parks",
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
     *                  @OA\Items(ref="#/components/schemas/Park")
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
        $parks = $this->parkRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ParkResource::collection($parks), 'Parks retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/parks",
     *      summary="createPark",
     *      tags={"Park"},
     *      description="Create Park",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Park")
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
     *                  ref="#/components/schemas/Park"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateParkAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $park = $this->parkRepository->create($input);

        return $this->sendResponse(new ParkResource($park), 'Park saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/parks/{id}",
     *      summary="getParkItem",
     *      tags={"Park"},
     *      description="Get Park",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Park",
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
     *                  ref="#/components/schemas/Park"
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
        /** @var Park $park */
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            return $this->sendError('Park not found');
        }

        return $this->sendResponse(new ParkResource($park), 'Park retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/parks/{id}",
     *      summary="updatePark",
     *      tags={"Park"},
     *      description="Update Park",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Park",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Park")
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
     *                  ref="#/components/schemas/Park"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateParkAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Park $park */
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            return $this->sendError('Park not found');
        }

        $park = $this->parkRepository->update($input, $id);

        return $this->sendResponse(new ParkResource($park), 'Park updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/parks/{id}",
     *      summary="deletePark",
     *      tags={"Park"},
     *      description="Delete Park",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Park",
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
        /** @var Park $park */
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            return $this->sendError('Park not found');
        }

        $park->delete();

        return $this->sendSuccess('Park deleted successfully');
    }
}
