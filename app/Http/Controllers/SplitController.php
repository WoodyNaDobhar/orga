<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSplitRequest;
use App\Http\Requests\UpdateSplitRequest;

use App\Repositories\SplitRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SplitController extends AppBaseController
{
	/** @var SplitRepository $splitRepository*/
	private $splitRepository;

	public function __construct(SplitRepository $splitRepo)
	{
		$this->splitRepository = $splitRepo;
	}

	/**
	 * Display a listing of the Split.
	 */
	public function index(Request $request)
	{
		return view('splits.index');
	}

	/**
	 * Show the form for creating a new Split.
	 */
	public function create()
	{
		return view('splits.create');
	}

	/**
	 * Store a newly created Split in storage.
	 */
	public function store(CreateSplitRequest $request)
	{
		$input = $request->all();

		$this->splitRepository->create($input);

		Flash::success('Split saved successfully.');

		return redirect(route('splits.index'));
	}

	/**
	 * Display the specified Split.
	 */
	public function show($id)
	{
		$split = $this->splitRepository->find($id);

		if (empty($split)) {
			Flash::error('Split not found');

			return redirect(route('splits.index'));
		}

		return view('splits.show')->with('split', $split);
	}

	/**
	 * Show the form for editing the specified Split.
	 */
	public function edit($id)
	{
		$split = $this->splitRepository->find($id);

		if (empty($split)) {
			Flash::error('Split not found');

			return redirect(route('splits.index'));
		}

		return view('splits.edit')->with('split', $split);
	}

	/**
	 * Update the specified Split in storage.
	 */
	public function update($id, UpdateSplitRequest $request)
	{
		$split = $this->splitRepository->find($id);

		if (empty($split)) {
			Flash::error('Split not found');

			return redirect(route('splits.index'));
		}

		$split = $this->splitRepository->update($request->all(), $id);

		Flash::success('Split updated successfully.');

		return redirect(route('splits.index'));
	}

	/**
	 * Remove the specified Split from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$split = $this->splitRepository->find($id);

		if (empty($split)) {
			Flash::error('Split not found');

			return redirect(route('splits.index'));
		}

		$this->splitRepository->delete($id);

		Flash::success('Split deleted successfully.');

		return redirect(route('splits.index'));
	}
}
