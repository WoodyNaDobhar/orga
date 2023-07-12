<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAwardAPIRequest;
use App\Http\Requests\API\UpdateAwardAPIRequest;
use App\Models\Award;
use App\Repositories\AwardRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AwardResource;

/**
 * Class AwardController
 */

class AwardAPIController extends AppBaseController
{
    /** @var  AwardRepository */
    private $awardRepository;

    public function __construct(AwardRepository $awardRepo)
    {
        $this->awardRepository = $awardRepo;
    }

    /**
     * @OA\Get(
     *      path="/awards",
     *      summary="getAwardList",
     *      tags={"Award"},
     *      description="Get all Awards",
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
     *                  @OA\Items(ref="#/components/schemas/Award")
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
        $awards = $this->awardRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AwardResource::collection($awards), 'Awards retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/awards",
     *      summary="createAward",
     *      tags={"Award"},
     *      description="Create Award",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Award")
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
     *                  ref="#/components/schemas/Award"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAwardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $award = $this->awardRepository->create($input);

        return $this->sendResponse(new AwardResource($award), 'Award saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/awards/{id}",
     *      summary="getAwardItem",
     *      tags={"Award"},
     *      description="Get Award",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Award",
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
     *                  ref="#/components/schemas/Award"
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
        /** @var Award $award */
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            return $this->sendError('Award not found');
        }

        return $this->sendResponse(new AwardResource($award), 'Award retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/awards/{id}",
     *      summary="updateAward",
     *      tags={"Award"},
     *      description="Update Award",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Award",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Award")
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
     *                  ref="#/components/schemas/Award"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAwardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Award $award */
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            return $this->sendError('Award not found');
        }

        $award = $this->awardRepository->update($input, $id);

        return $this->sendResponse(new AwardResource($award), 'Award updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/awards/{id}",
     *      summary="deleteAward",
     *      tags={"Award"},
     *      description="Delete Award",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Award",
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
        /** @var Award $award */
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            return $this->sendError('Award not found');
        }

        $award->delete();

        return $this->sendSuccess('Award deleted successfully');
    }
}
