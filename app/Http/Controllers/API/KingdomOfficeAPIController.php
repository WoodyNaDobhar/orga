<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKingdomOfficeAPIRequest;
use App\Http\Requests\API\UpdateKingdomOfficeAPIRequest;
use App\Models\KingdomOffice;
use App\Repositories\KingdomOfficeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\KingdomOfficeResource;

/**
 * Class KingdomOfficeController
 */

class KingdomOfficeAPIController extends AppBaseController
{
    /** @var  KingdomOfficeRepository */
    private $kingdomOfficeRepository;

    public function __construct(KingdomOfficeRepository $kingdomOfficeRepo)
    {
        $this->kingdomOfficeRepository = $kingdomOfficeRepo;
    }

    /**
     * @OA\Get(
     *      path="/kingdom-offices",
     *      summary="getKingdomOfficeList",
     *      tags={"KingdomOffice"},
     *      description="Get all KingdomOffices",
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
     *                  @OA\Items(ref="#/components/schemas/KingdomOffice")
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
        $kingdomOffices = $this->kingdomOfficeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(KingdomOfficeResource::collection($kingdomOffices), 'Kingdom Offices retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/kingdom-offices",
     *      summary="createKingdomOffice",
     *      tags={"KingdomOffice"},
     *      description="Create KingdomOffice",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/KingdomOffice")
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
     *                  ref="#/components/schemas/KingdomOffice"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateKingdomOfficeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $kingdomOffice = $this->kingdomOfficeRepository->create($input);

        return $this->sendResponse(new KingdomOfficeResource($kingdomOffice), 'Kingdom Office saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/kingdom-offices/{id}",
     *      summary="getKingdomOfficeItem",
     *      tags={"KingdomOffice"},
     *      description="Get KingdomOffice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomOffice",
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
     *                  ref="#/components/schemas/KingdomOffice"
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
        /** @var KingdomOffice $kingdomOffice */
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            return $this->sendError('Kingdom Office not found');
        }

        return $this->sendResponse(new KingdomOfficeResource($kingdomOffice), 'Kingdom Office retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/kingdom-offices/{id}",
     *      summary="updateKingdomOffice",
     *      tags={"KingdomOffice"},
     *      description="Update KingdomOffice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomOffice",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/KingdomOffice")
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
     *                  ref="#/components/schemas/KingdomOffice"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateKingdomOfficeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var KingdomOffice $kingdomOffice */
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            return $this->sendError('Kingdom Office not found');
        }

        $kingdomOffice = $this->kingdomOfficeRepository->update($input, $id);

        return $this->sendResponse(new KingdomOfficeResource($kingdomOffice), 'KingdomOffice updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/kingdom-offices/{id}",
     *      summary="deleteKingdomOffice",
     *      tags={"KingdomOffice"},
     *      description="Delete KingdomOffice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of KingdomOffice",
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
        /** @var KingdomOffice $kingdomOffice */
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            return $this->sendError('Kingdom Office not found');
        }

        $kingdomOffice->delete();

        return $this->sendSuccess('Kingdom Office deleted successfully');
    }
}
