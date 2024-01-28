<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSocialAPIRequest;
use App\Http\Requests\API\UpdateSocialAPIRequest;
use App\Models\Social;
use App\Repositories\SocialRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SocialResource;

/**
 * Class SocialController
 */

class SocialAPIController extends AppBaseController
{
    /** @var  SocialRepository */
    private $socialRepository;

    public function __construct(SocialRepository $socialRepo)
    {
        $this->socialRepository = $socialRepo;
    }

    /**
     * @OA\Get(
     *      path="/socials",
     *      summary="getSocialList",
     *      tags={"Social"},
     *      description="Get all Socials",
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
     *                  @OA\Items(ref="#/components/schemas/Social")
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
        $socials = $this->socialRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SocialResource::collection($socials), 'Socials retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/socials",
     *      summary="createSocial",
     *      tags={"Social"},
     *      description="Create Social",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Social")
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
     *                  ref="#/components/schemas/Social"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSocialAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $social = $this->socialRepository->create($input);

        return $this->sendResponse(new SocialResource($social), 'Social saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/socials/{id}",
     *      summary="getSocialItem",
     *      tags={"Social"},
     *      description="Get Social",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Social",
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
     *                  ref="#/components/schemas/Social"
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
        /** @var Social $social */
        $social = $this->socialRepository->find($id);

        if (empty($social)) {
            return $this->sendError('Social not found');
        }

        return $this->sendResponse(new SocialResource($social), 'Social retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/socials/{id}",
     *      summary="updateSocial",
     *      tags={"Social"},
     *      description="Update Social",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Social",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Social")
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
     *                  ref="#/components/schemas/Social"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSocialAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Social $social */
        $social = $this->socialRepository->find($id);

        if (empty($social)) {
            return $this->sendError('Social not found');
        }

        $social = $this->socialRepository->update($input, $id);

        return $this->sendResponse(new SocialResource($social), 'Social updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/socials/{id}",
     *      summary="deleteSocial",
     *      tags={"Social"},
     *      description="Delete Social",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Social",
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
        /** @var Social $social */
        $social = $this->socialRepository->find($id);

        if (empty($social)) {
            return $this->sendError('Social not found');
        }

        $social->delete();

        return $this->sendSuccess('Social deleted successfully');
    }
}
