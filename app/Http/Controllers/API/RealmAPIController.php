<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKingdomAPIRequest;
use App\Http\Requests\API\UpdateKingdomAPIRequest;
use App\Models\Realm;
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
     *      tags={"Realm"},
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
     *                  @OA\Items(ref="#/components/schemas/Realm")
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
     *      tags={"Realm"},
     *      description="Create Realm",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Realm")
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
     *                  ref="#/components/schemas/Realm"
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

        $realm = $this->kingdomRepository->create($input);

        return $this->sendResponse(new KingdomResource($realm), 'Realm saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/kingdoms/{id}",
     *      summary="getKingdomItem",
     *      tags={"Realm"},
     *      description="Get Realm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Realm",
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
     *                  ref="#/components/schemas/Realm"
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
        /** @var Realm $realm */
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        return $this->sendResponse(new KingdomResource($realm), 'Realm retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/kingdoms/{id}",
     *      summary="updateKingdom",
     *      tags={"Realm"},
     *      description="Update Realm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Realm",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Realm")
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
     *                  ref="#/components/schemas/Realm"
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

        /** @var Realm $realm */
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        $realm = $this->kingdomRepository->update($input, $id);

        return $this->sendResponse(new KingdomResource($realm), 'Realm updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/kingdoms/{id}",
     *      summary="deleteKingdom",
     *      tags={"Realm"},
     *      description="Delete Realm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Realm",
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
        /** @var Realm $realm */
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        $realm->delete();

        return $this->sendSuccess('Realm deleted successfully');
    }
}
