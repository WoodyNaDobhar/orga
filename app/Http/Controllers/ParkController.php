<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParkRequest;
use App\Http\Requests\UpdateParkRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ParkRepository;
use Illuminate\Http\Request;
use Flash;

class ParkController extends AppBaseController
{
    /** @var ParkRepository $parkRepository*/
    private $parkRepository;

    public function __construct(ParkRepository $parkRepo)
    {
        $this->parkRepository = $parkRepo;
    }

    /**
     * Display a listing of the Park.
     */
    public function index(Request $request)
    {
        return view('parks.index');
    }

    /**
     * Show the form for creating a new Park.
     */
    public function create()
    {
        return view('parks.create');
    }

    /**
     * Store a newly created Park in storage.
     */
    public function store(CreateParkRequest $request)
    {
        $input = $request->all();

        $park = $this->parkRepository->create($input);

        Flash::success('Park saved successfully.');

        return redirect(route('parks.index'));
    }

    /**
     * Display the specified Park.
     */
    public function show($id)
    {
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            Flash::error('Park not found');

            return redirect(route('parks.index'));
        }

        return view('parks.show')->with('park', $park);
    }

    /**
     * Show the form for editing the specified Park.
     */
    public function edit($id)
    {
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            Flash::error('Park not found');

            return redirect(route('parks.index'));
        }

        return view('parks.edit')->with('park', $park);
    }

    /**
     * Update the specified Park in storage.
     */
    public function update($id, UpdateParkRequest $request)
    {
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            Flash::error('Park not found');

            return redirect(route('parks.index'));
        }

        $park = $this->parkRepository->update($request->all(), $id);

        Flash::success('Park updated successfully.');

        return redirect(route('parks.index'));
    }

    /**
     * Remove the specified Park from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $park = $this->parkRepository->find($id);

        if (empty($park)) {
            Flash::error('Park not found');

            return redirect(route('parks.index'));
        }

        $this->parkRepository->delete($id);

        Flash::success('Park deleted successfully.');

        return redirect(route('parks.index'));
    }
}
