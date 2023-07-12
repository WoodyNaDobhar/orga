<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePronounAPIRequest;
use App\Http\Requests\API\UpdatePronounAPIRequest;
use App\Models\Pronoun;
use App\Repositories\PronounRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PronounResource;

/**
 * Class PronounController
 */

class PronounAPIController extends AppBaseController
{
    /** @var  PronounRepository */
    private $pronounRepository;

    public function __construct(PronounRepository $pronounRepo)
    {
        $this->pronounRepository = $pronounRepo;
    }

    /**
     * @OA\Get(
     *      path="/pronouns",
     *      summary="getPronounList",
     *      tags={"Pronoun"},
     *      description="Get all Pronouns",
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
     *                  @OA\Items(ref="#/components/schemas/Pronoun")
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
        $pronouns = $this->pronounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PronounResource::collection($pronouns), 'Pronouns retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/pronouns",
     *      summary="createPronoun",
     *      tags={"Pronoun"},
     *      description="Create Pronoun",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Pronoun")
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
     *                  ref="#/components/schemas/Pronoun"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePronounAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pronoun = $this->pronounRepository->create($input);

        return $this->sendResponse(new PronounResource($pronoun), 'Pronoun saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/pronouns/{id}",
     *      summary="getPronounItem",
     *      tags={"Pronoun"},
     *      description="Get Pronoun",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pronoun",
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
     *                  ref="#/components/schemas/Pronoun"
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
        /** @var Pronoun $pronoun */
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            return $this->sendError('Pronoun not found');
        }

        return $this->sendResponse(new PronounResource($pronoun), 'Pronoun retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/pronouns/{id}",
     *      summary="updatePronoun",
     *      tags={"Pronoun"},
     *      description="Update Pronoun",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pronoun",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Pronoun")
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
     *                  ref="#/components/schemas/Pronoun"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePronounAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Pronoun $pronoun */
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            return $this->sendError('Pronoun not found');
        }

        $pronoun = $this->pronounRepository->update($input, $id);

        return $this->sendResponse(new PronounResource($pronoun), 'Pronoun updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/pronouns/{id}",
     *      summary="deletePronoun",
     *      tags={"Pronoun"},
     *      description="Delete Pronoun",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pronoun",
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
        /** @var Pronoun $pronoun */
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            return $this->sendError('Pronoun not found');
        }

        $pronoun->delete();

        return $this->sendSuccess('Pronoun deleted successfully');
    }
}
