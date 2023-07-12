<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSplitAPIRequest;
use App\Http\Requests\API\UpdateSplitAPIRequest;
use App\Models\Split;
use App\Repositories\SplitRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SplitResource;

/**
 * Class SplitController
 */

class SplitAPIController extends AppBaseController
{
    /** @var  SplitRepository */
    private $splitRepository;

    public function __construct(SplitRepository $splitRepo)
    {
        $this->splitRepository = $splitRepo;
    }

    /**
     * @OA\Get(
     *      path="/splits",
     *      summary="getSplitList",
     *      tags={"Split"},
     *      description="Get all Splits",
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
     *                  @OA\Items(ref="#/components/schemas/Split")
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
        $splits = $this->splitRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SplitResource::collection($splits), 'Splits retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/splits",
     *      summary="createSplit",
     *      tags={"Split"},
     *      description="Create Split",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Split")
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
     *                  ref="#/components/schemas/Split"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSplitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $split = $this->splitRepository->create($input);

        return $this->sendResponse(new SplitResource($split), 'Split saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/splits/{id}",
     *      summary="getSplitItem",
     *      tags={"Split"},
     *      description="Get Split",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Split",
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
     *                  ref="#/components/schemas/Split"
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
        /** @var Split $split */
        $split = $this->splitRepository->find($id);

        if (empty($split)) {
            return $this->sendError('Split not found');
        }

        return $this->sendResponse(new SplitResource($split), 'Split retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/splits/{id}",
     *      summary="updateSplit",
     *      tags={"Split"},
     *      description="Update Split",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Split",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Split")
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
     *                  ref="#/components/schemas/Split"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSplitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Split $split */
        $split = $this->splitRepository->find($id);

        if (empty($split)) {
            return $this->sendError('Split not found');
        }

        $split = $this->splitRepository->update($input, $id);

        return $this->sendResponse(new SplitResource($split), 'Split updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/splits/{id}",
     *      summary="deleteSplit",
     *      tags={"Split"},
     *      description="Delete Split",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Split",
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
        /** @var Split $split */
        $split = $this->splitRepository->find($id);

        if (empty($split)) {
            return $this->sendError('Split not found');
        }

        $split->delete();

        return $this->sendSuccess('Split deleted successfully');
    }
}
