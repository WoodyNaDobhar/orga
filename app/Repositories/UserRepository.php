<?php

namespace App\Repositories;

use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;
use Exception;

class UserRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'persona_id',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'api_token',
		'is_restricted'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return User::class;
	}
	
	/**
	 * Create model record.
	 *
	 * @param array $input
	 *
	 * @return Model
	 */
	public function create(array $input): Model
	{
		$password = $input['password'];
		$stupidPass = new LaravelStupidPassword(40, config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
		if($stupidPass->validate($password) === false) {
			$errors = '';
			foreach($stupidPass->getErrors() as $error) {
				$errors .= $error . '<br />';
			}
			throw new Exception('The given password is weak:<br \>' . substr($errors, 0, -6));
		}
		
		$input['password'] = Hash::make($password);
		$input['api_token'] = Str::random(80);
		$model = parent::create($input);
		
		//roles
		$model->assignRole('player');
		if(array_key_exists('is_admin', $input) && $input['is_admin'] == 1){
			$model->assignRole('admin');
		}
		if(array_key_exists('is_officer', $input) && $input['is_sales'] == 1){
			$model->assignRole('officer');
		}
		if(array_key_exists('is_crat', $input) && $input['is_coach'] == 1){
			$model->assignRole('crat');
		}
		if(array_key_exists('is_commander', $input) && $input['is_trainer'] == 1){
			$model->assignRole('commander');
		}
		
		PasswordHistory::create([
			'user_id' => $model->id,
			'password' => $input['password']
		]);
		
		//send a welcome email
		$emailData = [];
		$emailData['from_email'] = config('mail.from.address');
		$emailData['from_name'] = config('mail.from.name');
		$emailData['subject'] = 'Welcome to ORK4!';
		$emailData['content'] = $model;
		Log::info('About to send a welcome email to: ' . $emailData['content']['email']);
		Mail::send('emails.welcome', ['data' => $emailData], function ($message) use ($emailData) {
			$message->from($emailData['from_email']);
			$message->to($emailData['content']['email']);
			$message->replyTo($emailData['from_email'], $emailData['from_name']);
			$message->subject($emailData['subject']);
		});
					
		return $model;
	}
	
	/**
	 * Update model record for given id.
	 *
	 * @param array $input
	 * @param  int  $id
	 *
	 * @return Model
	 */
	public function update($input, $id)
	{
		
		$query = $this->model->newQuery();
		
		$model = $query->findOrFail($id)->makeVisible(['password']);
		
		if(array_key_exists('password', $input) && $input['password'] === null){
			unset($input['password']);
		}
		
		$model->fill($input);
		
		unset($model['api_token']);
		
		// $model->save();
		parent::relatedSave($this->model, $input, $model);
		
		//roles
		if(array_key_exists('is_admin', $input) && $input['is_admin'] == 1){
			if (!$model->hasRole('admin')) {
				$model->assignRole('admin');
			}
		}
		if(array_key_exists('is_officer', $input) && $input['is_sales'] == 1){
			if (!$model->hasRole('officer')) {
				$model->assignRole('officer');
			}
		}
		if(array_key_exists('is_crat', $input) && $input['is_trainer'] == 1){
			if (!$model->hasRole('crat')) {
				$model->assignRole('crat');
			}
		}
		if(array_key_exists('is_commander', $input) && $input['is_trainer'] == 1){
			if (!$model->hasRole('commander')) {
				$model->assignRole('commander');
			}
		}
		
		return $model;
	}
	
	/**
	 * @param int $id
	 *
	 * @throws Exception
	 *
	 * @return bool|mixed|null
	 */
	public function delete($id)
	{
		
		$query = $this->model->newQuery();
		
		$model = $query->findOrFail($id);
		
		// return $model->delete();
		return $this->relatedDelete($this->model, $model);
	}
}
