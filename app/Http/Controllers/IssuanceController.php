<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIssuanceRequest;
use App\Http\Requests\UpdateIssuanceRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\IssuanceRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class IssuanceController extends AppBaseController
{
    /** @var IssuanceRepository $issuanceRepository*/
    private $issuanceRepository;

    public function __construct(IssuanceRepository $issuanceRepo)
    {
        $this->issuanceRepository = $issuanceRepo;
    }

    /**
     * Display a listing of the Issuance.
     */
    public function index(Request $request)
    {
        return view('issuances.index');
    }

    /**
     * Show the form for creating a new Issuance.
     */
    public function create()
    {
        return view('issuances.create');
    }

    /**
     * Store a newly created Issuance in storage.
     */
    public function store(CreateIssuanceRequest $request)
    {
        $input = $request->all();

        $issuance = $this->issuanceRepository->create($input);

        Flash::success('Issuance saved successfully.');

        return redirect(route('issuances.index'));
    }

    /**
     * Display the specified Issuance.
     */
    public function show($id)
    {
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            Flash::error('Issuance not found');

            return redirect(route('issuances.index'));
        }

        return view('issuances.show')->with('issuance', $issuance);
    }

    /**
     * Show the form for editing the specified Issuance.
     */
    public function edit($id)
    {
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            Flash::error('Issuance not found');

            return redirect(route('issuances.index'));
        }

        return view('issuances.edit')->with('issuance', $issuance);
    }

    /**
     * Update the specified Issuance in storage.
     */
    public function update($id, UpdateIssuanceRequest $request)
    {
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            Flash::error('Issuance not found');

            return redirect(route('issuances.index'));
        }

        $issuance = $this->issuanceRepository->update($request->all(), $id);

        Flash::success('Issuance updated successfully.');

        return redirect(route('issuances.index'));
    }

    /**
     * Remove the specified Issuance from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $issuance = $this->issuanceRepository->find($id);

        if (empty($issuance)) {
            Flash::error('Issuance not found');

            return redirect(route('issuances.index'));
        }

        $this->issuanceRepository->delete($id);

        Flash::success('Issuance deleted successfully.');

        return redirect(route('issuances.index'));
    }
}
