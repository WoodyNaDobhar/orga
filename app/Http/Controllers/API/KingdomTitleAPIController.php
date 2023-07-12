<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKingdomTitleAPIRequest;
use App\Http\Requests\API\UpdateKingdomTitleAPIRequest;
use App\Models\KingdomTitle;
use App\Repositories\KingdomTitleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\KingdomTitleResource;

/**
 * Class KingdomTitleController
 */

class KingdomTitleAPIController extends AppBaseController
{
    /** @var  KingdomTitleRepository */
    private $kingdomTitleRepository;

    public function __construct(KingdomTitleRepository $kingdomTitleRepo)
    {
        $this->kingdomTitleRepository = $kingdomTitleRepo;
    }

    /**
     * @OA\Get(
     *      path="/kingdom-titles",
     *      summary="getKingdomTitleList",
     *      tags={"KingdomTitle"},
     *      description="Get all KingdomTitles",
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
     *                  @OA\Items(ref="#/components/schemas/KingdomTitle")
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
        $kingdomTitles = $this->kingdomTitleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(KingdomTitleResource::collection($kingdomTitles), 'Kingdom Titles retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/kingdom-titles",
     *      summary="createKingdomTitle",
     *      tags={"KingdomTitle"},
     *      description="Create KingdomTitle",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/KingdomTitle")
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
     *                  ref="#/components/schemas/KingdomTitle"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateKingdomTitleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $kingdomTitle = $this->kingdomTitleRepository->create($input);

        return $this->sendResponse(new KingdomTitleResource($kingdomTitle), 'Kingdom Title saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/kingdom-titles/{id}",
     *      summary="getKingdomTitleItem",
     *      tags={"KingdomTitle"},
     *      description="Get KingdomTitle",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomTitle",
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
     *                  ref="#/components/schemas/KingdomTitle"
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
        /** @var KingdomTitle $kingdomTitle */
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            return $this->sendError('Kingdom Title not found');
        }

        return $this->sendResponse(new KingdomTitleResource($kingdomTitle), 'Kingdom Title retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/kingdom-titles/{id}",
     *      summary="updateKingdomTitle",
     *      tags={"KingdomTitle"},
     *      description="Update KingdomTitle",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomTitle",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/KingdomTitle")
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
     *                  ref="#/components/schemas/KingdomTitle"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateKingdomTitleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var KingdomTitle $kingdomTitle */
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            return $this->sendError('Kingdom Title not found');
        }

        $kingdomTitle = $this->kingdomTitleRepository->update($input, $id);

        return $this->sendResponse(new KingdomTitleResource($kingdomTitle), 'KingdomTitle updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/kingdom-titles/{id}",
     *      summary="deleteKingdomTitle",
     *      tags={"KingdomTitle"},
     *      description="Delete KingdomTitle",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomTitle",
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
        /** @var KingdomTitle $kingdomTitle */
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            return $this->sendError('Kingdom Title not found');
        }

        $kingdomTitle->delete();

        return $this->sendSuccess('Kingdom Title deleted successfully');
    }
}
