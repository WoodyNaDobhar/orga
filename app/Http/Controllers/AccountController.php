<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class AccountController extends AppBaseController
{
	/** @var AccountRepository $accountRepository*/
	private $accountRepository;

	public function __construct(AccountRepository $accountRepo)
	{
		$this->accountRepository = $accountRepo;
	}

	/**
	 * Display a listing of the Account.
	 */
	public function index(Request $request)
	{
		return view('accounts.index');
	}

	/**
	 * Show the form for creating a new Account.
	 */
	public function create()
	{
		return view('accounts.create');
	}

	/**
	 * Store a newly created Account in storage.
	 */
	public function store(CreateAccountRequest $request)
	{
		$input = $request->all();

		$this->accountRepository->create($input);

		Flash::success('Account saved successfully.');

		return redirect(route('accounts.index'));
	}

	/**
	 * Display the specified Account.
	 */
	public function show($id)
	{
		$account = $this->accountRepository->find($id);

		if (empty($account)) {
			Flash::error('Account not found');

			return redirect(route('accounts.index'));
		}

		return view('accounts.show')->with('account', $account);
	}

	/**
	 * Show the form for editing the specified Account.
	 */
	public function edit($id)
	{
		$account = $this->accountRepository->find($id);

		if (empty($account)) {
			Flash::error('Account not found');

			return redirect(route('accounts.index'));
		}

		return view('accounts.edit')->with('account', $account);
	}

	/**
	 * Update the specified Account in storage.
	 */
	public function update($id, UpdateAccountRequest $request)
	{
		$account = $this->accountRepository->find($id);

		if (empty($account)) {
			Flash::error('Account not found');

			return redirect(route('accounts.index'));
		}

		$account = $this->accountRepository->update($request->all(), $id);

		Flash::success('Account updated successfully.');

		return redirect(route('accounts.index'));
	}

	/**
	 * Remove the specified Account from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$account = $this->accountRepository->find($id);

		if (empty($account)) {
			Flash::error('Account not found');

			return redirect(route('accounts.index'));
		}

		$this->accountRepository->delete($id);

		Flash::success('Account deleted successfully.');

		return redirect(route('accounts.index'));
	}
}
