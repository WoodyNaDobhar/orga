<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSuspensionAPIRequest;
use App\Http\Requests\API\UpdateSuspensionAPIRequest;
use App\Models\Suspension;
use App\Repositories\SuspensionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SuspensionResource;

/**
 * Class SuspensionController
 */

class SuspensionAPIController extends AppBaseController
{
    /** @var  SuspensionRepository */
    private $suspensionRepository;

    public function __construct(SuspensionRepository $suspensionRepo)
    {
        $this->suspensionRepository = $suspensionRepo;
    }

    /**
     * @OA\Get(
     *      path="/suspensions",
     *      summary="getSuspensionList",
     *      tags={"Suspension"},
     *      description="Get all Suspensions",
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
     *                  @OA\Items(ref="#/components/schemas/Suspension")
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
        $suspensions = $this->suspensionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SuspensionResource::collection($suspensions), 'Suspensions retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/suspensions",
     *      summary="createSuspension",
     *      tags={"Suspension"},
     *      description="Create Suspension",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Suspension")
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
     *                  ref="#/components/schemas/Suspension"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSuspensionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $suspension = $this->suspensionRepository->create($input);

        return $this->sendResponse(new SuspensionResource($suspension), 'Suspension saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/suspensions/{id}",
     *      summary="getSuspensionItem",
     *      tags={"Suspension"},
     *      description="Get Suspension",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Suspension",
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
     *                  ref="#/components/schemas/Suspension"
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
        /** @var Suspension $suspension */
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            return $this->sendError('Suspension not found');
        }

        return $this->sendResponse(new SuspensionResource($suspension), 'Suspension retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/suspensions/{id}",
     *      summary="updateSuspension",
     *      tags={"Suspension"},
     *      description="Update Suspension",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Suspension",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Suspension")
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
     *                  ref="#/components/schemas/Suspension"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSuspensionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Suspension $suspension */
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            return $this->sendError('Suspension not found');
        }

        $suspension = $this->suspensionRepository->update($input, $id);

        return $this->sendResponse(new SuspensionResource($suspension), 'Suspension updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/suspensions/{id}",
     *      summary="deleteSuspension",
     *      tags={"Suspension"},
     *      description="Delete Suspension",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Suspension",
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
        /** @var Suspension $suspension */
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            return $this->sendError('Suspension not found');
        }

        $suspension->delete();

        return $this->sendSuccess('Suspension deleted successfully');
    }
}
