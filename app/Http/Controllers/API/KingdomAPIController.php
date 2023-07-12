<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKingdomAPIRequest;
use App\Http\Requests\API\UpdateKingdomAPIRequest;
use App\Models\Kingdom;
use App\Repositories\KingdomRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\KingdomResource;

/**
 * Class KingdomController
 */

class KingdomAPIController extends AppBaseController
{
    /** @var  KingdomRepository */
    private $kingdomRepository;

    public function __construct(KingdomRepository $kingdomRepo)
    {
        $this->kingdomRepository = $kingdomRepo;
    }

    /**
     * @OA\Get(
     *      path="/kingdoms",
     *      summary="getKingdomList",
     *      tags={"Kingdom"},
     *      description="Get all Kingdoms",
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
     *                  @OA\Items(ref="#/components/schemas/Kingdom")
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
        $kingdoms = $this->kingdomRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(KingdomResource::collection($kingdoms), 'Kingdoms retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/kingdoms",
     *      summary="createKingdom",
     *      tags={"Kingdom"},
     *      description="Create Kingdom",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Kingdom")
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
     *                  ref="#/components/schemas/Kingdom"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateKingdomAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $kingdom = $this->kingdomRepository->create($input);

        return $this->sendResponse(new KingdomResource($kingdom), 'Kingdom saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/kingdoms/{id}",
     *      summary="getKingdomItem",
     *      tags={"Kingdom"},
     *      description="Get Kingdom",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Kingdom",
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
     *                  ref="#/components/schemas/Kingdom"
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
        /** @var Kingdom $kingdom */
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            return $this->sendError('Kingdom not found');
        }

        return $this->sendResponse(new KingdomResource($kingdom), 'Kingdom retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/kingdoms/{id}",
     *      summary="updateKingdom",
     *      tags={"Kingdom"},
     *      description="Update Kingdom",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Kingdom",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Kingdom")
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
     *                  ref="#/components/schemas/Kingdom"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateKingdomAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Kingdom $kingdom */
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            return $this->sendError('Kingdom not found');
        }

        $kingdom = $this->kingdomRepository->update($input, $id);

        return $this->sendResponse(new KingdomResource($kingdom), 'Kingdom updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/kingdoms/{id}",
     *      summary="deleteKingdom",
     *      tags={"Kingdom"},
     *      description="Delete Kingdom",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Kingdom",
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
        /** @var Kingdom $kingdom */
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            return $this->sendError('Kingdom not found');
        }

        $kingdom->delete();

        return $this->sendSuccess('Kingdom deleted successfully');
    }
}
