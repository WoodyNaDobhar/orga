<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReconciliationAPIRequest;
use App\Http\Requests\API\UpdateReconciliationAPIRequest;
use App\Models\Reconciliation;
use App\Repositories\ReconciliationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ReconciliationResource;

/**
 * Class ReconciliationController
 */

class ReconciliationAPIController extends AppBaseController
{
    /** @var  ReconciliationRepository */
    private $reconciliationRepository;

    public function __construct(ReconciliationRepository $reconciliationRepo)
    {
        $this->reconciliationRepository = $reconciliationRepo;
    }

    /**
     * @OA\Get(
     *      path="/reconciliations",
     *      summary="getReconciliationList",
     *      tags={"Reconciliation"},
     *      description="Get all Reconciliations",
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
     *                  @OA\Items(ref="#/components/schemas/Reconciliation")
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
        $reconciliations = $this->reconciliationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ReconciliationResource::collection($reconciliations), 'Reconciliations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/reconciliations",
     *      summary="createReconciliation",
     *      tags={"Reconciliation"},
     *      description="Create Reconciliation",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Reconciliation")
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
     *                  ref="#/components/schemas/Reconciliation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReconciliationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $reconciliation = $this->reconciliationRepository->create($input);

        return $this->sendResponse(new ReconciliationResource($reconciliation), 'Reconciliation saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/reconciliations/{id}",
     *      summary="getReconciliationItem",
     *      tags={"Reconciliation"},
     *      description="Get Reconciliation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reconciliation",
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
     *                  ref="#/components/schemas/Reconciliation"
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
        /** @var Reconciliation $reconciliation */
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            return $this->sendError('Reconciliation not found');
        }

        return $this->sendResponse(new ReconciliationResource($reconciliation), 'Reconciliation retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/reconciliations/{id}",
     *      summary="updateReconciliation",
     *      tags={"Reconciliation"},
     *      description="Update Reconciliation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reconciliation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Reconciliation")
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
     *                  ref="#/components/schemas/Reconciliation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReconciliationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Reconciliation $reconciliation */
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            return $this->sendError('Reconciliation not found');
        }

        $reconciliation = $this->reconciliationRepository->update($input, $id);

        return $this->sendResponse(new ReconciliationResource($reconciliation), 'Reconciliation updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/reconciliations/{id}",
     *      summary="deleteReconciliation",
     *      tags={"Reconciliation"},
     *      description="Delete Reconciliation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reconciliation",
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
        /** @var Reconciliation $reconciliation */
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            return $this->sendError('Reconciliation not found');
        }

        $reconciliation->delete();

        return $this->sendSuccess('Reconciliation deleted successfully');
    }
}
