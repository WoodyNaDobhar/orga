<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePronounAPIRequest;
use App\Http\Requests\API\UpdatePronounAPIRequest;
use App\Models\Pronoun;
use App\Repositories\PronounRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Helpers\AppHelper;
use Throwable;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PronounResource;

/**
 * Class PronounController
 * @package App\Http\Controllers\API
 */

class PronounAPIController extends AppBaseController
{
	
	use AuthorizesRequests;
	
    /** @var  PronounRepository */
    private $pronounRepository;

    public function __construct(PronounRepository $pronounRepo)
    {
        $this->pronounRepository = $pronounRepo;
    }

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/pronouns",
	 *		summary="Get a listing of the Pronouns.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Pronoun"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full<br>The following relationships can be attached, and in the case of plural relations, searched:<br>
			personas (Persona) (HasMany): Personas using the Pronoun.<br>
			waivers (Waivers) (HasMany): Waivers using the Pronoun.<br>
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
	 *								ref="#/components/schemas/PronounSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Pronouns retrieved successfully."
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

// 			$this->authorize('viewAny', Pronoun::class);

			$pronouns = $this->pronounRepository->all(
				$request->has('search') ? $request->get('search') : [],
				$request->has('skip') && $request->has('limit') ? $request->get('skip') : null,
				$request->has('limit') ? $request->get('limit') : null,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null,
				$request->has('sort') ? $request->get('sort') : null
			);

			return $this->sendResponse(PronounResource::collection($pronouns), 'Pronouns retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param CreatePronounAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/pronouns",
	 *		summary="Store a newly created Pronoun in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Pronoun"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: none<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/Pronoun"},
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
	 *								ref="#/components/schemas/PronounSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Pronoun saved successfully."
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
	 *								ref="#/components/schemas/PronounSuperSimple"
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
	public function store(CreatePronounAPIRequest $request): JsonResponse
	{
		try {

			$this->authorize('create', Pronoun::class);
			
			$input = $request->all();

			$pronoun = $this->pronounRepository->create($input);

			return $this->sendResponse(new PronounResource($pronoun), 'Pronoun saved successfully.');
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
	 *		path="/pronouns/{id}",
	 *		summary="Display the specified Pronoun",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Pronoun"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full<br>The following relationships can be attached, and in the case of plural relations, searched:<br>
			personas (Persona) (HasMany): Personas using the Pronoun.<br>
			waivers (Waivers) (HasMany): Waivers using the Pronoun.<br>
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
	 *			description="ID of Pronoun",
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
	 *								ref="#/components/schemas/PronounSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Pronoun retrieved successfully."
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
			/** @var Pronoun $pronoun */
			$pronoun = $this->pronounRepository->find(
				$id,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null
			);
			
			if (empty($pronoun)) {
				return $this->sendError('Pronoun (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
// 			$this->authorize('view', $pronoun);

			return $this->sendResponse(new PronounResource($pronoun), 'Pronoun retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @param UpdatePronounAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/pronouns/{id}",
	 *		summary="Update the specified Pronoun in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Pronoun"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: none<br>Admins: full",
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Pronoun",
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
	 *		requestBody={"$ref": "#/components/requestBodies/Pronoun"},
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
	 *								ref="#/components/schemas/PronounSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Pronoun updated successfully."
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
	 *								ref="#/components/schemas/PronounSuperSimple"
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
	public function update($id, UpdatePronounAPIRequest $request): JsonResponse
	{
		try {
			$input = $request->all();

			/** @var Pronoun $Pronoun */
			$Pronoun = $this->PronounRepository->find($id);

			if (empty($Pronoun)) {
				return $this->sendError('Pronoun (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('update', $Pronoun);

			$Pronoun = $this->PronounRepository->update($input, $id);

			return $this->sendResponse(new PronounResource($Pronoun), 'Pronoun updated successfully.');
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
	 *		path="/pronouns/{id}",
	 *		summary="Remove the specified Pronoun from storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Pronoun"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: none<br>Admins: full",
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Pronoun",
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
	 *								ref="#/components/schemas/PronounSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Pronoun deleted successfully."
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
			/** @var Pronoun $pronoun */
			$pronoun = $this->pronounRepository->find($id);

			if (empty($pronoun)) {
				return $this->sendError('Pronoun (' . $id . ') not found.', ['id' => $id], 404);
			}
		
			$this->authorize('delete', $pronoun);

			$pronoun->delete();

			return $this->sendSuccess('Pronoun deleted successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
