<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTournamentAPIRequest;
use App\Http\Requests\API\UpdateTournamentAPIRequest;
use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use app\Helpers\AppHelper;
use Throwable;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TournamentResource;

/**
 * Class TournamentController
 * @package App\Http\Controllers\API
 */

class TournamentAPIController extends AppBaseController
{
	
	use AuthorizesRequests;
	
    /** @var  TournamentRepository */
    private $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepo)
    {
        $this->tournamentRepository = $tournamentRepo;
    }

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/tournaments",
	 *		summary="Get a listing of the Tournaments.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Tournament"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full
	 * 		tournamentable (Chapter, Event, or Realm) (MorphTo): The Tournament sponsor type; Chapter, Event, or Realm.
	 * 		createdBy (User) (BelongsTo): Tournament that created it.
	 * 		updatedBy (User) (BelongsTo): Tournament that last updated it (if any).
	 * 		deletedBy (User) (BelongsTo): Tournament that deleted it (if any).",
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
	 *								ref="#/components/schemas/TournamentSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Tournaments retrieved successfully."
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

			$this->authorize('viewAny', Tournament::class);

			$tournaments = $this->tournamentRepository->all(
				$request->has('search') ? $request->get('search') : [],
				$request->has('skip') && $request->has('limit') ? $request->get('skip') : null,
				$request->has('limit') ? $request->get('limit') : null,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null,
				$request->has('sort') ? $request->get('sort') : null
			);

			return $this->sendResponse(new TournamentResource($tournaments), 'Tournaments retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param CreateTournamentAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/tournaments",
	 *		summary="Store a newly created Tournament in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Tournament"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: full<br>Chapter Officers: full<br>Admins: full
	 *		requestBody={"$ref": "#/components/requestBodies/Tournament"},
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
	 *								ref="#/components/schemas/TournamentSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Tournament saved successfully."
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
	 *								ref="#/components/schemas/TournamentSuperSimple"
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
	public function store(CreateTournamentAPIRequest $request): JsonResponse
	{
		try {

			$this->authorize('create', Tournament::class);
			
			$input = $request->all();

			$tournament = $this->tournamentRepository->create($input);

			return $this->sendResponse(new TournamentResource($tournament), 'Tournament saved successfully.');
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
	 *		path="/tournaments/{id}",
	 *		summary="Display the specified Tournament",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Tournament"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full
	 * 		tournamentable (Chapter, Event, or Realm) (MorphTo): The Tournament sponsor type; Chapter, Event, or Realm.
	 * 		createdBy (User) (BelongsTo): User that created it.
	 * 		updatedBy (User) (BelongsTo): User that last updated it (if any).
	 * 		deletedBy (User) (BelongsTo): User that deleted it (if any).",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/columns"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/with"
	 *		),
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Tournament",
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
	 *								ref="#/components/schemas/TournamentSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Tournament retrieved successfully."
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
			/** @var Tournament $tournament */
			$tournament = $this->tournamentRepository->find(
				$id,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null
			);
			
			if (empty($tournament)) {
				return $this->sendError('Tournament (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('view', $tournament);

			return $this->sendResponse(new TournamentResource($tournament), 'Tournament retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @param UpdateTournamentAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/tournaments/{id}",
	 *		summary="Update the specified Tournament in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Tournament"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: related<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Tournament",
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
	 *		requestBody={"$ref": "#/components/requestBodies/Tournament"},
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
	 *								ref="#/components/schemas/TournamentSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Tournament updated successfully."
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
	 *								ref="#/components/schemas/TournamentSuperSimple"
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
	public function update($id, UpdateTournamentAPIRequest $request): JsonResponse
	{
		try {
			$input = $request->all();

			/** @var Tournament $Tournament */
			$Tournament = $this->TournamentRepository->find($id);

			if (empty($Tournament)) {
				return $this->sendError('Tournament (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('update', $Tournament);

			$Tournament = $this->TournamentRepository->update($input, $id);

			return $this->sendResponse(new TournamentResource($Tournament), 'Tournament updated successfully.');
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
	 *		path="/tournaments/{id}",
	 *		summary="Remove the specified Tournament from storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Tournament"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: related<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Tournament",
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
	 *								ref="#/components/schemas/TournamentSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Tournament deleted successfully."
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
			/** @var Tournament $tournament */
			$tournament = $this->tournamentRepository->find($id);

			if (empty($tournament)) {
				return $this->sendError('Tournament (' . $id . ') not found.', ['id' => $id], 404);
			}
		
			$this->authorize('delete', $tournament);

			$tournament->delete();

			return $this->sendSuccess('Tournament deleted successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
