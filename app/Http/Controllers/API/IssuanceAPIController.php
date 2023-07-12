<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIssuanceAPIRequest;
use App\Http\Requests\API\UpdateIssuanceAPIRequest;
use App\Models\Issuance;
use App\Repositories\IssuanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\IssuanceResource;

/**
 * Class IssuanceController
 */

class IssuanceAPIController extends AppBaseController
{
    /** @var  IssuanceRepository */
    private $issuanceRepository;

    public function __construct(IssuanceRepository $issuanceRepo)
    {
        $this->issuanceRepository = $issuanceRepo;
    }

    /**
     * @OA\Get(
     *      path="/issuances",
     *      summary="getIssuanceList",
     *      tags={"Issuance"},
     *      description="Get all Issuances",
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
     *                  @OA\Items(ref="#/components/schemas/Issuance")
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
        $issuances = $this->issuanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(IssuanceResource::collection($issuances), 'Issuances retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/issuances",
     *      summary="createIssuance",
     *      tags={"Issuance"},
     *      description="Create Issuance",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Issuance")
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
     *                  ref="#/components/schemas/Issuance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIssuanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $issuance = $this->issuanceRepository->create($input);

        return $this->sendResponse(new IssuanceResource($issuance), 'Issuance saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/issuances/{id}",
     *      summary="getIssuanceItem",
     *      tags={"Issuance"},
     *      description="Get Issuance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Issuance",
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
     *                  ref="#/components/schemas/Issuance"
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
        /** @var Issuance $issuance */
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            return $this->sendError('Issuance not found');
        }

        return $this->sendResponse(new IssuanceResource($issuance), 'Issuance retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/issuances/{id}",
     *      summary="updateIssuance",
     *      tags={"Issuance"},
     *      description="Update Issuance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Issuance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Issuance")
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
     *                  ref="#/components/schemas/Issuance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIssuanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Issuance $issuance */
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            return $this->sendError('Issuance not found');
        }

        $issuance = $this->issuanceRepository->update($input, $id);

        return $this->sendResponse(new IssuanceResource($issuance), 'Issuance updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/issuances/{id}",
     *      summary="deleteIssuance",
     *      tags={"Issuance"},
     *      description="Delete Issuance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Issuance",
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
        /** @var Issuance $issuance */
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            return $this->sendError('Issuance not found');
        }

        $issuance->delete();

        return $this->sendSuccess('Issuance deleted successfully');
    }
}
