<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChaptertypeRequest;
use App\Http\Requests\UpdateChaptertypeRequest;

use App\Repositories\ChaptertypeRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ChaptertypeController extends AppBaseController
{
	/** @var ChaptertypeRepository $chaptertypeRepository*/
	private $chaptertypeRepository;

	public function __construct(ChaptertypeRepository $chaptertypeRepo)
	{
		$this->chaptertypeRepository = $chaptertypeRepo;
	}

	/**
	 * Display a listing of the Chaptertype.
	 */
	public function index(Request $request)
	{
		return view('chaptertypes.index');
	}

	/**
	 * Show the form for creating a new Chaptertype.
	 */
	public function create()
	{
		return view('chaptertypes.create');
	}

	/**
	 * Store a newly created Chaptertype in storage.
	 */
	public function store(CreateChaptertypeRequest $request)
	{
		$input = $request->all();

		$this->chaptertypeRepository->create($input);

		Flash::success('Chaptertype saved successfully.');

		return redirect(route('chaptertypes.index'));
	}

	/**
	 * Display the specified Chaptertype.
	 */
	public function show($id)
	{
		$chaptertype = $this->chaptertypeRepository->find($id);

		if (empty($chaptertype)) {
			Flash::error('Chaptertype not found');

			return redirect(route('chaptertypes.index'));
		}

		return view('chaptertypes.show')->with('chaptertype', $chaptertype);
	}

	/**
	 * Show the form for editing the specified Chaptertype.
	 */
	public function edit($id)
	{
		$chaptertype = $this->chaptertypeRepository->find($id);

		if (empty($chaptertype)) {
			Flash::error('Chaptertype not found');

			return redirect(route('chaptertypes.index'));
		}

		return view('chaptertypes.edit')->with('chaptertype', $chaptertype);
	}

	/**
	 * Update the specified Chaptertype in storage.
	 */
	public function update($id, UpdateChaptertypeRequest $request)
	{
		$chaptertype = $this->chaptertypeRepository->find($id);

		if (empty($chaptertype)) {
			Flash::error('Chaptertype not found');

			return redirect(route('chaptertypes.index'));
		}

		$chaptertype = $this->chaptertypeRepository->update($request->all(), $id);

		Flash::success('Chaptertype updated successfully.');

		return redirect(route('chaptertypes.index'));
	}

	/**
	 * Remove the specified Chaptertype from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$chaptertype = $this->chaptertypeRepository->find($id);

		if (empty($chaptertype)) {
			Flash::error('Chaptertype not found');

			return redirect(route('chaptertypes.index'));
		}

		$this->chaptertypeRepository->delete($id);

		Flash::success('Chaptertype deleted successfully.');

		return redirect(route('chaptertypes.index'));
	}
}
