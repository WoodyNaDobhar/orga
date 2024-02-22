<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArchetypeRequest;
use App\Http\Requests\UpdateArchetypeRequest;

use App\Repositories\ArchetypeRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ArchetypeController extends AppBaseController
{
	/** @var ArchetypeRepository $archetypeRepository*/
	private $archetypeRepository;

	public function __construct(ArchetypeRepository $archetypeRepo)
	{
		$this->archetypeRepository = $archetypeRepo;
	}

	/**
	 * Display a listing of the Archetype.
	 */
	public function index(Request $request)
	{
		return view('archetypes.index');
	}

	/**
	 * Show the form for creating a new Archetype.
	 */
	public function create()
	{
		return view('archetypes.create');
	}

	/**
	 * Store a newly created Archetype in storage.
	 */
	public function store(CreateArchetypeRequest $request)
	{
		$input = $request->all();

		$this->archetypeRepository->create($input);

		Flash::success('Archetype saved successfully.');

		return redirect(route('archetypes.index'));
	}

	/**
	 * Display the specified Archetype.
	 */
	public function show($id)
	{
		$archetype = $this->archetypeRepository->find($id);

		if (empty($archetype)) {
			Flash::error('Archetype not found');

			return redirect(route('archetypes.index'));
		}

		return view('archetypes.show')->with('archetype', $archetype);
	}

	/**
	 * Show the form for editing the specified Archetype.
	 */
	public function edit($id)
	{
		$archetype = $this->archetypeRepository->find($id);

		if (empty($archetype)) {
			Flash::error('Archetype not found');

			return redirect(route('archetypes.index'));
		}

		return view('archetypes.edit')->with('archetype', $archetype);
	}

	/**
	 * Update the specified Archetype in storage.
	 */
	public function update($id, UpdateArchetypeRequest $request)
	{
		$archetype = $this->archetypeRepository->find($id);

		if (empty($archetype)) {
			Flash::error('Archetype not found');

			return redirect(route('archetypes.index'));
		}

		$archetype = $this->archetypeRepository->update($request->all(), $id);

		Flash::success('Archetype updated successfully.');

		return redirect(route('archetypes.index'));
	}

	/**
	 * Remove the specified Archetype from storage.
	 *
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$archetype = $this->archetypeRepository->find($id);

		if (empty($archetype)) {
			Flash::error('Archetype not found');

			return redirect(route('archetypes.index'));
		}

		$this->archetypeRepository->delete($id);

		Flash::success('Archetype deleted successfully.');

		return redirect(route('archetypes.index'));
	}
}
