<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccountAPIRequest;
use App\Http\Requests\API\UpdateAccountAPIRequest;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use app\Helpers\AppHelper;
use Throwable;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AccountResource;

/**
 * Class AccountController
 * @package App\Http\Controllers\API
 */

class AccountAPIController extends AppBaseController
{
	
	use AuthorizesRequests;
	
	/** @var  AccountRepository */
	private $accountRepository;

	public function __construct(AccountRepository $accountRepo)
	{
		$this->accountRepository = $accountRepo;
	}

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/accounts",
	 *		summary="Get a listing of the Accounts.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Account"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: full<br>Crats: none<br>Chapter Officers: full<br>Admins: full
	 * accountable (Realm, Chapter, or Unit) (MorphTo): Realm, Chapter, or Unit that owns this Account.
	 * parent (Account) (BelongsTo): Parent Account, if any.
	 * splits (Split) (HasMany): Splits for this Account.
	 * createdBy (User) (BelongsTo): Account that created it.
	 * updatedBy (User) (BelongsTo): Account that last updated it (if any).
	 * deletedBy (User) (BelongsTo): Account that deleted it (if any).",
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
	 *								ref="#/components/schemas/AccountSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Accounts retrieved successfully."
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

			$this->authorize('viewAny', Account::class);

			$accounts = $this->accountRepository->all(
				$request->has('search') ? $request->get('search') : [],
				$request->has('skip') && $request->has('limit') ? $request->get('skip') : null,
				$request->has('limit') ? $request->get('limit') : null,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null,
				$request->has('sort') ? $request->get('sort') : null
			);

			return $this->sendResponse(new AccountResource($accounts), 'Accounts retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param CreateAccountAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/accounts",
	 *		summary="Store a newly created Account in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Account"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: full<br>Crats: none<br>Chapter Officers: full<br>Admins: full
	 *		requestBody={"$ref": "#/components/requestBodies/Account"},
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
	 *								ref="#/components/schemas/AccountSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Account saved successfully."
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
	 *								ref="#/components/schemas/AccountSuperSimple"
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
	public function store(CreateAccountAPIRequest $request): JsonResponse
	{
		try {

			$this->authorize('create', Account::class);
			
			$input = $request->all();

			$account = $this->accountRepository->create($input);

			return $this->sendResponse(new AccountResource($account), 'Account saved successfully.');
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
	 *		path="/accounts/{id}",
	 *		summary="Display the specified Account",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Account"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: related<br>Crats: none<br>Chapter Officers: related<br>Admins: full
	 * accountable (Realm, Chapter, or Unit) (MorphTo): Realm, Chapter, or Unit that owns this Account.
	 * parent (Account) (BelongsTo): Parent Account, if any.
	 * splits (Split) (HasMany): Splits for this Account.
	 * createdBy (User) (BelongsTo): User that created it.
	 * updatedBy (User) (BelongsTo): User that last updated it (if any).
	 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/columns"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/with"
	 *		),
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Account",
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
	 *								ref="#/components/schemas/AccountSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Account retrieved successfully."
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
			/** @var Account $account */
			$account = $this->accountRepository->find(
				$id,
				$request->has('columns') ? $request->get('columns') : ['*'],
				$request->has('with') ? $request->get('with') : null
			);
			
			if (empty($account)) {
				return $this->sendError('Account (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('view', $account);

			return $this->sendResponse(new AccountResource($account), 'Account retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}

	/**
	 * @param int $id
	 * @param UpdateAccountAPIRequest $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/accounts/{id}",
	 *		summary="Update the specified Account in storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Account"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: related<br>Crats: none<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Account",
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
	 *		requestBody={"$ref": "#/components/requestBodies/Account"},
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
	 *								ref="#/components/schemas/AccountSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Account updated successfully."
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
	 *								ref="#/components/schemas/AccountSuperSimple"
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
	public function update($id, UpdateAccountAPIRequest $request): JsonResponse
	{
		try {
			$input = $request->all();

			/** @var Account $Account */
			$Account = $this->AccountRepository->find($id);

			if (empty($Account)) {
				return $this->sendError('Account (' . $id . ') not found.', ['id' => $id] + $request->all(), 404);
			}
		
			$this->authorize('update', $Account);

			$Account = $this->AccountRepository->update($input, $id);

			return $this->sendResponse(new AccountResource($Account), 'Account updated successfully.');
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
	 *		path="/accounts/{id}",
	 *		summary="Remove the specified Account from storage",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Account"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: related<br>Crats: none<br>Chapter Officers: related<br>Admins: full
	 *		@OA\Parameter(
	 *			in="path",
	 *			name="id",
	 *			description="ID of Account",
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
	 *								ref="#/components/schemas/AccountSimple"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Account deleted successfully."
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
			/** @var Account $account */
			$account = $this->accountRepository->find($id);

			if (empty($account)) {
				return $this->sendError('Account (' . $id . ') not found.', ['id' => $id], 404);
			}
		
			$this->authorize('delete', $account);

			$account->delete();

			return $this->sendSuccess('Account deleted successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), null, $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
