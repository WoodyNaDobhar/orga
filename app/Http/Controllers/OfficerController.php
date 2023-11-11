<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOfficerRequest;
use App\Http\Requests\UpdateOfficerRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OfficerRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class OfficerController extends AppBaseController
{
    /** @var OfficerRepository $officerRepository*/
    private $officerRepository;

    public function __construct(OfficerRepository $officerRepo)
    {
        $this->officerRepository = $officerRepo;
    }

    /**
     * Display a listing of the Officer.
     */
    public function index(Request $request)
    {
        return view('officers.index');
    }

    /**
     * Show the form for creating a new Officer.
     */
    public function create()
    {
        return view('officers.create');
    }

    /**
     * Store a newly created Officer in storage.
     */
    public function store(CreateOfficerRequest $request)
    {
        $input = $request->all();

        $officer = $this->officerRepository->create($input);

        Flash::success('Officer saved successfully.');

        return redirect(route('officers.index'));
    }

    /**
     * Display the specified Officer.
     */
    public function show($id)
    {
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            Flash::error('Officer not found');

            return redirect(route('officers.index'));
        }

        return view('officers.show')->with('officer', $officer);
    }

    /**
     * Show the form for editing the specified Officer.
     */
    public function edit($id)
    {
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            Flash::error('Officer not found');

            return redirect(route('officers.index'));
        }

        return view('officers.edit')->with('officer', $officer);
    }

    /**
     * Update the specified Officer in storage.
     */
    public function update($id, UpdateOfficerRequest $request)
    {
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            Flash::error('Officer not found');

            return redirect(route('officers.index'));
        }

        $officer = $this->officerRepository->update($request->all(), $id);

        Flash::success('Officer updated successfully.');

        return redirect(route('officers.index'));
    }

    /**
     * Remove the specified Officer from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $officer = $this->officerRepository->find($id);

        if (empty($officer)) {
            Flash::error('Officer not found');

            return redirect(route('officers.index'));
        }

        $this->officerRepository->delete($id);

        Flash::success('Officer deleted successfully.');

        return redirect(route('officers.index'));
    }
}
