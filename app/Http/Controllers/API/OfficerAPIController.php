<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOfficerAPIRequest;
use App\Http\Requests\API\UpdateOfficerAPIRequest;
use App\Models\Officer;
use App\Repositories\OfficerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\OfficerResource;

/**
 * Class OfficerController
 */

class OfficerAPIController extends AppBaseController
{
    /** @var  OfficerRepository */
    private $officerRepository;

    public function __construct(OfficerRepository $officerRepo)
    {
        $this->officerRepository = $officerRepo;
    }

    /**
     * @OA\Get(
     *      path="/officers",
     *      summary="getOfficerList",
     *      tags={"Officer"},
     *      description="Get all Officers",
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
     *                  @OA\Items(ref="#/components/schemas/Officer")
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
        $officers = $this->officerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(OfficerResource::collection($officers), 'Officers retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/officers",
     *      summary="createOfficer",
     *      tags={"Officer"},
     *      description="Create Officer",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Officer")
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
     *                  ref="#/components/schemas/Officer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOfficerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $officer = $this->officerRepository->create($input);

        return $this->sendResponse(new OfficerResource($officer), 'Officer saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/officers/{id}",
     *      summary="getOfficerItem",
     *      tags={"Officer"},
     *      description="Get Officer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Officer",
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
     *                  ref="#/components/schemas/Officer"
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
        /** @var Officer $officer */
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            return $this->sendError('Officer not found');
        }

        return $this->sendResponse(new OfficerResource($officer), 'Officer retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/officers/{id}",
     *      summary="updateOfficer",
     *      tags={"Officer"},
     *      description="Update Officer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Officer",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Officer")
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
     *                  ref="#/components/schemas/Officer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOfficerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Officer $officer */
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            return $this->sendError('Officer not found');
        }

        $officer = $this->officerRepository->update($input, $id);

        return $this->sendResponse(new OfficerResource($officer), 'Officer updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/officers/{id}",
     *      summary="deleteOfficer",
     *      tags={"Officer"},
     *      description="Delete Officer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Officer",
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
        /** @var Officer $officer */
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            return $this->sendError('Officer not found');
        }

        $officer->delete();

        return $this->sendSuccess('Officer deleted successfully');
    }
}
