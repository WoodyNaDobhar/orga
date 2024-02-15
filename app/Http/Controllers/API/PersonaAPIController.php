<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePersonaAPIRequest;
use App\Http\Requests\API\UpdatePersonaAPIRequest;
use App\Models\Persona;
use App\Repositories\PersonaRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use app\Helpers\AppHelper;
use Throwable;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PersonaResource;

/**
 * Class PersonaController
 * @package App\Http\Controllers\API
 */

class PersonaAPIController extends AppBaseController
{
	
	use AuthorizesRequests;
	
    /** @var  PersonaRepository */
    private $personaRepository;

    public function __construct(PersonaRepository $personaRepo)
    {
        $this->personaRepository = $personaRepo;
    }

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/personas",
	 *		summary="Get a listing of the Personas.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Persona"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full
	 * 		attendances (Attendance) (HasMany): Attendances for the Persona.
	 * 		awards (Issuance) {MorphMany): Awards received by the Persona.
	 * 		chapter (Chapter) (BelongsTo): Chapter the Persona calls home.
	 * 		crats (Crat) (HasMany): Crat positions held by the Persona.
	 * 		dues (Due) (HasMany): Dues paid by the Persona.
	 * 		events (Event) (MorphMany): Events sponsored by the Persona.
	 * 		issuanceGivens (Issuance) {MorphMany): Issuances made by the Persona, typically retainer and squire Titles.
	 * 		issuanceRevokeds (Issuance) {MorphMany): Issuances revoked by the Persona.
	 * 		issuanceSigneds (Issuance) {MorphMany): Issuances signed by the Persona.
	 * 		members (Member) (HasMany): Memberships in Units the Persona has had.
	 * 		officers (Officer) (HasMany): Officer positions held by the Persona.
	 * 		pronoun (Pronoun) (BelongsTo): Prefered selected pronouns for the Persona.
	 * 		recommendations (Recommendation) (HasMany): Issuance Recommendations made for this Persona.
	 * 		reconciliations (Reconciliation) (HasMany): Credit reconciliations for this Persona.
	 * 		socials (Social) (MorphMany): Socials for the Persona.
	 * 		splits (Split) (HasMany): Splits this Persona took part in.
	 * 		suspensions (Suspension) (HasMany): Suspensions the Persona has undergone.
	 * 		suspensionIssueds (Suspension) (HasMany): Suspensions the Persona has issued.
	 * 		titles (Issuance) {MorphMany): Titles received by the Persona.
	 * 		titleIssuables (Title) (MorphMany): Titles the Persona can Issue.
	 * 		user (User) (BelongsTo): The User for the Persona.
	 * 		waivers (Waiver) (HasMany): The Waivers for the Persona.
	 * 		waiverVerifieds (Waiver) (HasMany): Waivers age verified by the Persona.
	 * 		createdBy (User) (BelongsTo): Persona that created it.
	 * 		updatedBy (User) (BelongsTo): Persona that last updated it (if any).
	 * 		deletedBy (User) (BelongsTo): Persona that deleted it (if any).",
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
	 *								ref="#/components/schemas/PersonaSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Personas retrieved successfully."
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

			$this->authorize('viewAny', Persona::class);

			$personas = $this->personaRepository->all(
				$request->has('search') ? $request->get('search') : [],
				$request->has('skip') && $request->has('limit') ? $request->get('skip') : null,
				$request->has('limit') ? $request->get('limit') : null,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null,
				$request->has('sort') ? $request->get('sort') : null
			);

			return $this->sendResponse(new PersonaResource($personas), 'Personas retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param CreatePersonaAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/personas",
	 *		summary="Store a newly created Persona in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Persona"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: full<br>Admins: full
	 *		requestBody={"$ref": "#/components/requestBodies/Persona"},
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
	 *								ref="#/components/schemas/PersonaSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Persona saved successfully."
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
	 *								ref="#/components/schemas/PersonaSuperSimple"
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
	public function store(CreatePersonaAPIRequest $request): JsonResponse
	{
		try {

			$this->authorize('create', Persona::class);
			
			$input = $request->all();

			$persona = $this->personaRepository->create($input);

			return $this->sendResponse(new PersonaResource($persona), 'Persona saved successfully.');
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
	 *		path="/personas/{id}",
	 *		summary="Display the specified Persona",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Persona"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full
	 * 		attendances (Attendance) (HasMany): Attendances for the Persona.
	 * 		awards (Issuance) {MorphMany): Awards received by the Persona.
	 * 		chapter (Chapter) (BelongsTo): Chapter the Persona calls home.
	 * 		crats (Crat) (HasMany): Crat positions held by the Persona.
	 * 		dues (Due) (HasMany): Dues paid by the Persona.
	 * 		events (Event) (MorphMany): Events sponsored by the Persona.
	 * 		issuanceGivens (Issuance) {MorphMany): Issuances made by the Persona, typically retainer and squire Titles.
	 * 		issuanceRevokeds (Issuance) {MorphMany): Issuances revoked by the Persona.
	 * 		issuanceSigneds (Issuance) {MorphMany): Issuances signed by the Persona.
	 * 		members (Member) (HasMany): Memberships in Units the Persona has had.
	 * 		officers (Officer) (HasMany): Officer positions held by the Persona.
	 * 		pronoun (Pronoun) (BelongsTo): Prefered selected pronouns for the Persona.
	 * 		recommendations (Recommendation) (HasMany): Issuance Recommendations made for this Persona.
	 * 		reconciliations (Reconciliation) (HasMany): Credit reconciliations for this Persona.
	 * 		socials (Social) (MorphMany): Socials for the Persona.
	 * 		splits (Split) (HasMany): Splits this Persona took part in.
	 * 		suspensions (Suspension) (HasMany): Suspensions the Persona has undergone.
	 * 		suspensionIssueds (Suspension) (HasMany): Suspensions the Persona has issued.
	 * 		titles (Issuance) {MorphMany): Titles received by the Persona.
	 * 		titleIssuables (Title) (MorphMany): Titles the Persona can Issue.
	 * 		user (User) (BelongsTo): The User for the Persona.
	 * 		waivers (Waiver) (HasMany): The Waivers for the Persona.
	 * 		waiverVerifieds (Waiver) (HasMany): Waivers age verified by the Persona.
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
	 *			description="ID of Persona",
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
	 *								ref="#/components/schemas/PersonaSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Persona retrieved successfully."
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
			/** @var Persona $persona */
			$persona = $this->personaRepository->find(
				$id,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null
			);
			
			if (empty($persona)) {
				return $this->sendError('Persona (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('view', $persona);

			return $this->sendResponse(new PersonaResource($persona), 'Persona retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @param UpdatePersonaAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/personas/{id}",
	 *		summary="Update the specified Persona in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Persona"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: own<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Persona",
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
	 *		requestBody={"$ref": "#/components/requestBodies/Persona"},
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
	 *								ref="#/components/schemas/PersonaSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Persona updated successfully."
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
	 *								ref="#/components/schemas/PersonaSuperSimple"
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
	public function update($id, UpdatePersonaAPIRequest $request): JsonResponse
	{
		try {
			$input = $request->all();

			/** @var Persona $Persona */
			$Persona = $this->PersonaRepository->find($id);

			if (empty($Persona)) {
				return $this->sendError('Persona (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('update', $Persona);

			$Persona = $this->PersonaRepository->update($input, $id);

			return $this->sendResponse(new PersonaResource($Persona), 'Persona updated successfully.');
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
	 *		path="/personas/{id}",
	 *		summary="Remove the specified Persona from storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Persona"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Persona",
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
	 *								ref="#/components/schemas/PersonaSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Persona deleted successfully."
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
			/** @var Persona $persona */
			$persona = $this->personaRepository->find($id);

			if (empty($persona)) {
				return $this->sendError('Persona (' . $id . ') not found.', ['id' => $id], 404);
			}
		
			$this->authorize('delete', $persona);

			$persona->delete();

			return $this->sendSuccess('Persona deleted successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
