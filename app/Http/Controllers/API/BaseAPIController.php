<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Helpers\AppHelper;
use App\Http\Controllers\AppBaseController;
use App\Models\Persona;
use App\Models\User;
use App\Traits\RegisterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Password;
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
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full",
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
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full",
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

			return $this->sendResponse([explode('|', $user->createToken($request->device_name)->plainTextToken)[1]], 'Login successful.');
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
	 *		summary="Reset user password.",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: full<br>Unit Officers: full<br>Crats: full<br>Chapter Officers: full<br>Admins: full",
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
	public function resetPassword(Request $request)
	{
		try {

			$request->validate([
				'email' => 'required|email',
				'device_name' => 'required',
			]);

			$user = User::where('email', $request->email)->first();

			if (!$user) {
				return $this->sendSuccess("");
			}
			
			Password::sendResetLink(
				$request->only('email')
			);

			return $this->sendSuccess("A password reset link has been sent to the given email address.");
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
	 *		summary="Register new user or accept mobile invitation. For normal users, simply query the user for the required information and post it.  For invitees, the following link should be published to the invitees: http://market.android.com/details?id=<our.package.name>&referrer=<invitation_id>||<invitation_email> .  The application should use that to, upon first boot, call up this function, passing it the com.android.vending.INSTALL_REFERRER as the invite_token and email parameters (after exploding via ||).",
	 *		tags={"Base"},
	 *		description="<b>Access</b>:<br>Visitors: full<br>Users: none<br>Unit Officers: none<br>Crats: none<br>Chapter Officers: none<br>Admins: none",
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
	 *			ref="#/components/parameters/invite_token"
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

			$request->validate([
				'email' => 'required|email',
				'password' => 'required',
				'invite_token' => 'required',
				'device_name' => 'required',
				'is_agreed' => 'required'
			]);

			if($request->input('is_agreed') === 'false'){
				return $this->sendError('You must agree to the Terms of Service before you can sign up for the ORK.');
			}

			$stupidPass = new LaravelStupidPassword(40, config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
			if($stupidPass->validate($request->input('password')) === false) {
				$errors = '';
				foreach($stupidPass->getErrors() as $error) {
					$errors .= $error . '<br />';
				}
				$message = 'Your password is weak:<br \>' . substr($errors, 0, -6);
				return $this->sendError($message);
				
			}

			$input = $request->all();
			
			if(!$request->has('invite_token')){
				throw ValidationException::withMessages([
						'invite_token' => ['The provided credentials ('.$request->input('invite_token').') are incorrect.'],
				]);
			}
			
			$invitedPersona = Persona::where('id', decrypt($request->input('invite_token')))->first();

			if($invitedPersona){
				$input['persona_id'] = $invitedPersona->id;
			}else{
				throw ValidationException::withMessages([
						'invite_token' => ['The provided credentials ('.$request->input('invite_token').') are incorrect.'],
				]);
			}

			$this->create($input);
			
			return $this->login($request);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return $this->sendError($e->getMessage(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? null : $request->all(), $e instanceof \Illuminate\Auth\Access\AuthorizationException ? 403 : 400);
		}
	}
}
