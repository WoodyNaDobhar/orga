<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateParkrankAPIRequest;
use App\Http\Requests\API\UpdateParkrankAPIRequest;
use App\Models\Parkrank;
use App\Repositories\ParkrankRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ParkrankResource;

/**
 * Class ParkrankController
 */

class ParkrankAPIController extends AppBaseController
{
    /** @var  ParkrankRepository */
    private $parkrankRepository;

    public function __construct(ParkrankRepository $parkrankRepo)
    {
        $this->parkrankRepository = $parkrankRepo;
    }

    /**
     * @OA\Get(
     *      path="/parkranks",
     *      summary="getParkrankList",
     *      tags={"Parkrank"},
     *      description="Get all Parkranks",
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
     *                  @OA\Items(ref="#/components/schemas/Parkrank")
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
        $parkranks = $this->parkrankRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ParkrankResource::collection($parkranks), 'Parkranks retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/parkranks",
     *      summary="createParkrank",
     *      tags={"Parkrank"},
     *      description="Create Parkrank",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Parkrank")
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
     *                  ref="#/components/schemas/Parkrank"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateParkrankAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $parkrank = $this->parkrankRepository->create($input);

        return $this->sendResponse(new ParkrankResource($parkrank), 'Parkrank saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/parkranks/{id}",
     *      summary="getParkrankItem",
     *      tags={"Parkrank"},
     *      description="Get Parkrank",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Parkrank",
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
     *                  ref="#/components/schemas/Parkrank"
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
        /** @var Parkrank $parkrank */
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            return $this->sendError('Parkrank not found');
        }

        return $this->sendResponse(new ParkrankResource($parkrank), 'Parkrank retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/parkranks/{id}",
     *      summary="updateParkrank",
     *      tags={"Parkrank"},
     *      description="Update Parkrank",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Parkrank",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Parkrank")
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
     *                  ref="#/components/schemas/Parkrank"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateParkrankAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Parkrank $parkrank */
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            return $this->sendError('Parkrank not found');
        }

        $parkrank = $this->parkrankRepository->update($input, $id);

        return $this->sendResponse(new ParkrankResource($parkrank), 'Parkrank updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/parkranks/{id}",
     *      summary="deleteParkrank",
     *      tags={"Parkrank"},
     *      description="Delete Parkrank",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Parkrank",
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
        /** @var Parkrank $parkrank */
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            return $this->sendError('Parkrank not found');
        }

        $parkrank->delete();

        return $this->sendSuccess('Parkrank deleted successfully');
    }
}
