<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRecommendationAPIRequest;
use App\Http\Requests\API\UpdateRecommendationAPIRequest;
use App\Models\Recommendation;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\RecommendationResource;

/**
 * Class RecommendationController
 */

class RecommendationAPIController extends AppBaseController
{
    /** @var  RecommendationRepository */
    private $recommendationRepository;

    public function __construct(RecommendationRepository $recommendationRepo)
    {
        $this->recommendationRepository = $recommendationRepo;
    }

    /**
     * @OA\Get(
     *      path="/recommendations",
     *      summary="getRecommendationList",
     *      tags={"Recommendation"},
     *      description="Get all Recommendations",
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
     *                  @OA\Items(ref="#/components/schemas/Recommendation")
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
        $recommendations = $this->recommendationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(RecommendationResource::collection($recommendations), 'Recommendations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/recommendations",
     *      summary="createRecommendation",
     *      tags={"Recommendation"},
     *      description="Create Recommendation",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Recommendation")
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
     *                  ref="#/components/schemas/Recommendation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRecommendationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $recommendation = $this->recommendationRepository->create($input);

        return $this->sendResponse(new RecommendationResource($recommendation), 'Recommendation saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/recommendations/{id}",
     *      summary="getRecommendationItem",
     *      tags={"Recommendation"},
     *      description="Get Recommendation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Recommendation",
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
     *                  ref="#/components/schemas/Recommendation"
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
        /** @var Recommendation $recommendation */
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            return $this->sendError('Recommendation not found');
        }

        return $this->sendResponse(new RecommendationResource($recommendation), 'Recommendation retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/recommendations/{id}",
     *      summary="updateRecommendation",
     *      tags={"Recommendation"},
     *      description="Update Recommendation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Recommendation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Recommendation")
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
     *                  ref="#/components/schemas/Recommendation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRecommendationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Recommendation $recommendation */
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            return $this->sendError('Recommendation not found');
        }

        $recommendation = $this->recommendationRepository->update($input, $id);

        return $this->sendResponse(new RecommendationResource($recommendation), 'Recommendation updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/recommendations/{id}",
     *      summary="deleteRecommendation",
     *      tags={"Recommendation"},
     *      description="Delete Recommendation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Recommendation",
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
        /** @var Recommendation $recommendation */
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            return $this->sendError('Recommendation not found');
        }

        $recommendation->delete();

        return $this->sendSuccess('Recommendation deleted successfully');
    }
}
