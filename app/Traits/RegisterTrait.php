<?PHP 

namespace App\Traits;

use Throwable;
use App\Exceptions\ApiOperationFailedException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Trait RegisterTrait.
 */
trait RegisterTrait
{

	/** @var  UserRepository */
	private $userRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserRepository $userRepo)
	{
		$this->userRepository = $userRepo;
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\Models\User
	 */
	public function create(array $data)
	{
		try {
			$user = [
				'persona_id' => $data['persona_id'],
				'email' => $data['email'],
				'password' => $data['password'],
				'created_by' => array_key_exists('created_by', $data) ? $data['created_by'] : 1,
				'updated_by' => array_key_exists('created_by', $data) ? $data['created_by'] : null
			];
	
			$newUser = $this->userRepository->create($user);
	
			return $newUser;
		} catch (Throwable $e) {
			Log::info($e->getMessage());
			throw new ApiOperationFailedException($e->getMessage(), $e->getCode());
		}
	}
}
