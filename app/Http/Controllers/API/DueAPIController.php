<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDueAPIRequest;
use App\Http\Requests\API\UpdateDueAPIRequest;
use App\Models\Due;
use App\Repositories\DueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DueResource;

/**
 * Class DueController
 */

class DueAPIController extends AppBaseController
{
    /** @var  DueRepository */
    private $dueRepository;

    public function __construct(DueRepository $dueRepo)
    {
        $this->dueRepository = $dueRepo;
    }

    /**
     * @OA\Get(
     *      path="/dues",
     *      summary="getDueList",
     *      tags={"Due"},
     *      description="Get all Dues",
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
     *                  @OA\Items(ref="#/components/schemas/Due")
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
        $dues = $this->dueRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(DueResource::collection($dues), 'Dues retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/dues",
     *      summary="createDue",
     *      tags={"Due"},
     *      description="Create Due",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Due")
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
     *                  ref="#/components/schemas/Due"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDueAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $due = $this->dueRepository->create($input);

        return $this->sendResponse(new DueResource($due), 'Due saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/dues/{id}",
     *      summary="getDueItem",
     *      tags={"Due"},
     *      description="Get Due",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Due",
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
     *                  ref="#/components/schemas/Due"
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
        /** @var Due $due */
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            return $this->sendError('Due not found');
        }

        return $this->sendResponse(new DueResource($due), 'Due retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/dues/{id}",
     *      summary="updateDue",
     *      tags={"Due"},
     *      description="Update Due",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Due",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Due")
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
     *                  ref="#/components/schemas/Due"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDueAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Due $due */
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            return $this->sendError('Due not found');
        }

        $due = $this->dueRepository->update($input, $id);

        return $this->sendResponse(new DueResource($due), 'Due updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/dues/{id}",
     *      summary="deleteDue",
     *      tags={"Due"},
     *      description="Delete Due",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Due",
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
        /** @var Due $due */
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            return $this->sendError('Due not found');
        }

        $due->delete();

        return $this->sendSuccess('Due deleted successfully');
    }
}
