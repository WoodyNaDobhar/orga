<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRealmAPIRequest;
use App\Http\Requests\API\UpdateRealmAPIRequest;
use App\Models\Realm;
use App\Repositories\RealmRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\RealmResource;

/**
 * Class RealmController
 */

class RealmAPIController extends AppBaseController
{
    /** @var  RealmRepository */
    private $realmRepository;

    public function __construct(RealmRepository $realmRepo)
    {
        $this->realmRepository = $realmRepo;
    }

    /**
     * @OA\Get(
     *      path="/realms",
     *      summary="getRealmList",
     *      tags={"Realm"},
     *      description="Get all Realms",
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
        $realms = $this->realmRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(RealmResource::collection($realms), 'Realms retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/realms",
     *      summary="createRealm",
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
    public function store(CreateRealmAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $realm = $this->realmRepository->create($input);

        return $this->sendResponse(new RealmResource($realm), 'Realm saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/realms/{id}",
     *      summary="getRealmItem",
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
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        return $this->sendResponse(new RealmResource($realm), 'Realm retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/realms/{id}",
     *      summary="updateRealm",
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
    public function update($id, UpdateRealmAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Realm $realm */
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        $realm = $this->realmRepository->update($input, $id);

        return $this->sendResponse(new RealmResource($realm), 'Realm updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/realms/{id}",
     *      summary="deleteRealm",
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
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            return $this->sendError('Realm not found');
        }

        $realm->delete();

        return $this->sendSuccess('Realm deleted successfully');
    }
}
