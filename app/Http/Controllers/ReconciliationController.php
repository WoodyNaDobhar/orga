<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReconciliationRequest;
use App\Http\Requests\UpdateReconciliationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReconciliationRepository;
use Illuminate\Http\Request;
use Flash;

class ReconciliationController extends AppBaseController
{
    /** @var ReconciliationRepository $reconciliationRepository*/
    private $reconciliationRepository;

    public function __construct(ReconciliationRepository $reconciliationRepo)
    {
        $this->reconciliationRepository = $reconciliationRepo;
    }

    /**
     * Display a listing of the Reconciliation.
     */
    public function index(Request $request)
    {
        return view('reconciliations.index');
    }

    /**
     * Show the form for creating a new Reconciliation.
     */
    public function create()
    {
        return view('reconciliations.create');
    }

    /**
     * Store a newly created Reconciliation in storage.
     */
    public function store(CreateReconciliationRequest $request)
    {
        $input = $request->all();

        $reconciliation = $this->reconciliationRepository->create($input);

        Flash::success('Reconciliation saved successfully.');

        return redirect(route('reconciliations.index'));
    }

    /**
     * Display the specified Reconciliation.
     */
    public function show($id)
    {
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            Flash::error('Reconciliation not found');

            return redirect(route('reconciliations.index'));
        }

        return view('reconciliations.show')->with('reconciliation', $reconciliation);
    }

    /**
     * Show the form for editing the specified Reconciliation.
     */
    public function edit($id)
    {
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            Flash::error('Reconciliation not found');

            return redirect(route('reconciliations.index'));
        }

        return view('reconciliations.edit')->with('reconciliation', $reconciliation);
    }

    /**
     * Update the specified Reconciliation in storage.
     */
    public function update($id, UpdateReconciliationRequest $request)
    {
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            Flash::error('Reconciliation not found');

            return redirect(route('reconciliations.index'));
        }

        $reconciliation = $this->reconciliationRepository->update($request->all(), $id);

        Flash::success('Reconciliation updated successfully.');

        return redirect(route('reconciliations.index'));
    }

    /**
     * Remove the specified Reconciliation from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reconciliation = $this->reconciliationRepository->find($id);

        if (empty($reconciliation)) {
            Flash::error('Reconciliation not found');

            return redirect(route('reconciliations.index'));
        }

        $this->reconciliationRepository->delete($id);

        Flash::success('Reconciliation deleted successfully.');

        return redirect(route('reconciliations.index'));
    }
}
