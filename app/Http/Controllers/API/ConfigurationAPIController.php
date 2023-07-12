<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateConfigurationAPIRequest;
use App\Http\Requests\API\UpdateConfigurationAPIRequest;
use App\Models\Configuration;
use App\Repositories\ConfigurationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ConfigurationResource;

/**
 * Class ConfigurationController
 */

class ConfigurationAPIController extends AppBaseController
{
    /** @var  ConfigurationRepository */
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepo)
    {
        $this->configurationRepository = $configurationRepo;
    }

    /**
     * @OA\Get(
     *      path="/configurations",
     *      summary="getConfigurationList",
     *      tags={"Configuration"},
     *      description="Get all Configurations",
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
     *                  @OA\Items(ref="#/components/schemas/Configuration")
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
        $configurations = $this->configurationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ConfigurationResource::collection($configurations), 'Configurations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/configurations",
     *      summary="createConfiguration",
     *      tags={"Configuration"},
     *      description="Create Configuration",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Configuration")
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
     *                  ref="#/components/schemas/Configuration"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConfigurationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $configuration = $this->configurationRepository->create($input);

        return $this->sendResponse(new ConfigurationResource($configuration), 'Configuration saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/configurations/{id}",
     *      summary="getConfigurationItem",
     *      tags={"Configuration"},
     *      description="Get Configuration",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Configuration",
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
     *                  ref="#/components/schemas/Configuration"
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
        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        return $this->sendResponse(new ConfigurationResource($configuration), 'Configuration retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/configurations/{id}",
     *      summary="updateConfiguration",
     *      tags={"Configuration"},
     *      description="Update Configuration",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Configuration",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Configuration")
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
     *                  ref="#/components/schemas/Configuration"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConfigurationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        $configuration = $this->configurationRepository->update($input, $id);

        return $this->sendResponse(new ConfigurationResource($configuration), 'Configuration updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/configurations/{id}",
     *      summary="deleteConfiguration",
     *      tags={"Configuration"},
     *      description="Delete Configuration",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Configuration",
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
        /** @var Configuration $configuration */
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            return $this->sendError('Configuration not found');
        }

        $configuration->delete();

        return $this->sendSuccess('Configuration deleted successfully');
    }
}
