<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParkrankRequest;
use App\Http\Requests\UpdateParkrankRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ParkrankRepository;
use Illuminate\Http\Request;
use Flash;

class ParkrankController extends AppBaseController
{
    /** @var ParkrankRepository $parkrankRepository*/
    private $parkrankRepository;

    public function __construct(ParkrankRepository $parkrankRepo)
    {
        $this->parkrankRepository = $parkrankRepo;
    }

    /**
     * Display a listing of the Parkrank.
     */
    public function index(Request $request)
    {
        return view('parkranks.index');
    }

    /**
     * Show the form for creating a new Parkrank.
     */
    public function create()
    {
        return view('parkranks.create');
    }

    /**
     * Store a newly created Parkrank in storage.
     */
    public function store(CreateParkrankRequest $request)
    {
        $input = $request->all();

        $parkrank = $this->parkrankRepository->create($input);

        Flash::success('Parkrank saved successfully.');

        return redirect(route('parkranks.index'));
    }

    /**
     * Display the specified Parkrank.
     */
    public function show($id)
    {
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            Flash::error('Parkrank not found');

            return redirect(route('parkranks.index'));
        }

        return view('parkranks.show')->with('parkrank', $parkrank);
    }

    /**
     * Show the form for editing the specified Parkrank.
     */
    public function edit($id)
    {
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            Flash::error('Parkrank not found');

            return redirect(route('parkranks.index'));
        }

        return view('parkranks.edit')->with('parkrank', $parkrank);
    }

    /**
     * Update the specified Parkrank in storage.
     */
    public function update($id, UpdateParkrankRequest $request)
    {
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            Flash::error('Parkrank not found');

            return redirect(route('parkranks.index'));
        }

        $parkrank = $this->parkrankRepository->update($request->all(), $id);

        Flash::success('Parkrank updated successfully.');

        return redirect(route('parkranks.index'));
    }

    /**
     * Remove the specified Parkrank from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $parkrank = $this->parkrankRepository->find($id);

        if (empty($parkrank)) {
            Flash::error('Parkrank not found');

            return redirect(route('parkranks.index'));
        }

        $this->parkrankRepository->delete($id);

        Flash::success('Parkrank deleted successfully.');

        return redirect(route('parkranks.index'));
    }
}
