<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateChaptertypeAPIRequest;
use App\Http\Requests\API\UpdateChaptertypeAPIRequest;
use App\Models\Chaptertype;
use App\Repositories\ChaptertypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ChaptertypeResource;

/**
 * Class ChaptertypeController
 */

class ChaptertypeAPIController extends AppBaseController
{
    /** @var  ChaptertypeRepository */
    private $chaptertypeRepository;

    public function __construct(ChaptertypeRepository $chaptertypeRepo)
    {
        $this->chaptertypeRepository = $chaptertypeRepo;
    }

    /**
     * @OA\Get(
     *      path="/chaptertypes",
     *      summary="getChaptertypeList",
     *      tags={"Chaptertype"},
     *      description="Get all Chaptertypes",
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
     *                  @OA\Items(ref="#/components/schemas/Chaptertype")
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
        $chaptertypes = $this->chaptertypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ChaptertypeResource::collection($chaptertypes), 'Chaptertypes retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/chaptertypes",
     *      summary="createChaptertype",
     *      tags={"Chaptertype"},
     *      description="Create Chaptertype",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Chaptertype")
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
     *                  ref="#/components/schemas/Chaptertype"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateChaptertypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $chaptertype = $this->chaptertypeRepository->create($input);

        return $this->sendResponse(new ChaptertypeResource($chaptertype), 'Chaptertype saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/chaptertypes/{id}",
     *      summary="getChaptertypeItem",
     *      tags={"Chaptertype"},
     *      description="Get Chaptertype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chaptertype",
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
     *                  ref="#/components/schemas/Chaptertype"
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
        /** @var Chaptertype $chaptertype */
        $chaptertype = $this->chaptertypeRepository->find($id);

        if (empty($chaptertype)) {
            return $this->sendError('Chaptertype not found');
        }

        return $this->sendResponse(new ChaptertypeResource($chaptertype), 'Chaptertype retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/chaptertypes/{id}",
     *      summary="updateChaptertype",
     *      tags={"Chaptertype"},
     *      description="Update Chaptertype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chaptertype",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Chaptertype")
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
     *                  ref="#/components/schemas/Chaptertype"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateChaptertypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Chaptertype $chaptertype */
        $chaptertype = $this->chaptertypeRepository->find($id);

        if (empty($chaptertype)) {
            return $this->sendError('Chaptertype not found');
        }

        $chaptertype = $this->chaptertypeRepository->update($input, $id);

        return $this->sendResponse(new ChaptertypeResource($chaptertype), 'Chaptertype updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/chaptertypes/{id}",
     *      summary="deleteChaptertype",
     *      tags={"Chaptertype"},
     *      description="Delete Chaptertype",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chaptertype",
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
        /** @var Chaptertype $chaptertype */
        $chaptertype = $this->chaptertypeRepository->find($id);

        if (empty($chaptertype)) {
            return $this->sendError('Chaptertype not found');
        }

        $chaptertype->delete();

        return $this->sendSuccess('Chaptertype deleted successfully');
    }
}
