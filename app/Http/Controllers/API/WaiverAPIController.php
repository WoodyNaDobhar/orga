<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWaiverAPIRequest;
use App\Http\Requests\API\UpdateWaiverAPIRequest;
use App\Models\Waiver;
use App\Repositories\WaiverRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\WaiverResource;

/**
 * Class WaiverController
 */

class WaiverAPIController extends AppBaseController
{
    /** @var  WaiverRepository */
    private $waiverRepository;

    public function __construct(WaiverRepository $waiverRepo)
    {
        $this->waiverRepository = $waiverRepo;
    }

    /**
     * @OA\Get(
     *      path="/waivers",
     *      summary="getWaiverList",
     *      tags={"Waiver"},
     *      description="Get all Waivers",
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
     *                  @OA\Items(ref="#/components/schemas/Waiver")
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
        $waivers = $this->waiverRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(WaiverResource::collection($waivers), 'Waivers retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/waivers",
     *      summary="createWaiver",
     *      tags={"Waiver"},
     *      description="Create Waiver",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Waiver")
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
     *                  ref="#/components/schemas/Waiver"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateWaiverAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $waiver = $this->waiverRepository->create($input);

        return $this->sendResponse(new WaiverResource($waiver), 'Waiver saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/waivers/{id}",
     *      summary="getWaiverItem",
     *      tags={"Waiver"},
     *      description="Get Waiver",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Waiver",
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
     *                  ref="#/components/schemas/Waiver"
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
        /** @var Waiver $waiver */
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            return $this->sendError('Waiver not found');
        }

        return $this->sendResponse(new WaiverResource($waiver), 'Waiver retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/waivers/{id}",
     *      summary="updateWaiver",
     *      tags={"Waiver"},
     *      description="Update Waiver",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Waiver",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Waiver")
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
     *                  ref="#/components/schemas/Waiver"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateWaiverAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Waiver $waiver */
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            return $this->sendError('Waiver not found');
        }

        $waiver = $this->waiverRepository->update($input, $id);

        return $this->sendResponse(new WaiverResource($waiver), 'Waiver updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/waivers/{id}",
     *      summary="deleteWaiver",
     *      tags={"Waiver"},
     *      description="Delete Waiver",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Waiver",
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
        /** @var Waiver $waiver */
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            return $this->sendError('Waiver not found');
        }

        $waiver->delete();

        return $this->sendSuccess('Waiver deleted successfully');
    }
}
