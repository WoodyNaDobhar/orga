<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UnitRepository;
use Illuminate\Http\Request;
use Flash;

class UnitController extends AppBaseController
{
    /** @var UnitRepository $unitRepository*/
    private $unitRepository;

    public function __construct(UnitRepository $unitRepo)
    {
        $this->unitRepository = $unitRepo;
    }

    /**
     * Display a listing of the Unit.
     */
    public function index(Request $request)
    {
        return view('units.index');
    }

    /**
     * Show the form for creating a new Unit.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created Unit in storage.
     */
    public function store(CreateUnitRequest $request)
    {
        $input = $request->all();

        $unit = $this->unitRepository->create($input);

        Flash::success('Unit saved successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Display the specified Unit.
     */
    public function show($id)
    {
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            Flash::error('Unit not found');

            return redirect(route('units.index'));
        }

        return view('units.show')->with('unit', $unit);
    }

    /**
     * Show the form for editing the specified Unit.
     */
    public function edit($id)
    {
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            Flash::error('Unit not found');

            return redirect(route('units.index'));
        }

        return view('units.edit')->with('unit', $unit);
    }

    /**
     * Update the specified Unit in storage.
     */
    public function update($id, UpdateUnitRequest $request)
    {
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            Flash::error('Unit not found');

            return redirect(route('units.index'));
        }

        $unit = $this->unitRepository->update($request->all(), $id);

        Flash::success('Unit updated successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Remove the specified Unit from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            Flash::error('Unit not found');

            return redirect(route('units.index'));
        }

        $this->unitRepository->delete($id);

        Flash::success('Unit deleted successfully.');

        return redirect(route('units.index'));
    }
}
