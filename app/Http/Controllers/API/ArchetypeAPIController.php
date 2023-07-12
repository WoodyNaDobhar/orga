<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateArchetypeAPIRequest;
use App\Http\Requests\API\UpdateArchetypeAPIRequest;
use App\Models\Archetype;
use App\Repositories\ArchetypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ArchetypeResource;

/**
 * Class ArchetypeController
 */

class ArchetypeAPIController extends AppBaseController
{
    /** @var  ArchetypeRepository */
    private $archetypeRepository;

    public function __construct(ArchetypeRepository $archetypeRepo)
    {
        $this->archetypeRepository = $archetypeRepo;
    }

    /**
     * @OA\Get(
     *      path="/archetypes",
     *      summary="getArchetypeList",
     *      tags={"Archetype"},
     *      description="Get all Archetypes",
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
     *                  @OA\Items(ref="#/components/schemas/Archetype")
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
        $archetypes = $this->archetypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ArchetypeResource::collection($archetypes), 'Archetypes retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/archetypes",
     *      summary="createArchetype",
     *      tags={"Archetype"},
     *      description="Create Archetype",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Archetype")
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
     *                  ref="#/components/schemas/Archetype"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateArchetypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $archetype = $this->archetypeRepository->create($input);

        return $this->sendResponse(new ArchetypeResource($archetype), 'Archetype saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/archetypes/{id}",
     *      summary="getArchetypeItem",
     *      tags={"Archetype"},
     *      description="Get Archetype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Archetype",
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
     *                  ref="#/components/schemas/Archetype"
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
        /** @var Archetype $archetype */
        $archetype = $this->archetypeRepository->find($id);

        if (empty($archetype)) {
            return $this->sendError('Archetype not found');
        }

        return $this->sendResponse(new ArchetypeResource($archetype), 'Archetype retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/archetypes/{id}",
     *      summary="updateArchetype",
     *      tags={"Archetype"},
     *      description="Update Archetype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Archetype",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Archetype")
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
     *                  ref="#/components/schemas/Archetype"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateArchetypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Archetype $archetype */
        $archetype = $this->archetypeRepository->find($id);

        if (empty($archetype)) {
            return $this->sendError('Archetype not found');
        }

        $archetype = $this->archetypeRepository->update($input, $id);

        return $this->sendResponse(new ArchetypeResource($archetype), 'Archetype updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/archetypes/{id}",
     *      summary="deleteArchetype",
     *      tags={"Archetype"},
     *      description="Delete Archetype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Archetype",
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
        /** @var Archetype $archetype */
        $archetype = $this->archetypeRepository->find($id);

        if (empty($archetype)) {
            return $this->sendError('Archetype not found');
        }

        $archetype->delete();

        return $this->sendSuccess('Archetype deleted successfully');
    }
}
