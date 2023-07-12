<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLocationAPIRequest;
use App\Http\Requests\API\UpdateLocationAPIRequest;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LocationResource;

/**
 * Class LocationController
 */

class LocationAPIController extends AppBaseController
{
    /** @var  LocationRepository */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * @OA\Get(
     *      path="/locations",
     *      summary="getLocationList",
     *      tags={"Location"},
     *      description="Get all Locations",
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
     *                  @OA\Items(ref="#/components/schemas/Location")
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
        $locations = $this->locationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(LocationResource::collection($locations), 'Locations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/locations",
     *      summary="createLocation",
     *      tags={"Location"},
     *      description="Create Location",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Location")
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
     *                  ref="#/components/schemas/Location"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLocationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $location = $this->locationRepository->create($input);

        return $this->sendResponse(new LocationResource($location), 'Location saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/locations/{id}",
     *      summary="getLocationItem",
     *      tags={"Location"},
     *      description="Get Location",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Location",
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
     *                  ref="#/components/schemas/Location"
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
        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        return $this->sendResponse(new LocationResource($location), 'Location retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/locations/{id}",
     *      summary="updateLocation",
     *      tags={"Location"},
     *      description="Update Location",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Location",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Location")
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
     *                  ref="#/components/schemas/Location"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLocationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location = $this->locationRepository->update($input, $id);

        return $this->sendResponse(new LocationResource($location), 'Location updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/locations/{id}",
     *      summary="deleteLocation",
     *      tags={"Location"},
     *      description="Delete Location",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Location",
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
        /** @var Location $location */
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            return $this->sendError('Location not found');
        }

        $location->delete();

        return $this->sendSuccess('Location deleted successfully');
    }
}
