<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\AppHelper;
use Throwable;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;
	
	/**
	 * Login throttling.
	 *
	 * @var string
	 */
	protected $maxAttempts = 2;
	protected $decayMinutes = 15;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
	
	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		
		try {
			//update API token, if necessary
			if(!$user->api_token){
				$user->api_token = Str::random(80);
				$user->save();
			}
			$token = $user->createToken('www');
			session(['sanctum_token' => $token->plainTextToken]);
			
			//MailChimp update
//     		Mailchimp::subscribe(config('mailchimp.list'), Auth::user()->email, [
//     				'FNAME'		 => Auth::user()->first_name != '' ? Auth::user()->first_name : 'unknown',
//     				'LNAME'		 => Auth::user()->last_name != '' ? Auth::user()->last_name : 'unknown',
//     				'FULLNAME'	  => Auth::user()->first_name != '' ? Auth::user()->first_name : 'unknown' . ' ' . (Auth::user()->last_name != '' ? Auth::user()->last_name : 'unknown'),
//     				'TRACK'		 => Auth::user()->track ? Auth::user()->track->name : 'none',
//     				'TEAM'		  => Auth::user()->team ? Auth::user()->team->name : 'none',
//     				'ADMIN'		 => Auth::user()->hasRole('admin') ? 'True' : 'False',
//     				'TRAINER'	 => Auth::user()->hasRole('trainer') ? 'True' : 'False',
//     				'COACH'		 => Auth::user()->hasRole('coach') ? 'True' : 'False',
//     				'SALES'		 => Auth::user()->hasRole('sales') ? 'True' : 'False',
//     				'LASTLOGIN'	 => date('m/d/yy', strtotime('now'))
//     		], false);
//     		if (!Auth::user()->is_contactable) {
//     			Mailchimp::unsubscribe(config('mailchimp.list'), Auth::user()->email);
//     		}
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . " (" . $trace['file'] . ":" . $trace['line'] . ")\r\n" . '[stacktrace]' . "\r\n" . $e->getTraceAsString());
			return Redirect::back()
				->withInput($request->all())
				->withErrors($e->getMessage());
		}
	}
}
