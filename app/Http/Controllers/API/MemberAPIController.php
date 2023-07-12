<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMemberAPIRequest;
use App\Http\Requests\API\UpdateMemberAPIRequest;
use App\Models\Member;
use App\Repositories\MemberRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MemberResource;

/**
 * Class MemberController
 */

class MemberAPIController extends AppBaseController
{
    /** @var  MemberRepository */
    private $memberRepository;

    public function __construct(MemberRepository $memberRepo)
    {
        $this->memberRepository = $memberRepo;
    }

    /**
     * @OA\Get(
     *      path="/members",
     *      summary="getMemberList",
     *      tags={"Member"},
     *      description="Get all Members",
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
     *                  @OA\Items(ref="#/components/schemas/Member")
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
        $members = $this->memberRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(MemberResource::collection($members), 'Members retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/members",
     *      summary="createMember",
     *      tags={"Member"},
     *      description="Create Member",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Member")
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
     *                  ref="#/components/schemas/Member"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $member = $this->memberRepository->create($input);

        return $this->sendResponse(new MemberResource($member), 'Member saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/members/{id}",
     *      summary="getMemberItem",
     *      tags={"Member"},
     *      description="Get Member",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Member",
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
     *                  ref="#/components/schemas/Member"
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
        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        return $this->sendResponse(new MemberResource($member), 'Member retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/members/{id}",
     *      summary="updateMember",
     *      tags={"Member"},
     *      description="Update Member",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Member",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Member")
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
     *                  ref="#/components/schemas/Member"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        $member = $this->memberRepository->update($input, $id);

        return $this->sendResponse(new MemberResource($member), 'Member updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/members/{id}",
     *      summary="deleteMember",
     *      tags={"Member"},
     *      description="Delete Member",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Member",
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
        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        $member->delete();

        return $this->sendSuccess('Member deleted successfully');
    }
}
