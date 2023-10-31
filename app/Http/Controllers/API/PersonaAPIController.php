<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePersonaAPIRequest;
use App\Http\Requests\API\UpdatePersonaAPIRequest;
use App\Models\Persona;
use App\Repositories\PersonaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PersonaResource;

/**
 * Class PersonaController
 */

class PersonaAPIController extends AppBaseController
{
    /** @var  PersonaRepository */
    private $personaRepository;

    public function __construct(PersonaRepository $personaRepo)
    {
        $this->personaRepository = $personaRepo;
    }

    /**
     * @OA\Get(
     *      path="/personas",
     *      summary="getPersonaList",
     *      tags={"Persona"},
     *      description="Get all Personas",
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
     *                  @OA\Items(ref="#/components/schemas/Persona")
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
        $personas = $this->personaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PersonaResource::collection($personas), 'Personas retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/personas",
     *      summary="createPersona",
     *      tags={"Persona"},
     *      description="Create Persona",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Persona")
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
     *                  ref="#/components/schemas/Persona"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePersonaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $persona = $this->personaRepository->create($input);

        return $this->sendResponse(new PersonaResource($persona), 'Persona saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/personas/{id}",
     *      summary="getPersonaItem",
     *      tags={"Persona"},
     *      description="Get Persona",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Persona",
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
     *                  ref="#/components/schemas/Persona"
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
        /** @var Persona $persona */
        $persona = $this->personaRepository->find($id);

        if (empty($persona)) {
            return $this->sendError('Persona not found');
        }

        return $this->sendResponse(new PersonaResource($persona), 'Persona retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/personas/{id}",
     *      summary="updatePersona",
     *      tags={"Persona"},
     *      description="Update Persona",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Persona",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Persona")
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
     *                  ref="#/components/schemas/Persona"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePersonaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Persona $persona */
        $persona = $this->personaRepository->find($id);

        if (empty($persona)) {
            return $this->sendError('Persona not found');
        }

        $persona = $this->personaRepository->update($input, $id);

        return $this->sendResponse(new PersonaResource($persona), 'Persona updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/personas/{id}",
     *      summary="deletePersona",
     *      tags={"Persona"},
     *      description="Delete Persona",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Persona",
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
        /** @var Persona $persona */
        $persona = $this->personaRepository->find($id);

        if (empty($persona)) {
            return $this->sendError('Persona not found');
        }

        $persona->delete();

        return $this->sendSuccess('Persona deleted successfully');
    }
}
