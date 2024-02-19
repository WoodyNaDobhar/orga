<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAwardAPIRequest;
use App\Http\Requests\API\UpdateAwardAPIRequest;
use App\Models\Award;
use App\Repositories\AwardRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Helpers\AppHelper;
use Throwable;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AwardResource;

/**
 * Class AwardController
 * @package App\Http\Controllers\API
 */

class AwardAPIController extends AppBaseController
{
	
	use AuthorizesRequests;
	
    /** @var  AwardRepository */
    private $awardRepository;

    public function __construct(AwardRepository $awardRepo)
    {
        $this->awardRepository = $awardRepo;
    }

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/awards",
	 *		summary="Get a listing of the Awards.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Award"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full<br>The following relationships can be attached, and in the case of plural relations, searched:<br>
			awarder (Chapter, Realm, or Unit) (MorphTo): The Realm, Chapter, or Unit that Issues this Award.<br>
			issuances (Issuance) (MorphMany): Issuances of this Award.<br>
			recommendations (Recommendation) (MorphMany): Recommendations to Issue this Award.<br>
			createdBy (User) (BelongsTo): User that created it.<br>
			updatedBy (User) (BelongsTo): User that last updated it (if any).<br>
			deletedBy (User) (BelongsTo): User that deleted it (if any).",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/search"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/columns"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/with"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/limit"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/skip"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/sort"
	 *		),
	 *		@OA\Response(
	 *			response=200,
	 *			description="successful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="true",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Awards retrieved successfully."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=400,
	 *			description="unsuccessful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Exception"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/QueryParameters"
	 *							)
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=401,
	 *			description="unauthenticated",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Unauthenticated."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=403,
	 *			description="unauthorized",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="This action is unauthorized."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		)
	 *	)
	 */
	public function index(Request $request): JsonResponse
	{
		try {

// 			$this->authorize('viewAny', Award::class);
			$awards = $this->awardRepository->all(
				$request->has('search') ? $request->get('search') : [],
				$request->has('skip') && $request->has('limit') ? $request->get('skip') : null,
				$request->has('limit') ? $request->get('limit') : null,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null,
				$request->has('sort') ? $request->get('sort') : null
			);

			return $this->sendResponse(AwardResource::collection($awards), 'Awards retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param CreateAwardAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/awards",
	 *		summary="Store a newly created Award in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Award"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: full<br>Crats: none<br>Chapter Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/Award"},
	 *		@OA\Response(
	 *			response=200,
	 *			description="successful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="true",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Award saved successfully."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=400,
	 *			description="unsuccessful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Exception"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSuperSimple"
	 *							)
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=401,
	 *			description="unauthenticated",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Unauthenticated."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=403,
	 *			description="unauthorized",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="This action is unauthorized."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		)
	 *	)
	 */
	public function store(CreateAwardAPIRequest $request): JsonResponse
	{
		try {

			$this->authorize('create', Award::class);
			
			$input = $request->all();

			$award = $this->awardRepository->create($input);

			return $this->sendResponse(new AwardResource($award), 'Award saved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/awards/{id}",
	 *		summary="Display the specified Award",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Award"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full<br>The following relationships can be attached, and in the case of plural relations, searched:<br>
			awarder (Chapter, Realm, or Unit) (MorphTo): The Realm, Chapter, or Unit that Issues this Award.<br>
			issuances (Issuance) (MorphMany): Issuances of this Award.<br>
			recommendations (Recommendation) (MorphMany): Recommendations to Issue this Award.<br>
			createdBy (User) (BelongsTo): User that created it.<br>
			updatedBy (User) (BelongsTo): User that last updated it (if any).<br>
			deletedBy (User) (BelongsTo): User that deleted it (if any).",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/columns"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/with"
	 *		),
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Award",
	 *			@OA\Schema(
	 *				type="integer"
	 *			),
	 *			required=true,
	 *			example=42
	 *		),
	 *		@OA\Response(
	 *			response=200,
	 *			description="successful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="true",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Award retrieved successfully."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=400,
	 *			description="unsuccessful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Exception"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/SimpleQueryParameters"
	 *							)
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=401,
	 *			description="unauthenticated",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Unauthenticated."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=403,
	 *			description="unauthorized",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="This action is unauthorized."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		)
	 *	)
	 */
	public function show($id, Request $request): JsonResponse
	{
		try {
			/** @var Award $award */
			$award = $this->awardRepository->find(
				$id,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null
			);
			
			if (empty($award)) {
				return $this->sendError('Award (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
// 			$this->authorize('view', $award);

			return $this->sendResponse(new AwardResource($award), 'Award retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @param UpdateAwardAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/awards/{id}",
	 *		summary="Update the specified Award in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Award"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: related<br>Crats: none<br>Chapter Officers: related<br>Admins: full",
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Award",
	 *			@OA\Schema(
	 *				type="integer"
	 *			),
	 *			required=true,
	 *			example=42
	 *		),
	 *		@OA\Parameter(
	 *			in="query",
	 *			name="_method",
	 *			description="This is a patch for swagger-ui, to send form data.  If you're sending json content, and using PUT method, it's not really required.",
	 *			@OA\Schema(
	 *				type="string"
	 *			),
	 *			required=true,
	 *			example="Put"
	 *		),
	 *		requestBody={"$ref": "#/components/requestBodies/Award"},
	 *		@OA\Response(
	 *			response=200,
	 *			description="successful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="true",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Award updated successfully."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=400,
	 *			description="unsuccessful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Exception"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSuperSimple"
	 *							)
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=401,
	 *			description="unauthenticated",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Unauthenticated."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=403,
	 *			description="unauthorized",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="This action is unauthorized."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		)
	 *	)
	 */
	public function update($id, UpdateAwardAPIRequest $request): JsonResponse
	{
		try {
			$input = $request->all();

			/** @var Award $Award */
			$Award = $this->AwardRepository->find($id);

			if (empty($Award)) {
				return $this->sendError('Award (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('update', $Award);

			$Award = $this->AwardRepository->update($input, $id);

			return $this->sendResponse(new AwardResource($Award), 'Award updated successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @return Response
	 *
	 * @OA\Delete(
	 *		path="/awards/{id}",
	 *		summary="Remove the specified Award from storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Award"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: related<br>Crats: none<br>Chapter Officers: related<br>Admins: full",
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Award",
	 *			@OA\Schema(
	 *				type="integer"
	 *			),
	 *			required=true,
	 *			example=42
	 *		),
	 *		@OA\Response(
	 *			response=200,
	 *			description="successful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="true",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								ref="#/components/schemas/AwardSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Award deleted successfully."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=400,
	 *			description="unsuccessful operation",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Exception"
	 *						),
	 *						@OA\Property(
	 *							property="data",
	 *							type="array",
	 *							@OA\Items(
	 *								@OA\Property(
	 *									property="id",
	 *									description="The entry's ID.",
	 *									type="integer",
	 *									format="int32",
	 *									example=42
	 *								)
	 *							)
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=401,
	 *			description="unauthenticated",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Unauthenticated."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		),
	 *		@OA\Response(
	 *			response=403,
	 *			description="unauthorized",
	 *			content={
	 *				@OA\MediaType(
	 *					mediaType="application/json",
	 *					@OA\Schema(
	 *						type="object",
	 *						@OA\Property(
	 *							property="success",
	 *							default="false",
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="This action is unauthorized."
	 *						)
	 *					)
	 *				)
	 *			}
	 *		)
	 *	)
	 */
	public function destroy($id): JsonResponse
	{
		try {
			/** @var Award $award */
			$award = $this->awardRepository->find($id);

			if (empty($award)) {
				return $this->sendError('Award (' . $id . ') not found.', ['id' => $id], 404);
			}
		
			$this->authorize('delete', $award);

			$award->delete();

			return $this->sendSuccess('Award deleted successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
