<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCratAPIRequest;
use App\Http\Requests\API\UpdateCratAPIRequest;
use App\Models\Crat;
use App\Repositories\CratRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CratResource;

/**
 * Class CratController
 */

class CratAPIController extends AppBaseController
{
    /** @var  CratRepository */
    private $cratRepository;

    public function __construct(CratRepository $cratRepo)
    {
        $this->cratRepository = $cratRepo;
    }

    /**
     * @OA\Get(
     *      path="/crats",
     *      summary="getCratList",
     *      tags={"Crat"},
     *      description="Get all Crats",
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
     *                  @OA\Items(ref="#/components/schemas/Crat")
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
        $crats = $this->cratRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CratResource::collection($crats), 'Crats retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/crats",
     *      summary="createCrat",
     *      tags={"Crat"},
     *      description="Create Crat",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Crat")
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
     *                  ref="#/components/schemas/Crat"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCratAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $crat = $this->cratRepository->create($input);

        return $this->sendResponse(new CratResource($crat), 'Crat saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/crats/{id}",
     *      summary="getCratItem",
     *      tags={"Crat"},
     *      description="Get Crat",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Crat",
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
     *                  ref="#/components/schemas/Crat"
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
        /** @var Crat $crat */
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            return $this->sendError('Crat not found');
        }

        return $this->sendResponse(new CratResource($crat), 'Crat retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/crats/{id}",
     *      summary="updateCrat",
     *      tags={"Crat"},
     *      description="Update Crat",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Crat",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Crat")
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
     *                  ref="#/components/schemas/Crat"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCratAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Crat $crat */
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            return $this->sendError('Crat not found');
        }

        $crat = $this->cratRepository->update($input, $id);

        return $this->sendResponse(new CratResource($crat), 'Crat updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/crats/{id}",
     *      summary="deleteCrat",
     *      tags={"Crat"},
     *      description="Delete Crat",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Crat",
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
        /** @var Crat $crat */
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            return $this->sendError('Crat not found');
        }

        $crat->delete();

        return $this->sendSuccess('Crat deleted successfully');
    }
}
