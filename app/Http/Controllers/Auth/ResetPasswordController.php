<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;use Illuminate\Support\Facades\URL;
use Laracasts\Flash\Flash;
use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;
use App\Helpers\AppHelper;
use Throwable;

class ResetPasswordController extends Controller
{
	/*
	 |--------------------------------------------------------------------------
	 | Password Reset Controller
	 |--------------------------------------------------------------------------
	 |
	 | This controller is responsible for handling password reset requests
	 | and uses a simple trait to include this behavior. You're free to
	 | explore this trait and override any methods you wish to tweak.
	 |
	 */
	
	use ResetsPasswords;
	
	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}
	
	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
	 */
	public function reset(Request $request)
	{
		try {
			
			$request->validate($this->rules(), $this->validationErrorMessages());
			
			$stupidPass = new LaravelStupidPassword(40, config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
			if($stupidPass->validate($request->input('password')) === false) {
				$errors = '';
				foreach($stupidPass->getErrors() as $error) {
					$errors .= $error . '<br />';
				}
				Flash::error('Your password is weak:<br \>' . substr($errors, 0, -6));
				return redirect(URL::previous());
			}
			
			$user = User::where('email', $request->input('email'))->first();
			$passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
			foreach($passwordHistories as $passwordHistory){
				if (Hash::check($request->input('password'), $passwordHistory->password)) {
					Flash::error('Your new password can not be same as any of your recent passwords. Please choose a new password.');
					return redirect(URL::previous());
				}
			}
			
			// Here we will attempt to reset the user's password. If it is successful we
			// will update the password on an actual user model and persist it to the
			// database. Otherwise we will parse the error and return the response.
			$response = $this->broker()->reset(
					$this->credentials($request), function ($user, $password) {
						$this->resetPassword($user, $password);
						PasswordHistory::create([
							'user_id' => $user->id,
							'password' => $user->password
						]);
					}
					);
			
			// If the password was successfully reset, we will redirect the user back to
			// the application's home authenticated view. If there is an error we can
			// redirect them back to where they came from with their error message.
			return $response == Password::PASSWORD_RESET
			? $this->sendResetResponse($request, $response)
			: $this->sendResetFailedResponse($request, $response);
		} catch (\Illuminate\Validation\ValidationException $e ) {
			$errorsArray = $e->errors();
			$message = '';
			foreach ($errorsArray as $key => $errors) {
				$message .= $key . ': ';
				foreach ($errors as $error) {
					$message .= $error . '<br>';
				}
			}
			Flash::error($message);
			return back()
				->withInput($request->all())
				->withErrors($message);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return Redirect::back()
				->withInput($request->all())
				->withErrors($e->getMessage());
		}
	}
	
	/**
	 * Get the password reset validation rules.
	 *
	 * @return array
	 */
	protected function rules()
	{
		return [
			'_token' => 'required',
			'email' => 'required|email',
			'password' => 'nullable|min:6|required_with:password_confirmation|same:password_confirmation',
			'password_confirmation' => 'nullable|min:6',
		];
	}
}
