<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReignAPIRequest;
use App\Http\Requests\API\UpdateReignAPIRequest;
use App\Models\Reign;
use App\Repositories\ReignRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ReignResource;

/**
 * Class ReignController
 */

class ReignAPIController extends AppBaseController
{
    /** @var  ReignRepository */
    private $reignRepository;

    public function __construct(ReignRepository $reignRepo)
    {
        $this->reignRepository = $reignRepo;
    }

    /**
     * @OA\Get(
     *      path="/reigns",
     *      summary="getReignList",
     *      tags={"Reign"},
     *      description="Get all Reigns",
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
     *                  @OA\Items(ref="#/components/schemas/Reign")
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
        $reigns = $this->reignRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ReignResource::collection($reigns), 'Reigns retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/reigns",
     *      summary="createReign",
     *      tags={"Reign"},
     *      description="Create Reign",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Reign")
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
     *                  ref="#/components/schemas/Reign"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReignAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $reign = $this->reignRepository->create($input);

        return $this->sendResponse(new ReignResource($reign), 'Reign saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/reigns/{id}",
     *      summary="getReignItem",
     *      tags={"Reign"},
     *      description="Get Reign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reign",
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
     *                  ref="#/components/schemas/Reign"
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
        /** @var Reign $reign */
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            return $this->sendError('Reign not found');
        }

        return $this->sendResponse(new ReignResource($reign), 'Reign retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/reigns/{id}",
     *      summary="updateReign",
     *      tags={"Reign"},
     *      description="Update Reign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reign",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Reign")
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
     *                  ref="#/components/schemas/Reign"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReignAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Reign $reign */
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            return $this->sendError('Reign not found');
        }

        $reign = $this->reignRepository->update($input, $id);

        return $this->sendResponse(new ReignResource($reign), 'Reign updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/reigns/{id}",
     *      summary="deleteReign",
     *      tags={"Reign"},
     *      description="Delete Reign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reign",
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
        /** @var Reign $reign */
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            return $this->sendError('Reign not found');
        }

        $reign->delete();

        return $this->sendSuccess('Reign deleted successfully');
    }
}
