<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;

use App\Repositories\OfficeRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class OfficeController extends AppBaseController
{
	/** @var OfficeRepository $officeRepository*/
	private $officeRepository;

	public function __construct(OfficeRepository $officeRepo)
	{
		$this->officeRepository = $officeRepo;
	}

	/**
	 * Display a listing of the Office.
	 */
	public function index(Request $request)
	{
		return view('offices.index');
	}

	/**
	 * Show the form for creating a new Office.
	 */
	public function create()
	{
		return view('offices.create');
	}

	/**
	 * Store a newly created Office in storage.
	 */
	public function store(CreateOfficeRequest $request)
	{
		$input = $request->all();

		$this->officeRepository->create($input);

		Flash::success('Office saved successfully.');

		return redirect(route('offices.index'));
	}

	/**
	 * Display the specified Office.
	 */
	public function show($id)
	{
		$office = $this->officeRepository->find($id);

		if (empty($office)) {
			Flash::error('Office not found');

			return redirect(route('offices.index'));
		}

		return view('offices.show')->with('office', $office);
	}

	/**
	 * Show the form for editing the specified Office.
	 */
	public function edit($id)
	{
		$office = $this->officeRepository->find($id);

		if (empty($office)) {
			Flash::error('Office not found');

			return redirect(route('offices.index'));
		}

		return view('offices.edit')->with('office', $office);
	}

	/**
	 * Update the specified Office in storage.
	 */
	public function update($id, UpdateOfficeRequest $request)
	{
		$office = $this->officeRepository->find($id);

		if (empty($office)) {
			Flash::error('Office not found');

			return redirect(route('offices.index'));
		}

		$office = $this->officeRepository->update($request->all(), $id);

		Flash::success('Office updated successfully.');

		return redirect(route('offices.index'));
	}

	/**
	 * Remove the specified Office from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$office = $this->officeRepository->find($id);

		if (empty($office)) {
			Flash::error('Office not found');

			return redirect(route('offices.index'));
		}

		$this->officeRepository->delete($id);

		Flash::success('Office deleted successfully.');

		return redirect(route('offices.index'));
	}
}
