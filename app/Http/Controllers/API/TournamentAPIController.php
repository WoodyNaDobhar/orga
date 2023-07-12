<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTournamentAPIRequest;
use App\Http\Requests\API\UpdateTournamentAPIRequest;
use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TournamentResource;

/**
 * Class TournamentController
 */

class TournamentAPIController extends AppBaseController
{
    /** @var  TournamentRepository */
    private $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepo)
    {
        $this->tournamentRepository = $tournamentRepo;
    }

    /**
     * @OA\Get(
     *      path="/tournaments",
     *      summary="getTournamentList",
     *      tags={"Tournament"},
     *      description="Get all Tournaments",
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
     *                  @OA\Items(ref="#/components/schemas/Tournament")
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
        $tournaments = $this->tournamentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TournamentResource::collection($tournaments), 'Tournaments retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/tournaments",
     *      summary="createTournament",
     *      tags={"Tournament"},
     *      description="Create Tournament",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tournament")
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
     *                  ref="#/components/schemas/Tournament"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTournamentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $tournament = $this->tournamentRepository->create($input);

        return $this->sendResponse(new TournamentResource($tournament), 'Tournament saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/tournaments/{id}",
     *      summary="getTournamentItem",
     *      tags={"Tournament"},
     *      description="Get Tournament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tournament",
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
     *                  ref="#/components/schemas/Tournament"
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
        /** @var Tournament $tournament */
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            return $this->sendError('Tournament not found');
        }

        return $this->sendResponse(new TournamentResource($tournament), 'Tournament retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/tournaments/{id}",
     *      summary="updateTournament",
     *      tags={"Tournament"},
     *      description="Update Tournament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tournament",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tournament")
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
     *                  ref="#/components/schemas/Tournament"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTournamentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Tournament $tournament */
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            return $this->sendError('Tournament not found');
        }

        $tournament = $this->tournamentRepository->update($input, $id);

        return $this->sendResponse(new TournamentResource($tournament), 'Tournament updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/tournaments/{id}",
     *      summary="deleteTournament",
     *      tags={"Tournament"},
     *      description="Delete Tournament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tournament",
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
        /** @var Tournament $tournament */
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            return $this->sendError('Tournament not found');
        }

        $tournament->delete();

        return $this->sendSuccess('Tournament deleted successfully');
    }
}
