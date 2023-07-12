<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTitleAPIRequest;
use App\Http\Requests\API\UpdateTitleAPIRequest;
use App\Models\Title;
use App\Repositories\TitleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TitleResource;

/**
 * Class TitleController
 */

class TitleAPIController extends AppBaseController
{
    /** @var  TitleRepository */
    private $titleRepository;

    public function __construct(TitleRepository $titleRepo)
    {
        $this->titleRepository = $titleRepo;
    }

    /**
     * @OA\Get(
     *      path="/titles",
     *      summary="getTitleList",
     *      tags={"Title"},
     *      description="Get all Titles",
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
     *                  @OA\Items(ref="#/components/schemas/Title")
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
        $titles = $this->titleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TitleResource::collection($titles), 'Titles retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/titles",
     *      summary="createTitle",
     *      tags={"Title"},
     *      description="Create Title",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Title")
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
     *                  ref="#/components/schemas/Title"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTitleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $title = $this->titleRepository->create($input);

        return $this->sendResponse(new TitleResource($title), 'Title saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/titles/{id}",
     *      summary="getTitleItem",
     *      tags={"Title"},
     *      description="Get Title",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Title",
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
     *                  ref="#/components/schemas/Title"
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
        /** @var Title $title */
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            return $this->sendError('Title not found');
        }

        return $this->sendResponse(new TitleResource($title), 'Title retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/titles/{id}",
     *      summary="updateTitle",
     *      tags={"Title"},
     *      description="Update Title",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Title",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Title")
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
     *                  ref="#/components/schemas/Title"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTitleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Title $title */
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            return $this->sendError('Title not found');
        }

        $title = $this->titleRepository->update($input, $id);

        return $this->sendResponse(new TitleResource($title), 'Title updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/titles/{id}",
     *      summary="deleteTitle",
     *      tags={"Title"},
     *      description="Delete Title",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Title",
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
        /** @var Title $title */
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            return $this->sendError('Title not found');
        }

        $title->delete();

        return $this->sendSuccess('Title deleted successfully');
    }
}
