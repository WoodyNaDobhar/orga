<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuspensionRequest;
use App\Http\Requests\UpdateSuspensionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SuspensionRepository;
use Illuminate\Http\Request;
use Flash;

class SuspensionController extends AppBaseController
{
    /** @var SuspensionRepository $suspensionRepository*/
    private $suspensionRepository;

    public function __construct(SuspensionRepository $suspensionRepo)
    {
        $this->suspensionRepository = $suspensionRepo;
    }

    /**
     * Display a listing of the Suspension.
     */
    public function index(Request $request)
    {
        return view('suspensions.index');
    }

    /**
     * Show the form for creating a new Suspension.
     */
    public function create()
    {
        return view('suspensions.create');
    }

    /**
     * Store a newly created Suspension in storage.
     */
    public function store(CreateSuspensionRequest $request)
    {
        $input = $request->all();

        $suspension = $this->suspensionRepository->create($input);

        Flash::success('Suspension saved successfully.');

        return redirect(route('suspensions.index'));
    }

    /**
     * Display the specified Suspension.
     */
    public function show($id)
    {
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            Flash::error('Suspension not found');

            return redirect(route('suspensions.index'));
        }

        return view('suspensions.show')->with('suspension', $suspension);
    }

    /**
     * Show the form for editing the specified Suspension.
     */
    public function edit($id)
    {
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            Flash::error('Suspension not found');

            return redirect(route('suspensions.index'));
        }

        return view('suspensions.edit')->with('suspension', $suspension);
    }

    /**
     * Update the specified Suspension in storage.
     */
    public function update($id, UpdateSuspensionRequest $request)
    {
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            Flash::error('Suspension not found');

            return redirect(route('suspensions.index'));
        }

        $suspension = $this->suspensionRepository->update($request->all(), $id);

        Flash::success('Suspension updated successfully.');

        return redirect(route('suspensions.index'));
    }

    /**
     * Remove the specified Suspension from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $suspension = $this->suspensionRepository->find($id);

        if (empty($suspension)) {
            Flash::error('Suspension not found');

            return redirect(route('suspensions.index'));
        }

        $this->suspensionRepository->delete($id);

        Flash::success('Suspension deleted successfully.');

        return redirect(route('suspensions.index'));
    }
}
