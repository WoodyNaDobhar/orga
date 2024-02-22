<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSocialRequest;
use App\Http\Requests\UpdateSocialRequest;

use App\Repositories\SocialRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SocialController extends AppBaseController
{
	/** @var SocialRepository $socialRepository*/
	private $socialRepository;

	public function __construct(SocialRepository $socialRepo)
	{
		$this->socialRepository = $socialRepo;
	}

	/**
	 * Display a listing of the Social.
	 */
	public function index(Request $request)
	{
		return view('socials.index');
	}

	/**
	 * Show the form for creating a new Social.
	 */
	public function create()
	{
		return view('socials.create');
	}

	/**
	 * Store a newly created Social in storage.
	 */
	public function store(CreateSocialRequest $request)
	{
		$input = $request->all();

		$this->socialRepository->create($input);

		Flash::success('Social saved successfully.');

		return redirect(route('socials.index'));
	}

	/**
	 * Display the specified Social.
	 */
	public function show($id)
	{
		$social = $this->socialRepository->find($id);

		if (empty($social)) {
			Flash::error('Social not found');

			return redirect(route('socials.index'));
		}

		return view('socials.show')->with('social', $social);
	}

	/**
	 * Show the form for editing the specified Social.
	 */
	public function edit($id)
	{
		$social = $this->socialRepository->find($id);

		if (empty($social)) {
			Flash::error('Social not found');

			return redirect(route('socials.index'));
		}

		return view('socials.edit')->with('social', $social);
	}

	/**
	 * Update the specified Social in storage.
	 */
	public function update($id, UpdateSocialRequest $request)
	{
		$social = $this->socialRepository->find($id);

		if (empty($social)) {
			Flash::error('Social not found');

			return redirect(route('socials.index'));
		}

		$social = $this->socialRepository->update($request->all(), $id);

		Flash::success('Social updated successfully.');

		return redirect(route('socials.index'));
	}

	/**
	 * Remove the specified Social from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$social = $this->socialRepository->find($id);

		if (empty($social)) {
			Flash::error('Social not found');

			return redirect(route('socials.index'));
		}

		$this->socialRepository->delete($id);

		Flash::success('Social deleted successfully.');

		return redirect(route('socials.index'));
	}
}
