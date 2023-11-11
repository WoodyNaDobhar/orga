<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateChapterAPIRequest;
use App\Http\Requests\API\UpdateChapterAPIRequest;
use App\Models\Chapter;
use App\Repositories\ChapterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ChapterResource;

/**
 * Class ChapterController
 */

class ChapterAPIController extends AppBaseController
{
    /** @var  ChapterRepository */
    private $chapterRepository;

    public function __construct(ChapterRepository $chapterRepo)
    {
        $this->chapterRepository = $chapterRepo;
    }

    /**
     * @OA\Get(
     *      path="/chapters",
     *      summary="getChapterList",
     *      tags={"Chapter"},
     *      description="Get all Chapters",
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
     *                  @OA\Items(ref="#/components/schemas/Chapter")
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
        $chapters = $this->chapterRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ChapterResource::collection($chapters), 'Chapters retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/chapters",
     *      summary="createChapter",
     *      tags={"Chapter"},
     *      description="Create Chapter",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Chapter")
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
     *                  ref="#/components/schemas/Chapter"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateChapterAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $chapter = $this->chapterRepository->create($input);

        return $this->sendResponse(new ChapterResource($chapter), 'Chapter saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/chapters/{id}",
     *      summary="getChapterItem",
     *      tags={"Chapter"},
     *      description="Get Chapter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chapter",
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
     *                  ref="#/components/schemas/Chapter"
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
        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->find($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        return $this->sendResponse(new ChapterResource($chapter), 'Chapter retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/chapters/{id}",
     *      summary="updateChapter",
     *      tags={"Chapter"},
     *      description="Update Chapter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chapter",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Chapter")
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
     *                  ref="#/components/schemas/Chapter"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateChapterAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->find($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        $chapter = $this->chapterRepository->update($input, $id);

        return $this->sendResponse(new ChapterResource($chapter), 'Chapter updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/chapters/{id}",
     *      summary="deleteChapter",
     *      tags={"Chapter"},
     *      description="Delete Chapter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Chapter",
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
        /** @var Chapter $chapter */
        $chapter = $this->chapterRepository->find($id);

        if (empty($chapter)) {
            return $this->sendError('Chapter not found');
        }

        $chapter->delete();

        return $this->sendSuccess('Chapter deleted successfully');
    }
}
