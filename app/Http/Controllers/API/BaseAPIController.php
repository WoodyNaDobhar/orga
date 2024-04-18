<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Helpers\AppHelper;
use App\Http\Controllers\AppBaseController;
use App\Models\Chapter;
use App\Models\Event;
use App\Models\PasswordHistory;
use App\Models\Persona;
use App\Models\Realm;
use App\Models\Unit;
use App\Models\User;
use App\Traits\RegisterTrait;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use \Illuminate\Validation\ValidationException;
use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;
use App\Notifications\InviteNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
// use NZTim\Mailchimp\Exception\MailchimpBadRequestException;
// use NZTim\Mailchimp\MailchimpFacade as Mailchimp;

/**
 * Class BaseController
 * @package App\Http\Controllers\API
 */

class BaseAPIController extends AppBaseController
{

	use RegisterTrait;

	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/images",
	 *		summary="Get a listing of the images in the public folder.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
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
	 *								type="string",
	 *								example="path/image.ext"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Images retrieved successfully."
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
	public function images(Request $request)
	{
		try {
			//the response for this is jank because the image dd script won't take standard response data.
			$imagesArray = AppHelper::instance()->getImages();
			$images = array_keys($imagesArray);
			return $this->sendResponse((object) $images, 'Images retrieved successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/sendInvite",
	 *		summary="Send a Persona a registration invitation. Invite tokens are generated for Officers in the invitePersona method.  This is the only way to register a new User.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/sendInvite"},
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
	 *								type="string",
	 *								example="yR1234D5gqZlgmiR1234YM01KDRJG1234KRHjA12"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Login Successful."
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
	public function sendInvite(Request $request)
	{
		try {
			
			$request->validate([
				'email' => 'required|email|unique:users,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/|max:191',
				'persona_id' => 'required'
			]);
			
			/** @var Persona $persona */
			$persona = Persona::findOrFail($request->persona_id);
			
			if (empty($persona)) {
				return $this->sendError('Persona (' . $request->persona_id . ') not found.', ['id' => $request->persona_id] + $request->all(), 404);
			}
			
			$this->authorize('update', $persona);

			Notification::route('mail', [
				$request->email => $persona->name,
			])->notify(new InviteNotification($persona->name, config('app.url') . '/register/' . $request->email . '/' . Crypt::encryptString($persona->id)));
			
			return $this->sendResponse([], 'Persona invited successfully.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/register",
	 *		summary="Accept invitation. Invite tokens are generated for Officers in the sendInvite method. Returns auth token (as per login).",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Officers: none<br>Admins: none",
	 *		requestBody={"$ref": "#/components/requestBodies/register"},
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
	 *								type="string",
	 *								example="yR1234D5gqZlgmiR1234YM01KDRJG1234KRHjA12"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Login Successful."
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
	public function register(Request $request)
	{
		try {
			
			$request->validate(User::$createRules, User::$messages);
			
			$stupidPass = new LaravelStupidPassword(40, config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
			if($stupidPass->validate($request->input('password')) === false) {
				$errors = '';
				foreach($stupidPass->getErrors() as $error) {
					$errors .= $error . '<br />';
				}
				return $this->sendError('Your password is weak:<br \>' . substr($errors, 0, -6), null, 404);
			}
			
			$invitedPersona = Persona::where('id', Crypt::decryptString($request->input('invite_token')))->first();
			if($invitedPersona){
				$invitedPersona->pronoun_id = $request->input('pronoun_id');
				$invitedPersona->save();
			}else{
				throw ValidationException::withMessages([
						'invite_token' => ['The provided credentials are incorrect.'],
				]);
			}
			
			$input = $request->all();
			$input['persona_id'] = $invitedPersona->id;
			$input['email_verified_at'] = Carbon::now();
			
			$this->create($input);
			
			return $this->login($request);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/login",
	 *		summary="Get auth token.  This token should be passed in the Authorization header as a bearer token with every request.  The token will expire after 20 minutes of inactivity, and a new login will be required.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/login"},
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
	 *								ref="#/components/schemas/UserLogin"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Login Successful."
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
	public function login(Request $request)
	{
		try {
			
			$request->validate([
					'email' => 'required|email',
					'password' => 'required',
					'device_name' => 'required',
			]);
			
			$user = User::where('email', $request->email)->with('persona')->first();

			if (! $user || ! Hash::check($request->password, $user->password)) {
				throw ValidationException::withMessages([
						'email' => ['The provided credentials are incorrect.'],
				]);
			}
			
			//MailChimp update
			// 			Mailchimp::subscribe(config('mailchimp.list'), $user->email, [
			// 				'FNAME'		 => $user->first_name != '' ? $user->first_name : 'unknown',
			// 				'LNAME'		 => $user->last_name != '' ? $user->last_name : 'unknown',
			// 				'FULLNAME'	  => $user->first_name != '' ? $user->first_name : 'unknown' . ' ' . ($user->last_name != '' ? $user->last_name : 'unknown'),
			// 				'TRACK'		 => $user->track ? $user->track->name : 'none',
			// 				'TEAM'		  => $user->team ? $user->team->name : 'none',
			// 				'ADMIN'		 => $user->hasRole('admin') ? 'True' : 'False',
			// 				'TRAINER'	 => $user->hasRole('trainer') ? 'True' : 'False',
			// 				'COACH'		 => $user->hasRole('coach') ? 'True' : 'False',
			// 				'SALES'		 => $user->hasRole('sales') ? 'True' : 'False',
			// 				'LASTLOGIN'	 => date('m/d/yy', strtotime('now'))
			// 			], false);
			// 			if (!$user->is_contactable) {
			// 				Mailchimp::unsubscribe(config('mailchimp.list'), $user->email);
			// 			}
			
			$userArray = $user->toArray();
			$userArray['jsPermissions'] = $user->jsPermissions();
			$userArray['token'] = explode('|', $user->createToken($request->device_name)->plainTextToken)[1];
			
			return $this->sendResponse($userArray, 'Login successful.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @return Response
	 *
	 * @OA\Get(
	 *		path="/logout",
	 *		summary="Delete auth token.  Prevents security leaks and informs other users they are not available.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
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
	 *							property="message",
	 *							type="string",
	 *							example="Logout Successful."
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
	public function logout()
	{
		try {
			
			$user = Auth::user();

			if (! $user ) {
				throw ValidationException::withMessages([
						'auth' => ['You are not logged in.'],
				]);
			}
			
			//MailChimp update
			// 			Mailchimp::subscribe(config('mailchimp.list'), $user->email, [
			// 				'FNAME'		 => $user->first_name != '' ? $user->first_name : 'unknown',
			// 				'LNAME'		 => $user->last_name != '' ? $user->last_name : 'unknown',
			// 				'FULLNAME'	  => $user->first_name != '' ? $user->first_name : 'unknown' . ' ' . ($user->last_name != '' ? $user->last_name : 'unknown'),
			// 				'TRACK'		 => $user->track ? $user->track->name : 'none',
			// 				'TEAM'		  => $user->team ? $user->team->name : 'none',
			// 				'ADMIN'		 => $user->hasRole('admin') ? 'True' : 'False',
			// 				'TRAINER'	 => $user->hasRole('trainer') ? 'True' : 'False',
			// 				'COACH'		 => $user->hasRole('coach') ? 'True' : 'False',
			// 				'SALES'		 => $user->hasRole('sales') ? 'True' : 'False',
			// 				'LASTLOGIN'	 => date('m/d/yy', strtotime('now'))
			// 			], false);
			// 			if (!$user->is_contactable) {
			// 				Mailchimp::unsubscribe(config('mailchimp.list'), $user->email);
			// 			}
			
			$user->tokens()->delete();
			
			return $this->sendResponse(null, 'Logout successful.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/check",
	 *		summary="Check to see if a given User's auth token is still active.  Can only be accessed once every minute.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/check"},
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
	 *							type="boolean"
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Check Successful."
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
	public function check(Request $request)
	{
		try {
			
			$request->validate([
				'user_id' => 'required',
				'device_name' => 'required',
			]);
			
			$user = User::where('id', $request->user_id)->first();
			
			if (! $user ) {
				return $this->sendResponse(false, 'Check successful.');
			}
			
			foreach($user->tokens()->get() as $token){
				if (Carbon::parse($token->created_at)->addMinutes(20)->greaterThanOrEqualTo(Carbon::now())) {
					return $this->sendResponse(true, 'Check successful.');
				}
			}
			
			return $this->sendResponse(false, 'Check successful.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/forgot",
	 *		summary="Send reset password email to user.  May only be accessed once every five minutes.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/forgot"},
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
	 *								type="string",
	 *								example="yR1234D5gqZlgmiR1234YM01KDRJG1234KRHjA12"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="A password reset link has been sent to the given email address."
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
	public function forgot(Request $request)
	{
		try {
			
			$request->validate([
				'email' => 'required|email',
				'device_name' => 'required',
			]);
			
			//in order to prevent using this to identify users, the response is always the same from here out
			$response = "Assuming it's in our system, a password reset link has been sent to the given email address.  Please check your spam folder, and if you like, consider whitelisting amtgard.com!";
			
			$user = User::where('email', $request->email)->with('persona')->first();
			
			if (!$user) {
				return $this->sendSuccess($response);
			}
			
			$passwordBrokerManager = app(PasswordBrokerManager::class);
			$passwordBroker = $passwordBrokerManager->broker();
			
			if ($passwordBroker->getRepository()->recentlyCreatedToken($user)) {
				return static::RESET_THROTTLED;
			}
			
			$token = $passwordBroker->getRepository()->create($user);
			
			Notification::route('mail', [
				$request->email => ($user->persona ? $user->persona->name : $user->name),
			])->notify(new ResetPasswordNotification(($user->persona ? $user->persona->name : $user->name), config('app.url') . '/reset/' . $token));
			
			return $this->sendSuccess($response);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/reset",
	 *		summary="Change User password.  Returns auth token (as per login).",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/reset"},
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
	 *								type="string",
	 *								example="yR1234D5gqZlgmiR1234YM01KDRJG1234KRHjA12"
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="A password reset link has been sent to the given email address."
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
	public function reset(Request $request)
	{
		try {
			
			$request->validate(User::$setPasswordRules);
			
			$user = User::where('email', $request->input('email'))->first();
			
			$passwordBrokerManager = app(PasswordBrokerManager::class);
			$passwordBroker = $passwordBrokerManager->broker();
			
			$stupidPass = new LaravelStupidPassword(40, config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
			if($stupidPass->validate($request->input('password')) === false) {
				$errors = '';
				foreach($stupidPass->getErrors() as $error) {
					$errors .= $error . '<br />';
				}
				return $this->sendError('Your password is weak:<br \>' . substr($errors, 0, -6), null, 404);
			}
			
			$passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
			foreach($passwordHistories as $passwordHistory){
				if (Hash::check($request->input('password'), $passwordHistory->password)) {
					return $this->sendError('Your new password can not be same as any of your recent passwords. Please choose a new password.', null, 404);
				}
			}
			
			$passwordBroker->reset(
				// Pass an array containing user and token
				['email' => $request->input('email'), 'token' => $request->input('password_token'), 'password' => $request->input('password')],
				// Provide a closure for handling the result of the reset
				function ($user, $password) use($request){
					$user->password = Hash::make($request->input('password'));
					$user->setRememberToken(Str::random(60));
					$user->save();
					event(new PasswordReset($user));
					PasswordHistory::create([
						'user_id' => $user->id,
						'password' => $user->password
					]);
				}
			);
			return $this->login($request);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
	
	/**
	 * @param Request $request
	 * @return Response
	 *
	 * @OA\Post(
	 *		path="/search",
	 *		summary="Search common predetermined models for keywords.  The models that are searched are: Chapter, Event, Persona, Realm, User, Unit.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		requestBody={"$ref": "#/components/requestBodies/search"},
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
	 *							type="object",
	 *							@OA\Property(
	 *								property="Chapters",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/ChapterSimple")
	 *							),
	 *							@OA\Property(
	 *								property="Events",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/EventSimple")
	 *							),
	 *							@OA\Property(
	 *								property="Personas",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/PersonaSimple")
	 *							),
	 *							@OA\Property(
	 *								property="Realms",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/RealmSimple")
	 *							),
	 *							@OA\Property(
	 *								property="Users",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/UserSimple")
	 *							),
	 *							@OA\Property(
	 *								property="Units",
	 *								type="array",
	 *								@OA\Items(ref="#/components/schemas/UnitSimple")
	 *							)
	 *						),
	 *						@OA\Property(
	 *							property="message",
	 *							type="string",
	 *							example="Search complete."
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
	public function search(Request $request)
	{
		try {

			$chapters = Chapter::search($request->search)->get();
			$events = Event::search($request->search)->get();
			$personas = Persona::search($request->search)->get();
			$realms = Realm::search($request->search)->get();
			$users = User::search($request->search)->get();
			$units = Unit::search($request->search)->get();
			
			$response = [
				'Chapters' => $chapters,
				'Events' => $events,
				'Personas' => $personas,
				'Realms' => $realms,
				'Users' => $users,
				'Units' => $units,
			];
			
			return $this->sendResponse($response, 'Search complete.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
