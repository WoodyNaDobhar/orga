<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Helpers\AppHelper;
use App\Http\Controllers\AppBaseController;
use App\Models\PasswordHistory;
use App\Models\Persona;
use App\Models\User;
use App\Traits\RegisterTrait;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use \Illuminate\Validation\ValidationException;
use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;
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
	 *		path="/login",
	 *		summary="Get auth token.  This token should be passed in the Authorization header as a bearer token with every request.  The token will expire in 8 hours, and a new login will be required.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/email"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/device_name"
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
	public function login(Request $request)
	{
		try {

			$request->validate([
				'email' => 'required|email',
				'password' => 'required',
				'device_name' => 'required',
			]);

			$user = User::where('email', $request->email)->first();
			
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
			$userArray['token'] = explode('|', $user->createToken($request->device_name)->plainTextToken)[1];

			return $this->sendResponse($userArray, 'Login successful.');
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
	 *		summary="Send reset password email to user.  May only be accessed once every five minutes.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/email"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/device_name"
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
	public function sendReset(Request $request)
	{
		try {

			$request->validate([
				'email' => 'required|email',
				'device_name' => 'required',
			]);
			
			//in order to prevent using this to identify users, the response is always the same from here out
			$response = "Assuming it's in our system, a password reset link has been sent to the given email address.";

			$user = User::where('email', $request->email)->first();
			if (!$user) {
				return $this->sendSuccess($response);
			}
			
			$input['email'] = $request->email;
			$input['password_token'] = Crypt::encryptString($request->email);
			$input['user_id'] = null;
			
			//send an invite email
			$emailData = [];
			$emailData['from_email'] = config('mail.from.address');
			$emailData['from_name'] = config('mail.from.name');
			$emailData['subject'] = 'ORK4 Password Reset Request';
			$emailData['content'] = $input;
			
			Log::info('About to send a password reset to: ' . $emailData['content']['email']);
			Mail::send('emails.reset', ['data' => $emailData], function ($message) use ($emailData) {
				$message->from($emailData['from_email']);
				$message->to($emailData['content']['email']);
				$message->replyTo($emailData['from_email'], $emailData['from_name']);
				$message->subject($emailData['subject']);
			});

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
	 *		path="/update",
	 *		summary="Change User password.  Returns auth token (as per login).",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Officers: full<br>Admins: full",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password_token"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/email"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password_confirm"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/device_name"
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
	public function updatePassword(Request $request)
	{
		try {
			
			$request->validate(User::$setPasswordRules);
			
			$user = User::where('email', $request->input('email'))->first();
			
			if(Crypt::decryptString($request->input('password_token')) != $request->input('email') || !$user){
				return $this->sendError('The provided values are invalid.', null, 404);
			}

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
			
			$user->password = Hash::make($request->input('password'));
			$user->setRememberToken(Str::random(60));
			$user->save();
			event(new PasswordReset($user));
			PasswordHistory::create([
					'user_id' => $user->id,
					'password' => $user->password
			]);
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
	 *		path="/sendInvite",
	 *		summary="Send a Persona a registration invitation. Invite tokens are generated for Officers in the invitePersona method.  This is the only way to register a new User.",
	 *		security={{"bearer_token":{}}},
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: none<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Officers: full<br>Admins: full",
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/email"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/persona_id"
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
				'email' => 'required|email',
				'persona_id' => 'required'
			]);
			
			/** @var Persona $Persona */
			$Persona = Persona::findOrFail($request->persona_id);
			
			if (empty($Persona)) {
				return $this->sendError('Persona (' . $request->persona_id . ') not found.', ['id' => $request->persona_id] + $request->all(), 404);
			}

			$this->authorize('update', $Persona);
			
			$input['email'] = $request->email;
			$input['invite_token'] = Crypt::encryptString($request->persona_id);
			$input['user_id'] = null;
			
			//send an invite email
			$emailData = [];
			$emailData['from_email'] = config('mail.from.address');
			$emailData['from_name'] = config('mail.from.name');
			$emailData['subject'] = 'You have been invited to ORK4!';
			$emailData['content'] = $input;
			
			Log::info('About to send a invite email to: ' . $emailData['content']['email']);
			Mail::send('emails.invitation', ['data' => $emailData], function ($message) use ($emailData) {
				$message->from($emailData['from_email']);
				$message->to($emailData['content']['email']);
				$message->replyTo($emailData['from_email'], $emailData['from_name']);
				$message->subject($emailData['subject']);
			});
				
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
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/invite_token"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/email"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/password_confirm"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/is_agreed"
	 *		),
	 *		@OA\Parameter(
	 *			ref="#/components/parameters/device_name"
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
}
